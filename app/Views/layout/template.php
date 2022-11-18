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

<body class="hold-transition sidebar-mini" onload="config('<?= $_SERVER['app.baseURL'] ?>')">
<div class="wrapper">
    <?= $this->include('layout/navbar'); ?>
    <?php
    switch ($role) {
        case 1:
            echo $this->include('layout/sidebar-admin.php');
            break;
        case 2:
            echo $this->include('layout/sidebar-teacher.php');
            break;
        case 3:
            echo $this->include('layout/sidebar-siswa.php');
            break;
        default:
            echo "";
    }
    ?>
    <?= $this->include('layout/header'); ?>
    <?= $this->include('./flash/flash'); ?>
    <div class="preloader">
        <div class="loading">
            <img src="<?= base_url('/assets/img/gif-muhka.gif'); ?>" width="300">
        </div>
    </div>
    <?= $this->renderSection('content'); ?>
    <?= $this->include('layout/control-sidebar'); ?>
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Template by <a href="https://adminlte.io">AdminLTE.io</a>
        </div>
        <strong>Copyright &copy; 2021 - <?= date('Y'); ?> <a
                    href="https://yantodev.github.io">Yantodev</a>.</strong> All rights
        reserved. || <a href="https://smkmuhkarangmojo.sch.id">SMK Muhammadiyah Karangmojo</a>
    </footer>
</div>
<script src=<?= base_url('assets/sweetalert2/dist/sweetalert2.all.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/jquery/jquery.min.js') ?>></script>
<script src=<?= base_url('assets/js/datatables-demo.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables/jquery.dataTables.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>>
</script>
<script src=<?= base_url('assets/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>>
</script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/jszip/jszip.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/pdfmake/pdfmake.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/pdfmake/vfs_fonts.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.print.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>></script>
<script src=<?= base_url('assets/template/dist/js/adminlte.min.js') ?>></script>
<script src=<?= base_url('assets/config/config.js') ?>></script>
<script src=<?= base_url('assets/yantodev/Flashdata.js') ?>></script>
<script src=<?= base_url('assets/yantodev/Iduka.js') ?>></script>
<script src=<?= base_url('assets/yantodev/tp.js') ?>></script>
<script src=<?= base_url('assets/yantodev/Guru.js') ?>></script>
<script src=<?= base_url('assets/yantodev/users.js') ?>></script>
<script src=<?= base_url('assets/yantodev/print.js') ?>></script>
<script src=<?= base_url('assets/yantodev/auth/logout.js') ?>></script>

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
</body>

</html>