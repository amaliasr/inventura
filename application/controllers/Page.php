<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Page extends CI_Controller
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
    }
    public function invoices()
    {
        $data['title'] = 'Invoices Lists';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/invoices', $data);
    }
    public function cetakInvoices()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $data['id'] = $explodedParams[1];
        $data['name'] = $explodedParams[2];
        $data['no_invoices'] = $explodedParams[3];
        $data['is_pajak'] = $explodedParams[4];
        $data['is_harga_satuan'] = $explodedParams[5];
        $data['qrcode'] = $explodedParams[6];
        $data['datas'] = json_decode($this->curl->simple_get(api_url('getInvoice?purchaseId=' . $data['id'])))->data;
        // $this->load->view('print/cetakInvoices', $data);
        $html = $this->load->view('print/cetakInvoices', $data, true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "INVOICES " . $data['no_invoices'] . ".pdf";
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream("INVOICES " . $data['no_invoices'] . ".pdf", array("Attachment" => 0));
    }
    public function purchase_recap()
    {
        $data['title'] = 'Purchase Recap';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/purchase_recap', $data);
    }
    public function recap_shipment()
    {
        $data['title'] = 'Shipment Recap';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/recap_shipment', $data);
    }
    public function recap_puchase_supplier()
    {
        $data['title'] = 'Purchase Supplier Recap';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/recap_puchase_supplier', $data);
    }
    public function recap_warehouse_stock()
    {
        $data['title'] = 'Warehouse Stock Recap';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/recap_warehouse_stock', $data);
    }
    public function report_shipment()
    {
        $data['title'] = 'Shipment Report';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/report_shipment', $data);
    }
    public function history_purchase()
    {
        $data['title'] = 'Purchase History';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/history_purchase', $data);
    }
    public function history_shipment()
    {
        $data['title'] = 'Shipment History';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/history_shipment', $data);
    }
    public function shippings()
    {
        $data['title'] = 'Shipping';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/shippings', $data);
    }
    public function recap_production()
    {
        $data['title'] = 'Production Recap';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/recap_production', $data);
    }
    public function cetakSuratJalan()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $data['id'] = $explodedParams[1];
        $data['document_number'] = $explodedParams[2];
        $data['qrcode'] = $explodedParams[3];
        $data['datas'] = json_decode($this->curl->simple_get(api_url('getShipmentPrint?id=' . $data['id'])))->data->shipment;
        // $this->load->view('print/cetakSuratJalan', $data);
        $html = $this->load->view('print/cetakSuratJalan', $data, true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "SURAT JALAN " . $data['document_number'] . ".pdf";
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream("SURAT JALAN " . $data['document_number'] . ".pdf", array("Attachment" => 0));
    }
    public function cetakPackingList()
    {
        $params = $this->input->get('params');
        $decodedParams = urldecode($params);
        $explodedParams = explode("*$", $decodedParams);
        $data['id'] = $explodedParams[1];
        $data['doc_num'] = $explodedParams[2];
        $data['datas'] = json_decode($this->curl->simple_get(api_url('getHistoryShipmentItem?shipmentId=' . $data['id'] . '&dataProfile=DETAIL')))->data->history_shipment_item->data;
        // $this->load->view('print/cetakPackingList', $data);
        // exit;
        $html = $this->load->view('print/cetakPackingList', $data, true);
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "PACKING LIST SJ " . $data['doc_num'] . ".pdf";
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream("PACKING LIST SJ " . $data['doc_num'] . ".pdf", array("Attachment" => 0));
    }
    public function history_production()
    {
        $data['title'] = 'Production History';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/history_production', $data);
    }
    public function receptions()
    {
        $data['title'] = 'Receptions';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/receptions', $data);
    }
    public function history_material()
    {
        $data['title'] = 'History Material';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/history_material', $data);
    }
    public function master_supplier()
    {
        $data['title'] = 'Master Supplier';
        $data['permission'] = $this->permission;
        $data['warehouse_id'] = $this->warehouse_id;
        $this->template->views('page/master_supplier', $data);
    }
}
