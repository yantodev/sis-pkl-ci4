<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
<!--        <form action="" type="GET">-->
            <select class="form-control-info" id="jurusan" name="jurusan" onchange="getIduka()">
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($jurusan as $j): ?>
                    <option value="<?= $j['id']; ?>"><?= $j['jurusan']; ?></option>
                <?php endforeach; ?>
            </select>
<!--            <button type="submit" class="btn btn-outline-info">SAVE</button>-->
<!--        </form>-->
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Iduka</th>
                <th>Alamat</th>
                <th>Penanggungjawab</th>
                <th>No HP</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($iduka as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $d['iduka']; ?></td>
                    <td><?= $d['alamat']; ?></td>
                    <td><?= $d['nama_pembimbing_instansi']; ?></td>
                    <td><?= $d['hp_pembimbing']; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <button class="btn btn-outline-primary" onclick="addCategory()"><i class="fa fa-plus"></i> Tambah Iduka</button>
        </div>
    </div>
</div>
<!-- /.card-body -->

<?= $this->endSection() ?>; ?>