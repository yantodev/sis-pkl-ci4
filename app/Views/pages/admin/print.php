<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card col">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <div class="wrapper">
            <button class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modal-default" onclick="modal()">
                <em class="fa fa-print"> Permohonan PKL</em>
            </button>
            <button class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modal-surat-tugas">
                <em class="fa fa-print"> Surat Tugas</em>
            </button>
            <button class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modal-surat-pengantar">
                <em class="fa fa-print"> Surat Pengantar</em>
            </button>
            <button class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modal-id-card">
                <em class="fa fa-money-check-alt"> ID Card</em>
            </button>
            <button class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modal-kop-surat">
                <em class="fa fa-envelope"> KOP Surat</em>
            </button>
            <button class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modal-surat-jalan">
                <em class="fa fa-envelope"> Surat Jalan</em>
            </button>
            <button class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modal-daftar-siswa">
                <em class="fa fa-users"> Daftar Peserta</em>
            </button>
        </div>
    </div>
</div>
<?= $this->include('pages/admin/modal/modal-cetak-surat-permohonan'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-surat-tugas'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-surat-pengantar'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-id-card'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-kop-surat'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-surat-jalan'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-daftar-peserta'); ?>
<?= $this->endSection() ?>; ?>