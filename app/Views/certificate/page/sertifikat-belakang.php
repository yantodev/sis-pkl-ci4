8<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        .container {
            margin: 100px;
        }

        .datasiswa table tr th {
            text-align: left;
            font-size: 20px;
        }

        .nilai {
            text-align: center;
            font-size: 20px;
            margin-top: 20px;
        }

        .nilai table thead tr th {
            font-size: 20px;
        }

        .nilai table tbody tr th {
            text-align: left;
            font-size: 20px;
            text-transform: capitalize;
        }

        .footer table tr th {
            text-align: left;
            font-size: 20px;
        }
    </style>
</head>

<body>
<div class="container">
    <div style="text-align: center;">
        <h1 style="font-size:40px;margin: 0px;">Kompetensi Keahlian</h1>
        <h1 style="font-size:30px;margin-top: 0px;"><?= $jurusan; ?></h1>
    </div>
    <div class="datasiswa">
        <table>
            <tr>
                <th>Nama Siswa</th>
                <th>:</th>
                <th><?= $data->name; ?></th>
            </tr>
            <tr>
                <th>Nomot Induk Siswa Nasional</th>
                <th>:</th>
                <th><?= $data->nisn; ?></th>
            </tr>
        </table>
    </div>
    <div class="nilai">
        <table border='1' cellspacing='0' width="100%" align="center">
            <thead>
            <tr>
                <th>NO</th>
                <th>KOMPETENSI KEAHLIAN/SUB KOMPETENSI</th>
                <th>NILAI</th>
            </tr>
            </thead>
            <tbody>
            <?php $number = 1; ?>
            <?php foreach ($table as $t): ?>
                <tr>
                    <th align="center"><?= $number++; ?></th>
                    <th><?= $t->name; ?></th>
                    <th width="100px" align="center"> <?php
                        $named = "nil_" . $number - 1;
                        echo number_format($data->$named, 2); ?></th>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="footer">
        <table align="center" style="margin-top:40px;">
            <tr>
                <th align="center">Kepala Sekolah</th>
                <th width="250px"></th>
                <th align="center">Penguji/Asesor</th>
            </tr>
            <tr>
                <th height="100px" valign="bottom" align="center">
                    <?= $sekolah->kepala_sekolah; ?>
                </th>
                <td></td>
                <th valign="bottom" align="center">
                    <?= $asesor->name_assessor; ?>
                </th>
            </tr>
            <tr>
                <th align="center">NBM. <?= $sekolah->nip; ?></th>
            </tr>
        </table>
    </div>
</div>
</body>

</html>