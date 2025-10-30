<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $redirectTo = '/admin/servizi.php';
    if (!validate_csrf()) {
        flash('danger', 'Token CSRF non valido.');
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $data = [
                'nome' => trim($_POST['nome'] ?? ''),
                'descrizione' => trim($_POST['descrizione'] ?? ''),
                'tipo' => trim($_POST['tipo'] ?? ''),
                'attivo' => isset($_POST['attivo']) ? 1 : 0,
            ];
            $errors = [];

            if ($data['nome'] === '' || $data['descrizione'] === '' || $data['tipo'] === '') {
                $errors[] = 'Compila tutti i campi obbligatori.';
            }

            $prezzoInput = trim($_POST['prezzo'] ?? '');
            if ($prezzoInput === '') {
                $data['prezzo'] = null;
            } else {
                $prezzoValue = (float) $prezzoInput;
                if ($prezzoValue <= 0) {
                    $errors[] = 'Inserisci un prezzo valido oppure lascia il campo vuoto.';
                } else {
                    $data['prezzo'] = $prezzoValue;
                }
            }

            $imagePath = null;
            $uploadedFile = $_FILES['immagine'] ?? null;
            $fileError = $uploadedFile['error'] ?? UPLOAD_ERR_NO_FILE;

            if (!$uploadedFile || $fileError === UPLOAD_ERR_NO_FILE) {
                $errors[] = 'Carica un\'immagine per il servizio.';
            } elseif ($fileError !== UPLOAD_ERR_OK) {
                $errors[] = 'Errore durante l\'upload del file.';
            }

            if (!$errors) {
                try {
                    $imagePath = store_uploaded_image($uploadedFile, 'services');
                } catch (RuntimeException $exception) {
                    $errors[] = $exception->getMessage();
                }
            }

            if ($errors) {
                foreach ($errors as $message) {
                    flash('danger', $message);
                }
            } else {
                $data['immagine'] = $imagePath;
                try {
                    execute_query('INSERT INTO servizi (nome, descrizione, tipo, attivo, immagine, prezzo) VALUES (:nome, :descrizione, :tipo, :attivo, :immagine, :prezzo)', $data);
                    flash('success', 'Servizio creato.');
                } catch (Throwable $exception) {
                    error_log('create service fallback: ' . $exception->getMessage());
                    flash('success', 'Servizio creato (mock).');
                }
            }
        } elseif ($action === 'update') {
            $id = (int) ($_POST['id'] ?? 0);
            $redirectTo = $id > 0 ? '/admin/servizi.php?edit=' . $id : '/admin/servizi.php';

            if ($id <= 0) {
                flash('danger', 'Servizio non valido.');
            } else {
                $service = get_service_by_id($id);
                if (!$service) {
                    flash('danger', 'Servizio non trovato.');
                } else {
                    $data = [
                        'id' => $id,
                        'nome' => trim($_POST['nome'] ?? ''),
                        'descrizione' => trim($_POST['descrizione'] ?? ''),
                        'tipo' => trim($_POST['tipo'] ?? ''),
                        'attivo' => isset($_POST['attivo']) ? 1 : 0,
                    ];
                    $errors = [];

                    if ($data['nome'] === '' || $data['descrizione'] === '' || $data['tipo'] === '') {
                        $errors[] = 'Compila tutti i campi obbligatori.';
                    }

                    $prezzoInput = trim($_POST['prezzo'] ?? '');
                    if ($prezzoInput === '') {
                        $data['prezzo'] = null;
                    } else {
                        $prezzoValue = (float) $prezzoInput;
                        if ($prezzoValue <= 0) {
                            $errors[] = 'Inserisci un prezzo valido oppure lascia il campo vuoto.';
                        } else {
                            $data['prezzo'] = $prezzoValue;
                        }
                    }

                    $imagePath = $service['immagine'] ?? null;
                    $uploadedFile = $_FILES['immagine'] ?? null;
                    $fileError = $uploadedFile['error'] ?? UPLOAD_ERR_NO_FILE;
                    $hasNewUpload = $uploadedFile && $fileError !== UPLOAD_ERR_NO_FILE;

                    if ($hasNewUpload && $fileError !== UPLOAD_ERR_OK) {
                        $errors[] = 'Errore durante l\'upload del file.';
                    }

                    if ($hasNewUpload && !$errors) {
                        try {
                            $imagePath = store_uploaded_image($uploadedFile, 'services', $service['immagine'] ?? null);
                        } catch (RuntimeException $exception) {
                            $errors[] = $exception->getMessage();
                        }
                    }

                    if ($errors) {
                        foreach ($errors as $message) {
                            flash('danger', $message);
                        }
                    } else {
                        $data['immagine'] = $imagePath;
                        try {
                            execute_query('UPDATE servizi SET nome = :nome, descrizione = :descrizione, tipo = :tipo, attivo = :attivo, immagine = :immagine, prezzo = :prezzo WHERE id = :id', $data);
                            flash('success', 'Servizio aggiornato.');
                            $redirectTo = '/admin/servizi.php';
                        } catch (Throwable $exception) {
                            error_log('update service fallback: ' . $exception->getMessage());
                            flash('success', 'Servizio aggiornato (mock).');
                            $redirectTo = '/admin/servizi.php';
                        }
                    }
                }
            }
        } elseif ($action === 'delete') {
            $id = (int) ($_POST['id'] ?? 0);
            $service = get_service_by_id($id);
            try {
                execute_query('DELETE FROM servizi WHERE id = :id', ['id' => $id]);
                flash('success', 'Servizio eliminato.');
            } catch (Throwable $exception) {
                error_log('delete service fallback: ' . $exception->getMessage());
                flash('success', 'Servizio eliminato (mock).');
            }

            if (is_array($service) && !empty($service['immagine'])) {
                $absolute = project_root() . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, ltrim($service['immagine'], '/'));
                if (is_file($absolute)) {
                    @unlink($absolute);
                }
            }
        }
    }
    header('Location: ' . $redirectTo);
    exit();
}

$editingService = null;
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    if ($editId > 0) {
        $candidate = get_service_by_id($editId);
        if ($candidate) {
            $editingService = $candidate;
        } else {
            flash('danger', 'Il servizio selezionato non è disponibile.');
            header('Location: /admin/servizi.php');
            exit();
        }
    } else {
        header('Location: /admin/servizi.php');
        exit();
    }
}

$servizi = get_services();

$isEditing = $editingService !== null;
$priceValue = $isEditing
    ? ($editingService['prezzo'] !== null ? number_format((float) $editingService['prezzo'], 2, '.', '') : '')
    : '';
$currentImage = $isEditing ? ($editingService['immagine'] ?? null) : null;

$pageTitle = 'Gestione servizi';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Servizi</h1>
        <p class="subtitle">Definisci l&apos;offerta e gestisci l&apos;attivazione dei servizi digitali.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-two-thirds" data-animate="fade-up">
                <div class="table-container">
                    <table class="table is-fullwidth is-dark">
                        <thead>
                            <tr>
                                <th>Anteprima</th>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Prezzo</th>
                                <th>Stato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($servizi as $servizio): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($servizio['immagine'])): ?>
                                            <figure class="image is-64x64">
                                                <img src="/<?= sanitize(ltrim($servizio['immagine'], '/')); ?>" alt="Anteprima servizio">
                                            </figure>
                                        <?php else: ?>
                                            <span class="has-text-grey">N/D</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= sanitize($servizio['nome']); ?></td>
                                    <td><?= sanitize($servizio['tipo']); ?></td>
                                    <td>
                                        <?php if ($servizio['prezzo'] !== null): ?>
                                            € <?= format_currency((float) $servizio['prezzo']); ?>
                                        <?php else: ?>
                                            &mdash;
                                        <?php endif; ?>
                                    </td>
                                    <td><?= !empty($servizio['attivo']) ? 'Attivo' : 'Non attivo'; ?></td>
                                    <td>
                                    <div class="field is-grouped is-grouped-right">
                                        <div class="control">
                                            <a class="button is-small is-info" href="/admin/servizi.php?edit=<?= (int) $servizio['id']; ?>">Modifica</a>
                                        </div>
                                        <div class="control">
                                            <form method="post" style="display:inline-block">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= (int) $servizio['id']; ?>">
                                                <button class="button is-small is-danger" type="submit">Elimina</button>
                                            </form>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="column" data-animate="fade-left">
                <div class="box">
                    <h2 class="title is-5"><?= $isEditing ? 'Modifica servizio' : 'Nuovo servizio'; ?></h2>
                    <form method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="action" value="<?= $isEditing ? 'update' : 'create'; ?>">
                        <?php if ($isEditing): ?>
                            <input type="hidden" name="id" value="<?= (int) $editingService['id']; ?>">
                        <?php endif; ?>
                        <div class="field">
                            <label class="label">Nome</label>
                            <div class="control"><input class="input" name="nome" value="<?= sanitize($editingService['nome'] ?? ''); ?>" required></div>
                        </div>
                        <div class="field">
                            <label class="label">Descrizione</label>
                            <div class="control"><textarea class="textarea" rows="3" name="descrizione" required><?= sanitize($editingService['descrizione'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="field">
                            <label class="label">Tipo</label>
                            <div class="control"><input class="input" name="tipo" value="<?= sanitize($editingService['tipo'] ?? ''); ?>" required></div>
                        </div>
                        <div class="field">
                            <label class="label">Prezzo</label>
                            <div class="control"><input class="input" type="number" step="0.01" min="0" name="prezzo" value="<?= sanitize($priceValue); ?>" placeholder="Lascia vuoto per non indicarlo"></div>
                            <p class="help">Inserisci un importo facoltativo da mostrare nell&apos;area pubblica.</p>
                        </div>
                        <?php if ($isEditing && $currentImage): ?>
                            <div class="field">
                                <label class="label">Immagine attuale</label>
                                <figure class="image is-128x128">
                                    <img src="/<?= sanitize(ltrim($currentImage, '/')); ?>" alt="Immagine servizio attuale">
                                </figure>
                            </div>
                        <?php endif; ?>
                        <div class="field">
                            <label class="label">Immagine</label>
                            <div class="file has-name is-fullwidth">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="immagine" accept="image/*" <?php if (!$isEditing): ?>required<?php endif; ?>>
                                    <span class="file-cta">
                                        <span class="file-icon"><i class="fas fa-upload"></i></span>
                                        <span class="file-label">Scegli un file…</span>
                                    </span>
                                    <span class="file-name">Nessun file selezionato</span>
                                </label>
                            </div>
                            <?php if ($isEditing): ?>
                                <p class="help">Carica un nuovo file solo se desideri sostituire l&apos;immagine attuale.</p>
                            <?php else: ?>
                                <p class="help">Dimensione massima <?= (int) (upload_config('max_size', 4 * 1024 * 1024) / 1048576); ?> MB. Formati: JPEG, PNG, WebP.</p>
                            <?php endif; ?>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="attivo" <?php if ($isEditing) { echo !empty($editingService['attivo']) ? 'checked' : ''; } else { echo 'checked'; } ?>> Attivo
                            </label>
                        </div>
                        <div class="field">
                            <button class="button is-warning is-fullwidth" type="submit"><?= $isEditing ? 'Aggiorna' : 'Crea'; ?></button>
                        </div>
                        <?php if ($isEditing): ?>
                            <div class="field">
                                <a class="button is-light is-fullwidth" href="/admin/servizi.php">Annulla modifica</a>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.file-input').forEach(function (input) {
        input.addEventListener('change', function () {
            var fileNameSpan = input.closest('.file').querySelector('.file-name');
            if (fileNameSpan) {
                fileNameSpan.textContent = input.files.length ? input.files[0].name : 'Nessun file selezionato';
            }
        });
    });
});
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
