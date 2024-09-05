<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SURAT JALAN <?= $doc_num ?></title>
    <style type="text/css">
        body {
            /* font-family: 'Nunito';
            font-family: 'Nunito', sans-serif; */
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .table_main,
        .th_main,
        .td_main {
            border: 1px solid black;
            border-color: #444941;
            border-collapse: collapse;
        }

        .td_main {
            font-size: 11px;
            padding: 1px;
            vertical-align: middle;
            padding-top: 3px;
            padding-bottom: 3px;
        }

        .bg_color_blue {
            background-color: #CEE5D0;
        }

        .bg_color_yellow {
            background-color: #FFE162;
        }

        .th_main {
            padding: 5px;
            height: 10px;
            text-align: center;
            word-wrap: break-word;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .page_break {
            page-break-before: always;
            margin-top: 10px;
        }

        .bg-skm-0 {
            background-color: #73A9AD;
        }

        .bg-skm-1 {
            background-color: #B3C890;
        }

        .bg-skm-2 {
            background-color: #FCFFB2;
        }

        @page {
            margin-top: 20px;
            margin-bottom: 10px;
            margin-left: 30px;
            margin-right: 30px;
        }

        table {
            page-break-inside: always;
        }

        table tr {
            page-break-inside: always;
        }

        table tr td {
            page-break-inside: always;
        }

        .bg-pita-other-0 {
            background-color: #F2DF3A !important;
        }

        .bg-pita-other-1 {
            background-color: #3AB4F2 !important;
        }

        .bg-pita-other-2 {
            background-color: #0078AA !important;
        }

        .card {
            position: relative;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 2px;
            padding-left: 10px;
        }

        .bg-shift-42 {
            background-color: #9DB2BF !important;
            border-width: 2px;
            border-color: #1D5B79;
        }

        .bg-shift-39 {
            background-color: #EA906C !important;
            border-width: 2px;
            border-color: #B31312;
        }

        .bg-shift-44 {
            background-color: #526D82 !important;
            color: white;
            border-width: 2px;
            border-color: #1D5B79;
        }

        .bg-shift-41 {
            background-color: #B31312 !important;
            color: white;
            border-width: 2px;
            border-color: #470707;
        }

        .bg-line {
            background-color: #d7f0fc !important;
        }

        .bg-danger {
            background-color: #ec9797 !important;
        }

        .text-all {
            color: #5a5a5a;
        }

        .text-grey {
            color: #818181;
        }

        .m-0 {
            margin: 0px;
        }

        .line-hr {
            height: 0.5px;
            border: none;
            color: #818181;
            background-color: #818181;
            margin-bottom: 20px;
        }

        .small {
            font-size: 12px;
        }

        .small-text {
            font-size: 10px;
        }

        .super-small-text {
            font-size: 8px;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-2 {
            padding: 2px;
        }

        .p-5 {
            padding: 5px;
        }

        .p-10 {
            padding: 10px;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .d-flex {
            display: flex !important;
        }

        .container {
            /* display: flex;
            justify-content: space-between; */
        }

        .column {
            width: 48%;
        }

        .page_break {
            page-break-before: always;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -15px;
            margin-right: -15px;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding-left: 15px;
            padding-right: 15px;
        }
    </style>
</head>
<?php

use function PHPUnit\Framework\lessThan;

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
function abbreviateName($fullName)
{
    // Pisahkan nama berdasarkan spasi
    $nameParts = explode(' ', $fullName);
    // Jika nama hanya terdiri dari satu atau dua bagian, kembalikan tanpa perubahan
    if (count($nameParts) <= 2) {
        return $fullName;
    }

    // Ambil bagian pertama dan kedua
    $firstPart = $nameParts[0];
    $secondPart = $nameParts[1];
    // Ambil inisial dari bagian ketiga dan seterusnya
    $initials = '';
    for ($i = 2; $i < count($nameParts); $i++) {
        $initials .= ' ' . strtoupper($nameParts[$i][0]);
    }

    // Gabungkan bagian pertama, kedua, dan inisial
    return $firstPart . ' ' . $secondPart . $initials;
}
function formatIndonesianDate($dateString)
{
    // Array untuk nama hari dan bulan dalam Bahasa Indonesia
    $days = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    $months = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];

    // Buat objek DateTime dari string input
    $date = new DateTime($dateString);

    // Ambil nama hari dan bulan dalam Bahasa Inggris
    $dayName = $date->format('l'); // Menghasilkan nama hari
    $monthName = $date->format('F'); // Menghasilkan nama bulan

    // Ganti dengan nama hari dan bulan dalam Bahasa Indonesia
    $dayName = $days[$dayName];
    $monthName = $months[$monthName];

    // Format tanggal sesuai dengan kebutuhan
    return $dayName . ', ' . $date->format('j') . ' ' . $monthName . ' ' . $date->format('Y');
}
function formatDate2($inputDate)
{
    // Mengonversi string input menjadi objek DateTime
    $date = new DateTime($inputDate);

    // Mengembalikan tanggal dalam format DD/MM/YY
    return $date->format('d/m/y');
}

$totalIndex = count($datas);
$sisaIndex = count($datas);
$index = 0;
$constantIndex = 65;
$loop = ceil($totalIndex);
$row = ceil($loop / 2);
?>

<body class="text-all" style="padding:12px;padding-top: 0px;">
    <main>
        <table width="100%">
            <tr>
                <td width="100%">
                    <h3 class="text-center">Packing List <?= $doc_num ?></h3>
                </td>
            </tr>
        </table>
        <div class="container">
            <?php for ($j = 0; $j < $row; $j++) {
                if ($sisaIndex > 0) { ?>
                    <table width="100%">
                        <tr>
                            <?php for ($key = 0; $key < 2; $key++) {
                                if ($sisaIndex > 0) { ?>
                                    <td width="50%" style="max-width: 50%;vertical-align: top;">
                                        <table style="font-size:10px;margin-bottom:10px;margin-right:24px;" width="100%" class="table_main">
                                            <tr>
                                                <th class="th_main p-2 small-text">No</th>
                                                <!-- <th class="th_main p-2 small-text">Tgl</th> -->
                                                <th class="th_main p-2 small-text">No Bale</th>
                                                <th class="th_main p-2 small-text">Berat</th>
                                                <th class="th_main p-2 small-text">Item</th>
                                                <th class="th_main p-2 small-text">Grade</th>
                                            </tr>
                                            <?php for ($i = 0; $i < $constantIndex; $i++) {
                                                if (isset($datas[$index])) { ?>
                                                    <tr>
                                                        <td class="td_main p-2 super-small-text text-center"><?= $index + 1 ?></td>
                                                        <!-- <td class="td_main p-2 super-small-text"><?= $datas[$index]->inventory->date ?></td> -->
                                                        <td class="td_main p-2 super-small-text text-center"><?= formatDate2($datas[$index]->inventory->date) ?>-<?= $datas[$index]->inventory->bale_number ?></td>
                                                        <td class="td_main p-2 super-small-text"><?= number_format(round($datas[$index]->weight, 2)) ?></td>
                                                        <td class="td_main p-2 super-small-text"><?= $datas[$index]->item->code ?></td>
                                                        <td class="td_main p-2 super-small-text"><?= $datas[$index]->item_grade->name ?></td>
                                                    </tr>
                                            <?php $index++;
                                                }
                                            } ?>
                                        </table>
                                    </td>
                                <?php $sisaIndex = $sisaIndex - $constantIndex;
                                } else {
                                ?>
                                    <td width="50%" style="max-width: 50%;vertical-align: top;"></td>
                            <?php
                                }
                            } ?>
                        </tr>
                    </table>
                    <?php if ($sisaIndex > 0) { ?>
                        <div class="page_break"></div>
                    <?php } ?>
            <?php }
            } ?>
        </div>
    </main>
</body>

</html>