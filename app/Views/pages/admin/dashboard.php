<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome, <?= $users; ?></h5>
                    <p class="card-text">
                    </p>
                    <p>
                        <img src="<?= base_url();?>/assets/img/users/default.png" width="100px" alt="product">
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>