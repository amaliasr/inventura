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
}
