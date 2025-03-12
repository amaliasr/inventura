<link href="<?= base_url(); ?>assets/smm/purchase_order.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/shipping.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/report.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/tracking.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    .litepicker .container__months .month-item {
        box-sizing: content-box !important;
        width: 280px !important;
    }

    .container__months {
        width: 280px !important;
    }

    #custom-search-container div.dataTables_filter input {
        border-radius: 20px;
        width: 200px;
    }

    #custom-search-container div.dataTables_filter {
        font-size: 0px;
    }

    .formFilter {
        border-radius: 20px;
        width: 200px;
        padding-left: 30px;
        padding: 9px !important;
        padding-right: 50px !important;
        font-size: 10px;
    }

    .circular-landscape {
        display: inline-block;
        position: relative;
        width: 30px;
        height: 30px;
        overflow: hidden;
        border-radius: 50%;
    }

    .circular-landscape img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Flashing */
    .avatar:hover img {
        opacity: 1;
        -webkit-animation: flash 1.5s;
        animation: flash 1.5s;
    }

    @-webkit-keyframes flash {
        0% {
            opacity: .4;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes flash {
        0% {
            opacity: .4;
        }

        100% {
            opacity: 1;
        }
    }

    .avatars {
        display: inline-flex;
        flex-direction: row;
    }

    .avatar {
        position: relative;
        border: 2px solid #fff;
        border-radius: 50%;
        overflow: hidden;
        width: 30px;
        height: 30px;
        /* Sesuaikan dengan ukuran yang diinginkan */
    }

    .avatar:not(:last-child) {
        margin-right: -20px;
        /* Mengatur jarak antara gambar */
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Memastikan gambar tetap terlihat utuh dalam lingkaran */
        display: block;
    }

    .avatar canvas {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Memastikan gambar tetap terlihat utuh dalam lingkaran */
        display: block;
    }

    .plus-avatar {
        background-color: #27374D;
        width: 30px;
        height: 30px;
        display: flex;
        color: white;
        justify-content: center;
        align-items: center;
    }

    .plus-avatar-grey {
        background-color: #EFF5F5;
        width: 30px;
        height: 30px;
        display: flex;
        color: grey;
        justify-content: center;
        align-items: center;
    }

    .plus-avatar-grey-empty {
        background-color: transparent;
        width: 30px;
        height: 30px;
        display: flex;
        color: white;
        justify-content: center;
        align-items: center;
    }

    .plus-icon {
        font-size: 10px;
        font-weight: bold;
    }

    .text-dark-teal {
        color: #268281;
    }

    .text-light-teal {
        color: #7cb4b3;
    }

    .chart-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 8px;
        margin-top: 20px;
        width: 100%;
    }

    .bar {
        height: 30px;
        border-radius: 5px;
        text-align: center;
        color: #fff;
        line-height: 30px;
        font-size: 14px;
        margin-right: 10px;
        transition: width 0.5s ease-in-out, transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .bar:hover {
        transform: scale(1.02);
        /* Slight zoom in effect on hover */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        /* Shadow effect on hover */
        /* Zoom in effect on hover */
    }

    .bar-1 {
        background-color: #87CEEB;
    }

    .bar-2 {
        background-color: #90EE90;
    }

    .bar-3 {
        background-color: #F4A460;
    }

    .bar-4 {
        background-color: #FFB6C1;
    }

    .legend {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 12px;
        text-align: start;
    }

    .legend-item {
        display: flex;
        align-items: baseline;
    }

    .legend-item span {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 5px;
    }

    .blue {
        background-color: #87CEEB;
    }

    .green {
        background-color: #90EE90;
    }

    .orange {
        background-color: #F4A460;
    }

    .red {
        background-color: #FFB6C1;
    }

    #chartStocks {
        min-height: 0px !important;
    }

    /* Custom styles for popover text */
    .popover-body {
        font-size: 12px;
        /* Set font size for popover text */
    }

    .popover-header {
        font-size: 12px;
        /* Set font size for popover text */
    }

    #custom-length-menu-container label {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        font-size: 11px;
    }

    #custom-length-menu-container label select {
        margin-left: 5px;
        margin-right: 5px;
    }

    #custom-length-menu-container {
        margin-bottom: 10px;
        /* Optional, untuk memberikan jarak bawah */
    }

    .btn-outline-grey {
        color: #69707a;
        border-color: #69707a;
    }

    .btn-outline-grey.active {
        color: #fff;
        background-color: #69707a;
        border-color: #69707a;
    }

    #bs-select-1 {
        overflow: visible !important;
    }

    .is-select-picker {
        border-radius: 4px !important;
        width: 100% !important;
    }

    .circle-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 30px;
    }

    .bg-light-warning {
        background-color: #fdf5e5 !important;
    }
</style>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
</svg>
<main>
    <!-- Main page content-->
    <header class="page-header page-header-dark pb-10">
        <div class="container-xl px-4 mb-5">
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl mt-n10">
        <div class="row mb-4">
            <div class="col-4">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h1 class="text-dark fw-bolder m-0 d-flex align-items-center" style="font-weight: 700 !important">Stock List <span class="badge bg-orange small-text ms-2">OLD</span></h1>
                        <p class="m-0 super-small-text" id="dateRangeString"></p>
                    </div>
                </div>
            </div>
            <div class="col-8 text-end align-self-center">
                <div class="row justify-content-end">
                    <div class="col-auto pe-0">
                        <p class="m-0 small-text"><i>Last Updated</i></p>
                        <p class="m-0 small-text"><i>Today at <b id="timeRefresh">-</b></i></p>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <button type="button" class="btn btn-sm shadow-none btn-outline-primary me-2" onclick="datatableStock()"><i class="fa fa-refresh"></i></button>
                        <input class="form-control form-control-sm datepicker shadow-none me-2" type="text" id="dateRange" placeholder="Tanggal" autocomplete="off" style="width: 200px;">
                        <button type="button" class="btn btn-sm shadow-none btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Filter</button>
                        <button type="button" class="btn btn-light border border-dark btn-sm ms-2" onclick="switchToNew()">Switch to New ver</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-2 col-3 pe-0">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="m-0 small-text fw-bolder d-flex align-items-center">Total All Stocks</p>
                        <p class="m-0 super-small-text mb-3">Data Tersebut termasuk produk FC, Cengkeh (Daun), Rajangan Bale, Rajangan Press</p>
                        <p class="m-0 fw-bolder lh-1" style="font-size:40px !important"><span class="text-dark-teal total-all-bale">--</span> <span id="unitName"></span></p>
                        <p class="m-0 lh-1"><span class="text-light-teal total-all-weight">--</span> Kg</p>
                    </div>
                </div>
            </div>
            <div class="mb-2 col-9">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="m-0 small-text fw-bolder d-flex align-items-center">Stocks Age</p>
                        <div class="" id="stockAgeChart">
                            <div class="chart-container">
                                <!-- <div class="bar bar-1" data-bs-toggle="popover" data-bs-trigger="hover"></div>
                                <div class="bar bar-2" data-bs-toggle="popover" data-bs-trigger="hover"></div>
                                <div class="bar bar-3" data-bs-toggle="popover" data-bs-trigger="hover"></div> -->
                            </div>
                            <div class="legend">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2 col-12">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <p class="m-0 small-text fw-bolder d-flex align-items-center">Current Stocks</p>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-outline-grey active py-1 px-2 shadow-none small-text btnChart" id="btnqty" onclick="changeChartStocks('qty')">QTY</button>
                                <button class="btn btn-sm btn-outline-grey py-1 px-2 shadow-none small-text btnChart" id="btnweight" onclick="changeChartStocks('weight')">Weight</button>
                            </div>
                        </div>
                        <div id="chartStocks"></div>
                    </div>
                </div>
            </div>
            <div class="mb-2 col-12">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <p class="m-0 small-text fw-bolder d-flex align-items-center">Detail Stocks</p>
                            </div>
                            <div class="col-auto">
                                <div id="custom-length-menu-container" class="d-flex align-items-center"></div>
                            </div>
                            <div class="col-auto">
                                <div id="custom-search-container"></div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <table class="table table-hover table-sm" style="overflow-x: hidden;" id="tableStocks">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center small-text bg-white">#</th>
                                        <th class="align-middle text-center small-text bg-white">Age<br>(Days)</th>
                                        <th class="align-middle text-center small-text bg-white">Item</th>
                                        <th class="align-middle text-center small-text bg-white">Item Origin</th>
                                        <th class="align-middle text-center small-text bg-white">Grade</th>
                                        <th class="align-middle text-center small-text bg-white">QTY</th>
                                        <th class="align-middle text-center small-text bg-white">Unit</th>
                                        <th class="align-middle text-center small-text bg-white">Weight<br>(Kg)</th>
                                        <th class="align-middle text-center small-text bg-white">Supplier</th>
                                        <th class="align-middle text-center small-text bg-white">Bale Number</th>
                                        <th class="align-middle text-center small-text bg-white">Code</th>
                                        <th class="align-middle text-center small-text bg-white">Global Code</th>
                                        <th class="align-middle text-center small-text bg-white">Purchase At</th>
                                        <th class="align-middle text-center small-text bg-white"></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTable">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<!-- Modal -->
<div class="modal fade small" id="modal" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document" id="modalDialog">
        <div class="modal-content">
            <div class="modal-header small" id="modalHeader">

            </div>
            <div class="modal-body small" style="min-height: 300px;" id="modalBody">

            </div>
            <div class="modal-footer small" id="modalFooter">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal2" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document" id="modalDialog2">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader2">

            </div>
            <div class="modal-body" id="modalBody2">

            </div>
            <div class="modal-footer" id="modalFooter2">

            </div>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="z-index: 9999;width: 650px;">
    <div class="offcanvas-header border-bottom">
        <p class="m-0 small" id="offcanvasRightLabel">Filter Special</p>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-4" id="offcanvasRightBody">
        <div class="row">
            <!-- // start date -->
            <div class="col-6 mb-2">
                <p class="m-0 small-text fw-bolder">Start Date</p>
                <input class="form-control form-control-sm datepicker shadow-none me-2" type="text" id="dateStart" placeholder="Tanggal Mulai" autocomplete="off" style="width: 100%;height:30px;padding:10px;">
                <div class="form-check form-check-sm d-flex align-items-center">
                    <input class="form-check-input me-2" type="checkbox" id="checkStart" onclick="checkStart()" checked>
                    <label class="form-check-label small-text" for="checkStart">Disable Start Date</label>
                </div>
            </div>
            <!-- // start date -->
            <!-- //  click check to disabled start date -->
            <!-- <div class="col-12 mb-2 text-end">
            </div> -->
            <!-- //  click check to disabled start date -->
            <!-- // end date -->
            <div class="col-6 mb-2">
                <p class="m-0 small-text fw-bolder">End Date</p>
                <input class="form-control form-control-sm datepicker shadow-none me-2" type="text" id="dateEnd" placeholder="Tanggal Mulai" autocomplete="off" style="width: 100%;height:30px;padding:10px;">
            </div>
            <!-- // end date -->
            <div class=" col-6 mb-2">
                <p class="m-0 small-text fw-bolder">Item</p>
                <select class="selectpicker w-100" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 1" id="selectItem" title="Pilih Item" onchange="getDataGrade()">
                </select>
            </div>
            <!-- // item checkbox small -->
            <div class="col-6 mb-2">
                <p class="m-0 small-text fw-bolder">Unit</p>
                <select class="selectpicker w-100" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 1" id="selectUnit" title="Pilih Unit">
                </select>
            </div>
            <!-- // item checkbox small -->
            <div class=" col-12 mb-2">
                <p class="m-0 small-text fw-bolder">Item Origin</p>
                <select class="selectpicker w-100" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 1" id="selectWarehouse" title="Pilih Warehouse">
                </select>
            </div>
            <!-- // grade checkbox small -->
            <div class=" col-12 mb-2">
                <p class="m-0 small-text fw-bolder">Grade</p>
                <div class="row pt-2">
                    <div class="col-12">
                        <div class="form-check form-check-sm d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" id="btnCheckAllGrade" onclick="checkAllGrade()" checked>
                            <label class="form-check-label small-text" for="btnCheckAllGrade">Semua Grade</label>
                        </div>
                    </div>
                </div>
                <div class="row pt-2" id="listCheckBoxGrade">

                </div>
                <!-- <select class="selectpicker w-100" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 1" id="selectGrade" title="Pilih Grade">
                </select> -->
            </div>

            <!-- // grade checkbox small -->
            <!-- // btn save -->
            <div class=" col-12 mb-2 text-end">
                <button type="button" class="btn btn-outline-success btn-sm" onclick="downloadExcel()"><i class="fa fa-file-excel-o me-2"></i>Download Excel</button>
                <button type="button" class="btn btn-success btn-sm" onclick="saveFilter()">Apply Filter</button>
            </div>
            <!-- // btn save -->
        </div>
    </div>
</div>
<?php $this->load->view('components/modal_static') ?>
<!-- Chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="<?= base_url(); ?>assets/smm/format.js"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<!-- autocomplete -->
<!-- <script type="text/javascript" src="<?= base_url() ?>assets/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/bootstrap-multiselect/js/bootstrap-multiselect.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<!-- QR CODE -->
<script type="text/javascript" src="<?= base_url() ?>assets/js/vendor/qrcode.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="<?= base_url(); ?>assets/JSPrintManager.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- <script src="<?= base_url(); ?>assets/ebapi-modules.js"></script> -->
<script>
    var imgBase64Data

    function notFoundReturn(text, height = null) {
        if (!height) {
            height = '100%'
        }
        var html = '<div class="row"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:' + height + ';"><div class="card-body h-100 p-5 m-5"><lottie-player style="margin:auto;width: 200px; height: 100%;" src="<?= base_url() ?>assets/`json/`nodata.json" mode="bounce" background="transparent" speed="2" loop autoplay></lottie-player><p class="small"><i>' + text + '</i></p></div></div></div></div>'
        return html
    }

    function empty(location, text, height = null) {
        if (!height) {
            height = '100%'
        }
        $(location).html('<div class="row"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:' + height + ';"><div class="card-body h-100 p-5 m-5"><lottie-player style="margin:auto;width: 150px; height: 100%;" src="<?= base_url() ?>assets/json/lf20_s8pbrcfw.json" mode="bounce" background="transparent" speed="2" loop autoplay></lottie-player><p class="small"><i>' + text + '</i></p></div></div></div></div>')
    }

    function emptyReturn(text, height = null) {
        if (!height) {
            height = '100%'
        }
        var html = '<div class="row"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:' + height + ';"><div class="card-body h-100 p-5 m-5"><lottie-player style="margin:auto;width: 150px; height: 100%;" src="<?= base_url() ?>assets/json/lf20_s8pbrcfw.json" mode="bounce" background="transparent" speed="2" loop autoplay></lottie-player><p class="small"><i>' + text + '</i></p></div></div></div></div>'
        return html
    }

    function emptyText(location, text) {
        $(location).html('<div class="row h-100"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:100%;background-color:transparent"><div class="card-body h-100 m-5"><p class="small"><i>' + text + '</i></p></div></div></div></div>')
    }

    function emptyTextReturn(text) {
        var html = '<div class="row h-100"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:100%;background-color:transparent"><div class="card-body h-100 m-5"><p class="small"><i>' + text + '</i></p></div></div></div></div>'
        return html
    }

    function loadingReturn(text, height = null) {
        if (!height) {
            height = '100%'
        }
        var html = '<div class="row h-100"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:' + height + ';"><div class="card-body h-100 p-5 m-5"><lottie-player style="margin:auto;width: 150px; height: 100%;" src="<?= base_url() ?>assets/json/loading.json" mode="bounce" background="transparent" speed="2" loop autoplay></lottie-player><p class="small"><i>' + text + '</i></p></div></div></div></div>'
        return html
    }

    function iconStocks() {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16"><path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/></svg>'
        return html
    }

    function redSmallText(text = null) {
        var html = ''
        if (text) {
            html += '<span class="text-danger super-small-text">' + text + '</span>'
        } else {
            html += '<span class="text-danger">*</span>'
        }
        return html
    }

    var imgBase64Data

    function getQrcode(url, id, status) {
        if (url != 0) {
            var qrcode = new QRCode("qrcode", {
                text: url,
                width: 100,
                height: 100,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            imgBase64Data = qrcode._oDrawing._elCanvas.toDataURL("image/png")
            var image = btoa(imgBase64Data)
            if (status == 0) {
                var url = '<?= base_url('order/cetakPR') ?>'
            } else {
                var url = '<?= base_url('order/cetakPO') ?>'
            }
            var params = "*$" + image + "*$" + id + "*$" + user_id
            window.open(url + '?params=' + (params), '_blank')
        } else {
            // buat supplier
            var url = '<?= base_url('order/cetakPO') ?>'
            var params = "*$0" + "*$" + id + "*$" + user_id
            window.open(url + '?params=' + (params), '_blank')
        }
    }

    function getFirstDate() {
        // Mendapatkan tanggal hari ini
        const today = new Date();
        // Mengurangi tiga bulan dari bulan saat ini
        today.setMonth(today.getMonth() - 3);
        var month = today.getMonth() + 1;
        var year = today.getFullYear();

        // Format tanggal menjadi string 'YYYY-MM-DD'
        const formattedDate = year + "-" + (month < 10 ? '0' : '') + month + "-01";

        return formattedDate;
    }

    function clearModal() {
        $('#modalDialog').removeClass();
        $('#modalDialog').removeAttr('style');
        $('#modalHeader').html('');
        $('#modalBody').html('');
        $('#modalFooter').html('');
    }


    $('#modal').on('hidden.bs.modal', function(e) {
        clearModal();
    })
    $(document).on('show.bs.modal', '.modal', function() {
        const zIndex = 1040 + 10 * $('.modal:visible').length;
        $(this).css('z-index', zIndex);
        setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
    });
    var warehouse_id = '<?= $this->session->userdata('warehouse_id') ?>'
    var data_warehouse = {}
    var data_master = {}
    var data_warehouse_showed = []
    var date_start = ''
    var date_end = currentDate()
    var indexVariable = 0
    var indexVariablePacking = 0
    var data_packing_list = []
    var data_packing_list_showed = []
    var linkPhoto = ''
    var printers = []
    var itemId = []
    var gradeId = []
    var warehouse_id_origin = []
    var item_unit_id = []
    $(document).ready(function() {
        loadData()
        dateRangeString()
        setDaterange()
    })

    function selectItem() {
        var html = ''
        data_master.item.forEach(e => {
            var select = ''
            select = 'selected'
            html += '<option value="' + e.id + '" ' + select + '>' + e.name + '</option>'
        });
        $('#selectItem').html(html)
        $('#selectItem').selectpicker('refresh');
        // $('#selectItem').selectpicker({

        // });
        selectWarehouse()
        getDataGrade()
    }

    function selectWarehouse() {
        var html = ''
        data_master.warehouse.forEach(e => {
            var select = ''
            select = 'selected'
            html += '<option value="' + e.id + '" ' + select + '>' + e.name + '</option>'
        });
        $('#selectWarehouse').html(html)
        $('#selectWarehouse').selectpicker('refresh');
        selectUnit()
    }

    function selectUnit() {
        var html = ''
        data_master.unit.forEach(e => {
            var select = ''
            select = 'selected'
            html += '<option value="' + e.id + '" ' + select + '>' + e.name + '</option>'
        });
        $('#selectUnit').html(html)
        $('#selectUnit').selectpicker('refresh');
    }

    function getDataGrade() {
        var itemId = $('#selectItem').val()
        // console.log(itemId)
        if (itemId.length) {
            $.ajax({
                url: "<?= api_url('getItemGrade'); ?>",
                method: "GET",
                dataType: 'JSON',
                data: {
                    itemId: itemId,
                },
                error: function(xhr) {
                    showOverlay('hide')
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error Data'
                    })
                },
                beforeSend: function() {
                    showOverlay('show')
                },
                success: function(response) {
                    showOverlay('hide')
                    var data = response.data.itemGrade
                    selectGrade(data)
                }
            })
        } else {
            var data = []
            selectGrade(data)
        }
    }

    function checkAllGrade() {
        if ($('#btnCheckAllGrade').is(':checked')) {
            $('.selectGradeItem').prop('checked', true)
        } else {
            $('.selectGradeItem').prop('checked', false)
        }
    }

    function selectGrade(data) {
        // console.log(data)
        var html = ''
        if (data) {
            data.forEach(e => {
                // checkbox
                html += '<div class="col-2 pe-0">'
                var select = ''
                select = 'checked'
                html += '<div class="form-check form-check-inline">' +
                    '<input class="form-check-input selectGradeItem" type="checkbox" id="selectGradeItem' + e.id + '" value="' + e.id + '" ' + select + '>' +
                    '<label class="form-check-label small-text d-flex align-self-center" for="selectGradeItem' + e.id + '">' + e.name + '</label>' +
                    '</div>'
                html += '</div>'
            })
        }
        $('#listCheckBoxGrade').html(html);

        // $('#selectGrade').selectpicker('deselectAll');
        // $('#selectGrade').val('').selectpicker('refresh')
        // if (data) {
        //     data.forEach(e => {
        //         var select = ''
        //         select = 'selected'
        //         html += '<option value="' + e.id + '" ' + select + '>' + e.name + '</option>'
        //     });
        // }
        // $('#selectGrade').html(html)
        // $('#selectGrade').selectpicker('refresh');
        // $('#selectGrade').selectpicker({

        // });
        // $('#bs-select-2 li').not('[class*="selected"]').remove();
        checkStart()
    }

    // function resetFilter() {
    //     $('#selectGrade').selectpicker('deselectAll');
    // }

    function checkStart() {
        if ($('#checkStart').is(':checked')) {
            date_start = ''
            $('#dateStart').val('')
            $('#dateStart').prop('disabled', true)
        } else {
            $('#dateStart').prop('disabled', false)
            date_start = currentDate()
            $('#dateStart').val(formatInternationalDate(currentDate()))
        }
    }

    function checkItem(id) {
        if (itemId.includes(id)) {
            itemId.splice(itemId.indexOf(id), 1)
        } else {
            itemId.push(id)
        }
    }

    function saveFilter() {
        itemId = []
        gradeId = []
        warehouse_id_origin = []
        item_unit_id = []
        itemId = $('#selectItem').val()
        gradeId = $('.selectGradeItem:checked').map(function() {
            return $(this).val();
        }).get()
        warehouse_id_origin = $('#selectWarehouse').val()
        item_unit_id = $('#selectUnit').val()
        $('#dateRange').val(formatInternationalDate(date_end))
        dateRangeString()
        datatableStock()
    }

    function datatableStock() {
        data_warehouse = {}
        $('#custom-search-container').html('');
        $('#custom-length-menu-container').html('');
        $('#tableStocks').DataTable().destroy()
        $('#tableStocks').DataTable({
            pageLength: 100,
            scrollY: "600px",
            fixedHeader: true,
            processing: true,
            serverSide: true,
            paging: true,
            searchDelay: 2000,
            ajax: function(data, callback, settings) {
                var page = Math.floor(settings._iDisplayStart / settings._iDisplayLength) + 1; // Hitung halaman berdasarkan start & length
                // var pageSize = 100;
                var pageSize = settings._iDisplayLength;
                var data = {
                    warehouseId: warehouse_id,
                    page: page,
                    pageSize: pageSize,
                    itemId: itemId,
                    dateEnd: date_end,
                    itemGradeId: gradeId,
                    warehouseIdOrigin: warehouse_id_origin,
                    itemUnitId: item_unit_id
                }
                if (date_start) {
                    data.dateStart = date_start
                }
                $.ajax({
                    url: 'https://rest.pt-bks.com/tobacco/getInventoryStockList',
                    data: data,
                    error: function(xhr) {
                        showOverlay('hide')
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Data'
                        })
                    },
                    beforeSend: function() {
                        showOverlay('show')
                    },
                    success: function(response) {
                        showOverlay('hide')
                        // Format data sesuai kebutuhan DataTables
                        data_warehouse = response.data
                        callback({
                            draw: data.draw,
                            recordsTotal: response.data.inventoryStockList.total, // Total data di server
                            recordsFiltered: response.data.inventoryStockList.total, // Data setelah filtering
                            data: response.data.inventoryStockList.data // Data untuk ditampilkan di tabel
                        });
                        arrangeVariableStocks()
                    }
                });
            },
            columns: [{ // Kolom #
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1; // Menampilkan nomor urut
                    },
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Age (Days)
                    data: 'age_days',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Item
                    data: 'item.name',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Item
                    data: 'warehouse_origin.name',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Grade
                    data: 'item_grade.name',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom QTY
                    data: 'qty',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Unit
                    data: 'unit.name',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Weight (Kg)
                    data: 'weight',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Supplier
                    data: 'supplier.name',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Bale Number
                    data: 'inventory.bale_number',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Code
                    data: 'inventory.code',
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Global Code
                    data: 'inventory.global_code',
                    defaultContent: '', // Jika null, tampilkan konten kosong
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Purchase At
                    data: 'purchase_at',
                    render: function(data) {
                        return getDateTime(data); // Format tanggal menjadi lebih mudah dibaca
                    },
                    className: 'align-middle text-center super-small-text'
                },
                { // Kolom Tombol
                    data: null,
                    render: function(data, type, row, meta) {
                        return `
                    <div class="dropdown">
                        <button class="super-small-text btn btn-sm btn-outline-dark py-1 px-2 shadow-none" id="dropdownMenuButton${meta.row}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu shadow-sm" aria-labelledby="dropdownMenuButton${meta.row}">
                           <a class="dropdown-item" onclick="getInventoryScan('${data.inventory.id}')">
                            <i class="fa fa-th-list me-2"></i> Data Inventory
                            </a>
                           <a class="dropdown-item" onclick="showBarcode('${data.inventory.id}')">
                            <i class="fa fa-qrcode me-2"></i> Lihat Barcode
                            </a>
                        </div>
                    </div>`;
                    },
                    className: 'align-middle text-center'
                }
            ],
            lengthMenu: [
                [100, 200, 500],
                [100, 200, 500]
            ], // Opsi jumlah record per halaman
            pageLength: 100, // Default jumlah record per halaman
            pagingType: 'simple_numbers', // Pagination style
            dom: '<"top"fl>rt<"bottom"ip><"clear">', // Pastikan filter di atas
            language: {
                paginate: {
                    previous: 'Prev',
                    next: 'Next'
                },
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ Data' // Menyesuaikan format info
            },
            // Styling tambahan agar lebih responsif
            responsive: true,
            autoWidth: false,
            lengthChange: true,
            "initComplete": function(settings, json) {
                $('div.dataTables_filter input').attr('placeholder', 'Search...');
            },
        });
        $('#custom-search-container').html($('.dataTables_filter'));
        $('#custom-length-menu-container').html($('#tableStocks_length').detach());
    }

    function showBarcode(id) {
        $('#modal2').modal('show')
        $('#modalDialog2').addClass('modal-dialog modal-dialog-scrollable');
        var html_header = '';
        html_header += '<h5 class="modal-title">Barcode</h5>';
        html_header += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $('#modalHeader2').html(html_header);
        var html_body = '';
        $('#modalBody2').html(html_body);
        var html_footer = '';
        $('#modalFooter2').html(html_footer).addClass('d-none')
        $('#qrcodePacking').empty()
        layoutPrinted(id)
    }

    function formatDateBarcode(dateString) {
        // Create a new Date object from the input date string
        const date = new Date(dateString);

        // Array of month names for converting month number to name
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        // Extract day, month, year, hours, and minutes
        const day = date.getDate(); // Day of the month
        const month = months[date.getMonth()]; // Month name
        const year = String(date.getFullYear()).slice(-2); // Last 2 digits of the year
        const hours = String(date.getHours()).padStart(2, '0'); // Hour in 2 digits
        const minutes = String(date.getMinutes()).padStart(2, '0'); // Minutes in 2 digits

        // Format the date as '18 Sep 24, 16:06'
        return `${day} ${month} ${year}, ${hours}:${minutes}`;
    }

    function layoutPrinted(id) {
        var data = data_warehouse.inventoryStockList.data.find(item => item.inventory.id == id)
        // console.log(id)
        var weight = data.weight
        var html = '';
        html += '<div class="row">'
        html += '<div class="col-3">'
        html += '<div id="qrcodePacking" style="margin-top:15px;margin:auto;"></div>'
        html += '</div>'
        html += '<div class="col-9">'

        html += '<div class="row">'
        html += '<div class="col-12">'
        html += '<p class="m-0 small-text fw-bolder">' + formatDateBarcode(data.purchase_at) + '</p>'
        html += '</div>'
        html += '<div class="col-6">'
        html += '<p class="m-0 small-text">GRADE</p>'
        html += '<h1 class="m-0 fw-bolder" style="font-size:50px !important">' + data.item_grade.name + '</h1>'
        html += '</div>'
        html += '<div class="col-6">'
        html += '<p class="m-0 small-text">BERAT (Kg)</p>'
        html += '<h1 class="m-0 fw-bolder" style="font-size:50px !important">' + weight + '</h1>'
        html += '</div>'
        html += '</div>'

        html += '</div>'

        html += '<div class="col-12 mt-2">'
        html += '<p class="m-0 small-text fw-bold">' + data.inventory.code + '</p>'
        html += '<p class="m-0 small fw-bolder">' + data.item.name + '</p>'
        html += '</div>'

        html += '<div class="col-6 mt-3">'
        html += '<p class="m-0 small fw-bolder">' + data.supplier.name + '</p>'
        html += '<p class="m-0 small fw-bolder">' + data.inventory.bale_number + '</p>'
        html += '</div>'

        html += '<div class="col-6 mt-3 text-end">'
        if (!data.inventory.global_code) {
            data.inventory.global_code = ''
        }
        html += '<p class="m-0 small fw-bolder">' + data.inventory.global_code + '</p>'
        html += '</div>'

        html += '</div>'
        $('#modalBody2').html(html);
        $('#qrcodePacking').empty()
        var qrcode = new QRCode("qrcodePacking", {
            text: data.inventory.code,
            width: 100,
            height: 100,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }
    var variableWeightSeries = 'qty';

    function changeChartStocks(status) {
        $('.btnChart').removeClass('active')
        variableWeightSeries = status
        arrangeVariableStocks()
    }

    function arrangeVariableStocks() {
        $('#chartStocks').html('')
        $('#btn' + variableWeightSeries).addClass('active')
        var data = {
            series: [],
            categories: [],
            units: [], // Tambahkan array untuk menyimpan unit_name
        }
        var a = 0
        var b = 0
        data_warehouse.inventoryAgeHeader.forEach(e => {
            data.series[a] = {
                name: e,
                data: []
            }
            b = 0
            data_warehouse.inventoryStockListItemSummary.data.forEach(el => {
                var unit = el.unit.name
                if (variableWeightSeries == 'weight') {
                    unit = 'Kg'
                }
                if (a == 0) {
                    data.categories.push(el.item.code + ' ( ' + el.unit.name + ' )')
                    data.units.push(unit); // Simpan unit_name di array units
                }
                var available = false
                el.datas.forEach(ele => {
                    if (ele.label == e) {
                        available = true
                        // data.series[a].data.push(ele.weight)
                        data.series[a].data.push({
                            weight: ele[variableWeightSeries],
                            unit: unit
                        }); // Simpan unit_name dengan weight
                    }
                });
                if (available == false) {
                    // data.series[a].data.push(0)
                    data.series[a].data.push({
                        weight: 0,
                        unit: unit
                    }); // Simpan unit_name meskipun datanya 0
                }
                b++
            });
            a++
        });
        chartStocks(data)
    }

    function chartStocks(data) {
        var options = {
            // series: data.series,
            series: data.series.map(serie => ({
                name: serie.name,
                data: serie.data.map(d => d.weight) // Hanya ambil weight untuk ditampilkan di chart
            })),
            chart: {
                type: 'bar',
                height: 200,
                toolbar: {
                    show: false,
                }
            },
            legend: {
                show: false,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: data.categories,
            },
            yaxis: {
                title: {
                    text: ''
                }
            },
            fill: {
                colors: ['#87CEEB', '#90EE90', '#F4A460', '#FFB6C1'],
                opacity: 1
            },
            tooltip: {
                y: {
                    // formatter: function(val) {
                    //     return number_format(val) + " Bale"
                    // }
                    formatter: function(val, {
                        seriesIndex,
                        dataPointIndex
                    }) {
                        // Ambil unit dari data series
                        var unit = data.series[seriesIndex].data[dataPointIndex].unit;
                        return number_format(val) + " " + unit;
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartStocks"), options);
        chart.render();
        stockAgeChart()
    }

    function stockAgeChart() {
        var stockData = data_warehouse.inventoryStockListSummary.data;

        // Hitung total stok untuk menentukan persentase
        var totalStock = stockData.reduce(function(sum, data) {
            return sum + data.qty;
        }, 0);

        // Kosongkan bar dan legenda sebelumnya
        $('.chart-container').empty();
        $('.legend').empty();

        // Buat bar dan legenda secara dinamis berdasarkan data
        stockData.forEach(function(data, index) {
            var percentage = (data.qty / totalStock) * 100;

            // Buat elemen bar baru
            var $bar = $('<div class="bar"></div>');
            $bar.css({
                'width': '0%', // Mulai dengan lebar 0 untuk animasi
                'background-color': ['#87CEEB', '#90EE90', '#F4A460'][index], // Warna berbeda per bar
                'margin-right': index === stockData.length - 1 ? '0px' : '10px' // Hilangkan margin untuk bar terakhir
            });

            // Tambahkan elemen bar ke container
            $('.chart-container').append($bar);

            // Animasi lebar bar dan tambahkan popover serta teks persentase
            setTimeout(function() {
                $bar.animate({
                    width: percentage + '%'
                }, 1000); // Animasi ke lebar persentase
                $bar.html('<span class="super-small-text">' + percentage.toFixed(1) + '%</span>'); // Tampilkan persentase

                // Tambahkan popover untuk menampilkan informasi qty dan weight
                $bar.attr('title', data.label);
                $bar.attr('data-bs-trigger', 'hover');
                $bar.attr('data-bs-content',
                    'Total : <b>' + number_format(data.qty) + '</b> Bale<br>' +
                    'Weight : <b>' + number_format(roundToTwo(data.weight)) + '</b> kg'
                );

                // Inisialisasi Bootstrap Popover
                new bootstrap.Popover($bar[0], {
                    placement: 'top',
                    html: true
                });
            }, index * 500); // Penundaan untuk efek animasi bertahap

            // Tambahkan item legenda secara dinamis
            var colorClass = ['blue', 'green', 'orange'][index];
            $('.legend').append(
                '<div class="legend-item"><span class="' + colorClass + '"></span>' +
                data.label + '<br>' + percentage.toFixed(1) + '% (' + number_format(data.qty) + ' Bale)</div>'
            );
        });

        // Update total jika diperlukan
        totalAllBale(stockData);
    }


    function totalAllBale(stockData) {
        var totalQTY = stockData.reduce(function(sum, data) {
            return sum + data.qty;
        }, 0);
        var totalWeight = stockData.reduce(function(sum, data) {
            return sum + data.weight;
        }, 0);
        $('.total-all-bale').html(number_format(totalQTY))
        $('.total-all-weight').html(number_format(roundToTwo(totalWeight)))
        // yang nanti dihapus
        unitName()
    }

    function unitName() {
        var name = 'Bale'
        if (item_unit_id.length == 1) {
            var data = data_master.unit.find(e => e.id == item_unit_id)
            if (data) {
                if (data.name == 'Press') {
                    name = 'Press'
                }
            }
        }
        $('#unitName').html(name)
    }

    function loadData() {
        $.ajax({
            url: "<?= api_url('loadPageRecapReportWarehouse'); ?>",
            method: "GET",
            dataType: 'JSON',
            data: {
                warehouseId: warehouse_id,
            },
            error: function(xhr) {
                showOverlay('hide')
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error Data'
                })
            },
            beforeSend: function() {
                showOverlay('show')
            },
            success: function(response) {
                showOverlay('hide')
                data_master = response.data
                var dataItem = data_master.item
                itemId = []
                warehouse_id_origin = []
                dataItem.forEach(e => {
                    itemId.push(e.id)
                });
                data_master.warehouse.forEach(e => {
                    warehouse_id_origin.push(e.id)
                });
                selectItem()
                datatableStock()
            }
        })
    }

    function currentTimeNew() {
        var d = new Date();
        var jam = d.getHours();
        var menit = d.getMinutes();
        if (menit < 10) {
            menit = "0" + menit;
        }
        if (jam < 10) {
            jam = "0" + jam;
        }
        var time = jam + ":" + menit;
        return time;
    }

    function setDaterange() {
        new Litepicker({
            element: document.getElementById('dateRange'),
            singleMode: true,
            firstDay: 0,
            // startDate: date_start,
            startDate: date_end,
            format: "DD MMMM YYYY",
            autoRefresh: true,
            lockDays: [],
            numberOfColumns: 1,
            setup: (picker) => {
                picker.on('selected', (date1) => {
                    // date_start = formatDate(date1['dateInstance'])
                    date_end = formatDate(date1['dateInstance'])
                    dateRangeString()
                    datatableStock()
                });
            },
        })
        new Litepicker({
            element: document.getElementById('dateStart'),
            singleMode: true,
            firstDay: 0,
            startDate: date_start,
            format: "DD MMMM YYYY",
            autoRefresh: true,
            lockDays: [],
            numberOfColumns: 1,
            setup: (picker) => {
                picker.on('selected', (date1) => {
                    date_start = formatDate(date1['dateInstance'])
                });
            },
        })
        new Litepicker({
            element: document.getElementById('dateEnd'),
            singleMode: true,
            firstDay: 0,
            startDate: date_end,
            format: "DD MMMM YYYY",
            autoRefresh: true,
            lockDays: [],
            numberOfColumns: 1,
            setup: (picker) => {
                picker.on('selected', (date1) => {
                    date_end = formatDate(date1['dateInstance'])
                });
            },
        })
    }

    function dateRangeString() {
        if (date_start) {
            $('#dateRangeString').html(formatDateIndonesiaShort(date_start) + ' - ' + formatDateIndonesiaShort(date_end))
        } else {
            $('#dateRangeString').html(formatDateIndonesiaShort(date_end))
        }
    }

    function deepCopy(obj) {
        return JSON.parse(JSON.stringify(obj));
    }
    var indexInventory = 0
    var data_inventory = []

    function getInventoryScan(id) {
        indexInventory = 0
        $.ajax({
            url: "<?= api_url('inventoryScan'); ?>",
            method: "GET",
            dataType: 'JSON',
            data: {
                id: id,
            },
            error: function(xhr) {
                showOverlay('hide')
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error Data'
                })
            },
            beforeSend: function() {
                showOverlay('show')
            },
            success: function(response) {
                showOverlay('hide')
                var data = response.data.inventory
                data_inventory = deepCopy(data)
                inventoryScan(data)
            }
        })
    }

    function inventoryScan(data) {
        $('#modal').modal('show')
        $('#modalDialog').addClass('modal-dialog modal-dialog-scrollable');
        var html_header = '';
        html_header += '<h5 class="modal-title small">Data Inventory</h5>';
        html_header += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $('#modalHeader').html(html_header);
        var html_body = '';
        html_body += '<div class="row">'
        html_body += '<div class="col-12" id="statusInventoryLine">'
        html_body += '</div>'
        html_body += '<div class="col-12" id="bodyInventory">'
        html_body += '</div>'
        html_body += '</div>'
        $('#modalBody').html(html_body);
        var html_footer = '';
        html_footer += '<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>'
        $('#modalFooter').html(html_footer);
        statusInventoryLine(data)
    }

    function statusInventoryLine(data) {
        var html = ''
        html += '<div class="row ps-3 mb-3" style="height:20px">'
        $.each(data, function(key, value) {
            var text = 'text-grey'
            if (key == indexInventory) {
                text = 'fw-bold filter-border'
            }
            html += '<div class="col-auto h-100 statusLine text-small pb-2 align-self-center ' + text + '" style="cursor:pointer" onclick="statusLineSwitchPacking(' + key + ')" id="colStatusLinekey">'
            html += '#' + (key + 1)
            html += ' </div>'
        });
        html += '</div>'
        $('#statusInventoryLine').html(html)
        bodyInventory()
    }

    function statusLineSwitchPacking(key) {
        indexInventory = key
        statusInventoryLine(data_inventory)
    }

    function iconBox(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/></svg>'
        return html
    }

    function iconDirect(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg"width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>'
        return html
    }

    function iconQTY(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg"  width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16"><path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/></svg>'
        return html
    }

    function iconWeight(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg"  width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-minecart-loaded" viewBox="0 0 16 16"><path d="M4 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2m0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4m8-1a1 1 0 1 1 0-2 1 1 0 0 1 0 2m0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4M.115 3.18A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 14 12H2a.5.5 0 0 1-.491-.408l-1.5-8a.5.5 0 0 1 .106-.411zm.987.82 1.313 7h11.17l1.313-7z"/><path fill-rule="evenodd" d="M6 1a2.498 2.498 0 0 1 4 0c.818 0 1.545.394 2 1 .67 0 1.552.57 2 1h-2c-.314 0-.611-.15-.8-.4-.274-.365-.71-.6-1.2-.6-.314 0-.611-.15-.8-.4a1.497 1.497 0 0 0-2.4 0c-.189.25-.486.4-.8.4-.507 0-.955.251-1.228.638q-.136.194-.308.362H3c.13-.147.401-.432.562-.545a1.6 1.6 0 0 0 .393-.393A2.5 2.5 0 0 1 6 1"/></svg>'
        return html
    }

    function iconHistory(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16"><path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/><path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/><path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/></svg>'
        return html
    }

    function iconPURCHASE(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/><path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/></svg>'
        return html
    }

    function iconMATERIAL(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16"><path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/></svg>'
        return html

    }

    function iconSEND(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16"><path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/></svg>'
        return html

    }

    function iconRECEIVE(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/></svg>'
        return html

    }

    function iconDEFAULT(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg"width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/></svg>'
        return html

    }

    function formatDateIndonesiaTanggalBulanSortWithYear(orginaldate) {
        var date = new Date(orginaldate);
        var bulan = date.getMonth();
        var tanggal = date.getDate();
        var tahun = date.getFullYear();
        if (tanggal < 10) {
            tanggal = "0" + tanggal;
        }
        switch (bulan) {
            case 0:
                bulan = "Jan";
                break;
            case 1:
                bulan = "Feb";
                break;
            case 2:
                bulan = "Mar";
                break;
            case 3:
                bulan = "Apr";
                break;
            case 4:
                bulan = "Mei";
                break;
            case 5:
                bulan = "Jun";
                break;
            case 6:
                bulan = "Jul";
                break;
            case 7:
                bulan = "Agu";
                break;
            case 8:
                bulan = "Sep";
                break;
            case 9:
                bulan = "Okt";
                break;
            case 10:
                bulan = "Nov";
                break;
            case 11:
                bulan = "Des";
                break;
        }
        var tampilTanggal = tanggal + " " + bulan + " " + tahun
        return tampilTanggal;
    }

    function abbreviate(text) {
        return text
            .split(' ') // Memisahkan teks berdasarkan spasi
            .map(word => word[0]) // Mengambil huruf pertama dari setiap kata
            .join('') // Menggabungkan huruf-huruf tersebut menjadi singkatan
            .toUpperCase(); // Mengubah hasilnya menjadi huruf kapital
    }

    function bodyInventory() {
        var data = deepCopy(data_inventory[indexInventory])
        // console.log(data)
        var html = ''
        html += '<div class="row">'
        // information
        html += '<div class="col-12 mb-2">'
        html += '<div class="card shadow-sm">'
        html += '<div class="card-body p-0">'
        //content
        html += '<div class="row p-3 pb-0">'
        html += '<div class="col-auto d-flex text-end align-self-center">'
        html += '<div class="circle-icon bg-warning">' + iconBox(14, 14) + '</div>'
        html += '</div>'
        html += '<div class="col-auto ps-0 align-self-center">'
        html += '<p class="m-0 small-text">No. Inventory : ' + data.code + '</p>'
        html += '<p class="m-0 fw-bolder">(' + data.item_code + ') ' + data.item_name + '</p>'
        html += '</div>'
        html += '</div>'
        html += '<div class="row">'
        html += '<div class="col-12">'
        html += '<hr>'
        html += '</div>'
        html += '</div>'
        html += '<div class="row p-3 pt-0">'
        html += '<div class="col-12">'
        // detail data
        html += '<div class="row d-flex justify-content-between">'
        html += '<div class="col">'
        html += '<p class="m-0 super-small-text text-dark-grey">Bale</p>'
        html += '<p class="m-0 small text-grey-dark fw-bolder">' + data.bale_number + '</p>'
        html += '</div>'
        html += '<div class="col">'
        html += '<p class="m-0 super-small-text text-dark-grey">Grade</p>'
        html += '<p class="m-0 small text-grey-dark fw-bolder">' + data.item_grade.name + '</p>'
        html += '</div>'
        html += '<div class="col">'
        html += '<p class="m-0 super-small-text text-dark-grey">Satuan</p>'
        html += '<p class="m-0 small text-grey-dark fw-bolder">' + data.item_unit.name + '</p>'
        html += '</div>'
        html += '<div class="col">'
        html += '<p class="m-0 super-small-text text-dark-grey">Supplier</p>'
        html += '<p class="m-0 small text-grey-dark fw-bolder">' + data.supplier.name + '</p>'
        html += '</div>'
        html += '</div>'
        // detail data
        html += '</div>'
        html += '</div>'
        //content
        html += '</div>'
        html += '</div>'
        html += '</div>'
        // information
        // recent location
        html += '<div class="col-12 mb-2">'
        html += '<div class="card shadow-sm bg-light-warning">'
        html += '<div class="card-header py-2">'
        html += '<p class="m-0 fw-bold small-text d-flex align-items-center"><span class="text-warning d-flex align-items-center me-2">' + iconDirect(10, 10) + '</span> <span class="small-text">Current Location</span></p>'
        html += '</div>'
        html += '<div class="card-body p-3">'
        // isi location
        html += '<div class="row">'
        if (data.locations) {
            if (data.locations.length) {
                data.locations.forEach(e => {
                    html += '<div class="col">'
                    html += '<div class="row">'
                    html += '<div class="col-auto d-flex align-items-center pe-0">'
                    html += '<div class="circle-icon bg-white border-warning" style="border: 1px solid;" title="' + e.type + '"><span class="small-text text-warning">' + abbreviate(e.type) + '<span></div>'
                    html += '</div>'
                    html += '<div class="col-auto">'
                    html += '<p class="m-0 super-small-text fw-bold">Location</p>'
                    // html += '<p class="m-0 super-small-text fw-bold">' + e.type + '</p>'
                    html += '<p class="m-0 fw-bolder">' + e.name + '</p>'
                    html += '</div>'
                    html += '<div class="col-auto">'
                    html += '<p class="m-0 super-small-text fw-bold">Date</p>'
                    html += '<p class="m-0 fw-bolder">' + formatDateIndonesiaTanggalBulanSortWithYear(e.datetime) + '</p>'
                    html += '</div>'
                    html += '<div class="col-auto">'
                    html += '<p class="m-0 super-small-text fw-bold">Dimension</p>'
                    html += '<p class="m-0 small-text me-2 fw-bolder">' + iconQTY(10, 10) + ' ' + number_format(e.qty) + ' ' + data.item_unit.name + ' <span class="ms-3 me-2">' + iconWeight(10, 10) + ' ' + number_format(e.weight) + ' kg</span></p>'
                    html += '</div>'
                    html += '</div>'
                    html += '</div>'
                })
            }
        } else {
            html += '<div class="col text-center">'
            html += '<p class="m-0 small-text"><i>No Data</i></p>'
            html += '</div>'
        }
        html += '</div>'
        // isi location
        html += '</div>'
        html += '</div>'
        html += '</div>'
        // recent location
        // history
        html += '<div class="col-12 mb-2">'
        html += '<div class="card shadow-sm bg-white">'
        html += '<div class="card-header py-2 bg-white">'
        html += '<p class="m-0 fw-bold small-text d-flex align-items-center"><span class="text-warning d-flex align-items-center me-2">' + iconHistory(10, 10) + '</span> <span class="small-text">History</span></p>'
        html += '</div>'
        html += '<div class="card-body p-0">'
        // timeline
        if (data.history) {
            if (data.history.length) {
                html += '<div class="tracking-list border-0">'
                data.history.forEach(e => {
                    html += trackingItem(e)
                });
                html += '</div>'
            }
        }
        // timeline
        html += '</div>'
        html += '</div>'
        html += '</div>'
        // history
        html += '</div>'
        $('#bodyInventory').html(html)
    }

    function trackingItem(data) {
        var html = ''
        html += '<div class="tracking-item">'
        html += '<div class="tracking-icon status-intransit fw-bolder text-dark">'
        html += eval('icon' + data.type + '(20, 20)')
        html += '</div>'
        html += '<div class="tracking-date small-text">'
        html += '<span class="super-small-text fw-bolder" style="font-size:8px !important">' + formatDateIndonesia(data.datetime) + '</span>'
        html += '<span class="super-small-text" style="font-size:8px !important">' + formatTime(data.datetime) + '</span>'
        html += '</div>'
        html += '<div class="tracking-content">'
        // destination and source
        html += '<div class="row mb-2">'
        // html += '<div class="col-12">'
        // html += '<p class="m-0 super-small-text text-grey-dark">' + toTitleCase(data.type) + ' Item by ' + data.user_admin.name + '</p>'
        // html += '</div>'
        html += '<div class="col-12">'
        // badge
        html += '<div class="row mb-2">'
        html += '<div class="col-auto pe-0">'
        html += '<span class="badge bg-warning p-1 super-small-text text-white me-1">' + iconBox(10, 10) + ' ' + number_format(data.qty) + '</span>'
        html += '</div>'
        html += '<div class="col-auto pe-0 ps-0">'
        html += '<span class="badge bg-warning p-1 super-small-text text-white me-1">' + iconWeight(10, 10) + ' ' + number_format(data.weight) + ' kg</span>'
        html += '</div>'
        html += '<div class="col-auto pe-0 ps-0">'
        html += '<span class="badge bg-warning p-1 super-small-text text-white me-1">Rp ' + number_format(data.price) + '</span>'
        html += '</div>'
        html += '<div class="col-auto pe-0 ps-0">'
        html += '<span class="badge bg-warning p-1 super-small-text text-white me-1"><i class="fa fa-user"></i> ' + data.user_admin.name + '</span>'
        html += '</div>'
        html += '</div>'
        // badge
        html += '</div>'
        html += '<div class="col-auto">'
        html += '<p class="m-0 super-small-text fw-bold text-dark-grey">Source</p>'
        html += '<p class="m-0 small fw-bolder">' + data.source.name + '</p>'
        html += '</div>'
        html += '<div class="col-auto align-self-center">'
        html += '<span class="fa fa-long-arrow-right text-grey"></span>'
        html += '</div>'
        html += '<div class="col-auto">'
        html += '<p class="m-0 super-small-text fw-bold text-dark-grey">Destination</p>'
        html += '<p class="m-0 small fw-bolder">' + data.dest.name + '</p>'
        html += '</div>'
        html += '</div>'
        // destination and source
        html += '</div>'
        html += '</div>'
        return html
    }

    function downloadExcel() {
        itemId = $('#selectItem').val()
        gradeId = $('.selectGradeItem:checked').map(function() {
            return $(this).val();
        }).get()
        warehouse_id_origin = $('#selectWarehouse').val()
        item_unit_id = $('#selectUnit').val()
        exportExcel()
    }

    function exportExcel() {
        var url = '<?= base_url('report/excelWarehouseStockList') ?>';
        var params = "*$" + date_start + "*$" + date_end + "*$" + itemId + "*$" + gradeId + "*$" + warehouse_id_origin + "*$" + item_unit_id + "*$" + warehouse_id + "*$OLD";
        window.open(url + '?params=' + encodeURIComponent(params), '_blank');
    }

    function switchToNew() {
        let currentUrl = window.location.href;

        // Pisahkan URL berdasarkan '/'
        let urlParts = currentUrl.split('/');

        // Ambil bagian terakhir dari URL (nama halaman)
        let lastSegment = urlParts[urlParts.length - 1];

        // Periksa apakah ada '-old' dan hapus jika ada
        if (lastSegment.includes('-old')) {
            lastSegment = lastSegment.replace('-old', '');
        }

        // Gabungkan kembali URL dengan segmen yang diperbarui
        urlParts[urlParts.length - 1] = lastSegment;
        let newUrl = urlParts.join('/');

        // Redirect ke URL baru
        window.location.href = newUrl;
    }
</script>