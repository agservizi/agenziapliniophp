<?php
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf()) {
    $email = filter_var($_POST['newsletter_email'] ?? '', FILTER_VALIDATE_EMAIL);
    if ($email) {
        flash('success', 'Iscrizione alla newsletter completata.');
    } else {
        flash('warning', 'Inserisci un indirizzo email valido.');
    }
}
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit();
