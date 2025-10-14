<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg" style="width: 400px;">
    <div class="card-body text-center bg-<?= esc($class) ?> bg-opacity-25 rounded">
        <h3 class="fw-bold"><?= esc($icon) ?> <?= esc($title) ?></h3>
        <p class="mt-3"><?= esc($message) ?></p>
        <hr>
        <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>
