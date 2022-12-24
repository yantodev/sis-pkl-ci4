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
    </style>
</head>
<body>
<img src="<?= base_url('assets/img/kop.png'); ?>" alt="">
<h3 class="center">
    <u>SURAT TUGAS</u>
    <br/>Nomor : <?= $surat->nomor; ?></h3>
<p>Kepala SMK Muhammadiyah Karangmojo Gunungkidul, memberi tugas kepada :
</p>
<div class="container">
    <table>
        <tr>
            <td>Nama</td>
            <td class="column-name">: <?= $result->name; ?></td>
        </tr>
        <tr>
            <td>NBM</td>
            <td class="column-name">: <?= $result->nbm; ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td class="column-name">: <?= $result->position; ?></td>
        </tr>
    </table>
</div>

<p>Sebagai guru pembimbing dalam praktik kerja lapangan, pada :</p>

<table class="table" border="1" cellspacing="0">
    <thead>
    <tr>
        <th>No.</th>
        <th>Nama Siswa</th>
        <th>Kompetensi Keahlian</th>
        <th>Tempat PKL</th>
        <th>Alamat</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    <?php foreach ($data as $d) : ?>
        <tr>
            <td class="center"><?= $i; ?></td>
            <td class="top"><?= ucwords(strtolower($d->name)); ?></td>
            <td class="top">
                <?= ucwords(strtolower($d->jurusan)) ?>
            </td>
            <td class="top">
                <?= ucwords(strtolower($d->iduka)) ?>
            </td>
            <td class="top">
                <?= ucwords(strtolower($d->alamat)); ?>
            </td>
        </tr>
        <?php $i++; ?>
    <?php endforeach; ?>
    </tbody>
</table>
<p>Demikian surat tugas ini kami buat, agar dapat dilaksanakan dengan penuh tanggungjawab.
</p>
<table class="table">
    <tbody>
    <tr>
        <td width="400px" rowspan="4"></td>
        <td><?= $surat->tgl_surat; ?></td>
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
</body>
</html>