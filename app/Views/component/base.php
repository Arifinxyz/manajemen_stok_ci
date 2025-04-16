<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom CSS (SB Admin 2 Theme) -->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- CSRF Token -->
    <script>
        const csrfToken = '<?= csrf_hash() ?>';
    </script>

    <title>Judul Halaman</title>
</head>

<body id="page-top">

    <div id="wrapper">
        <?= $this->include('component/sidebar') ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?= $this->include('component/navbar') ?>
                <?= $this->renderSection('content') ?>
                <?= $this->include('component/footer') ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper (cukup satu ini saja!) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    <!-- JQuery Easing Plugin -->
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- SB Admin 2 JS -->
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>

    <!-- Optional: Toggle Trigger Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var offcanvasToggle = document.getElementById('offcanvasToggle');
            if (offcanvasToggle) {
                offcanvasToggle.click();
            }
        });
    </script>

</body>

</html>
