<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOESIS TI <?php echo $titulo ?? ''; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/vendor/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/build/vendor/css/select2.min.css">
    <link rel="stylesheet" href="/build/vendor/css/flatpickr.min.css">
    <link rel="stylesheet" href="/build/vendor/css/flatpickr-dark.css">
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <?php echo $contenido; ?>
    <script src="/build/vendor/js/jquery.min.js"></script>
    <script src="/build/vendor/js/fontawesome.js"></script>
    <script src="/build/vendor/js/sweetalert2.all.min.js"></script>
    <script src="/build/vendor/js/select2.min.js"></script>
    <script src="/build/vendor/js/flatpickr.js"></script>
    <script src="/build/vendor/js/flatpickr-es.js"></script>
    <?php echo $script ?? ''; ?>
</body>
</html>