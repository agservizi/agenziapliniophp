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
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $user = $email ? find_user_by_email($email) : null;
        if ($user && password_verify($password, $user['password'])) {
            login_user($user);
            flash('success', 'Bentornato!');
            header('Location: /user/dashboard.php');
            exit();
        }
        $error = 'Credenziali non valide.';
    }
}

$pageTitle = 'Login';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section" data-animate="fade-up">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-5">
                <div class="flip-card">
                    <div class="flip-card-inner is-active">
                        <div class="flip-card-front box">
                            <h1 class="title">Accesso clienti</h1>
                            <?php if ($error): ?>
                                <div class="notification is-danger"><?= sanitize($error); ?></div>
                            <?php endif; ?>
                            <form method="post">
                                <?= csrf_field(); ?>
                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control">
                                        <input class="input" type="email" name="email" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Password</label>
                                    <div class="control">
                                        <input class="input" type="password" name="password" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <button class="button is-warning is-fullwidth" type="submit">Accedi</button>
                                </div>
                                <p class="has-text-centered">Non hai un account? <a href="/user/register.php">Registrati</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
