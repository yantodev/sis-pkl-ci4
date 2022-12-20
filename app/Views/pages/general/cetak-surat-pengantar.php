<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Tugas</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
    <style>
        @page {
            margin-top: 20px;
            height: 100%;
        }

        #body {
            height: 100%;
        }
    </style>
</head>
<body>
<?php foreach ($result as $res): ?>
    <div id="body">
        <img src="<?= base_url('assets/img/kop.png'); ?>" alt="">
        <div>
            <div class="row">
                <p class="column">Nomor</p>
                <p class="column-name">: <?= $surat->nomor; ?></p>
            </div>
            <div class="row">
                <p class="column">Lampiran</p>
                <p class="column-name">: 1 Bandel</p>
            </div>
            <div class="row">
                <p class="column">Hal</p>
                <p class="column-name">: Pengiriman Peserta PKL</p>
            </div>
        </div>

        <p>Kepada<br/>
            Yth.<b> <?= $instansi; ?> <?= $res->idukaName; ?></b><br/>
            di <b><?= $res->address ?></b>
        </p>
        <p>Assalamu'alaikum Wr.Wb</p>
        <p>
            Sesuai program Kurikulum SMK Muhammadiyah Karangmojo tahun pelajaran <?= $res->tpName; ?> dan surat
            kesanggupan Bapak/Ibu untuk menerima siswa kami untuk melaksanakan kegiatan Praktik Kerja
            Lapangan (PKL) maka dengan ini kami kirimkan peserta PKL sebagaimana daftar terlampir
        </p>
        <p>
            Selanjutnya para peserta PKL kami serahkan sepenuhnya kepada Bapak/Ibu untuk mendapatkan
            bimbingan, pendidikan dan pelatihan, mulai tanggal 04 Januari 2022 sampai dengan 31 Maret 2022.
            Pada akhir PKL nanti kami mohon kepada Bapak/Ibu berkenan memberikan nilai terhadap siswa
            peserta PKL tersebut. Mengenai format penilaian, petunjuk penilaian, buku absen siswa ada
            pada buku laporan pembimbing. Setelah selesai masa PKL para siswa juga diwajibkan
            mengumpulkan buku laporan kegiatan PKL yang telah ditandatangani oleh Pembimbing
            IDUKA pada setiap jenis pekerjaan
        </p>
        <p>
            Demikian atas perhatian dan kerjasamanya kami sampaikan terimakasih.
        </p>
        <table class="table">
            <tbody>
            <tr>
                <td width="400px" rowspan="4"></td>
                <td>Karangmojo, <?= tgl2($surat->tanggal); ?></td>
            </tr>
            <tr>
                <td>
                    <img src="
            <?= base_url('assets/img/ttd-ks.png'); ?>" width="170px" height="100px" alt="ttd-kas">
                </td>
            </tr>
            <tr>
                <td>
                    MUNAWAR, S.Pd.I
                </td>
            </tr>
            <tr>
                <td>
                    NBM. 1076230
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>
</body>
</html>
