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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        midnight: {
                            950: '#020817',
                            925: '#030d1d',
                            900: '#050f24',
                            850: '#071431',
                            800: '#0a1b3a',
                            700: '#102347',
                            600: '#1a2f58'
                        },
                        accent: {
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'Poppins', 'sans-serif'],
                        display: ['Poppins', 'Inter', 'sans-serif']
                    },
                    boxShadow: {
                        primary: '0 30px 120px rgba(8, 16, 36, 0.48)',
                        frosted: '0 32px 90px rgba(5, 12, 28, 0.65)'
                    },
                    maxWidth: {
                        '8xl': '90rem'
                    }
                }
            }
        };
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
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
