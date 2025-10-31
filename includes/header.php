<?php
require_once __DIR__ . '/auth.php';
$siteName = app_config('app.name');
$pageTitle = $pageTitle ?? $siteName;
$fullTitle = $pageTitle === $siteName ? $siteName : $pageTitle . ' • ' . $siteName;
$bodyClass = isset($bodyClass)
    ? trim('bg-midnight-950 text-slate-100 antialiased min-h-screen ' . $bodyClass)
    : 'bg-midnight-950 text-slate-100 antialiased min-h-screen';
$mainClass = isset($mainClass)
    ? trim('page-content relative pt-28 pb-24 ' . $mainClass)
    : 'page-content relative pt-28 pb-24';
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
    <link rel="stylesheet" href="<?= asset('assets/css/tailwind.build.css'); ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/animations.css'); ?>">
    <link rel="stylesheet" href="<?= asset('assets/css/parallax.css'); ?>">
</head>
<body class="<?= sanitize($bodyClass); ?>">
<div id="preloader">
    <div class="loader-logo">Agenzia Plinio</div>
    <div class="loader-progress"><span></span></div>
</div>
<?php include __DIR__ . '/navbar.php'; ?>
<main class="<?= sanitize($mainClass); ?>" data-page="<?= sanitize($pageTitle); ?>">
    <?php foreach (get_flash() as $flash): ?>
        <div class="custom-toast" data-variant="<?= sanitize($flash['type']); ?>" data-auto-dismiss>
            <?= sanitize($flash['message']); ?>
        </div>
    <?php endforeach; ?>
