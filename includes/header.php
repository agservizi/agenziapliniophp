<?php
require_once __DIR__ . '/auth.php';
$siteName = app_config('app.name');
$pageTitle = $pageTitle ?? $siteName;
$fullTitle = $pageTitle === $siteName ? $siteName : $pageTitle . ' • ' . $siteName;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portale professionale Agenzia Plinio">
    <title><?= sanitize($fullTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/animations.css'); ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/parallax.css'); ?>">
</head>
<body class="theme-dark">
<div id="preloader">
    <div class="loader-logo">Agenzia Plinio</div>
    <div class="loader-progress"><span></span></div>
</div>
<?php include __DIR__ . '/navbar.php'; ?>
<main class="page-content" data-page="<?= sanitize($pageTitle); ?>">
    <?php foreach (get_flash() as $flash): ?>
        <div class="notification is-<?= sanitize($flash['type']); ?> custom-toast" data-auto-dismiss>
            <?= sanitize($flash['message']); ?>
        </div>
    <?php endforeach; ?>
