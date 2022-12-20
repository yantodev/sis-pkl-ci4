<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3>Welcome, <b><?= $data->name; ?></b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3" style="text-align: center">
                            <img src="<?= base_url('/assets/img/users/' . $data->image); ?>"
                                 class="img-circle elevation-2"
                                 alt="User Image" width="150px">
                        </div>
                        <div class="col-lg-9">
                            <div>
                                <div class="row">
                                    <p class="column">Lokasi PKL</p>
                                    <p class="column-name">: <?= $dataIduka->iduka; ?></p>
                                </div>
                                <div class="row">
                                    <p class="column">Alamat</p>
                                    <p class="column-name">: <?= $dataIduka->address; ?> </p>
                                </div>
                                <div class="row">
                                    <p class="column">Status</p>
                                    <p class="column-name">:
                                        <?= statusPKL($dataIduka->status); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <?php if (!$dataIduka->status): ?>
                                    <a href="<?= base_url('student/verifikasi?id=' . $dataIduka->id . '&statusData=student'); ?>">
                                        <button class="btn bg-gradient-green">
                                            <em class="fas fa-check-circle"></em>
                                            VERIFIKASI SEKARANG
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>