<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            $this->load->helper('cookie');
            $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $name   = 'link';
            $value  = $link;
            $expire = time() + 1000;
            $path  = '/';
            $secure = TRUE;
            setcookie($name, $value, $expire, $path);
            // echo $this->input->cookie('link');
            redirect('Auth');
        }
<<<<<<< HEAD
        $this->user_id = $this->session->userdata('id');
        $this->username = $this->session->userdata('username');
        $this->position_name = $this->session->userdata('position_name');
        $this->position_detail_name = $this->session->userdata('position_detail_name');
        $this->permission = $this->session->userdata('permission');
        $this->warehouse_id = $this->session->userdata('warehouse_id');
        $this->templateHeader = [
=======
        $this->user_id = $this->session->userdata('user_id');
    }
    public function hutang()
    {
        $this->template->views('report/hutang');
    }
    public function reportMutasiGudang()
    {
        $data['title'] = 'Report Gudang';
        $this->template->views('report/mutasi_gudang', $data);
    }
    public function reportOpname()
    {
        $data['title'] = 'Report Opname';
        $this->template->views('report/opname', $data);
    }
    public function reportPO()
    {
        $data['title'] = 'Report PO';
        $this->template->views('report/reportPO', $data);
    }
    public function reportPR()
    {
        $data['title'] = 'Report PR';
        $this->template->views('report/reportPR', $data);
    }
    public function exportLaporanGudang()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $item_id = (explode(',', $explodedParams[1]));
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $textItem = '';
        // print_r($item_id);
        foreach ($item_id as $k => $v) {
            $textItem .= 'item_id%5B%5D=' . $v . '&';
        }
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $url = "Api_Warehouse/mutasiStock?" . $textItem . "date_start=" . $date_start . "&date_end=" . $date_end . "";
        $main = json_decode(file_get_contents(api_url($url)), true);
        $body = $main['data'];
        // print_r($body);
        $huruf = range('A', 'Z');
        $extension = 'xlsx';
        $fileName = 'Report Gudang';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:A3')->setCellValue('A1', 'No');
        $sheet->mergeCells('B1:B3')->setCellValue('B1', 'Nama Item');
        $sheet->mergeCells('C1:C3')->setCellValue('C1', 'Satuan');
        $sheet->mergeCells('D1:D3')->setCellValue('D1', 'Stock Awal');
        $bulan_awal = 4;
        $bulan_akhir = 4;
        $tanggal_awal = 4;
        $tanggal_akhir = 4;
        $stock_awal = 5;
        foreach (json_decode($body[0]['datas']) as $key => $value) {
            // kolom bulan
            $bulan_akhir  = $bulan_awal + (count($value->data_perhari) * 4);
            $bulan_awal = $bulan_awal + 1;
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($bulan_awal) . '1:' . Coordinate::stringFromColumnIndex($bulan_akhir) . '1')->setCellValue(Coordinate::stringFromColumnIndex($bulan_awal) . '1', $value->bulan);
            $bulan_awal = $bulan_akhir;
            // kolom bulan
            // kolom tanggal
            foreach ($value->data_perhari as $keys => $values) {
                $tanggal_akhir  = $tanggal_awal + 4;
                $tanggal_awal = $tanggal_awal + 1;
                $sheet->mergeCells(Coordinate::stringFromColumnIndex($tanggal_awal) . '2:' . Coordinate::stringFromColumnIndex($tanggal_akhir) . '2')->setCellValue(Coordinate::stringFromColumnIndex($tanggal_awal) . '2', $values->perhari);
                $tanggal_awal = $tanggal_akhir;
                // kolom stock
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal++) . '3', 'IN');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal++) . '3', 'IN STOK');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal++) . '3', 'OUT');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal++) . '3', 'OUT STOK');
                // kolom stock
            }
            // kolom tanggal
        }
        $bulan_awal++;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($bulan_awal) . '1:' . Coordinate::stringFromColumnIndex($bulan_awal) . '3')->setCellValue(Coordinate::stringFromColumnIndex($bulan_awal++) . '1', 'TOTAL IN');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($bulan_awal) . '1:' . Coordinate::stringFromColumnIndex($bulan_awal) . '3')->setCellValue(Coordinate::stringFromColumnIndex($bulan_awal++) . '1', 'TOTAL IN OTHER');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($bulan_awal) . '1:' . Coordinate::stringFromColumnIndex($bulan_awal) . '3')->setCellValue(Coordinate::stringFromColumnIndex($bulan_awal++) . '1', 'TOTAL OUT');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($bulan_awal) . '1:' . Coordinate::stringFromColumnIndex($bulan_awal) . '3')->setCellValue(Coordinate::stringFromColumnIndex($bulan_awal++) . '1', 'TOTAL OUT OTHER');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($bulan_awal) . '1:' . Coordinate::stringFromColumnIndex($bulan_awal) . '3')->setCellValue(Coordinate::stringFromColumnIndex($bulan_awal++) . '1', 'STOCK AKHIR');

        $rowCount = 4;
        foreach ($body as $key => $value) {
            $sheet->setCellValue('A' . $rowCount, $key + 1);
            $sheet->setCellValue('B' . $rowCount, $value['name']);
            $sheet->setCellValue('C' . $rowCount, $value['satuan_name']);
            $sheet->setCellValue('D' . $rowCount, $value['stok_awal']);
            $total_in = 0;
            $total_inother = 0;
            $total_out = 0;
            $total_outother = 0;
            $stock_awal_2 = 5;
            foreach (json_decode($value['datas']) as $keys => $values) {
                foreach ($values->data_perhari as $keys2 => $values2) {
                    $total_in = $total_in + $values2->total_mutasi->jumlah_in;
                    $total_inother = $total_inother + $values2->total_mutasi->jumlah_in_other;
                    $total_out = $total_out + $values2->total_mutasi->jumlah_out;
                    $total_outother = $total_outother + $values2->total_mutasi->jumlah_out_other;
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $values2->total_mutasi->jumlah_in);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $values2->total_mutasi->jumlah_in_other);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $values2->total_mutasi->jumlah_out);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $values2->total_mutasi->jumlah_out_other);
                }
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $total_in);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $total_inother);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $total_out);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $total_outother);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($stock_awal_2++) . $rowCount, $value['stok_akhir']);
            $rowCount++;
        }
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT GUDANG ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function exportReportPO()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $supplier_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $url = "Api_Warehouse/reportPrPo?supplier_id=" . $supplier_id . "&date_start=" . $date_start . "&date_end=" . $date_end . "";
        $main = json_decode(file_get_contents(api_url($url)), true);
        $body = $main['data'];
        $huruf = range('A', 'Z');
        $extension = 'xlsx';
        $fileName = 'Report PO';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TANGGAL PO');
        $sheet->setCellValue('B1', 'KODE NTM');
        $sheet->setCellValue('C1', 'NO PR');
        $sheet->setCellValue('D1', 'NOMOR PO');
        $sheet->setCellValue('E1', 'NAMA SUPPLIER');
        $sheet->setCellValue('F1', 'NAMA BAHAN');
        $sheet->setCellValue('G1', 'QTY');
        $sheet->setCellValue('H1', 'SATUAN');
        $sheet->setCellValue('I1', 'HARGA');
        $sheet->setCellValue('J1', 'DPP');
        $sheet->setCellValue('K1', 'PPN');
        $sheet->setCellValue('L1', 'TOTAL');
        $rowCount = 2;
        for ($k = 0; $k < count($body); $k++) {
            $sheet->setCellValue('A' . $rowCount, $body[$k]['date']);
            $sheet->setCellValue('B' . $rowCount, $body[$k]['item_code']);
            $sheet->setCellValue('C' . $rowCount, $body[$k]['no_pr']);
            $sheet->setCellValue('D' . $rowCount, $body[$k]['no_po']);
            $sheet->setCellValue('E' . $rowCount, $body[$k]['supplier_name']);
            $sheet->setCellValue('F' . $rowCount, $body[$k]['item_name']);
            $sheet->setCellValue('G' . $rowCount, $body[$k]['jumlah']);
            $sheet->setCellValue('H' . $rowCount, $body[$k]['item_satuan']);
            $sheet->setCellValue('I' . $rowCount, $body[$k]['harga']);
            $sheet->setCellValue('J' . $rowCount, $body[$k]['dpp']);
            $sheet->setCellValue('K' . $rowCount, $body[$k]['ppn']);
            $sheet->setCellValue('L' . $rowCount, $body[$k]['total']);
            $rowCount++;
        }
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'wrapText' => false,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFB100',
                ],
                'endColor' => [
                    'argb' => 'FFB100',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '383838'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PO ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function exportReportPR()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $user_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $body = json_decode($this->curl->simple_get(api_produksi('getPurchaseRequesitionReport?userId=' . $user_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data->purchaseReport;
        $huruf = range('A', 'Z');
        $extension = 'xlsx';
        $fileName = 'Report PO';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'PR ID');
        $sheet->setCellValue('B1', 'PR DATE');
        $sheet->setCellValue('C1', 'CODE ITEM');
        $sheet->setCellValue('D1', 'NAME ITEM');
        $sheet->setCellValue('E1', 'COST CENTER');
        $sheet->setCellValue('F1', 'UNIT');
        $sheet->setCellValue('G1', 'QTY PR');
        $sheet->setCellValue('H1', 'QTY PO');
        $sheet->setCellValue('I1', 'QTY SHIPMENT');
        $sheet->setCellValue('J1', 'QTY RECEIVE');
        $sheet->setCellValue('K1', 'STATUS PR');
        $sheet->setCellValue('L1', 'STATUS PO');
        $sheet->setCellValue('M1', 'STATUS SHIPMENT');
        $sheet->setCellValue('N1', 'STATUS RECEIVE');
        $rowCount = 2;
        foreach ($body as $key => $value) {
            $sheet->setCellValue('A' . $rowCount, $value->no_pr);
            $sheet->setCellValue('B' . $rowCount, $value->date_pr);
            $sheet->setCellValue('C' . $rowCount, $value->item->code);
            $sheet->setCellValue('D' . $rowCount, $value->item->name);
            $sheet->setCellValue('E' . $rowCount, $value->cost_center->name);
            $sheet->setCellValue('F' . $rowCount, $value->unit->name);
            $sheet->setCellValue('G' . $rowCount, $value->qty_pr);
            $sheet->setCellValue('H' . $rowCount, $value->qty_po);
            $sheet->setCellValue('I' . $rowCount, $value->qty_shipment);
            $sheet->setCellValue('J' . $rowCount, $value->qty_receive);
            $sheet->setCellValue('K' . $rowCount, $value->status_pr);
            $sheet->setCellValue('L' . $rowCount, $value->status_po);
            $sheet->setCellValue('M' . $rowCount, $value->status_shipment);
            $sheet->setCellValue('N' . $rowCount, $value->status_receive);
            $rowCount++;
        }
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'wrapText' => false,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFB100',
                ],
                'endColor' => [
                    'argb' => 'FFB100',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '383838'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:N1')->applyFromArray($styleArray);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PR ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function reportMachine()
    {
        $data['title'] = 'Report Machine';
        $this->template->views('report/reportMachine', $data);
    }
    public function reportProduction()
    {
        $data['title'] = 'Report Production';
        $this->template->views('report/reportProduction', $data);
    }
    public function reportProductionWorker()
    {
        $data['title'] = 'Report Production Worker';
        $this->template->views('report/reportProductionWorker', $data);
    }
    public function pdfProductionWorker()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $data['format'] = $explodedParams[1];
        $data['date_start'] = date('Y-m-d', strtotime($explodedParams[2]));
        $data['date_end'] = date('Y-m-d', strtotime($explodedParams[3]));
        $data['groupingOption'] = $explodedParams[4];
        $data['periodOption'] = $explodedParams[5];
        $data['machineId'] = $explodedParams[6];
        $data['datas'] = json_decode($this->curl->simple_get(api_produksi('getReportResultPerson?dateStart=' . $data['dateStart'] . '&dateEnd=' . $data['dateEnd'] . '&groupingOption=' . $data['groupingOption'] . '&periodOption=' . $data['periodOption'] . '&machineId=' . $data['machineId'])))->data;
        $html = $this->load->view('report/cetakProductionWorker', $data, true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "REPORT PRODUCTION WORKER.pdf";
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream($data['datas']->no_pr, array("Attachment" => 0));
    }
    public function groupDataByProperties($data, $propertyNames)
    {
        // Menggunakan array asosiatif untuk menyimpan nilai unik dari kombinasi properti
        $uniqueValuesArray = array();

        // Loop melalui data untuk mendapatkan nilai unik dari kombinasi properti
        foreach ($data as $item) {
            // Membuat array yang berisi nilai properti yang diinginkan
            $propertyValues = array_map(function ($propertyName) use ($item) {
                if (isset($item->$propertyName->name)) {
                    return $item->$propertyName->name;
                } else {
                    return $item->$propertyName;
                }
            }, $propertyNames);

            // Menambahkan array nilai properti ke dalam array asosiatif
            $uniqueValuesArray[json_encode($propertyValues)] = $propertyValues;
        }

        // Mengembalikan hasilnya dalam bentuk array asosiatif
        return array_values($uniqueValuesArray);
    }
    function groupAndSum($arr, $groupKeys, $sumKeys)
    {
        $result = [];

        foreach ($arr as $curr) {
            $group = implode('-', array_map(function ($k) use ($curr) {
                return $curr[$k];
            }, $groupKeys));

            if (!isset($result[$group])) {
                $result[$group] = array_merge(array_combine($groupKeys, array_map(function ($k) use ($curr) {
                    return $curr[$k];
                }, $groupKeys)), array_combine($sumKeys, array_fill(0, count($sumKeys), 0)));
            }

            foreach ($sumKeys as $k) {
                $result[$group][$k] += $curr[$k];
            }
        }

        return array_values($result);
    }
    function findQty($data, $criteria)
    {
        foreach ($data as $item) {
            $match = true;

            foreach ($criteria as $key => $value) {
                // Mengatasi properti dengan hierarki
                $keys = explode('->', $key);
                $currentValue = $item;

                foreach ($keys as $nestedKey) {
                    if (isset($currentValue->{$nestedKey})) {
                        $currentValue = $currentValue->{$nestedKey};
                    } else {
                        $match = false;
                        break;
                    }
                }

                if (!$match || $currentValue != $value) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                // Mengatasi nilai null
                $qtyGoods = isset($item->qty_goods) ? $item->qty_goods : 0;
                $qtyReject = isset($item->qty_reject) ? $item->qty_reject : 0;
                $qtyWaste = isset($item->qty_waste) ? $item->qty_waste : 0;

                return [
                    'qty_goods' => $qtyGoods,
                    'qty_reject' => $qtyReject,
                    'qty_waste' => $qtyWaste,
                ];
            }
        }

        return null;
    }

    public function excelProductionWorker()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $format = $explodedParams[1];
        // format 0 raw
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $groupingOption = $explodedParams[4];
        $nameVariable = strtolower($groupingOption);
        $periodOption = $explodedParams[5];
        $machineId = $explodedParams[6];
        $dataStructure = json_decode($explodedParams[7]);
        $body = json_decode($this->curl->simple_get(api_produksi('getReportResultPerson?dateStart=' . $date_start . '&dateEnd=' . $date_end . '&groupingOption=' . $groupingOption . '&periodOption=' . $periodOption . '&machineId=' . $machineId)))->data->reportResultPerson;
        $huruf = range('A', 'Z');
        $extension = 'xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumn = 1;
        if ($format == 0) {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Tanggal');
            if ($groupingOption == 'WORKER') {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'IED');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No. Meja');
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Worker');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Product');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Good');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Waste');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Reject');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Jumlah Setor');
            $jumlahColumn = 1;
            $rowCount = 2;
            for ($k = 0; $k < count($body); $k++) {
                $jumlahColumn = 1;
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $k + 1);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->date);
                if ($groupingOption == 'WORKER') {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->$nameVariable->eid);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->row_code);
                }
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->$nameVariable->name);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->item->name);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->unit->name);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->qty_goods);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->qty_waste);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->qty_reject);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $rowCount, $body[$k]->deliv_total);
                $rowCount++;
            }
            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'wrapText' => false,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFB100',
                    ],
                    'endColor' => [
                        'argb' => 'FFB100',
                    ],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '383838'],
                    ],
                ],
            ];
            $spreadsheet->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray);
        } else {
            $jumlahColumn = 1;
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '' . $dataStructure->$periodOption->rowspan)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
            if ($groupingOption == 'WORKER') {
                $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '' . $dataStructure->$periodOption->rowspan)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'EID');
                $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '' . $dataStructure->$periodOption->rowspan)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No. Meja');
            }
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '' . $dataStructure->$periodOption->rowspan)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', ucfirst($groupingOption));
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '' . $dataStructure->$periodOption->rowspan)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Product');
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '' . $dataStructure->$periodOption->rowspan)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
            $jumlahRow = 1;
            $variableColumn = $jumlahColumn;
            $loopEnd = 1;
            foreach ($dataStructure->$periodOption->data as $key => $value) {
                $jumlahColumn = $variableColumn;
                $dataChild = $this->groupDataByProperties($body, [$value->variable]);
                $jumlahLoop = 1;
                $loopEnd = $loopEnd * count($dataChild);
                if ($jumlahRow == count($dataStructure->$periodOption->data) && count($dataStructure->$periodOption->data) >= 1) {
                    $jumlahLoop = count($this->groupDataByProperties($body, [$dataStructure->$periodOption->data[0]->variable]));
                }
                // for ($j = 0; $j < $jumlahLoop; $j++) {
                for ($i = 0; $i < count($dataChild); $i++) {
                    $endJumlahColumn = $jumlahColumn + $value->colspan - 1;
                    // echo $dataChild[$i][0];
                    $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($endJumlahColumn) . $jumlahRow)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow, $dataChild[$i][0]);
                    $jumlahColumn = $endJumlahColumn + 1;
                }
                // }
                $jumlahRow++;
            }
            $jumlahColumn = $variableColumn;
            for ($i = 0; $i < $loopEnd; $i++) {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Good');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Waste');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Reject');
            }
            $rowCount = 0;
            for ($k = 0; $k < count($body); $k++) {
                $data_report_detail[$rowCount]['item_id'] = $body[$k]->item->id;
                $data_report_detail[$rowCount]['item_name'] = $body[$k]->item->name;
                $data_report_detail[$rowCount]['item_code'] = $body[$k]->item->code;
                $data_report_detail[$rowCount]['unit_id'] = $body[$k]->unit->id;
                $data_report_detail[$rowCount]['unit_name'] = $body[$k]->unit->name;
                $data_report_detail[$rowCount]['qty_waste'] = $body[$k]->qty_waste;
                $data_report_detail[$rowCount]['qty_reject'] = $body[$k]->qty_reject;
                $data_report_detail[$rowCount]['qty_goods'] = $body[$k]->qty_goods;
                $data_report_detail[$rowCount][$nameVariable . '_id'] = $body[$k]->$nameVariable->id;
                $data_report_detail[$rowCount][$nameVariable . '_name'] = $body[$k]->$nameVariable->name;
                if ($groupingOption == 'WORKER') {
                    $data_report_detail[$rowCount][$nameVariable . '_eid'] = $body[$k]->$nameVariable->eid;
                    $data_report_detail[$rowCount][$nameVariable . '_row_code'] = $body[$k]->row_code;
                }
                $rowCount++;
            }
            if ($groupingOption == 'WORKER') {
                $dataMachine = $this->groupAndSum($data_report_detail, [$nameVariable . '_id', $nameVariable . '_name', $nameVariable . '_eid', $nameVariable . '_row_code', 'item_id', 'item_name', 'unit_name'], []);
            } else {
                $dataMachine = $this->groupAndSum($data_report_detail, [$nameVariable . '_id', $nameVariable . '_name', 'item_id', 'item_name', 'unit_name'], []);
            }
            $jumlahRow++;
            $jumlahColumn = 1;
            $no = 1;
            $indexChild = 0;
            foreach ($dataStructure->$periodOption->data as $key => $value) {
                $variableUsed = str_replace('.', '->', $value->variable_used);
                $dataChildBody[$indexChild]['variable'] = $variableUsed;
                $dataChildBody[$indexChild]['data'] = $this->groupDataByProperties($body, [$value->variable]);
                $indexChild++;
            }
            foreach ($dataMachine as $key => $value) {
                $jumlahColumn = 1;
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
                if ($groupingOption == 'WORKER') {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value[$nameVariable . '_eid']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value[$nameVariable . '_row_code']);
                }
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value[$nameVariable . '_name']);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['item_name']);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['unit_name']);
                for ($i = 0; $i < count($dataChildBody); $i++) {
                    $indexCriteria = 0;
                    if (count($dataChildBody) > 1) {
                        for ($j = 0; $j < count($dataChildBody[0]['data']); $j++) {
                            for ($k = 0; $k < count($dataChildBody[1]['data']); $k++) {
                                $criteria[$indexCriteria]['item->id'] = $value['item_id'];
                                $criteria[$indexCriteria][$nameVariable . '->id'] = $value[$nameVariable . '_id'];
                                $criteria[$indexCriteria][$dataChildBody[0]['variable']] = $dataChildBody[0]['data'][$j][0];
                                $criteria[$indexCriteria][$dataChildBody[1]['variable']] = $dataChildBody[1]['data'][$k][0];
                                $indexCriteria++;
                            }
                        }
                    } else {
                        for ($j = 0; $j < count($dataChildBody[0]['data']); $j++) {
                            $criteria[$indexCriteria]['item->id'] = $value['item_id'];
                            $criteria[$indexCriteria][$nameVariable . '->id'] = $value[$nameVariable . '_id'];
                            $criteria[$indexCriteria][$dataChildBody[0]['variable']] = $dataChildBody[0]['data'][$j][0];
                            $criteria[$indexCriteria][$dataChildBody[0]['variable']] = $dataChildBody[0]['data'][$j][0];
                            $indexCriteria++;
                        }
                    }
                }
                foreach ($criteria as $k => $v) {
                    $qty = $this->findQty($body, $v);
                    if (!$qty) {
                        $qty['qty_goods'] = '-';
                        $qty['qty_reject'] = '-';
                        $qty['qty_waste'] = '-';
                    }
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $qty['qty_goods']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $qty['qty_waste']);
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $qty['qty_reject']);
                }
                $jumlahRow++;
            }
        }
        // exit;
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PRODUCTION WORKER ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function reportPersonEarn()
    {
        $data['title'] = 'Report Person Earn Giling';
        $this->template->views('report/reportPersonEarn', $data);
    }
    public function excelPersonEarn()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $date_start = date('Y-m-d', strtotime($explodedParams[1]));
        $date_end = date('Y-m-d', strtotime($explodedParams[2]));
        $machineId = $explodedParams[3];
        $merge = $explodedParams[5];
        $body = json_decode($this->curl->simple_get(api_produksi('getReportResultPersonEarn?dateStart=' . $date_start . '&dateEnd=' . $date_end . '&machineId=' . $machineId)))->data->reportResultPersonEarn;
        $huruf = range('A', 'Z');
        $extension = 'xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:A2')->setCellValue('A1', 'No');
        $sheet->mergeCells('B1:B2')->setCellValue('B1', 'EID');
        $sheet->mergeCells('C1:C2')->setCellValue('C1', 'Nama');
        $sheet->mergeCells('D1:D2')->setCellValue('D1', 'No. Meja');
        $jumlahColumn = 5;
        $jumlahColumn2 = 5;
        $keys = array_map(function ($item) {
            return key($item);
        }, $body[0]->data);
        for ($i = 0; $i < count($keys); $i++) {
            $startColumn = $jumlahColumn;
            if ($merge == 1) {
                $sheet->mergeCells(Coordinate::stringFromColumnIndex($startColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn = $jumlahColumn + 2) . '1')->setCellValue(Coordinate::stringFromColumnIndex($startColumn) . '1', $keys[$i]);
            } else {
                for ($j = 0; $j < 3; $j++) {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', $keys[$i]);
                }
                $jumlahColumn--;
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'QTY');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Earn');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Total Setor');
            $jumlahColumn++;
        }
        $jumlahRow = 3;
        $jumlahColumn = 1;
        $no = 1;
        $styleArrayFormula = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'f9dfdf',
                ],
                'endColor' => [
                    'argb' => 'f9dfdf',
                ],
            ],
        ];
        foreach ($body as $key => $value) {
            $jumlahColumn = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->eid);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->row_code);
            // print_r($value->data);
            foreach ($value->data as $item) {
                $dateKey = key((array)$item);
                $jumlahColumQty = $jumlahColumn;
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->qty);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->earn);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_deliv);
                if ($item->{$dateKey}->reject_left) {
                    $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumQty) . $jumlahRow)->applyFromArray($styleArrayFormula);
                }
            }
            $jumlahRow++;
        }


        // exit;
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PERSON SALARY SUMMARY' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelPersonEarnDetail()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $date_start = date('Y-m-d', strtotime($explodedParams[1]));
        $date_end = date('Y-m-d', strtotime($explodedParams[2]));
        $machineId = $explodedParams[3];
        $viewBy = $explodedParams[4];
        $merge = $explodedParams[5];
        $body = json_decode($this->curl->simple_get(api_produksi('getReportResultPersonEarn?dateStart=' . $date_start . '&dateEnd=' . $date_end . '&machineId=' . $machineId)))->data->reportResultPersonEarn;
        $huruf = range('A', 'Z');
        $extension = 'xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:A2')->setCellValue('A1', 'No');
        $sheet->mergeCells('B1:B2')->setCellValue('B1', 'EID');
        $sheet->mergeCells('C1:C2')->setCellValue('C1', 'Nama');
        $sheet->mergeCells('D1:D2')->setCellValue('D1', 'No. Meja');
        $jumlahColumn = 5;
        $jumlahColumn2 = 5;
        $keys = array_map(function ($item) {
            return key($item);
        }, $body[0]->data);
        for ($i = 0; $i < count($keys); $i++) {
            $startColumn = $jumlahColumn;
            if ($viewBy) {
                $num = 0;
                foreach ($body[0]->data as $item) {
                    $dateKey = key((array)$item);
                    if ($dateKey == $keys[$i]) {
                        $num = count($item->{$dateKey}->detail_total);
                    }
                }
            } else {
                $num = 0;
            }
            if ($merge == 1) {
                $sheet->mergeCells(Coordinate::stringFromColumnIndex($startColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn = $jumlahColumn + 2 + ($num * 2)) . '1')->setCellValue(Coordinate::stringFromColumnIndex($startColumn) . '1', $keys[$i]);
            } else {
                $counting = 3;
                if ($viewBy) {
                    if ($num) {
                        $counting = 5;
                        if ($num > 1) {
                            $counting = 7;
                        }
                    }
                }
                for ($j = 0; $j < $counting; $j++) {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', $keys[$i]);
                }
                $jumlahColumn--;
            }
            if ($viewBy) {
                if ($num) {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'QTY Pokok');
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Earn Pokok');
                    if ($num > 1) {
                        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'QTY Incentive');
                        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Earn Incentive');
                    }
                }
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Total QTY');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Total Earn');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Total Setor');
            $jumlahColumn++;
        }
        $jumlahRow = 3;
        $jumlahColumn = 1;
        $no = 1;
        $styleArrayFormula = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'f9dfdf',
                ],
                'endColor' => [
                    'argb' => 'f9dfdf',
                ],
            ],
        ];
        foreach ($body as $key => $value) {
            $jumlahColumn = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->eid);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->row_code);
            // print_r($value->data);
            foreach ($value->data as $item) {
                $dateKey = key((array)$item);
                $jumlahColumQty = $jumlahColumn;
                if ($viewBy) {
                    $num = 0;
                    foreach ($body[0]->data as $items) {
                        $dateKeys = key((array)$items);
                        if ($dateKeys == $dateKey) {
                            $num = count($items->{$dateKeys}->detail_total);
                        }
                    }
                    for ($k = 0; $k < $num; $k++) {
                        if (isset($item->{$dateKey}->detail_total[$k])) {
                            $dataItem = $item->{$dateKey}->detail_total[$k];
                            foreach ($dataItem as $k2 => $v2) {
                                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $v2);
                            }
                        } else {
                            for ($l = 0; $l < 2; $l++) {
                                $jumlahColumn++;
                            }
                        }
                    }
                    // foreach ($item->{$dateKey}->detail_total as $v) {
                    //     $detailKey = key((array)$v);
                    //     $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $v->{$detailKey});
                    // }
                }
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_qty);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_earn);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_deliv);
                if ($item->{$dateKey}->reject_left) {
                    $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumQty) . $jumlahRow)->applyFromArray($styleArrayFormula);
                }
            }
            $jumlahRow++;
        }

        // exit;
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PERSON SALARY DETAIL ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function reportIncomplete()
    {
        $data['title'] = 'Report Incomplete Data';
        $this->template->views('report/reportIncompleteData', $data);
    }
    public function reportProductionDaily()
    {
        $data['title'] = 'Report Production Daily Giling';
        $this->template->views('report/reportProductionDaily', $data);
    }
    public function reportDailySKT()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $date = date('Y-m-d', strtotime($explodedParams[1]));
        $machineId = $explodedParams[2];
        $rowCode = $explodedParams[3];
        $dataProfile = $explodedParams[4];
        $body = json_decode($this->curl->simple_get(api_produksi('getReportResultPersonDaily?date=' . $date . '&machineId=' . $machineId . '&rowCode=' . $rowCode . '&dataProfile=' . $dataProfile)))->data->reportResultPersonDaily;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:A2')->setCellValue('A1', 'No');
        $sheet->mergeCells('B1:B2')->setCellValue('B1', 'EID');
        $sheet->mergeCells('C1:C2')->setCellValue('C1', 'Nama');
        $sheet->mergeCells('D1:D2')->setCellValue('D1', 'Group');
        $sheet->mergeCells('E1:E2')->setCellValue('E1', 'Tanggal');
        $keys = array_map(function ($item) {
            return key($item);
        }, $body[0]->data);
        $jumlahColumn = 6;
        $jumlahColumn2 = 6;
        for ($i = 0; $i < count($keys); $i++) {
            $startColumn = $jumlahColumn;
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($startColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn = $jumlahColumn + 1) . '1')->setCellValue(Coordinate::stringFromColumnIndex($startColumn) . '1', 'Setoran ' . $keys[$i]);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Jumlah Setoran');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Jam');
            $jumlahColumn++;
        }
        $jumlahRow = 3;
        $jumlahColumn = 1;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->eid);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->row_code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $date);
            // print_r($value->data);
            foreach ($value->data as $item) {
                $dateKey = key((array)$item);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_good);
                $time = '';
                if ($item->{$dateKey}->time) {
                    $time = date("H:i", strtotime($item->{$dateKey}->time[0]));
                }
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $time);
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->total_good);
            $jumlahRow++;
        }
        $jumlahColumn = $jumlahColumn - 1;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn) . '1', 'Total');
        // exit;
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PRODUCTION DAILY GILING ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function reportDailySKTPdf()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $data['date'] = date('Y-m-d', strtotime($explodedParams[1]));
        $data['machineId'] = $explodedParams[2];
        $data['rowCode'] = $explodedParams[3];
        $data['dataProfile'] = $explodedParams[4];
        $data['datas'] = json_decode($this->curl->simple_get(api_produksi('getReportResultPersonDaily?date=' . $data['date'] . '&machineId=' . $data['machineId'] . '&rowCode=' . $data['rowCode'] . '&dataProfile=' . $data['dataProfile'])))->data;
        // $this->load->view('report/cetakReportDailySKT', $data);
        $html = $this->load->view('report/cetakReportDailySKT', $data, true);
        $this->pdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape');
        $this->pdf->filename = "REPORT PRODUCTION DAILY GILING.pdf";
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream('REPORT PRODUCTION DAILY GILING ' . $data['date'], array("Attachment" => 0));
    }
    public function reportPersonQuality()
    {
        $data['title'] = 'Report Person Quality';
        $this->template->views('report/reportPersonQuality', $data);
    }
    public function reportPersonQualityExcel()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $dateStart = date('Y-m-d', strtotime($explodedParams[1]));
        $dateEnd = date('Y-m-d', strtotime($explodedParams[2]));
        $machineId = $explodedParams[3];
        $body = json_decode($this->curl->simple_get(api_produksi('getReportResultPersonQuality?dateStart=' . $dateStart . '&dateEnd=' . $dateEnd . '&machineId=' . $machineId)))->data->reportResultPersonQuality;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:A2')->setCellValue('A1', 'No');
        $sheet->mergeCells('B1:B2')->setCellValue('B1', 'EID');
        $sheet->mergeCells('C1:C2')->setCellValue('C1', 'Nama');
        $keys = array_map(function ($item) {
            return key($item);
        }, $body[0]->data);
        $jumlahColumn = 4;
        $jumlahColumn2 = 4;
        // print_r($keys);
        // exit();
        for ($i = 0; $i < count($keys); $i++) {
            $startColumn = $jumlahColumn;
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($startColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn = $jumlahColumn + 5) . '1')->setCellValue(Coordinate::stringFromColumnIndex($startColumn) . '1', date("M Y", strtotime($keys[$i])));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Quality');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'AVG Deliv');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Total Good');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Total Deliv');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Total Bad');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Total All');
            $jumlahColumn++;
        }
        $jumlahRow = 3;
        $jumlahColumn = 1;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->eid);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->name);
            // print_r($value->data);
            foreach ($value->data as $item) {
                $dateKey = key((array)$item);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->quality);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->avg_deliv);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_good);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_deliv);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_bad);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->{$dateKey}->total_all);
            }
            $jumlahRow++;
        }
        // exit;
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PERSON QUALITY ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function reportResultProduction()
    {
        $data['title'] = 'Report Result Production';
        $this->template->views('report/reportResultProduction', $data);
    }
    public function reportResultProductionExcel()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $dateStart = date('Y-m-d', strtotime($explodedParams[1]));
        $dateEnd = date('Y-m-d', strtotime($explodedParams[2]));
        $machineId = $explodedParams[3];
        $body = json_decode($this->curl->simple_get(api_produksi('getReportResultProduction?dateStart=' . $dateStart . '&dateEnd=' . $dateEnd . '&machineId=' . $machineId)))->data->reportResultPerson;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumn = 1;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Tanggal');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Shift');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Mesin');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
        $jumlahColumn2 = $jumlahColumn;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn = $jumlahColumn + 7) . '1')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2) . '1', 'Employee');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Cacther 1');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Cacther 2');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Helper 1');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Helper 2');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Mekanik 1');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Mekanik 2');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Operator 1');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn2++) . '2', 'Operator 2');
        $jumlahRow = 3;
        $jumlahColumn = 1;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->date);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->shift->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->machine->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->unit->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, ($value->employee_catcher1->name ?? '-'));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, ($value->employee_catcher2->name ?? '-'));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, ($value->employee_helper1->name ?? '-'));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, ($value->employee_helper2->name ?? '-'));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, ($value->employee_mechanic1->name ?? '-'));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, ($value->employee_mechanic2->name ?? '-'));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, ($value->employee_operator1->name ?? '-'));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, ($value->employee_operator2->name ?? '-'));
            $jumlahRow++;
        }
        // exit;
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT RESULT PRODUCTION ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function reportProductionGiling()
    {
        $data['title'] = 'Report Production Giling';
        $this->template->views('report/reportProductionGiling', $data);
    }
    public function reportGilingPdf()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $data['date'] = date('Y-m-d', strtotime($explodedParams[1]));
        $data['machineId'] = $explodedParams[2];
        $data['rowCode'] = $explodedParams[3];
        $data['tipeData'] = $explodedParams[4];
        $data['datas'] = json_decode($this->curl->simple_get(api_produksi('getResultProductWorkerTotalDaily?date=' . $data['date'] . '&machineId=' . $data['machineId'] . '&rowCode=' . $data['rowCode'])))->data;
        // $this->load->view('report/cetakRreportGilingPdf', $data);
        $html = $this->load->view('report/cetakRreportGilingPdf', $data, true);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "REPORT GILING.pdf";
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream('REPORT GILING', array("Attachment" => 0));
    }
    public function reportGilingExcel()
    {
        $dataMaterial = [
            [
                'satuan' => 'KG',
                'material' => 'TEMBAKAU GBK',
                'jumlah' => 10,
            ],
            [
                'satuan' => 'LEMBAR',
                'material' => 'AMBRI',
                'jumlah' => 10,
            ],
            [
                'satuan' => 'LITER',
                'material' => 'PEMANIS',
                'jumlah' => 10,
            ],
        ];

        $dataKaleng = [
            [
                'jenisKaleng' => 'MERAH MUDA TUTUP KOTAK',
                'ukuranKaleng1' => 0.36,
                'ukuranKaleng2' => 2.54,
                'tsg' => 2.18,
            ],
            [
                'jenisKaleng' => 'HIJAU & MERAH MUDA TUTUP BULAT YG BAGUS',
                'ukuranKaleng1' => 0.41,
                'ukuranKaleng2' => 2.54,
                'tsg' => 2.54,
            ],
            [
                'jenisKaleng' => 'BIRU & HIJAU KALENG LAMA',
                'ukuranKaleng1' => 0.33,
                'ukuranKaleng2' => 2.56,
                'tsg' => 2.23,
            ],
        ];
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $date = date('Y-m-d', strtotime($explodedParams[1]));
        $machineId = $explodedParams[2];
        $rowCode = $explodedParams[3];
        $tipeData = $explodedParams[4];
        $body = json_decode($this->curl->simple_get(api_produksi('getResultProductWorkerTotalDaily?date=' . $date . '&machineId=' . $machineId . '&rowCode=' . $rowCode)))->data->resultProductWorkerTotal;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
        $spreadsheet->getDefaultStyle()->getProtection()->setLocked(false);
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumn = 1;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'SATUAN');
        $jumlahColumnBefore = $jumlahColumn;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn += 1) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore) . '1', 'MATERIAL');
        $jumlahColumn++;
        $jumlahColumnBefore = $jumlahColumn;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn = $jumlahColumn + 2) . '1')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore) . '1', 'SISA AWAL');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . '2', 'DI ORANG GILING');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . '2', 'DI GUDANG GILING');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . '2', 'TOTAL');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . '2', 'DARI GUDANG BESAR');
        $jumlahColumn++;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'TERIMA');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'PEMAKAIAN');
        $jumlahColumnBefore = $jumlahColumn;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn = $jumlahColumn + 2) . '1')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore) . '1', 'SISA AKHIR');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . '2', 'DI ORANG GILING');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . '2', 'DI GUDANG GILING');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . '2', 'TOTAL');
        $jumlahColumn++;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'WASTE AMBRI RUSAK');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'WASTE TEMB. SAPON (KG)');
        $jumlahColumnKaleng = $jumlahColumn;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn += 3) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnKaleng) . '1', 'WARNA KALENG');
        $jumlahColumn++;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'UKURAN KALENG');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'UKURAN KALENG');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'MURNI TSG SAJA');
        // data material
        $jumlahRow = 3;
        foreach ($dataMaterial as $value) {
            $jumlahColumn = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['satuan']);
            $jumlahColumnBefore = $jumlahColumn;
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) .  $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn += 1) .  $jumlahRow)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore) . $jumlahRow, $value['material']);
            $sheet->setCellValue('F' . $jumlahRow, '=(D' . $jumlahRow . '+E' . $jumlahRow . ')');
            $jumlahRow++;
        }
        $jumlahRow = 3;
        $jumlahBefore = $jumlahColumnKaleng;
        foreach ($dataKaleng as $value) {
            $jumlahColumn = $jumlahColumnKaleng;
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn += 3) . $jumlahRow)->setCellValue(Coordinate::stringFromColumnIndex($jumlahBefore) . $jumlahRow, $value['jenisKaleng']);
            $jumlahColumn++;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['ukuranKaleng1']);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['ukuranKaleng2']);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['tsg']);
            $jumlahRow++;
        }
        $jumlahRowStart = 7;
        $jumlahColumnStart = 1;
        $jumlahRow = $jumlahRowStart;
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'NO');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'NIK');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'NAMA');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'GROUP');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'SISA AWAL TSG');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'TERIMA TSG');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'PEMAKAIAN TSG');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'SISA AKHIR TSG');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'RATA2 BERAT PER BTG');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'SISA AWAL AMBRI');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'PENGAMBILAN AMBRI (BTG)');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'SISA AKHIR AMBRI');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'HASIL PRODUKSI');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow++, 'AMBRI RUSAK (LBR)');
        $no = 1;
        $totalProduksi = 0;
        foreach ($body as $key => $value) {
            $jumlahColumn = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->eid);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->row_code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(7) . $jumlahRow, '=(' . Coordinate::stringFromColumnIndex(5) . $jumlahRow . '+' . Coordinate::stringFromColumnIndex(6) . $jumlahRow . ')-' . Coordinate::stringFromColumnIndex(8) . $jumlahRow . '');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(9) . $jumlahRow, '=(' . Coordinate::stringFromColumnIndex(7) . $jumlahRow . '/' . Coordinate::stringFromColumnIndex(13) . $jumlahRow . ')');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(14) . $jumlahRow, '=(' . Coordinate::stringFromColumnIndex(10) . $jumlahRow . '+' . Coordinate::stringFromColumnIndex(11) . $jumlahRow . '-' . Coordinate::stringFromColumnIndex(12) . $jumlahRow . '-' . Coordinate::stringFromColumnIndex(13) . $jumlahRow . ')');
            $jumlahColumn += 8;
            if ($tipeData == 'DATA') {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            } else {
                $jumlahColumn++;
            }
            $jumlahRow++;
            $totalProduksi += $value->qty;
        }
        $jumlahRowEnd = $jumlahRow - 1;
        $jumlahColumnEnd = $jumlahColumn;
        // bagian bawah 
        $jumlahRow = $jumlahRowEnd + 2;
        $jumlahRow2 = $jumlahRowEnd + 3;
        $jumlahColumn = 4;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow2)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow . '', 'SISA AWAL');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow2)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow . '', 'TERIMA BATANGAN DARI WAGIR');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow2)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow . '', 'HASIL PRODUKSI');
        $jumlahColumnBefore = $jumlahColumn;

        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn = $jumlahColumn + 1) . $jumlahRow . '')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore) . $jumlahRow . '', 'PEMAKAIAN');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . $jumlahRow2, 'AK 12 SKT');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnBefore++) . $jumlahRow2, 'AK 16 SKT');
        $jumlahColumn++;
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow2)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow . '', 'SISA AKHIR');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow2)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow . '', 'WASTE BTG DI BANDULAN');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumn) . $jumlahRow2)->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow . '', 'WASTE BTGAN DI WAGIR');


        $sheet->setCellValue('H3', '=SUM(E' . ($jumlahRowStart + 1) . ':E' . $jumlahRowEnd . ')');
        $sheet->setCellValue('I3', '=SUM(H' . ($jumlahRowStart + 1) . ':H' . $jumlahRowEnd . ')');
        $sheet->setCellValue('H4', '=SUM(J' . ($jumlahRowStart + 1) . ':J' . $jumlahRowEnd . ')');
        $sheet->setCellValue('I4', '=SUM(L' . ($jumlahRowStart + 1) . ':L' . $jumlahRowEnd . ')');
        $sheet->setCellValue('L4', '=SUM(N' . ($jumlahRowStart + 1) . ':N' . $jumlahRowEnd . ')');
        $sheet->setCellValue('K3', '=(I3+J3)');
        $sheet->setCellValue('K4', '=(I4+J4)');

        $sheet->setCellValue('F' . ($jumlahRow2 + 1), $totalProduksi);
        $styleArrayHeader = [
>>>>>>> fc4bb4bbec346a9c5ccc7faed52dce2cce0e7714
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'ffd87f',
                ],
                'endColor' => [
                    'argb' => 'ffd87f',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '737373'],
                ],
            ],
        ];
    }
    function transformData($data, $schema)
    {
        return array_map(function ($item) use ($schema) {
            $transformQtyOrWeight = function ($obj) use ($schema) {
                $transformedObj = [];
                foreach ($schema as $key => $fields) {
                    $sum = 0;
                    foreach ($fields as $field) {
                        $sum += isset($obj->$field) ? $obj->$field : 0;
                    }
                    $transformedObj[$key] = $sum;
                }
                return $transformedObj;
            };

            return [
                "item" => $item->item,
                "item_grade" => $item->item_grade,
                "qty" => $transformQtyOrWeight($item->qty),
                "weight" => $transformQtyOrWeight($item->weight)
            ];
        }, $data);
    }
    public function excelPurchaseRecap()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $body = json_decode($this->curl->simple_get(api_produksi('getRecapPurchaseItem?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data->recap_purchase_item->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $totalGood = [];
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Price');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Tax Out Come');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Total');
        $jumlahRow = 2;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            if (!$value->tax_out_come) {
                $value->tax_out_come = 0;
            }
            if (!$value->price) {
                $value->price = 0;
            }
            if (!$value->total) {
                $value->total = 0;
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->grade->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->price);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->tax_out_come);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->total);
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PURCHASE RECAP ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelPurchaseSupplierRecap()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $body = json_decode($this->curl->simple_get(api_produksi('getRecapPurchaseItemSupplier?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data->recap_purchase_item_supplier->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $totalGood = [];
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Supplier');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Price');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Tax Out Come');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Total');
        $jumlahRow = 2;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            if (!$value->tax_out_come) {
                $value->tax_out_come = 0;
            }
            if (!$value->price) {
                $value->price = 0;
            }
            if (!$value->total) {
                $value->total = 0;
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->supplier->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->grade->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->price);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->tax_out_come);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->total);
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PURCHASE SUPPLIER RECAP ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelShipmentRecap()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $body = json_decode($this->curl->simple_get(api_produksi('getRecapShipmentItem?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data->recap_shipment_item->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $totalGood = [];
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Warehouse Origin');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Warehouse Destination');
        $jumlahRow = 2;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item_grade->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->unit->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_origin->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_dest->name);
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'SHIPMENT RECAP ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelShipmentReport()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $body = json_decode($this->curl->simple_get(api_produksi('getReportShipmentItem?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data->recap_shipment_item->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $totalGood = [];
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Date');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Warehouse Origin');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Warehouse Destination');
        $jumlahRow = 2;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, date('Y-m-d', strtotime($value->date)));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item_grade->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->unit->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_origin->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_dest->name);
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'SHIPMENT REPORT ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelShipmentHistory()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $body = json_decode($this->curl->simple_get(api_produksi('getHistoryShipmentItem?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data->history_shipment_item->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $totalGood = [];
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Date Ship');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Doc Number');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Warehouse Origin');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Warehouse Destination');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Sender');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Vehicle Model');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Vehicle Number');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Driver Name');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Receive At');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Receive By');
        $jumlahRow = 2;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, date('Y-m-d', strtotime($value->shipment_at)));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->document_number);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item_grade->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->unit->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_origin->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_dest->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->sender->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->vehicle_model->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->vehicle_number);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->driver_name);
            if ($value->is_receive) {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, date('Y-m-d', strtotime($value->receive_at)));
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->receiver);
            } else {
                $jumlahColumn++;
                $jumlahColumn++;
            }
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'SHIPMENT HISTORY ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelWarehouseStockRecap()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $mapping = $explodedParams[4];
        $body = json_decode($this->curl->simple_get(api_produksi('getRecapStock?warehouseId=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data;
        $dataDetail = $body->recapStock->data;
        $kerangka_mapping = $body->mappingMutation;
        $ker_mapping = [
            'start' => ['start'],
            'IN' => [
                'purchase',
                'receive',
                'production',
                'adjust_in'
            ],
            'OUT' => [
                'send',
                'material',
                'adjust_out'
            ],
            'end' => ['end']
        ];
        $childMapping = [
            [
                "name" => "Start",
                "variable" => "start",
            ],
            [
                "name" => "IN",
                "variable" => "IN",
            ],
            [
                "name" => "OUT",
                "variable" => "OUT",
            ],
            [
                "name" => "End",
                "variable" => "end",
            ],
        ];
        $parent = [
            [
                "name" => "QTY",
                "variable" => "qty",
            ],
            [
                "name" => "Weight",
                "variable" => "weight",
            ],
        ];

        $child = [
            [
                "name" => "Start",
                "variable" => "start",
            ],
            [
                "name" => "Purchase",
                "variable" => "purchase",
            ],
            [
                "name" => "Receive",
                "variable" => "receive",
            ],
            [
                "name" => "Production",
                "variable" => "production",
            ],
            [
                "name" => "Send",
                "variable" => "send",
            ],
            [
                "name" => "Material",
                "variable" => "material",
            ],
            [
                "name" => "Adjust In",
                "variable" => "adjust_in",
            ],
            [
                "name" => "Adjust Out",
                "variable" => "adjust_out",
            ],
            [
                "name" => "End",
                "variable" => "end",
            ],
        ];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if ($mapping == 1) {
            $selectedMapping = $childMapping;
            $selectedData = $this->transformData($dataDetail, $ker_mapping);
        } else {
            $selectedMapping = $child;
            $selectedData = $dataDetail;
        }
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $totalGood = [];
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');

        // $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        // $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        // $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        // $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        foreach ($parent as $k => $v) {
            $jumlahColumnStartMerged = $jumlahColumn;
            foreach ($selectedMapping as $k2 => $v2) {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '2', $v2['name']);
            }
            $jumlahColumnEndMerged = $jumlahColumnStartMerged + count($selectedMapping) - 1;
            $sheet->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumnStartMerged) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEndMerged) . '1')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnStartMerged) . '1', $v['name']);
        }
        $jumlahRow = 3;
        $no = 1;
        foreach ($selectedData as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            if ($mapping == 1) {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['item']->code);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['item']->name);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['item_grade']->name);
            } else {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item_grade->name);
            }
            foreach ($parent as $k => $v) {
                foreach ($selectedMapping as $k2 => $v2) {
                    if ($mapping == 1) {
                        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value[$v['variable']][$v2['variable']]);
                    } else {
                        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->{$v['variable']}->{$v2['variable']});
                    }
                }
            }
            $jumlahRow++;
        }
        // exit;
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '2')->applyFromArray($this->templateHeader);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'WAREHOUSE STOCK RECAP ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelPurchaseHistory()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $body = json_decode($this->curl->simple_get(api_produksi('getHistoryPurchaseDetail?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data->history_purchase_detail->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $totalGood = [];
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Create Date');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Bale Number');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Supplier');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Price');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Tax Out Come');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade Cutoff');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade Latest');
        $jumlahRow = 2;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            if (!$value->tax_out_come) {
                $value->tax_out_come = 0;
            }
            if (!$value->price) {
                $value->price = 0;
            }
            if (!$value->total) {
                $value->total = 0;
            }
            if (!$value->grade_cutoff) {
                $grade_cutoff = '';
            } else {
                $grade_cutoff = $value->grade_cutoff->name;
            }
            if (!$value->grade_latest) {
                $grade_latest = '';
            } else {
                $grade_latest = $value->grade_latest->name;
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, date('Y-m-d', strtotime($value->datetime)));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->bale_number);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->supplier->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->grade->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->price);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->tax_out_come);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->total);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $grade_cutoff);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $grade_latest);
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PURCHASE HISTORY ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function reportProductionDailyVerpack()
    {
        $data['title'] = 'Report Production Daily Verpack';
        $this->template->views('report/reportProductionDailyVerpack', $data);
    }
    public function reportDailySKTVerpack()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $date = date('Y-m-d', strtotime($explodedParams[1]));
        $machineId = $explodedParams[2];
        $rowCode = $explodedParams[3];
        $dataProfile = $explodedParams[4];
        $body = json_decode($this->curl->simple_get(api_produksi('getReportResultPersonStepDaily?date=' . $date . '&machineId=' . $machineId . '&rowCode=' . $rowCode . '&dataProfile=' . $dataProfile)))->data->reportResultPersonDaily;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumn = 1;
        $totalGood = [];
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'EID');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Nama');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No. Meja');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Tanggal');
        foreach ($body[0]->results as $key => $value) {
            if (!$value->label) {
                $value->label = '';
            } else {
                $value->label = ' ' . $value->label;
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', $value->product->code . '' . $value->label);
            $totalGood[$key] = 0;
        }
        $jumlahRow = 2;
        $jumlahColumn = 1;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->eid);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->name);
            if (!$value->row_code) {
                $value->row_code = '-';
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->row_code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $date);
            foreach ($value->results as $keyItem => $item) {
                $totalGood[$keyItem] += $item->qty_rpp;
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $item->qty_rpp);
            }
            $jumlahRow++;
        }
        $jumlahColumn = 4;
        // print_r($totalGood);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total Good');
        for ($i = 0; $i < count($totalGood); $i++) {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $totalGood[$i]);
        }
        // exit;
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PRODUCTION DAILY VERPACK ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function reportDailySKTPdfVerpack()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $data['date'] = date('Y-m-d', strtotime($explodedParams[1]));
        $data['machineId'] = $explodedParams[2];
        $data['rowCode'] = $explodedParams[3];
        $data['dataProfile'] = $explodedParams[4];
        $data['datas'] = json_decode($this->curl->simple_get(api_produksi('getReportResultPersonStepDaily?date=' . $data['date'] . '&machineId=' . $data['machineId'] . '&rowCode=' . $data['rowCode'] . '&dataProfile=' . $data['dataProfile'])))->data;
        $html = $this->load->view('report/cetakReportDailySKTVerpack', $data, true);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "REPORT PRODUCTION DAILY VERPACK " . $data['date'] . ".pdf";
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream('REPORT PRODUCTION DAILY VERPACK ' . $data['date'], array("Attachment" => 0));
    }
    public function reportPersonEarnVerpack()
    {
        $data['title'] = 'Report Person Earn Verpack';
        $this->template->views('report/reportPersonEarnVerpack', $data);
    }
    public function excelPersonEarnVerpack()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $date_start = date('Y-m-d', strtotime($explodedParams[1]));
        $date_end = date('Y-m-d', strtotime($explodedParams[2]));
        $machineId = $explodedParams[3];
        $dataProfile = $explodedParams[4];
        $body = json_decode($this->curl->simple_get(api_produksi('getReportResultPersonEarnStep?dateStart=' . $date_start . '&dateEnd=' . $date_end . '&machineId=' . $machineId . '&dataProfile=' . $dataProfile)))->data;
        $huruf = range('A', 'Z');
        $extension = 'xlsx';
        $tipe = ['qty_rpp', 'earn'];
        $tipeName = ['Jumlah Setoran', 'Gaji Borongan'];
        $spreadsheet = new Spreadsheet();
        $dates = $body->reportResultPersonEarn->headerDate;
        foreach ($dates as $key => $value) {
            if ($key == 0) {
                $worksheet[] = $spreadsheet->getActiveSheet()->setTitle($value->date);
            } else {
                $worksheet[] = $spreadsheet->createSheet()->setTitle($value->date);
            }
            $datesArray[] = $value->date;
        }
        for ($i = 0; $i < count($worksheet); $i++) {
            $jumlahColumn = 1;
            $worksheet[$i]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '3')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
            $worksheet[$i]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '3')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'EID');
            $worksheet[$i]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '3')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Nama');
            $worksheet[$i]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '3')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No. Meja');
            for ($j = 0; $j < count($tipe); $j++) {
                $jumlahStartHeader = $jumlahColumn;
                $jumlahTotal = 0;
                foreach ($body->reportResultPersonEarn->headerStepProduct as $key => $value) {
                    foreach ($value->products as $keys => $values) {
                        $worksheet[$i]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn) . '2', $value->name);
                        $worksheet[$i]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn) . '3', $values->name);
                        $jumlahColumn++;
                        $jumlahTotal++;
                    }
                }
                $worksheet[$i]->mergeCells(Coordinate::stringFromColumnIndex($jumlahStartHeader) . '1:' . Coordinate::stringFromColumnIndex($jumlahStartHeader + $jumlahTotal) . '1')->setCellValue(Coordinate::stringFromColumnIndex($jumlahStartHeader) . '1', $tipeName[$j]);
                $worksheet[$i]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '2:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '3')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn) . '2', 'Total');
                $jumlahColumn += 2;
            }
            $jumlahRow = 4;
            foreach ($body->reportResultPersonEarn->result as $key => $value) {
                $jumlahColumn = 1;
                $jumlahColumnStart = $jumlahColumn;
                $worksheet[$i]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $key + 1);
                $worksheet[$i]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->eid);
                $worksheet[$i]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->employee->name);
                $worksheet[$i]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->row_code);
                for ($j = 0; $j < count($tipe); $j++) {
                    $jumlahColumnStart = $jumlahColumn;
                    $totalEarn = 0;
                    if ($value->dates) {
                        $dataDate = null;
                        $checkDate = 0;
                        foreach ($value->dates as $v) {
                            if (isset($v->{$datesArray[$i]}) && $checkDate == 0) {
                                $dataDate = $v->{$datesArray[$i]};
                                $checkDate = 1;
                            }
                        }
                        if ($dataDate == null) {
                            $dataDate = null;
                        }
                    } else {
                        $dataDate = null;
                    }


                    foreach ($body->reportResultPersonEarn->headerStepProduct as $ek) {
                        $dataStepProfile = null;
                        if ($dataDate != null) {
                            $checkStepProfile = 0;
                            foreach ($dataDate->result_earn_step_profiles as $v) {
                                if (isset($v->{$ek->id}) && $checkStepProfile == 0) {
                                    $dataStepProfile = $v->{$ek->id};
                                    $checkStepProfile = 1;
                                }
                            }
                            if ($dataStepProfile == null) {
                                $dataStepProfile = null;
                            }
                        } else {
                            $dataStepProfile = null;
                        }

                        foreach ($ek->products as $el) {
                            $dataProducts = null;
                            if ($dataStepProfile != null) {
                                $checkProducts = 0;
                                foreach ($dataStepProfile->products as $v) {
                                    if (isset($v->{$el->id}) && $checkProducts == 0) {
                                        $dataProducts = $v->{$el->id};
                                        $checkProducts = 1;
                                    }
                                }
                                if ($dataProducts == null) {
                                    $dataProducts = null;
                                }
                            } else {
                                $dataProducts = null;
                            }
                            if ($dataProducts != null) {
                                $totalEarn += $dataProducts->{$tipe[$j]};
                                $qtyName = $dataProducts->{$tipe[$j]};
                            } else {
                                $qtyName = '-';
                            }
                            $worksheet[$i]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $qtyName);
                        }
                    }
                    $worksheet[$i]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $totalEarn);
                    $jumlahColumnAkhir = $jumlahColumn - 1;
                    $styleArrayHeader = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'wrapText' => true,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'argb' => 'FFB100',
                            ],
                            'endColor' => [
                                'argb' => 'FFB100',
                            ],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '383838'],
                            ],
                        ],
                    ];
                    $worksheet[$i]->getStyle('A1:D3')->applyFromArray($styleArrayHeader);
                    $worksheet[$i]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnAkhir) . '3')->applyFromArray($styleArrayHeader);
                    $jumlahColumn++;
                }
                $jumlahRow++;
            }
        }
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);

        $writer = new Xlsx($spreadsheet);
        $filename = 'REPORT PERSON SALARY VERPACK ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function historyPayment()
    {
        $data['title'] = 'History Payment';
        $this->template->views('report/historyPayment', $data);
    }
    public function historyMaterialRequest()
    {
        $data['title'] = 'History Material Request';
        $this->template->views('report/historyMaterialRequest', $data);
    }
}
