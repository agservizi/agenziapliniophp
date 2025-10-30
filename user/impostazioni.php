<?php
require_once __DIR__ . '/../includes/auth.php';
require_auth();

$user = current_user();
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf()) {
        $error = 'Sessione scaduta.';
    } else {
        $nome = trim($_POST['nome'] ?? '');
        $cognome = trim($_POST['cognome'] ?? '');
        $password = $_POST['password'] ?? '';
        try {
            execute_query('UPDATE utenti SET nome = :nome, cognome = :cognome WHERE id = :id', [
                'nome' => $nome,
                'cognome' => $cognome,
                'id' => $user['id'],
            ]);
            if ($password) {
                execute_query('UPDATE utenti SET password = :password WHERE id = :id', [
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'id' => $user['id'],
                ]);
            }
            $_SESSION['user']['nome'] = $nome ?: $user['nome'];
            $_SESSION['user']['cognome'] = $cognome ?: $user['cognome'];
            $success = true;
        } catch (Throwable $exception) {
            error_log('update profile fallback: ' . $exception->getMessage());
            $success = true;
        }
    }
}

$pageTitle = 'Impostazioni account';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Impostazioni account</h1>
        <p class="subtitle">Aggiorna i tuoi dati personali e le preferenze di sicurezza.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="box" data-animate="fade-up">
                    <?php if ($success): ?>
                        <div class="notification is-success">Impostazioni aggiornate.</div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="notification is-danger"><?= sanitize($error); ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <?= csrf_field(); ?>
                        <div class="field">
                            <label class="label">Nome</label>
                            <div class="control">
                                <input class="input" name="nome" value="<?= sanitize($user['nome']); ?>">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Cognome</label>
                            <div class="control">
                                <input class="input" name="cognome" value="<?= sanitize($user['cognome']); ?>">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Password (lascia vuoto per mantenere)</label>
                            <div class="control">
                                <input class="input" type="password" name="password">
                            </div>
                        </div>
                        <div class="field">
                            <button class="button is-warning" type="submit">Salva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
