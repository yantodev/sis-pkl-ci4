<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <select class="form-control col-lg-3" id="major" name="major" onchange="getStudentByMajor()">
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($major as $j): ?>
                    <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!--        <button class="btn btn-outline-primary" onclick="addIduka()">-->
        <!--            <i class="fa fa-plus"></i> Tambah Iduka-->
        <!--        </button>-->
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Tahun Pelajaran</th>
                <th>Lokasi PKL</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($siswa as $s) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="name"><?= $s->nis; ?></td>
                    <td id="name"><?= $s->name; ?></td>
                    <td id="class"><?= $s->kelas; ?></td>
                    <td id="major"><?= $s->jurusan; ?></td>
                    <td id="major"><?= $s->tp; ?></td>
                    <td id="major"><?= $s->iduka; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" onclick="
                                editStudent(<?= $s->id; ?>,<?= $s->masterDataId; ?>)
                                "> Edit
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.card-body -->

<?= $this->endSection() ?>; ?>