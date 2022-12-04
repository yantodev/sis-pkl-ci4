<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Eko Cahyanto">
    <link rel="icon" href="<?= base_url('assets/img/logo/favicon.ico'); ?>">
    <title><?= $title ?></title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href=<?= base_url('assets/template/plugins/fontawesome-free/css/all.min.css') ?>>
    <link rel="stylesheet" href=<?= base_url('assets/template/dist/css/adminlte.min.css') ?>>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
    <script>
        $(document).ready(function () {
            $(".preloader").finish();
        })
    </script>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php
    switch ($role) {
        case 1:
            echo $this->include('layout/navbar');
            echo $this->include('layout/sidebar-admin.php');
            echo $this->include('layout/header');
            break;
        case 2:
            echo $this->include('layout/sidebar-teacher.php');
            break;
        case 3:
            echo $this->include('layout/navbar-siswa');
            echo $this->include('layout/sidebar-siswa.php');
            echo $this->include('layout/header-siswa');
            break;
        default:
            echo "";
    }
    ?>
    <?= $this->include('./flash/flash'); ?>
    <div class="preloader">
        <div class="loading">
            <img src="<?= base_url('/assets/img/gif-muhka.gif'); ?>" width="300">
        </div>
    </div>
    <?= $this->renderSection('content'); ?>
    <?= $this->include('layout/control-sidebar'); ?>
    <?= $this->include('layout/footer'); ?>
</div>
<?= $this->include('layout/script'); ?>
</body>

</html>