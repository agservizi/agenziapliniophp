<?php
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf()) {
    flash('danger', 'Richiesta non valida.');
    header('Location: /contatti.php');
    exit();
}

$nome = trim($_POST['nome'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$azienda = trim($_POST['azienda'] ?? '');
$messaggio = trim($_POST['messaggio'] ?? '');

if (!$nome || !$email || !$azienda || !$messaggio) {
    flash('warning', 'Compila tutti i campi.');
    header('Location: /contatti.php');
    exit();
}

try {
    execute_query('INSERT INTO richieste_servizi (id_utente, id_servizio, stato, data_richiesta) VALUES (:id_utente, :id_servizio, :stato, NOW())', [
        'id_utente' => current_user()['id'] ?? null,
        'id_servizio' => null,
        'stato' => 'nuova',
    ]);
} catch (Throwable $exception) {
    error_log('contatto fallback: ' . $exception->getMessage());
}

flash('success', 'Richiesta inviata. Ti contatteremo a breve.');
header('Location: /contatti.php');
exit();
