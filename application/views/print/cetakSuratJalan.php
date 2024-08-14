<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SURAT JALAN <?= $document_number ?></title>
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

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
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
?>

<body class="text-all" style="padding:12px;">
    <main>
        <table width="100%">
            <tr>
                <td width="50%">
                    <h2 class="text-center"><b>SURAT JALAN <?= $datas->document_number ?></b></h2>
                </td>
                <td width="40%">
                    <table>
                        <tr>
                            <td width="55px" style="vertical-align: top;">
                                <p class="m-0 small-text">Tanggal</p>
                            </td>
                            <td width="5px" style="vertical-align: top;">
                                <p class="m-0 small-text">:</p>
                            </td>
                            <td>
                                <p class="m-0 small-text"><?= formatIndonesianDate($datas->shipment_at) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td width="55px" style="vertical-align: top;">
                                <p class="m-0 small-text">Pemilik</p>
                            </td>
                            <td width="5px" style="vertical-align: top;">
                                <p class="m-0 small-text">:</p>
                            </td>
                            <td>
                                <p class="m-0 small-text">Bpk Bambang Sunarto</p>
                            </td>
                        </tr>
                        <tr>
                            <td width="55px" style="vertical-align: top;">
                                <p class="m-0 small-text">Tujuan</p>
                            </td>
                            <td width="5px" style="vertical-align: top;">
                                <p class="m-0 small-text">:</p>
                            </td>
                            <td>
                                <p class="m-0 small-text" style="margin-bottom: 3px;"><?= $datas->warehouse_destination->name ?></p>
                                <p class="m-0 small-text"><?= $datas->warehouse_destination->address ?></p>
                            </td>
                        </tr>
                    </table>
                </td>

                <td class="text-end">
                    <img src="<?= base64_decode(str_replace(' ', '', $qrcode)) ?>" style="width:70px; height:70px">
                </td>
            </tr>

            <tr>
                <td colspan="5" style="padding-top: 30px;padding-bottom: 10px;">
                    <p class="m-0 small-text">Kami kirimkan barang - barang tersebut di bawah ini dengan kendaraan <?= $datas->vehicle_model->name ?> No <?= $datas->vehicle_number ?></p>
                </td>
            </tr>
        </table>
        <table style="font-size:10px;width:100%;margin-bottom:10px;" class="table_main">
            <tr>
                <th class="th_main p-10 small" style="width: 20px;">No</th>
                <th class="th_main p-10 small">Nama Barang</th>
                <th class="th_main p-10 small">Grade</th>
                <th class="th_main p-10 small">QTY</th>
                <th class="th_main p-10 small">Berat (kg)</th>
            </tr>
            <?php if ($datas->details) {
                $totalQty = 0;
                $totalWeight = 0;
                foreach ($datas->details as $key => $value) { ?>
                    <tr>
                        <td class="td_main p-5 small text-center"><?= $key + 1 ?></td>
                        <td class="td_main p-5 small text-center"><?= $value->item->name ?></td>
                        <td class="td_main p-5 small text-center"><?= $value->item_grade->name ?></td>
                        <td class="td_main p-5 small text-end"><?= number_format($value->qty) ?></td>
                        <td class="td_main p-5 small text-end"><?= number_format($value->weight) ?></td>
                    </tr>
                <?php
                    $totalQty += $value->qty;
                    $totalWeight += $value->weight;
                } ?>
                <tr>
                    <th class="th_main p-5 small text-end" colspan="3">Total</th>
                    <th class="th_main p-5 small text-end"><?= number_format($totalQty) ?></th>
                    <th class="th_main p-5 small text-end"><?= number_format($totalWeight) ?></th>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="td_main p-5 small text-center" colspan="5">Tidak ada data</td>
                </tr>
            <?php } ?>
        </table>
        <table width="100%" style="margin-top: 20px;">
            <tr>
                <td width="30%" class="text-center">
                    <p class="m-0 small">Pengirim</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p class="m-0 small"><?= $datas->user_sender->name ?></p>
                </td>
                <td width="30%" class="text-center">
                    <p class="m-0 small">Driver</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p class="m-0 small"><?= $datas->driver_name ?></p>
                </td>
                <td width="30%" class="text-center">
                    <p class="m-0 small">Penerima</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p class="m-0 small">______________________</p>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>