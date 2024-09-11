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
        $this->user_id = $this->session->userdata('id');
        $this->username = $this->session->userdata('username');
        $this->position_name = $this->session->userdata('position_name');
        $this->position_detail_name = $this->session->userdata('position_detail_name');
        $this->permission = $this->session->userdata('permission');
        $this->warehouse_id = $this->session->userdata('warehouse_id');
        $this->templateHeader = [
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
    function getUniqueItems($data, $mapping)
    {
        $uniqueItems = [];

        foreach ($data as $entry) {
            // Menggabungkan id item dan id grade untuk membuat kunci unik
            if ($mapping == 1) {
                $itemKey = $entry['item']->id . '_' . $entry['item_grade']->id;
            } else {
                $itemKey = $entry->item->id . '_' . $entry->item_grade->id;
            }

            // Memastikan hanya menambahkan item jika belum ada di array
            if (!array_key_exists($itemKey, $uniqueItems)) {
                if ($mapping == 1) {
                    $uniqueItems[$itemKey] = [
                        "id" => $entry['item']->id,
                        "name" => $entry['item']->name,
                        "code" => $entry['item']->code,
                        "alias" => $entry['item']->alias,
                    ];
                } else {
                    $uniqueItems[$itemKey] = [
                        "id" => $entry->item->id,
                        "name" => $entry->item->name,
                        "code" => $entry->item->code,
                        "alias" => $entry->item->alias,
                    ];
                }
            }
        }

        // Mengembalikan array dengan item-item unik
        return array_values($uniqueItems);
    }
    function groupUniqueItems($data)
    {
        $uniqueItems = [];

        foreach ($data as $item) {
            $key = $item['id'] . '-' . $item['name'] . '-' . $item['code'] . '-' . $item['alias'];
            if (!array_key_exists($key, $uniqueItems)) {
                $uniqueItems[$key] = $item;
            }
        }

        return array_values($uniqueItems);
    }
    public function excelPurchaseRecap()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $itemId = $explodedParams[4];
        $supplierId = $explodedParams[5];
        $dataProfile = $explodedParams[6];
        $body = json_decode($this->curl->simple_get(api_produksi('getRecapPurchaseItem?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end . '&itemIds=' . $itemId . '&supplierIds=' . $supplierId . '&dataProfile=' . urlencode($dataProfile))))->data->recap_purchase_item->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $total_qty = 0;
        $total_weight = 0;
        $total_price = 0;
        $total_tax_outcome = 0;
        $total_total = 0;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        if ($dataProfile == 'ITEM GRADE') {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        }
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
            if (!$value->price_avg) {
                $value->price_avg = 0;
            }
            if (!$value->total) {
                $value->total = 0;
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            if ($dataProfile == 'ITEM GRADE') {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->grade->name);
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, round($value->price_avg, 2));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->tax_out_come);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->total);
            $total_qty += $value->qty;
            $total_weight += $value->weight;
            $total_price += $value->price_avg;
            $total_tax_outcome += $value->tax_out_come;
            $total_total += $value->total;
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        // tampil totalan
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        if ($dataProfile == 'ITEM GRADE') {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        }
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, round($total_price, 2));
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_tax_outcome);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_total);
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
        // tampil totalan
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PURCHASE RECAP ' . $dataProfile . ' ' . $epoch;

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
        $total_qty = 0;
        $total_weight = 0;
        $total_price = 0;
        $total_tax_outcome = 0;
        $total_total = 0;
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
            $total_qty += $value->qty;
            $total_weight += $value->weight;
            $total_price += $value->price;
            $total_tax_outcome += $value->tax_out_come;
            $total_total += $value->total;
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        // tampil totalan
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_price);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_tax_outcome);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_total);
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
        // tampil totalan
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
        $total_qty = 0;
        $total_qty_receive = 0;
        $total_weight = 0;
        $total_weight_receive = 0;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY Receive');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight Receive');
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
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty_receive);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->unit->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight_receive);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_origin->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_dest->name);
            $total_qty += $value->qty;
            $total_qty_receive += $value->qty_receive;
            $total_weight += $value->weight;
            $total_weight_receive += $value->weight_receive;
            $jumlahRow++;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        // tampil totalan
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty_receive);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight_receive);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
        // tampil totalan
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
        $total_qty = 0;
        $total_qty_receive = 0;
        $total_weight = 0;
        $total_weight_receive = 0;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Date');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY Receive');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight Receive');
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
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty_receive);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->unit->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight_receive);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_origin->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse_dest->name);
            $jumlahRow++;
            $total_qty += $value->qty;
            $total_qty_receive += $value->qty_receive;
            $total_weight += $value->weight;
            $total_weight_receive += $value->weight_receive;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        // tampil totalan
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty_receive);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight_receive);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
        // tampil totalan
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
        $data_profile = $explodedParams[4];
        $body = json_decode($this->curl->simple_get(api_produksi('getHistoryShipmentItem?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end . '&dataProfile=' . urlencode($data_profile))))->data->history_shipment_item->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $total_qty = 0;
        $total_qty_receive = 0;
        $total_weight = 0;
        $total_weight_receive = 0;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Date Ship');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Doc Number');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY Receive');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight Receive');
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
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty_receive);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->unit->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight_receive);
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
            $total_qty += $value->qty;
            $total_weight_receive += $value->weight_receive;
            $total_weight += $value->weight;
            $total_qty_receive += $value->qty_receive;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        // tampil totalan
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty_receive);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight_receive);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
        // tampil totalan
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'SHIPMENT HISTORY ' . $data_profile . ' ' . $epoch;

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
        if ($mapping == 1) {
            $selectedMapping = $childMapping;
            $selectedData = $this->transformData($dataDetail, $ker_mapping);
        } else {
            $selectedMapping = $child;
            $selectedData = $dataDetail;
        }
        $dataGroup = $this->groupUniqueItems($this->getUniqueItems($selectedData, $mapping));
        $worksheet[] = $spreadsheet->getActiveSheet()->setTitle('All Data');
        $idGroup[] = 0;
        foreach ($dataGroup as $key => $value) {
            $worksheet[] = $spreadsheet->createSheet()->setTitle($value['code']);
            $idGroup[] = $value['id'];
        }
        for ($m = 0; $m < count($idGroup); $m++) {
            // per sheet
            $total_variable = [];
            $jumlahColumnStart = 1;
            $jumlahColumn = $jumlahColumnStart;
            $worksheet[$m]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
            $worksheet[$m]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
            $worksheet[$m]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
            $worksheet[$m]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumn) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumn) . '2')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
            foreach ($parent as $k => $v) {
                $jumlahColumnStartMerged = $jumlahColumn;
                foreach ($selectedMapping as $k2 => $v2) {
                    $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '2', $v2['name']);
                }
                $jumlahColumnEndMerged = $jumlahColumnStartMerged + count($selectedMapping) - 1;
                $worksheet[$m]->mergeCells(Coordinate::stringFromColumnIndex($jumlahColumnStartMerged) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEndMerged) . '1')->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumnStartMerged) . '1', $v['name']);
            }
            $jumlahRow = 3;
            $no = 1;
            // print_r($selectedData);

            foreach ($selectedData as $key => $value) {
                $continue = false;
                if ($mapping == 1) {
                    $idData = $value['item']->id;
                } else {
                    $idData = $value->item->id;
                }
                if ($idGroup[$m] == 0) {
                    $continue = true;
                } else {
                    if ($idData == $idGroup[$m]) {
                        $continue = true;
                    }
                }
                if ($continue) {
                    $jumlahColumn = $jumlahColumnStart;
                    $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
                    if ($mapping == 1) {
                        $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['item']->code);
                        $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['item']->name);
                        $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value['item_grade']->name);
                    } else {
                        $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
                        $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
                        $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item_grade->name);
                    }
                    foreach ($parent as $k => $v) {
                        // if (!isset($total_variable[$v['variable']])) {
                        //     $total_variable[$v['variable']] = [];
                        // }
                        foreach ($selectedMapping as $k2 => $v2) {
                            if ($mapping == 1) {
                                $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value[$v['variable']][$v2['variable']]);
                                if (!isset($total_variable[$v['variable']][$v2['variable']])) {
                                    $total_variable[$v['variable']][$v2['variable']] = $value[$v['variable']][$v2['variable']];
                                } else {
                                    $total_variable[$v['variable']][$v2['variable']] += $value[$v['variable']][$v2['variable']];
                                }
                            } else {
                                $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->{$v['variable']}->{$v2['variable']});
                                if (!isset($total_variable[$v['variable']][$v2['variable']])) {
                                    $total_variable[$v['variable']][$v2['variable']] = $value->{$v['variable']}->{$v2['variable']};
                                } else {
                                    $total_variable[$v['variable']][$v2['variable']] += $value->{$v['variable']}->{$v2['variable']};
                                }
                            }
                        }
                    }
                    $jumlahRow++;
                }
                // print_r($total_variable);
                $jumlahColumnEnd = $jumlahColumn - 1;
                // echo $jumlahColumnEnd;
                // echo '<br>';
                $worksheet[$m]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '2')->applyFromArray($this->templateHeader);
                // tampil totalan
                $jumlahColumn = $jumlahColumnStart;
                $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
                $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
                $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
                $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
                foreach ($parent as $k => $v) {
                    foreach ($selectedMapping as $k2 => $v2) {
                        if ($total_variable) {
                            $worksheet[$m]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_variable[$v['variable']][$v2['variable']]);
                        }
                    }
                }
                // tampil totalan
            }
            $jumlahColumnEnd = $jumlahColumn - 1;
            $worksheet[$m]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
            // per sheet
            unset($total_variable);
        }
        // exit;
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
        $itemId = $explodedParams[4];
        $supplierId = $explodedParams[5];
        $dataProfile = $explodedParams[6];
        $body = json_decode($this->curl->simple_get(api_produksi('getHistoryPurchaseDetail?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end . '&itemIds=' . $itemId . '&supplierIds=' . $supplierId . '&dataProfile=' . urlencode($dataProfile))))->data->history_purchase_detail->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $total_qty = 0;
        $total_weight = 0;
        $total_price = 0;
        $total_tax_out_come = 0;
        $total_total = 0;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Create Date');
        if ($dataProfile == 'DETAIL') {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Bale Number');
        }
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Supplier');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        if ($dataProfile == 'ITEM GRADE') {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        }
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Price');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Tax Out Come');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Total');
        if ($dataProfile == 'DETAIL') {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade Cutoff');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade Latest');
        }
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
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, date('Y-m-d', strtotime($value->datetime)));
            if ($dataProfile == 'DETAIL') {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->bale_number);
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->supplier->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            if ($dataProfile == 'ITEM GRADE') {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->grade->name);
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->price);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->tax_out_come);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->total);
            if ($dataProfile == 'DETAIL') {
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
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $grade_cutoff);
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $grade_latest);
            }
            $jumlahRow++;
            $total_qty += $value->qty;
            $total_weight += $value->weight;
            $total_price += $value->price;
            $total_tax_out_come += $value->tax_out_come;
            $total_total += $value->total;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        // tampil totalan
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        if ($dataProfile != 'ITEM') {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        }
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_price);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_tax_out_come);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_total);
        if ($dataProfile == 'DETAIL') {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
        // tampil totalan
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PURCHASE HISTORY ' . $dataProfile . ' ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelProductionRecap()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $body = json_decode($this->curl->simple_get(api_produksi('getRecapProduction?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dateEnd=' . $date_end)))->data;
        $spreadsheet = new Spreadsheet();
        $dataVariable = ['recap_production_complete', 'recap_production_on_process'];
        $dataVariableTitle = ['Complete', 'On Process'];
        for ($k = 0; $k < count($dataVariable); $k++) {
            if ($k == 0) {
                $worksheet[] = $spreadsheet->getActiveSheet()->setTitle($dataVariableTitle[$k]);
            } else {
                $worksheet[] = $spreadsheet->createSheet()->setTitle($dataVariableTitle[$k]);
            }
        }
        // exit();
        for ($k = 0; $k < count($dataVariable); $k++) {
            $total_qty = 0;
            $total_weight = 0;
            $total_material_qty = 0;
            $total_material_weight = 0;
            $jumlahColumnStart = 1;
            $jumlahColumn = $jumlahColumnStart;
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Warehouse');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Code');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Material QTY');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Material Weight');
            $jumlahRow = 2;
            $no = 1;
            foreach ($body->{$dataVariable[$k]}->data as $key => $value) {
                $jumlahColumn = $jumlahColumnStart;
                if (!$value->qty) {
                    $value->qty = 0;
                }
                if (!$value->weight) {
                    $value->weight = 0;
                }
                if (!$value->material_qty) {
                    $value->material_qty = 0;
                }
                if (!$value->material_weight) {
                    $value->material_weight = 0;
                }
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->warehouse->name);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->grade->name);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->material_qty);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->material_weight);
                $jumlahRow++;
                $total_qty += $value->qty;
                $total_weight += $value->weight;
                $total_material_qty += $value->material_qty;
                $total_material_weight += $value->material_weight;
            }
            $jumlahColumnEnd = $jumlahColumn - 1;
            $worksheet[$k]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
            // tampil totalan
            $jumlahColumn = $jumlahColumnStart;
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_material_qty);
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_material_weight);
            $jumlahColumnEnd = $jumlahColumn - 1;
            $worksheet[$k]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
            // tampil totalan
        }
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PRODUCTION RECAP ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelProductionHistory()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $itemId = $explodedParams[4];
        $dataProfile = $explodedParams[5];
        $body = json_decode($this->curl->simple_get(api_produksi('getHistoryProduction?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&itemIds=' . $itemId . '&dataProfile=' . urlencode($dataProfile))))->data;
        $spreadsheet = new Spreadsheet();
        $dataVariable = ['history_production_complete', 'history_production_on_process'];
        $dataVariableTitle = ['Complete', 'On Process'];
        for ($k = 0; $k < count($dataVariable); $k++) {
            if ($k == 0) {
                $worksheet[] = $spreadsheet->getActiveSheet()->setTitle($dataVariableTitle[$k]);
            } else {
                $worksheet[] = $spreadsheet->createSheet()->setTitle($dataVariableTitle[$k]);
            }
        }
        // exit();
        for ($k = 0; $k < count($dataVariable); $k++) {
            $total_qty = 0;
            $total_weight = 0;
            $total_material_qty = 0;
            $total_material_weight = 0;
            $jumlahColumnStart = 1;
            $jumlahColumn = $jumlahColumnStart;
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Date');
            if ($dataProfile == 'DETAIL') {
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Kode Inventory');
            }
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Kode Item');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Nama Item');
            if ($dataProfile == 'ITEM GRADE') {
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
            }
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Unit');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Material QTY');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Material Weight');
            $jumlahRow = 2;
            $no = 1;
            foreach ($body->{$dataVariable[$k]}->data as $key => $value) {
                $jumlahColumn = $jumlahColumnStart;
                if (!$value->qty) {
                    $value->qty = 0;
                }
                if (!$value->weight) {
                    $value->weight = 0;
                }
                if (!$value->material_qty) {
                    $value->material_qty = 0;
                }
                if (!$value->material_weight) {
                    $value->material_weight = 0;
                }
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, date('Y-m-d m:i:s', strtotime($value->datetime)));
                if ($dataProfile == 'DETAIL') {
                    $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->inventory->code);
                }
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->code);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
                if ($dataProfile == 'ITEM GRADE') {
                    $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->grade->name);
                }
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->unit->name);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->material_qty);
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->material_weight);
                $jumlahRow++;
                $total_qty += $value->qty;
                $total_weight += $value->weight;
                $total_material_qty += $value->material_qty;
                $total_material_weight += $value->material_weight;
            }
            $jumlahColumnEnd = $jumlahColumn - 1;
            $worksheet[$k]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
            // tampil totalan
            $jumlahColumn = $jumlahColumnStart;
            if ($dataProfile == 'ITEM') {
                for ($i = 0; $i < 4; $i++) {
                    $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
                }
            } else {
                for ($i = 0; $i < 5; $i++) {
                    $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
                }
            }
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_material_qty);
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_material_weight);
            $jumlahColumnEnd = $jumlahColumn - 1;
            $worksheet[$k]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
            // tampil totalan
        }
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PRODUCTION HISTORY ' . $dataProfile . ' ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelPackingListTanpaTerima()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $id = $explodedParams[1];
        $doc_num = $explodedParams[2];
        $body = json_decode($this->curl->simple_get(api_produksi('getHistoryShipmentItem?shipmentId=' . $id . '&dataProfile=DETAIL')))->data->history_shipment_item->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $total_qty = 0;
        $total_weight = 0;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No Bale');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $jumlahRow = 2;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, date('d/m/y', strtotime($value->inventory->date)) . '-' . $value->inventory->bale_number);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item_grade->name);
            $jumlahRow++;
            $total_qty += $value->qty;
            $total_weight += $value->weight;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        // tampil totalan
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
        // tampil totalan
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PACKING LIST ' . $doc_num . ' ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelPackingList()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $id = $explodedParams[1];
        $doc_num = $explodedParams[2];
        $body = json_decode($this->curl->simple_get(api_produksi('getHistoryShipmentItem?shipmentId=' . $id . '&dataProfile=DETAIL')))->data->history_shipment_item->data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jumlahColumnStart = 1;
        $jumlahColumn = $jumlahColumnStart;
        $total_qty = 0;
        $total_qty_received = 0;
        $total_weight = 0;
        $total_weight_received = 0;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No Bale');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'QTY Terima');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Weight Terima');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Item');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'Grade');
        $jumlahRow = 2;
        $no = 1;
        foreach ($body as $key => $value) {
            $jumlahColumn = $jumlahColumnStart;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, date('d/m/y', strtotime($value->inventory->date)) . '-' . $value->inventory->bale_number);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->qty_receive);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->weight_receive);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item->name);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $value->item_grade->name);
            $jumlahRow++;
            $total_qty += $value->qty;
            $total_qty_received += $value->qty_receive;
            $total_weight += $value->weight;
            $total_weight_received += $value->weight_receive;
        }
        $jumlahColumnEnd = $jumlahColumn - 1;
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
        // tampil totalan
        $jumlahColumn = $jumlahColumnStart;
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, 'Total');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_qty_received);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $total_weight_received);
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, '');
        $sheet->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
        // tampil totalan
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'PACKING LIST ' . $doc_num . ' ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excelMaterialHistory()
    {
        $dataFillTable = [
            'DETAIL' => [
                [
                    'name' => 'Date',
                    'variable' => 'date("Y-m-d m:i:s", strtotime($value->datetime))',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Bale Number',
                    'variable' => '$value->inventory->bale_number',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Item',
                    'variable' => '$value->item->name',
                    'text' => ''
                ],
                [
                    'name' => 'Grade',
                    'variable' => '$value->grade->name',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Unit',
                    'variable' => '$value->unit->name',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'QTY',
                    'variable' => '$value->qty',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Weight',
                    'variable' => '$value->weight',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Production Bale Number',
                    'variable' => '$value->production_inventory->bale_number',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Production Item',
                    'variable' => '$value->production_item->name',
                    'text' => ''
                ],
                [
                    'name' => 'Production Grade',
                    'variable' => '$value->production_grade->name',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Production Unit',
                    'variable' => '$value->production_unit->name',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Production QTY',
                    'variable' => '$value->production_qty',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Production Weight',
                    'variable' => '$value->production_weight',
                    'text' => 'text-end'
                ]
            ],
            'ITEM' => [
                [
                    'name' => 'Date',
                    'variable' => '$value->datetime',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Item',
                    'variable' => '$value->item->name',
                    'text' => ''
                ],
                [
                    'name' => 'Unit',
                    'variable' => '$value->unit->name',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'QTY',
                    'variable' => '$value->qty',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Weight',
                    'variable' => '$value->weight',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Production QTY',
                    'variable' => '$value->production_qty',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Production Weight',
                    'variable' => '$value->production_weight',
                    'text' => 'text-end'
                ]
            ],
            'ITEM GRADE' => [
                [
                    'name' => 'Date',
                    'variable' => '$value->datetime',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Item',
                    'variable' => '$value->item->name',
                    'text' => ''
                ],
                [
                    'name' => 'Grade',
                    'variable' => '$value->grade->name',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'Unit',
                    'variable' => '$value->unit->name',
                    'text' => 'text-center'
                ],
                [
                    'name' => 'QTY',
                    'variable' => '$value->qty',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Weight',
                    'variable' => '$value->weight',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Production QTY',
                    'variable' => '$value->production_qty',
                    'text' => 'text-end'
                ],
                [
                    'name' => 'Production Weight',
                    'variable' => '$value->production_weight',
                    'text' => 'text-end'
                ]
            ]
        ];

        $dataFooterTable = [
            'DETAIL' => [
                [
                    'variable' => '""',
                    'text' => 'text-end',
                    'colspan' => 6
                ],
                [
                    'variable' => 'number_format(round($total_qty,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => 'number_format(round($total_weight,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => '""',
                    'text' => '',
                    'colspan' => 4
                ],
                [
                    'variable' => 'number_format(round($total_production_qty,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => 'number_format(round($total_production_weight,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ]
            ],
            'ITEM' => [
                [
                    'variable' => '""',
                    'text' => 'text-end',
                    'colspan' => 4
                ],
                [
                    'variable' => 'number_format(round($total_qty,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => 'number_format(round($total_weight,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => 'number_format(round($total_production_qty,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => 'number_format(round($total_production_weight,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ]
            ],
            'ITEM GRADE' => [
                [
                    'variable' => '""',
                    'text' => 'text-end',
                    'colspan' => 5
                ],
                [
                    'variable' => 'number_format(round($total_qty,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => 'number_format(round($total_weight,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => 'number_format(round($total_production_qty,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ],
                [
                    'variable' => 'number_format(round($total_production_weight,2))',
                    'text' => 'text-end',
                    'colspan' => 1
                ]
            ]
        ];

        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $warehouse_id = $explodedParams[1];
        $date_start = date('Y-m-d', strtotime($explodedParams[2]));
        $date_end = date('Y-m-d', strtotime($explodedParams[3]));
        $dataProfile = $explodedParams[4];
        $body = json_decode($this->curl->simple_get(api_produksi('getHistoryMaterial?warehouse_id=' . $warehouse_id . '&dateStart=' . $date_start . '&dataProfile=' . urlencode($dataProfile))))->data;
        $spreadsheet = new Spreadsheet();
        $dataVariable = ['history_material_complete', 'history_material_on_process'];
        $dataVariableTitle = ['Complete', 'On Process'];
        for ($k = 0; $k < count($dataVariable); $k++) {
            if ($k == 0) {
                $worksheet[] = $spreadsheet->getActiveSheet()->setTitle($dataVariableTitle[$k]);
            } else {
                $worksheet[] = $spreadsheet->createSheet()->setTitle($dataVariableTitle[$k]);
            }
        }
        // exit();
        for ($k = 0; $k < count($dataVariable); $k++) {
            $total_qty = 0;
            $total_weight = 0;
            $total_production_qty = 0;
            $total_production_weight = 0;
            $jumlahColumnStart = 1;
            $jumlahColumn = $jumlahColumnStart;
            $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', 'No');
            foreach ($dataFillTable[$dataProfile] as $key2 => $value2) {
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . '1', $value2['name']);
            }
            $jumlahRow = 2;
            $no = 1;
            foreach ($body->{$dataVariable[$k]}->data as $key => $value) {
                $jumlahColumn = $jumlahColumnStart;
                if (!$value->qty) {
                    $value->qty = 0;
                }
                if (!$value->weight) {
                    $value->weight = 0;
                }
                if (!$value->production_qty) {
                    $value->production_qty = 0;
                }
                if (!$value->production_weight) {
                    $value->production_weight = 0;
                }
                $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $no++);
                foreach ($dataFillTable[$dataProfile] as $key2 => $value2) {
                    $expression = $value2['variable'];
                    $result = eval('return ' . $expression . ';');
                    $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $result);
                }
                $jumlahRow++;
                $total_qty += $value->qty;
                $total_weight += $value->weight;
                $total_production_qty += $value->production_qty;
                $total_production_weight += $value->production_weight;
            }
            $jumlahColumnEnd = $jumlahColumn - 1;
            $worksheet[$k]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart) . '1:' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . '1')->applyFromArray($this->templateHeader);
            // tampil totalan
            $jumlahColumn = $jumlahColumnStart;

            foreach ($dataFooterTable[$dataProfile] as $key2 => $value2) {
                $expression = $value2['variable'];
                $result = eval('return ' . $expression . ';');
                for ($z = 0; $z < $value2['colspan']; $z++) {
                    $worksheet[$k]->setCellValue(Coordinate::stringFromColumnIndex($jumlahColumn++) . $jumlahRow, $result);
                }
            }

            $jumlahColumnEnd = $jumlahColumn - 1;
            $worksheet[$k]->getStyle(Coordinate::stringFromColumnIndex($jumlahColumnStart)  . $jumlahRow . ':' . Coordinate::stringFromColumnIndex($jumlahColumnEnd) . $jumlahRow)->applyFromArray($this->templateHeader);
            // tampil totalan
        }
        $date_time = date('Y-m-d H:i:s');
        $epoch = strtotime($date_time);
        $writer = new Xlsx($spreadsheet);
        $filename = 'MATERIAL HISTORY ' . $dataProfile . ' ' . $epoch;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
