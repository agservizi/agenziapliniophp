<?php
require_once __DIR__ . '/functions.php';

function create_notification(?int $userId, string $title, string $message): void
{
    try {
        execute_query('INSERT INTO notifiche (id_utente, titolo, messaggio, data_creazione) VALUES (:id_utente, :titolo, :messaggio, NOW())', [
            'id_utente' => $userId,
            'titolo' => $title,
            'messaggio' => $message,
        ]);
    } catch (Throwable $exception) {
        error_log('notification store failed: ' . $exception->getMessage());
    }
}

function notify_admins(string $title, string $message): void
{
    try {
        $admins = fetch_all('SELECT id FROM utenti WHERE ruolo = :ruolo', ['ruolo' => 'admin']);
        if (!$admins) {
            create_notification(null, $title, $message);
            return;
        }
        foreach ($admins as $admin) {
            create_notification((int) $admin['id'], $title, $message);
        }
    } catch (Throwable $exception) {
        error_log('notify_admins fallback: ' . $exception->getMessage());
        create_notification(null, $title, $message);
    }
}
