<div class="modal fade" id="modal-daftar-siswa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cetak Surat Jalan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/admin/printParticipantList'); ?>" method="post">
                    <div class="form-group">
                        <select class="form-control" type="text" id="tp_daftar_siswa" name="tp_daftar_siswa" required>
                            <option value="">--Pilih Tahun Pelajaran--</option>
                            <?php foreach ($tp as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Cetak</button>
            </div>
            </form>
        </div>
    </div>
</div>