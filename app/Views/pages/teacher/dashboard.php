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
                                <?php if ($tutor): ?>
                                    <h4>
                                        Saat ini anda terdaftar sebagai pendamping di <b><?= $tutor->iduka; ?></b>
                                        yang beralamat di <b><?= $tutor->address; ?></b>
                                    </h4>
                                    <h5>Daftar Siswa:</h5>
                                <?php else: ?>
                                    <h4>Mohon maaf, saat ini anda terdaftar sebagai pendamping</h4>
                                <?php endif; ?>
                                <ol>
                                    <?php if ($student): ?>
                                        <?php foreach ($student as $s): ?>
                                            <li><?= $s->name; ?></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>

                                    <?php endif; ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>