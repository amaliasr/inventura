<link href="<?= base_url(); ?>assets/smm/report.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/datatable_custom.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css">
<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<link href="<?= base_url(); ?>assets/smm/tracking.css" rel="stylesheet" type="text/css">
<!-- <link href="<?= base_url(); ?>assets/smm/purchase_order.css" rel="stylesheet" type="text/css"> -->
<style>
    table td {
        white-space: nowrap;
        /* Mencegah teks wrap */
    }
</style>
<style>
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

    .super-small-text {
        font-size: 9px !important;
    }
</style>
<main>
    <!-- Main page content-->
    <header class="page-header page-header-dark pb-10">
        <div class="container-xl px-4 mb-5">
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl mt-n10">
        <div class="row justify-content-center mb-2">
            <div class="col pb-2">
                <h1 class="text-dark fw-bolder m-0" style="font-weight: 900 !important">HISTORY PRODUCTION</h1>
                <p class="m-0 small" id="dateRangeString">-</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <div class="row">
                            <div class="col-auto">
                                <p class="fw-bolder small-text m-0">Tanggal</p>
                                <input class="form-select form-select-sm datepicker formFilter" type="text" id="dateRange" placeholder="Tanggal Mulai" autocomplete="off">
                            </div>
                            <div class="col-auto ps-0">
                                <p class="fw-bolder small-text m-0">Item</p>
                                <select class="selectpicker w-100" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 1" id="selectItem" title="Pilih Item" onchange="arrangeVariable()">
                                </select>
                            </div>
                            <div class="col-auto ps-0">
                                <p class="fw-bolder small-text m-0">Data Profile</p>
                                <select class="selectpicker w-100" data-live-search="true" data-actions-box="true" id="selectDataProfile" onchange="arrangeVariable()">
                                </select>
                            </div>
                            <div class="col-auto ps-0">
                                <p class="fw-bolder small-text m-0">Item Origin</p>
                                <select class="selectpicker w-100" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 1" id="selectWarehouse" title="Pilih Warehouse" onchange="arrangeVariable()">
                                </select>
                            </div>
                            <div class="col-auto ps-0 d-flex align-items-end">
                                <button type="button" class="btn btn-primary btn-sm btnSimpan" style="border-radius: 20px;padding: 10px;" onclick="simpanData()">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto d-flex align-items-end">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle border-radius-20 shadow-none small-text btnSimpan" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fa fa-download me-2"></span>Downloads
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="exportExcel()">Excel</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-light border border-dark btn-sm small-text p-2 ms-2" style="border-radius: 20px;padding: 10px;" onclick="switchToOld()">Switch to Old ver</button>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-2">
                <div class="card shadow-none border-radius-20">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 px-4" id="statusLine">

                            </div>
                        </div>
                        <div class="row me-0">
                            <div class="col-12 pe-0">
                                <div class="table-responsible" id="dataTable">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modal" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document" id="modalDialog">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">

            </div>
            <div class="modal-body" id="modalBody">

            </div>
            <div class="modal-footer" id="modalFooter">

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('components/modal_static') ?>
<!-- Chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/smm/format.js"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<!-- autocomplete -->
<script type="text/javascript" src="<?= base_url() ?>assets/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/bootstrap-multiselect/js/bootstrap-multiselect.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<!-- QR CODE -->
<script type="text/javascript" src="<?= base_url() ?>assets/js/vendor/qrcode.js"></script>
<script>
    function notFoundReturn(text, height = null) {
        if (!height) {
            height = '100%'
        }
        var html = '<div class="row"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:' + height + ';"><div class="card-body h-100 p-5 m-5"><lottie-player style="margin:auto;width: 200px; height: 100%;" src="<?= base_url() ?>assets/json/nodata.json" mode="bounce" background="transparent" speed="2" loop autoplay></lottie-player><p class="small"><i>' + text + '</i></p></div></div></div></div>'
        return html
    }

    function empty(location, text, height = null) {
        if (!height) {
            height = '100%'
        }
        $(location).html('<div class="row"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:' + height + ';"><div class="card-body h-100 p-5 m-5"><lottie-player style="margin:auto;width: 200px; height: 100%;" src="<?= base_url() ?>assets/json/lf20_s8pbrcfw.json" mode="bounce" background="transparent" speed="2" loop autoplay></lottie-player><p class="small"><i>' + text + '</i></p></div></div></div></div>')
    }

    function emptyReturn(text, height = null) {
        if (!height) {
            height = '100%'
        }
        var html = '<div class="row"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:' + height + ';"><div class="card-body h-100 p-5 m-5"><lottie-player style="margin:auto;width: 200px; height: 100%;" src="<?= base_url() ?>assets/json/lf20_s8pbrcfw.json" mode="bounce" background="transparent" speed="2" loop autoplay></lottie-player><p class="small"><i>' + text + '</i></p></div></div></div></div>'
        return html
    }

    function emptyText(location, text) {
        $(location).html('<div class="row h-100"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:100%;background-color:transparent"><div class="card-body h-100 m-5"><p class="small"><i>' + text + '</i></p></div></div></div></div>')
    }

    function emptyTextReturn(text) {
        var html = '<div class="row h-100"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:100%;background-color:transparent"><div class="card-body h-100 m-5"><p class="small"><i>' + text + '</i></p></div></div></div></div>'
        return html
    }

    function iconPRESS(width, height) {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/></svg>'
        return html
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

    function arrayToString(arr) {
        var resultString = arr.join(',');
        return resultString;
    }

    function groupDataByProperties(data, propertyNames) {
        // Menggunakan Set untuk menyimpan nilai unik dari kombinasi properti
        var uniqueValuesSet = new Set();

        // Loop melalui data untuk mendapatkan nilai unik dari kombinasi properti
        data.forEach(function(item) {

            // Membuat array yang berisi nilai properti yang diinginkan
            var propertyValues = propertyNames.map(function(propertyName) {
                if (item[propertyName].name) {
                    return item[propertyName].name
                } else {
                    return item[propertyName];
                }
            });

            // Menambahkan array nilai properti ke dalam Set
            uniqueValuesSet.add(JSON.stringify(propertyValues));
        });

        // Mengonversi Set menjadi array dan mengembalikan hasilnya
        var uniqueValuesArray = Array.from(uniqueValuesSet).map(function(stringifiedArray) {
            return JSON.parse(stringifiedArray);
        });

        return uniqueValuesArray;
    }

    function findQty(data, criteria) {
        for (let i = 0; i < data.length; i++) {
            let match = true;

            for (let key in criteria) {
                // Mengatasi properti dengan hierarki
                const keys = key.split('.');
                let currentValue = data[i];

                for (let j = 0; j < keys.length; j++) {
                    if (currentValue.hasOwnProperty(keys[j])) {
                        currentValue = currentValue[keys[j]];
                    } else {
                        match = false;
                        break;
                    }
                }

                if (!match) {
                    break;
                }
                if (currentValue != criteria[key]) {
                    match = false;
                    break;
                }
            }
            if (match) {
                if (data[i].qty_waste == null) {
                    data[i].qty_waste = 0
                }
                if (data[i].qty_goods == null) {
                    data[i].qty_goods = 0
                }
                if (data[i].qty_reject == null) {
                    data[i].qty_reject = 0
                }
                return {
                    qty_goods: number_format(data[i].qty_goods),
                    qty_reject: number_format(data[i].qty_reject),
                    qty_waste: number_format(data[i].qty_waste),
                }
            }
        }
        return null;
    }

    function formatJustDay(orginaldate) {
        var date = new Date(orginaldate);
        var hari = date.getDay();
        switch (hari) {
            case 0:
                hari = "Minggu";
                break;
            case 1:
                hari = "Senin";
                break;
            case 2:
                hari = "Selasa";
                break;
            case 3:
                hari = "Rabu";
                break;
            case 4:
                hari = "Kamis";
                break;
            case 5:
                hari = "Jumat";
                break;
            case 6:
                hari = "Sabtu";
                break;
        }
        return hari;
    }

    function clearModal() {
        $('#modalDialog').removeClass();
        $('#modalDialog').removeAttr('style');
        $('#modalHeader').html('');
        $('#modalBody').html('');
        $('#modalFooter').html('');
    }

    function getFirstDateOfCurrentMonth() {
        const currentDate = new Date();
        const firstDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);

        const year = firstDate.getFullYear();
        const month = (firstDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
        const day = firstDate.getDate().toString().padStart(2, '0');

        return `${year}-${month}-${day}`;
    }

    function getPreviousFriday() {
        // Mendapatkan tanggal hari ini
        const today = new Date();

        // Mendapatkan hari dalam bentuk angka (0: Minggu, 1: Senin, ..., 6: Sabtu)
        const dayOfWeek = today.getDay();

        // Menghitung selisih hari untuk kembali ke hari Jumat
        const daysUntilFriday = (dayOfWeek + 2) % 7;

        // Menghitung tanggal Jumat sebelumnya
        const previousFriday = new Date(today);
        previousFriday.setDate(today.getDate() - daysUntilFriday);

        // Format tanggal menjadi string 'YYYY-MM-DD'
        const formattedDate = previousFriday.toISOString().split('T')[0];

        return formattedDate;
    }

    $('#modal').on('hidden.bs.modal', function(e) {
        clearModal();
    })
    var warehouse_id = '<?= $this->session->userdata('warehouse_id') ?>'
    var data_report = ""
    var data_report_showed = []
    var date_start = getFirstDate()
    var date_end = currentDate()
    var itemId = []
    var supplierId = []
    var dataProfile = ''
    var data_user = {}
    var indexVariable = 0
    var warehouse_id_origin = []
    var statusLineVariable = [{
            id: 0,
            name: 'Complete',
            selected: true,
            functions: 'countDataComplete()',
            getData: 'chooseDataComplete()'
        },
        {
            id: 1,
            name: 'On Process',
            selected: false,
            functions: 'countDataOnProcess()',
            getData: 'chooseDataOnProcess()'
        }
    ]

    function chooseDataComplete() {
        var data = data_report.history_production_complete.data
        return data
    }

    function countDataComplete() {
        return chooseDataComplete().length
    }


    function chooseDataOnProcess() {
        var data = data_report.history_production_on_process.data
        return data
    }

    function countDataOnProcess() {
        return chooseDataOnProcess().length
    }

    function statusLineSwitch(id, getData) {
        indexVariable = id
        let updatedData = statusLineVariable.map(item => {
            return {
                ...item,
                selected: false
            };
        });
        let updatedData2 = updatedData.map(item => {
            if (item.id == id) {
                return {
                    ...item,
                    selected: true
                };
            }
            return item;
        });
        statusLineVariable = updatedData2
        data_report_showed = eval(getData)
        statusLine()
    }
    $(document).ready(function() {
        $('#dataTable').html(emptyReturn('Belum Melakukan Pencarian atau Bisa Langsung Download File'))
        $('select').selectpicker();
        loadData()
    })

    function getFirstDate() {
        // Mendapatkan tanggal hari ini
        const today = new Date();
        var month = today.getMonth() + 1;
        var year = today.getFullYear();
        if (month < 10) {
            month = "0" + month;
        }
        // Format tanggal menjadi string 'YYYY-MM-DD'
        const formattedDate = year + "-" + month + "-01";

        return formattedDate;
    }

    function loadData() {
        $.ajax({
            url: "<?= api_url('loadpageReportProduction'); ?>",
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
                });
            },
            beforeSend: function() {
                showOverlay('show')
            },
            success: function(response) {
                showOverlay('hide')
                data_user = response['data']
                setDaterange()
                dateRangeString()
                selectItem()
            }
        })
    }

    function selectItem() {
        var html = ''
        data_user.item.forEach(e => {
            var select = ''
            select = 'selected'
            html += '<option value="' + e.id + '" ' + select + '>' + e.code + ' - ' + e.name + '</option>'
        });
        $('#selectItem').html(html)
        $('#selectItem').selectpicker('refresh');
        $('#selectItem').selectpicker({

        });
        selectDataProfile()
    }

    function selectDataProfile() {
        var html = ''
        var a = 0
        data_user.data_profile.forEach(e => {
            var select = ''
            html += '<option value="' + e + '" ' + select + '>' + e + '</option>'
            a++
        });
        $('#selectDataProfile').html(html)
        $('#selectDataProfile').selectpicker('refresh');
        $('#selectDataProfile').selectpicker({

        });
        selectWarehouse()
    }

    function selectWarehouse() {
        var html = ''
        data_user.warehouse.forEach(e => {
            var select = ''
            select = 'selected'
            html += '<option value="' + e.id + '" ' + select + '>' + e.name + '</option>'
        });
        $('#selectWarehouse').html(html)
        $('#selectWarehouse').selectpicker('refresh');
        arrangeVariable()
    }

    function arrangeVariable() {
        itemId = $('#selectItem').map(function() {
            return $(this).val();
        }).get()
        dataProfile = $('#selectDataProfile').val()
        warehouse_id_origin = $('#selectWarehouse').val()
    }

    function dateRangeString() {
        $('#dateRangeString').html(formatDateIndonesiaShort(date_start) + ' - ' + formatDateIndonesiaShort(date_end))
    }

    function setDaterange() {
        new Litepicker({
            element: document.getElementById('dateRange'),
            singleMode: false,
            firstDay: 0,
            startDate: date_start,
            endDate: date_end,
            format: "DD MMMM YYYY",
            autoRefresh: true,
            setup: (picker) => {
                picker.on('selected', (date1, date2) => {
                    date_start = formatDate(date1['dateInstance'])
                    date_end = formatDate(date2['dateInstance'])
                });
            },
        })
    }
    const weightLabelsRaw = [{
            key: "weight_deduction_purchase",
            label: "Weight Deduction Purchase",
            total: 0
        },
        {
            key: "weight_gross",
            label: "Weight Gross",
            total: 0
        },
        {
            key: "weight_gross_latest",
            label: "Weight Gross Latest",
            total: 0
        },
        {
            key: "weight_gross_material",
            label: "Weight Gross Material",
            total: 0
        },
        {
            key: "weight_gross_purchase",
            label: "Weight Gross Purchase",
            total: 0
        },
        {
            key: "weight_gross_stock",
            label: "Weight Gross Stock",
            total: 0
        },
        {
            key: "weight_net",
            label: "Weight Net",
            total: 0
        },
        {
            key: "weight_net_latest",
            label: "Weight Net Latest",
            total: 0
        },
        {
            key: "weight_net_material",
            label: "Weight Net Material",
            total: 0
        },
        {
            key: "weight_net_purchase",
            label: "Weight Net Purchase",
            total: 0
        },
        {
            key: "weight_net_stock",
            label: "Weight Net Stock",
            total: 0
        },
        {
            key: "weight_packaging",
            label: "Weight Packaging",
            total: 0
        },
        {
            key: "weight_packaging_latest",
            label: "Weight Packaging Latest",
            total: 0
        },
        {
            key: "weight_packaging_material",
            label: "Weight Packaging Material",
            total: 0
        },
        {
            key: "weight_packaging_purchase",
            label: "Weight Packaging Purchase",
            total: 0
        },
        {
            key: "weight_packaging_stock",
            label: "Weight Packaging Stock",
            total: 0
        },
        {
            key: "weight_paid",
            label: "Weight Paid",
            total: 0
        }
    ];
    const weightLabels = weightLabelsRaw.map(item => ({
        ...item,
        label: item.label.replace(/ (.+)$/, "<br>$1") // Menambahkan <br> sebelum kata terakhir
    }));

    function simpanData() {
        // ----------------------------------------- //
        var type = 'GET'
        var button = '.btnSimpan'
        var url = '<?php echo api_url('getHistoryProductionNew'); ?>'
        var data = {
            dateStart: date_start,
            dateEnd: date_end,
            warehouseId: warehouse_id,
            itemIds: itemId,
            dataProfile: dataProfile,
            warehouseIdOrigin: warehouse_id_origin
        }
        kelolaData(data, type, url, button)
    }

    function kelolaData(data, type, url, button) {
        $.ajax({
            url: url,
            type: type,
            data: data,
            error: function(xhr) {
                showOverlay('hide')
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error Data'
                });
                $(button).prop("disabled", false);
            },
            beforeSend: function() {
                $(button).prop("disabled", true);
                showOverlay('show')
            },
            success: function(response) {
                showOverlay('hide')
                dateRangeString()
                $(button).prop("disabled", false);
                data_report = response.data
                data_report_showed = eval(statusLineVariable[indexVariable].getData)
                statusLine()
            }
        });
    }

    function statusLine() {
        var html = ''
        html += '<div class="row justify-content-between">'
        html += '<div class="col h-100">'
        html += '<div class="row" style="height:30px">'
        statusLineVariable.forEach(e => {
            var text = 'text-grey'
            var icon = 'text-grey bg-light'
            if (e.selected) {
                text = 'fw-bold filter-border'
                icon = 'bg-light-blue text-white'
            }
            var num = eval(e.functions)
            html += '<div class="col-auto h-100 statusLine text-small pb-2 align-self-center ' + text + '" style="cursor:pointer" onclick="statusLineSwitch(' + e.id + ',' + "'" + e.getData + "'" + ')" id="colStatusLine' + e.id + '">'
            html += e.name + '<span class="statusLineIcon ms-1 p-1 rounded ' + icon + '" id="statusLineIcon' + e.id + '">' + num + '</span>'
            html += ' </div>'

        });
        html += '</div>'
        html += '</div>'
        html += '</div>'
        $('#statusLine').html(html)
        dataTable()
    }

    function updatedStructure() {
        dataTable()
    }

    function dataTable() {
        var html = ''
        html += '<table class="table table-bordered table-hover table-sm small w-100 tableDetail" id="tableDetail" style="width: 100%;white-space:nowrap;cursor: grab;overflow:auto;">'
        html += '<thead id="headTable">'
        html += '</thead>'
        html += '<tbody id="bodyTable">'
        html += '</tbody>'
        html += '<tfoot id="footTable">'
        html += '</tfoot>'
        html += '</table>'
        $('#dataTable').html(html)
        headTable()
    }

    function headTable() {
        var html = ''
        html += '<tr>'
        html += '<th class="align-middle text-center small-text bg-white">#</th>'
        html += '<th class="align-middle text-center small-text bg-white">Date</th>'
        if (dataProfile == 'DETAIL') {
            html += '<th class="align-middle text-center small-text bg-white">Kode Inventory</th>'
        }
        html += '<th class="align-middle text-center small-text bg-white">Kode Item</th>'
        html += '<th class="align-middle text-center small-text bg-white">Nama Item</th>'
        html += '<th class="align-middle text-center small-text bg-white">Item Origin</th>'
        if (dataProfile == 'ITEM GRADE' || dataProfile == 'DETAIL') {
            html += '<th class="align-middle text-center small-text bg-white">Grade</th>'
        }
        html += '<th class="align-middle text-center small-text bg-white">Unit</th>'
        html += '<th class="align-middle text-center small-text bg-white">QTY</th>'
        weightLabels.forEach(e => {
            html += `<th class="align-middle text-center small-text bg-white">${e.label}</th>`;
        });
        html += '<th class="align-middle text-center small-text bg-white">Material<br>QTY</th>'
        if (dataProfile == 'DETAIL') {
            html += '<th class="align-middle text-center small-text bg-white"></th>'
        }
        html += '</tr>'
        $('#headTable').html(html)
        bodyTable()
    }

    var total_qty = 0
    var total_weight = {}
    var total_material_qty = 0
    var total_material_weight = 0

    function bodyTable() {
        var html = ''
        total_qty = 0
        total_weight = {}
        total_material_qty = 0
        total_material_weight = 0
        var dataFind = deepCopy(data_report_showed)
        $.each(dataFind, function(key, value) {
            if (!value.qty) {
                value.qty = 0
            }
            if (!value.material_qty) {
                value.material_qty = 0
            }
            html += '<tr>'
            html += '<td class="bg-white align-middle small-text text-center">' + (parseInt(key) + 1) + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + formatDate(value.datetime) + ' ' + formatTime(value.datetime) + '</td>'
            if (dataProfile == 'DETAIL') {
                html += '<td class="bg-white align-middle small-text text-center">' + value.inventory.code + '</td>'
            }
            html += '<td class="bg-white align-middle small-text">' + value.item.code + '</td>'
            html += '<td class="bg-white align-middle small-text">' + value.item.name + '</td>'
            html += '<td class="bg-white align-middle small-text">' + value.item_origin.name + '</td>'
            if (dataProfile == 'ITEM GRADE' || dataProfile == 'DETAIL') {
                html += '<td class="bg-white align-middle small-text text-center">' + value.grade.name + '</td>'
            }
            html += '<td class="bg-white align-middle small-text text-center">' + value.unit.name + '</td>'
            html += '<td class="bg-white align-middle small-text text-end">' + number_format(value.qty) + '</td>'
            weightLabels.forEach(e => {
                if (!value[e.key]) {
                    value[e.key] = 0
                }
                // total weight each
                if (total_weight[e.key] == undefined) {
                    total_weight[e.key] = 0
                } else {
                    total_weight[e.key] += parseFloat(total_weight[e.key])
                }
                html += `<td class="bg-white align-middle small-text text-end">${number_format(value[e.key])}</td>`;
            });
            html += '<td class="bg-white align-middle small-text text-end">' + number_format(value.material_qty) + '</td>'
            if (dataProfile == 'DETAIL') {
                html += '<td class="bg-white align-middle small-text">'
                html += `<div class="dropdown">
                        <button class="super-small-text btn btn-sm btn-outline-dark py-1 px-2 shadow-none" id="dropdownMenuButton${key}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu shadow-sm" aria-labelledby="dropdownMenuButton${key}">
                           <a class="dropdown-item" onclick="getDetailMaterial('${value.id}')">
                            <i class="fa fa-list me-2"></i> Detail Material
                            </a>
                            <a class="dropdown-item" onclick="getInventoryScan('${value.inventory.id}')">
                            <i class="fa fa-th-list me-2"></i> Data Inventory
                            </a>
                        </div>
                    </div>`
                html += '</td>'
            }
            html += '</tr>'
            total_qty += parseInt(value.qty)
            total_material_qty += parseInt(value.material_qty)
        })
        $('#bodyTable').html(html)
        footTable()
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
        if (!data.price) {
            data.price = 0
        }
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
        html += '<p class="m-0 small-text fw-bolder">' + data.source.name + '</p>'
        html += '</div>'
        html += '<div class="col-auto align-self-center">'
        html += '<span class="fa fa-long-arrow-right text-grey"></span>'
        html += '</div>'
        html += '<div class="col-auto">'
        html += '<p class="m-0 super-small-text fw-bold text-dark-grey">Destination</p>'
        html += '<p class="m-0 small-text fw-bolder">' + data.dest.name + '</p>'
        html += '</div>'
        html += '</div>'
        // destination and source
        html += '</div>'
        html += '</div>'
        return html
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

    function deepCopy(obj) {
        return JSON.parse(JSON.stringify(obj));
    }

    function footTable() {
        var html = ''
        html += '<tr>'
        if (dataProfile == 'ITEM') {
            html += '<th class="bg-white align-middle small-text text-end" colspan="6">Total</th>'
        } else if (dataProfile == 'ITEM GRADE') {
            html += '<th class="bg-white align-middle small-text text-end" colspan="7">Total</th>'
        } else {
            html += '<th class="bg-white align-middle small-text text-end" colspan="8">Total</th>'
        }
        html += '<th class="bg-white align-middle small-text text-end">' + number_format(roundToTwo(total_qty)) + '</th>'
        weightLabels.forEach(e => {
            html += '<th class="bg-white align-middle small-text text-center">' + number_format(roundToTwo(total_weight[e.key])) + '</th>'
        })
        html += '<th class="bg-white align-middle small-text text-end">' + number_format(roundToTwo(total_material_qty)) + '</th>'
        if (dataProfile == 'DETAIL') {
            html += '<th class="bg-white align-middle small-text"></th>'
        }
        html += '</tr>'
        $('#footTable').html(html)
        $('#tableDetail').DataTable({
            ordering: true, // Menonaktifkan pengurutan
            pageLength: 200,
            scrollY: "600px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedHeader: true,
            "initComplete": function(settings, json) {
                $('div.dataTables_filter input').attr('placeholder', 'Search...');
            },
        })
    }

    function exportExcel() {
        var url = '<?= base_url('report/excelProductionHistory') ?>';
        var params = "*$" + warehouse_id + "*$" + date_start + "*$" + date_end + "*$" + itemId + "*$" + dataProfile + "*$NEW";
        window.open(url + '?params=' + encodeURIComponent(params), '_blank');
    }

    function roundToOne(num) {
        return +(Math.round(num + "e+1") + "e-1");
    }

    function getDetailMaterial(id) {
        $.ajax({
            url: "<?= api_url('getHistoryMaterial'); ?>",
            method: "GET",
            dataType: 'JSON',
            data: {
                productionFormingId: id,
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
                var data = response.data.history_material_complete.data
                listDataDetailMaterial(data)
            }
        })
    }

    function listDataDetailMaterial(data) {
        $('#modal').modal('show')
        $('#modalDialog').addClass('modal-dialog modal-dialog-scrollable modal-xl');
        var html_header = '';
        html_header += '<h5 class="modal-title small">Detail Material</h5>';
        html_header += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $('#modalHeader').html(html_header);
        var html_body = '';
        html_body += '<div class="row">'
        html_body += '<div class="col-12 table-responsive">'
        html_body += '<table class="table table-bordered table-hover table-sm small w-100" id="tableDetailMaterial">'
        html_body += '<thead>'
        html_body += '<tr>'
        html_body += '<th class="align-middle small-text">No</th>'
        html_body += '<th class="align-middle small-text">Date</th>'
        html_body += '<th class="align-middle small-text">Code</th>'
        html_body += '<th class="align-middle small-text">No. Bale</th>'
        html_body += '<th class="align-middle small-text">Item</th>'
        html_body += '<th class="align-middle small-text">Grade</th>'
        html_body += '<th class="align-middle small-text">Unit</th>'
        html_body += '<th class="align-middle small-text">QTY</th>'
        html_body += '<th class="align-middle small-text">Weight</th>'
        // html_body += '<th class="align-middle small-text">Prod.<br>Code</th>'
        // html_body += '<th class="align-middle small-text">Prod.<br>No. Bale</th>'
        // html_body += '<th class="align-middle small-text">Prod.<br>Item</th>'
        html_body += '<th class="align-middle small-text">Prod.<br>Grade</th>'
        html_body += '<th class="align-middle small-text">Prod.<br>Unit</th>'
        html_body += '<th class="align-middle small-text">Prod.<br>QTY</th>'
        html_body += '<th class="align-middle small-text">Prod.<br>Weight</th>'
        html_body += '<th class="align-middle small-text">Purchase<br>At</th>'
        html_body += '<th class="align-middle small-text">Supplier</th>'
        html_body += '</tr>'
        html_body += '</thead>'
        html_body += '<tbody id="bodyDetailMaterial">'
        html_body += '</tbody>'
        html_body += '<tfoot id="footDetailMaterial">'
        html_body += '</tfoot>'
        html_body += '</table>'
        html_body += '</div>'
        html_body += '</div>'
        $('#modalBody').html(html_body);
        var html_footer = '';
        html_footer += '<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>'
        $('#modalFooter').html(html_footer);
        bodyDetailMaterial(data)
    }

    function bodyDetailMaterial(data) {
        var html = ''
        $.each(data, (key, value) => {
            html += '<tr>'
            html += '<td class="align-middle super-small-text">' + (key + 1) + '</td>'
            html += '<td class="align-middle super-small-text">' + formatDate(value.datetime) + ' ' + formatTime(value.datetime) + '</td>'
            html += '<td class="align-middle super-small-text">' + value.inventory.code + '</td>'
            if (!value.inventory.bale_number) {
                value.inventory.bale_number = ''
            }
            html += '<td class="align-middle super-small-text">' + value.inventory.bale_number + '</td>'
            html += '<td class="align-middle super-small-text">' + value.item.name + '</td>'
            html += '<td class="align-middle super-small-text">' + value.grade.name + '</td>'
            html += '<td class="align-middle super-small-text">' + value.unit.name + '</td>'
            html += '<td class="align-middle super-small-text text-end">' + number_format(roundToTwo(value.qty)) + '</td>'
            html += '<td class="align-middle super-small-text text-end">' + number_format(roundToTwo(value.weight)) + '</td>'
            // html += '<td class="align-middle super-small-text">' + value.production_inventory.code + '</td>'
            if (!value.production_inventory.bale_number) {
                value.production_inventory.bale_number = ''
            }
            // html += '<td class="align-middle super-small-text">' + value.production_inventory.bale_number + '</td>'
            // html += '<td class="align-middle super-small-text">' + value.production_item.name + '</td>'
            html += '<td class="align-middle super-small-text">' + value.production_grade.name + '</td>'
            html += '<td class="align-middle super-small-text">' + value.production_unit.name + '</td>'
            html += '<td class="align-middle super-small-text text-end">' + number_format(roundToTwo(value.production_qty)) + '</td>'
            html += '<td class="align-middle super-small-text text-end">' + number_format(roundToTwo(value.production_weight)) + '</td>'
            html += '<td class="align-middle super-small-text">' + formatDate(value.purchase_at) + ' ' + formatTime(value.purchase_at) + '</td>'
            if (!value.supplier.name) {
                value.supplier.name = ''
            }
            html += '<td class="align-middle super-small-text">' + value.supplier.name + '</td>'
            html += '</tr>'
        });
        $('#bodyDetailMaterial').html(html);
        footDetailMaterial(data)
    }

    function footDetailMaterial(data) {
        //tanpa colspan
        var total = {
            qty: 0,
            weight: 0,
            production_qty: 0,
            production_weight: 0
        }
        $.each(data, (key, value) => {
            total.qty += value.qty
            total.weight += value.weight
            total.production_qty += value.production_qty
            total.production_weight += value.production_weight
        });
        var html = ''
        html += '<tr>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end">Total</th>'
        html += '<th class="align-middle super-small-text text-end">' + number_format(roundToTwo(total.qty)) + '</th>'
        html += '<th class="align-middle super-small-text text-end">' + number_format(roundToTwo(total.weight)) + '</th>'
        // html += '<th class="align-middle super-small-text text-end"></th>'
        // html += '<th class="align-middle super-small-text text-end"></th>'
        // html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end">' + number_format(roundToTwo(total.production_qty)) + '</th>'
        html += '<th class="align-middle super-small-text text-end">' + number_format(roundToTwo(total.production_weight)) + '</th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '<th class="align-middle super-small-text text-end"></th>'
        html += '</tr>'
        $('#footDetailMaterial').html(html);
        $('#tableDetailMaterial').DataTable({
            ordering: true, // Menonaktifkan pengurutan
            // pageLength: 200,
            paging: false,
            fixedHeader: true,
            searching: true,
            // scrollY: "400px",
            // scrollX: true,
            // scrollCollapse: true,
            "info": false, // Mematikan tampilan informasi
            "lengthChange": false,
            "initComplete": function(settings, json) {
                $('div.dataTables_filter input').attr('placeholder', 'Search...');
            },
        })
    }

    function switchToOld() {
        let currentUrl = window.location.href;

        // Pisahkan URL berdasarkan '/'
        let urlParts = currentUrl.split('/');

        // Ambil bagian terakhir dari URL (nama halaman)
        let lastSegment = urlParts[urlParts.length - 1];

        // Periksa apakah sudah ada '-old'
        if (lastSegment.includes('-old')) {
            // Jika sudah ada '-old', hapus bagian '-old'
            lastSegment = lastSegment.replace('-old', '');
        } else {
            // Jika belum ada, tambahkan '-old'
            lastSegment += '-old';
        }

        // Gabungkan kembali URL dengan segmen yang diperbarui
        urlParts[urlParts.length - 1] = lastSegment;
        let newUrl = urlParts.join('/');

        // Redirect ke URL baru
        window.location.href = newUrl;
    }
</script>