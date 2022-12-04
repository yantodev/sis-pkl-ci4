<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card col-lg">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <button class="btn btn-outline-primary" onclick="addUser()">
            <i class="fa fa-plus"></i> Tambah Guru
        </button>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>NIP/NBM</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>HP</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="name"><?= $d->nbm; ?></td>
                    <td id="name"><?= $d->name; ?></td>
                    <td id="name"><?= $d->position; ?></td>
                    <td id="name"><?= $d->hp; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" onclick="updateTeacher(<?= $d->userDetailId; ?>)">
                            Edit
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>; ?>