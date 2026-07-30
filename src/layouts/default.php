<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Blossom Test' ?></title>
  <?php if (!isViteDev()): ?>
  <base href="<?= basePath() ?>/">
  <?php endif; ?>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
  <style>[x-cloak] { display: none !important; }</style>
  <?php if (isViteDev()): ?>
  <script type="module" src="<?= viteClient() ?>"></script>
  <?php endif; ?>
  <script type="module" src="<?= asset('js/app.js') ?>"></script>
</head>
<body class="font-sans bg-bg-app text-text-main m-0 p-0 antialiased">
  <?= $content ?>
</body>
</html>
