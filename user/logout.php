<?php
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf()) {
    logout_user();
    flash('success', 'Disconnessione avvenuta con successo.');
}
header('Location: /');
exit();
