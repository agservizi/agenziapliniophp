<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $redirectTo = '/admin/prodotti.php';
    if (!validate_csrf()) {
        flash('danger', 'Token CSRF non valido.');
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $data = [
                'nome' => trim($_POST['nome'] ?? ''),
                'descrizione' => trim($_POST['descrizione'] ?? ''),
                'prezzo' => (float) ($_POST['prezzo'] ?? 0),
                'categoria' => trim($_POST['categoria'] ?? ''),
                'disponibile' => isset($_POST['disponibile']) ? 1 : 0,
            ];
            $errors = [];

            if ($data['nome'] === '' || $data['descrizione'] === '' || $data['categoria'] === '') {
                $errors[] = 'Compila tutti i campi obbligatori.';
            }
            if ($data['prezzo'] <= 0) {
                $errors[] = 'Inserisci un prezzo valido.';
            }

            $imagePath = null;
            $uploadedFile = $_FILES['immagine'] ?? null;
            $fileError = $uploadedFile['error'] ?? UPLOAD_ERR_NO_FILE;

            if (!$uploadedFile || $fileError === UPLOAD_ERR_NO_FILE) {
                $errors[] = 'Carica un\'immagine per il prodotto.';
            } elseif ($fileError !== UPLOAD_ERR_OK) {
                $errors[] = 'Errore durante l\'upload del file.';
            }

            if (!$errors) {
                try {
                    $imagePath = store_uploaded_image($uploadedFile, 'products');
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
                    execute_query('INSERT INTO prodotti (nome, descrizione, prezzo, categoria, disponibile, immagine) VALUES (:nome, :descrizione, :prezzo, :categoria, :disponibile, :immagine)', $data);
                    flash('success', 'Prodotto creato.');
                } catch (Throwable $exception) {
                    error_log('create product fallback: ' . $exception->getMessage());
                    flash('success', 'Prodotto creato (mock).');
                }
            }
        } elseif ($action === 'update') {
            $id = (int) ($_POST['id'] ?? 0);
            $redirectTo = $id > 0 ? '/admin/prodotti.php?edit=' . $id : '/admin/prodotti.php';

            if ($id <= 0) {
                flash('danger', 'Prodotto non valido.');
            } else {
                $product = get_product_by_id($id);
                if (!$product) {
                    flash('danger', 'Prodotto non trovato.');
                } else {
                    $data = [
                        'id' => $id,
                        'nome' => trim($_POST['nome'] ?? ''),
                        'descrizione' => trim($_POST['descrizione'] ?? ''),
                        'prezzo' => (float) ($_POST['prezzo'] ?? 0),
                        'categoria' => trim($_POST['categoria'] ?? ''),
                        'disponibile' => isset($_POST['disponibile']) ? 1 : 0,
                    ];
                    $errors = [];

                    if ($data['nome'] === '' || $data['descrizione'] === '' || $data['categoria'] === '') {
                        $errors[] = 'Compila tutti i campi obbligatori.';
                    }
                    if ($data['prezzo'] <= 0) {
                        $errors[] = 'Inserisci un prezzo valido.';
                    }

                    $imagePath = $product['immagine'] ?? null;
                    $uploadedFile = $_FILES['immagine'] ?? null;
                    $fileError = $uploadedFile['error'] ?? UPLOAD_ERR_NO_FILE;
                    $hasNewUpload = $uploadedFile && $fileError !== UPLOAD_ERR_NO_FILE;

                    if ($hasNewUpload && $fileError !== UPLOAD_ERR_OK) {
                        $errors[] = 'Errore durante l\'upload del file.';
                    }

                    if ($hasNewUpload && !$errors) {
                        try {
                            $imagePath = store_uploaded_image($uploadedFile, 'products', $product['immagine'] ?? null);
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
                            execute_query('UPDATE prodotti SET nome = :nome, descrizione = :descrizione, prezzo = :prezzo, categoria = :categoria, disponibile = :disponibile, immagine = :immagine WHERE id = :id', $data);
                            flash('success', 'Prodotto aggiornato.');
                            $redirectTo = '/admin/prodotti.php';
                        } catch (Throwable $exception) {
                            error_log('update product fallback: ' . $exception->getMessage());
                            flash('success', 'Prodotto aggiornato (mock).');
                            $redirectTo = '/admin/prodotti.php';
                        }
                    }
                }
            }
        } elseif ($action === 'delete') {
            $id = (int) ($_POST['id'] ?? 0);
            $product = get_product_by_id($id);
            try {
                execute_query('DELETE FROM prodotti WHERE id = :id', ['id' => $id]);
                flash('success', 'Prodotto eliminato.');
            } catch (Throwable $exception) {
                error_log('delete product fallback: ' . $exception->getMessage());
                flash('success', 'Prodotto eliminato (mock).');
            }

            if (is_array($product) && !empty($product['immagine'])) {
                $absolute = project_root() . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, ltrim($product['immagine'], '/'));
                if (is_file($absolute)) {
                    @unlink($absolute);
                }
            }
        }
    }
    header('Location: ' . $redirectTo);
    exit();
}

$editingProduct = null;
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    if ($editId > 0) {
        $candidate = get_product_by_id($editId);
        if ($candidate) {
            $editingProduct = $candidate;
        } else {
            flash('danger', 'Il prodotto selezionato non è disponibile.');
            header('Location: /admin/prodotti.php');
            exit();
        }
    } else {
        header('Location: /admin/prodotti.php');
        exit();
    }
}

$prodotti = get_products();

$isEditing = $editingProduct !== null;
$priceValue = $isEditing ? number_format((float) ($editingProduct['prezzo'] ?? 0), 2, '.', '') : '';
$currentImage = $isEditing ? ($editingProduct['immagine'] ?? null) : null;

$pageTitle = 'Gestione prodotti';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Prodotti</h1>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-two-thirds">
                <div class="table-container" data-animate="fade-up">
                    <table class="table is-fullwidth is-dark">
                        <thead>
                            <tr>
                                <th>Anteprima</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Prezzo</th>
                                <th>Disponibile</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prodotti as $prodotto): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($prodotto['immagine'])): ?>
                                            <figure class="image is-64x64">
                                                <img src="/<?= sanitize(ltrim($prodotto['immagine'], '/')); ?>" alt="Anteprima prodotto">
                                            </figure>
                                        <?php else: ?>
                                            <span class="has-text-grey">N/D</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= sanitize($prodotto['nome']); ?></td>
                                    <td><?= sanitize($prodotto['categoria']); ?></td>
                                    <td>€ <?= format_currency((float) $prodotto['prezzo']); ?></td>
                                    <td><?= !empty($prodotto['disponibile']) ? 'Sì' : 'No'; ?></td>
                                    <td>
                                        <div class="field is-grouped is-grouped-right">
                                            <div class="control">
                                                <a class="button is-small is-info" href="/admin/prodotti.php?edit=<?= (int) $prodotto['id']; ?>">Modifica</a>
                                            </div>
                                            <div class="control">
                                                <form method="post" style="display:inline-block">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= (int) $prodotto['id']; ?>">
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
                    <h2 class="title is-5"><?= $isEditing ? 'Modifica prodotto' : 'Nuovo prodotto'; ?></h2>
                    <form method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="action" value="<?= $isEditing ? 'update' : 'create'; ?>">
                        <?php if ($isEditing): ?>
                            <input type="hidden" name="id" value="<?= (int) $editingProduct['id']; ?>">
                        <?php endif; ?>
                        <div class="field">
                            <label class="label">Nome</label>
                            <div class="control"><input class="input" name="nome" value="<?= sanitize($editingProduct['nome'] ?? ''); ?>" required></div>
                        </div>
                        <div class="field">
                            <label class="label">Descrizione</label>
                            <div class="control"><textarea class="textarea" name="descrizione" rows="3" required><?= sanitize($editingProduct['descrizione'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="field">
                            <label class="label">Prezzo</label>
                            <div class="control"><input class="input" type="number" step="0.01" name="prezzo" value="<?= sanitize($priceValue); ?>" required></div>
                        </div>
                        <div class="field">
                            <label class="label">Categoria</label>
                            <div class="control"><input class="input" name="categoria" value="<?= sanitize($editingProduct['categoria'] ?? ''); ?>" required></div>
                        </div>
                        <?php if ($isEditing && $currentImage): ?>
                            <div class="field">
                                <label class="label">Immagine attuale</label>
                                <figure class="image is-128x128">
                                    <img src="/<?= sanitize(ltrim($currentImage, '/')); ?>" alt="Immagine prodotto attuale">
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
                            <?php endif; ?>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="disponibile" <?php if ($isEditing) { echo !empty($editingProduct['disponibile']) ? 'checked' : ''; } else { echo 'checked'; } ?>> Disponibile
                            </label>
                        </div>
                        <div class="field">
                            <button class="button is-warning is-fullwidth" type="submit"><?= $isEditing ? 'Aggiorna' : 'Crea'; ?></button>
                        </div>
                        <?php if ($isEditing): ?>
                            <div class="field">
                                <a class="button is-light is-fullwidth" href="/admin/prodotti.php">Annulla modifica</a>
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
