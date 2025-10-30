<?php
require_once __DIR__ . '/../includes/auth.php';

if (is_authenticated()) {
    header('Location: /user/dashboard.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf()) {
        $error = 'Sessione scaduta. Aggiorna la pagina.';
    } else {
        $nome = trim($_POST['nome'] ?? '');
        $cognome = trim($_POST['cognome'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm'] ?? '';

        if (!$nome || !$cognome || !$email) {
            $error = 'Compila tutti i campi obbligatori.';
        } elseif ($password !== $confirm) {
            $error = 'Le password non coincidono.';
        } elseif (find_user_by_email($email)) {
            $error = 'Email già registrata.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            create_user([
                'nome' => $nome,
                'cognome' => $cognome,
                'email' => $email,
                'password' => $hashed,
            ]);
            flash('success', 'Registrazione completata. Accedi con le tue credenziali.');
            header('Location: /user/login.php');
            exit();
        }
    }
}

$pageTitle = 'Registrazione';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section" data-animate="fade-up">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-6">
                <div class="flip-card">
                    <div class="flip-card-inner is-active">
                        <div class="flip-card-front box">
                            <h1 class="title">Crea il tuo account</h1>
                            <?php if ($error): ?>
                                <div class="notification is-danger"><?= sanitize($error); ?></div>
                            <?php endif; ?>
                            <form method="post">
                                <?= csrf_field(); ?>
                                <div class="columns">
                                    <div class="column">
                                        <div class="field">
                                            <label class="label">Nome</label>
                                            <div class="control">
                                                <input class="input" name="nome" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="field">
                                            <label class="label">Cognome</label>
                                            <div class="control">
                                                <input class="input" name="cognome" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Email aziendale</label>
                                    <div class="control">
                                        <input class="input" type="email" name="email" required>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <div class="field">
                                            <label class="label">Password</label>
                                            <div class="control">
                                                <input class="input" type="password" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="field">
                                            <label class="label">Conferma password</label>
                                            <div class="control">
                                                <input class="input" type="password" name="confirm" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <button class="button is-warning is-fullwidth" type="submit">Registrati</button>
                                </div>
                                <p class="has-text-centered">Hai già un account? <a href="/user/login.php">Accedi</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
