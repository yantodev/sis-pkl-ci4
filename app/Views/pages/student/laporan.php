<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="card-header">
                        <div>
                            <h3>Daftar Laporan</h3>
                            <form action="<?= base_url('Student/laporan'); ?>" method="get">
                                <div class="form-group">
                                    <div class="row">
                                        <div>
                                            <div>
                                                <label for="date">Tanggal</label>
                                                <input type="date" class="form-control" id="date" name="date">
                                            </div>
                                            <label for="master_laporan"></label>
                                            <select class="form-control"
                                                    name="master_laporan"
                                                    id="master_laporan"
                                                    onchange="showMasterSubLaporan()">
                                                <option value="">Pilih Bidang Pekerjaan</option>
                                                <?php foreach ($master_data as $md): ?>
                                                    <option value="<?= $md->id; ?>"><?= $md->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div id="master_sub_laporan"></div>
                                        <div id="master_sub_laporan_1"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">SIMPAN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Tanggal</th>
                            <th>Bidang Pekerjaan</th>
                            <th>Uraian Pekerjaan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($laporan as $l): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= tanggal($l->date); ?></td>
                                <td><?= $l->bidang_pekerjaan; ?></td>
                                <td><?= $l->uraian_1; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>