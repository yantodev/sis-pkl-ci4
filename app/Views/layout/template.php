<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Eko Cahyanto">
    <link rel="icon" href="<?= base_url('assets/img/logo/favicon.ico'); ?>">
    <title><?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href=<?= base_url('assets/template/plugins/fontawesome-free/css/all.min.css') ?>>
    <!-- Theme style -->
    <link rel="stylesheet" href=<?= base_url('assets/template/dist/css/adminlte.min.css') ?>>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <script>
        $(document).ready(function () {
            $(".preloader").fadeOut();
        })
    </script>
</head>

<body class="hold-transition sidebar-mini" onload="config('<?= base_url(); ?>')">
<div class="wrapper">

    <?= $this->include('layout/navbar'); ?>
    <?= $this->include('layout/sidebar'); ?>
    <?= $this->include('layout/header'); ?>
    <?= $this->include('./flash/flash'); ?>
    <div class="preloader">
        <div class="loading">
            <img src="<?= base_url();?>/assets/img/gif-muhka.gif" width="300">
        </div>
    </div>
    <?= $this->renderSection('content'); ?>
    <?= $this->include('layout/control-sidebar'); ?>


    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Template by <a href="https://adminlte.io">AdminLTE.io</a>
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2021 - <?= date('Y'); ?> <a
                    href="https://yantodev.github.io">Yantodev</a>.</strong> All rights
        reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="<?= base_url(); ?>/assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

<!-- jQuery -->
<script src=<?= base_url('assets/template/plugins/jquery/jquery.min.js') ?>></script>
<!-- Bootstrap 4 -->
<script src=<?= base_url('assets/js/datatables-demo.js'); ?>></script>
<!-- Page level plugins -->
<!-- DataTables  & Plugins -->
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
<!-- AdminLTE App -->
<script src=<?= base_url('assets/template/dist/js/adminlte.min.js') ?>></script>
<script src=<?= base_url('assets/config/config.js') ?>></script>
<script src="<?= base_url() ?>/assets/yantodev/Flashdata.js"></script>
<script src=<?= base_url('assets/yantodev/Iduka.js') ?>></script>
<script src=<?= base_url('assets/yantodev/Guru.js') ?>></script>
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