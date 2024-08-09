<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>INVOICES <?= $no_invoices ?></title>
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
?>

<body class="text-all" style="padding:12px;">
    <main>
        <?php $showData = $datas->dataInvoice->data[0];  ?>
        <table width="100%">
            <tr>
                <td colspan="2" width="100%" class="text-center">
                    <h1 class="text-all">INVOICE <?= $no_invoices ?></h1>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr class="line-hr" />
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <p class="m-0 small">Tanggal</p>
                            </td>
                            <td>
                                <p class="m-0 small">:</p>
                            </td>
                            <td>
                                <p class="m-0 small"><b><?= tgl_indo(date('Y-m-d', strtotime($showData->datetime))) ?></b></p>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="m-0 small"><b><?= $showData->line->name ?></b></p>

                            </td>
                        </tr>
                    </table>
                </td>
                <td class="text-end">
                    <p class="m-0 small text-end">Supplier : <b><?= $showData->supplier->name ?></b></p>
                </td>
            </tr>
        </table>
        <?php

        $colspan = 4;
        if ($is_harga_satuan == 'true') {
            $colspan = 5;
        }
        ?>
        <table style="margin-top:10px;font-size:10px;width:100%;margin-bottom:10px;margin-top:30px" class="table_main">
            <tr style="text-align: center;">
                <th class="th_main p-10 small">NAMA ITEM</th>
                <th class="th_main p-10 small">GRADE</th>
                <th class="th_main p-10 small">BALE</th>
                <th class="th_main p-10 small">BERAT</th>
                <?php if ($is_harga_satuan == 'true') { ?>
                    <th class="th_main p-10 small">HARGA SATUAN</th>
                <?php } ?>
                <th class="th_main p-10 small">TOTAL HARGA</th>
            </tr>
            <?php
            $totalPrice = 0;
            $totalBale = 0;
            $totalBerat = 0;
            foreach ($showData->purchase_details as $key => $value) { ?>
                <tr>
                    <td class="td_main p-10 small"><?= $value->item->name ?></td>
                    <td class="td_main p-10 small text-center"><?= $value->grade->name ?></td>
                    <td class="td_main p-10 small text-end"><?= $value->qty ?></td>
                    <td class="td_main p-10 small text-end"><?= $value->weight ?></td>
                    <?php if ($is_harga_satuan == 'true') { ?>
                        <td class="td_main p-10 small text-end">Rp. <?= number_format($value->price) ?></td>
                    <?php } ?>
                    <td class="td_main p-10 small text-end">Rp. <?= number_format($value->price * $value->weight) ?></td>
                </tr>
            <?php
                $totalBale += $value->qty;
                $totalBerat += $value->weight;
                $totalPrice += $value->price * $value->weight;
            } ?>
            <tr>
                <td colspan="<?= $colspan ?>" class="td_main p-10 small text-end">SUBTOTAL (TOTAL <?= number_format($totalBale) ?> BALE, <?= $totalBerat ?> KG)</td>
                <td class="td_main p-10 small text-end">Rp. <?= number_format($totalPrice) ?></td>
            </tr>
            <?php if ($is_pajak == 'true') { ?>
                <tr>
                    <td colspan="<?= $colspan ?>" class="td_main p-10 small text-end">PD 0.5</td>
                    <?php $tax = $totalPrice * 0.005 ?>
                    <td class="td_main p-10 small text-end">Rp. <?= number_format($tax) ?></td>
                </tr>
            <?php } else {
                $tax = 0;
            } ?>
            <tr>
                <td colspan="<?= $colspan ?>" class="td_main p-10 small text-end"><b>TOTAL HARGA</b></td>
                <td class="td_main p-10 small text-end"><b>Rp. <?= number_format($totalPrice - $tax) ?></b></td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 20px;">
            <tr>
                <td width="50%" style="vertical-align: top;">
                    <?php if ($is_pajak == 'true') { ?>
                        <p class="m-0 small"><b>NB</b></p>
                        <p class="m-0 small">PAJAK DAERAH 0.5% DITANGGUNG SUPPLIER</p>
                    <?php } ?>
                </td>
                <td width="25%" class="text-center p-10" style="vertical-align: top;">
                    <p class="m-0 small"><b>SUPPLIER</b></p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p class="m-0 small"><?= $showData->supplier->name ?></p>
                </td>
                <td width="25%" class="text-center p-10" style="vertical-align: top;">
                    <p class="m-0 small"><b>ADMIN</b></p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p class="m-0 small"><?= strtoupper(abbreviateName($name)) ?></p>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>