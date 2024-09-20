<link href="<?= base_url(); ?>assets/smm/purchase_order.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/shipping.css" rel="stylesheet" type="text/css">
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
            <div class="col-8">
                <div class="row">
                    <div class="col-10 align-self-center">
                        <h1 class="text-dark fw-bolder m-0" style="font-weight: 700 !important">Receptions</h1>
                        <p class="m-0 super-small-text">Panel Kegiatan Entri untuk Management Receptions <br>dan Cetak Surat Jalan Pengiriman</p>
                    </div>
                </div>
            </div>
            <div class="col-4 text-end align-self-center">
                <div class="row justify-content-end">
                    <div class="col-auto pe-0">
                        <p class="m-0 small-text"><i>Last Updated</i></p>
                        <p class="m-0 small-text"><i>Today at <b id="timeRefresh">-</b></i></p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm shadow-none btn-outline-primary" onclick="loadData()"><i class="fa fa-refresh"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12" id="alertPOWithoutInvoice">
        </div>
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-header">
                    <p class="m-0 super-small-text fw-bolder text-dark">Shipping Lists</p>
                    <p class="m-0 super-small-text fw-bolder text-dark-grey" id="dateRangeString"></p>
                </div>
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
<div id="qrcode" style="width:100px; height:100px; margin-top:15px;text-align:center;margin:0 auto;display:none;"></div>
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
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
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
    var warehouse_id = '<?= $this->session->userdata('warehouse_id') ?>'
    var data_shipment = {}
    var data_shipment_showed = []
    var date_start = getFirstDate()
    var date_end = currentDate()
    var statusLineVariable = [{
            id: 0,
            name: 'All Data',
            selected: true,
            functions: 'countAllData()',
            getData: 'chooseDataAllData()'
        },
        {
            id: 1,
            name: 'In Transit',
            selected: false,
            functions: 'countTransit()',
            getData: 'chooseDataTransit()'
        }
    ]
    var indexVariable = 0
    var data_packing_list = []
    var linkPhoto = ''
    $(document).ready(function() {
        dateRangeString()
        loadData()
    })

    function alertPOWithoutInvoice(number) {
        var html = ''
        html += '<div class="alert alert-primary small-text py-3 d-flex align-items-center bd-highlight pointer" role="alert" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" onclick="getDataWithoutInvoice()">'
        html += '<div class="bd-highlight">'
        html += '<svg class="bi flex-shrink-0 me-2" width="15" height="15" role="img" aria-label="Warning:">'
        html += '<use xlink:href="#exclamation-triangle-fill" />'
        html += '</svg>'
        html += '</div>'
        html += '<div class="bd-highlight"><b class="me-1">' + number + '</b>Purchase Order belum memiliki Invoice</div>'
        html += '<div class="ms-auto bd-highlight"><i class="fa fa-chevron-right"></i></div>'
        html += '</div>'
        $('#alertPOWithoutInvoice').html(html)
    }

    function loadData() {
        $.ajax({
            url: "<?= api_url('getReceiveList'); ?>",
            method: "GET",
            dataType: 'JSON',
            data: {
                dateStart: date_start,
                dateEnd: date_end,
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
                data_shipment = response.data
                linkPhoto = data_shipment.folder.driver
                data_shipment_showed = eval(statusLineVariable[indexVariable].getData)
                statusLine()
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
            singleMode: false,
            firstDay: 0,
            startDate: date_start,
            endDate: date_end,
            format: "DD MMMM YYYY",
            autoRefresh: true,
            lockDays: [],
            numberOfColumns: 1,
            setup: (picker) => {
                picker.on('selected', (date1, date2) => {
                    date_start = formatDate(date1['dateInstance'])
                    date_end = formatDate(date2['dateInstance'])
                    dateRangeString()
                    loadData()
                });
            },
        })
    }

    function dateRangeString() {
        $('#dateRangeString').html(formatDateIndonesiaShort(date_start) + ' - ' + formatDateIndonesiaShort(date_end))
    }

    function chooseDataAllData() {
        var data = data_shipment.receive_list
        return data
    }

    function countAllData() {
        return chooseDataAllData().length
    }


    function chooseDataTransit() {
        var data = data_shipment.receive_list_transit
        return data
    }

    function countTransit() {
        return chooseDataTransit().length
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
        data_shipment_showed = eval(getData)
        statusLine()
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
        html += '<div class="col-auto">'
        html += '<div class="row h-100">'

        html += '<div class="col-auto ps-0">'
        html += '<input class="form-select form-select-sm datepicker formFilter" type="text" id="dateRange" placeholder="Tanggal" autocomplete="off">'
        html += '</div>'
        html += '<div class="col-auto ps-0" id="custom-search-container">'
        html += '</div>'

        html += '</div>'
        html += '</div>'
        html += '<div class="col-12 pt-2">'

        html += '<div class="row justify-content-end">'
        html += '<div class="col-auto">'
        // html += '<p class="m-0 small-text">Filter :</p>'
        html += '</div>'
        html += '<div class="col-auto">'
        html += '</div>'
        html += '</div>'

        html += '</div>'
        html += '</div>'
        $('#statusLine').html(html)
        setDaterange()
        kerangkaHistory()
    }

    function kerangkaHistory() {
        var html = ''
        html += '<table class="table table-hover table-sm small w-100" style="overflow-x: hidden;" id="tableDetail">'
        html += '<thead id="headTable">'
        html += '<tr class="py-2">'
        html += '<th class="align-middle text-center small-text bg-white">#</th>'
        html += '<th class="align-middle text-center small-text bg-white">Date Ship</th>'
        html += '<th class="align-middle text-center small-text bg-white">Doc Number</th>'
        html += '<th class="align-middle text-center small-text bg-white">Warehouse<br>Origin</th>'
        html += '<th class="align-middle text-center small-text bg-white">Warehouse<br>Destination</th>'
        html += '<th class="align-middle text-center small-text bg-white">Sender</th>'
        html += '<th class="align-middle text-center small-text bg-white">Total QTY</th>'
        html += '<th class="align-middle text-center small-text bg-white">Total QTY<br>Receive</th>'
        html += '<th class="align-middle text-center small-text bg-white">Total Weight</th>'
        html += '<th class="align-middle text-center small-text bg-white">Total Weight<br>Receive</th>'
        html += '<th class="align-middle text-center small-text bg-white">Vehicle<br>Model</th>'
        html += '<th class="align-middle text-center small-text bg-white">Vehicle<br>Number</th>'
        html += '<th class="align-middle text-center small-text bg-white">Driver<br>Photo</th>'
        html += '<th class="align-middle text-center small-text bg-white">Driver<br>Name</th>'
        html += '<th class="align-middle text-center small-text bg-white">Driver<br>Phone</th>'
        html += '<th class="align-middle text-center small-text bg-white">Receive<br>At</th>'
        html += '<th class="align-middle text-center small-text bg-white">Receive Close<br>At</th>'
        html += '<th class="align-middle text-center small-text bg-white">Receive<br>By</th>'
        html += '<th class="align-middle text-center small-text bg-white">Status</th>'
        html += '<th class="align-middle text-center small-text bg-white"></th>'
        html += '</tr>'
        html += '</thead>'
        html += '<tbody id="bodyTable">'
        html += '</tbody>'
        html += '<tfoot id="footTable">'
        html += '</tfoot>'
        html += '</table>'
        $('#dataTable').html(html)
        bodyHistory()
    }

    function deepCopy(obj) {
        return JSON.parse(JSON.stringify(obj));
    }

    function calculateTotals(details, attribute) {
        let total = 0;
        $.each(details, function(index, detail) {
            total += detail[attribute];
        });
        return total;
    }
    var all_total_qty = 0
    var all_total_qty_receive = 0
    var all_total_weight = 0
    var all_total_weight_receive = 0

    function bodyHistory() {
        var html = ''
        var a = 1
        all_total_qty = 0
        all_total_qty_receive = 0
        all_total_weight = 0
        all_total_weight_receive = 0
        var dataFind = deepCopy(data_shipment_showed)
        var b = 0
        $.each(dataFind, function(key, value) {
            var totalQty = calculateTotals(value.details, 'qty');
            var totalQtyReceive = calculateTotals(value.details, 'qty_receive');
            var totalWeight = calculateTotals(value.details, 'weight');
            var totalWeightReceive = calculateTotals(value.details, 'weight_receive');
            // selisih qty, dibuat absolut
            var selisih_qty = Math.abs(totalQty - totalQtyReceive)
            var iconSelisih = ''
            if (totalQtyReceive) {
                if (selisih_qty > 0) {
                    iconSelisih = '<i class="fa fa-warning text-warning small-text ms-1" title="Selisih ' + selisih_qty + '"></i>'
                }
            }
            html += '<tr>'
            html += '<td class="bg-white align-middle small-text text-center">' + (parseInt(key) + 1) + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + formatDate(value.shipment_at) + ' ' + formatTime(value.shipment_at) + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.document_number + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.warehouse_origin.name + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.warehouse_destination.name + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + shortenName(value.user_sender.name, 1) + '</td>'

            html += '<td class="bg-white align-middle small-text text-center">' + number_format(totalQty) + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + number_format(totalQtyReceive) + '' + iconSelisih + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + number_format(totalWeight) + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + number_format(totalWeightReceive) + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.vehicle_model.name + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.vehicle_number + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">'
            //picture
            html += '<div class="avatars text-center">'
            if (value.driver_photos) {
                for (let j = 0; j < value.driver_photos.length; j++) {
                    var hide = ''
                    if (j >= 3) {
                        hide = 'hidden'
                    }
                    html += '<span class="avatar pointer" href="' + linkPhoto + value.driver_photos[j] + '" data-fancybox="gallery' + key + '" data-caption="Gallery ' + key + '" ' + hide + '>'
                    html += '<img src="' + linkPhoto + value.driver_photos[j] + '">'
                    html += '</span>'
                }
            } else {
                html += '<span class="avatar">'
                var pict = '<?= base_url('assets/image/jpg/no_pict.jpg') ?>'
                html += '<img src="' + pict + '">'
                html += '</span>'
            }
            html += '</div>'
            //picture
            html += '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.driver_name + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.driver_phone + '</td>'
            if (value.is_receive) {
                if (value.receive_at) {
                    value.receive_at = formatDate(value.receive_at) + '<br>' + formatTime(value.receive_at)
                } else {
                    value.receive_at = ''
                }
                if (value.receive_close_at) {
                    value.receive_close_at = formatDate(value.receive_close_at) + '<br>' + formatTime(value.receive_close_at)
                } else {
                    value.receive_close_at = ''
                }
                if (!value.user_receiver.name) {
                    value.user_receiver.name = ''
                }
                html += '<td class="bg-white align-middle small-text text-center">' + value.receive_at + '</td>'
                html += '<td class="bg-white align-middle small-text text-center">' + value.receive_close_at + '</td>'
                html += '<td class="bg-white align-middle small-text text-center">' + value.user_receiver.name + '</td>'
            } else {
                html += '<td class="bg-white align-middle small-text text-center"></td>'
                html += '<td class="bg-white align-middle small-text text-center"></td>'
                html += '<td class="bg-white align-middle small-text text-center"></td>'
            }
            var badge = ''
            if (value.is_receive_all == 1) {
                if (value.is_receive_close == 1) {
                    badge = '<span class="badge rounded-pill bg-success super-small-text p-2 w-100">SELESAI DITERIMA</span>'
                } else {
                    badge = '<span class="badge rounded-pill bg-info super-small-text p-2 w-100">DITERIMA SEMUA</span>'
                }
            } else {
                // jika belum diterima
                if (totalQtyReceive) {
                    badge = '<span class="badge rounded-pill bg-warning super-small-text p-2 w-100">PROSES TERIMA</span>'
                } else {
                    badge = '<span class="badge rounded-pill bg-grey super-small-text p-2 w-100">IN TRANSIT</span>'
                }
            }
            html += '<td class="bg-white align-middle small-text text-center">' + badge + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">'
            html += '<button class="super-small-text btn btn-sm btn-outline-dark py-1 px-2 shadow-none" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>'
            html += '<div class="dropdown-menu shadow-sm" aria-labelledby="dropdownMenuButton">'
            html += '<a class="dropdown-item" onclick="getPackingList(' + "'" + value.id + "'" + ',' + "'" + value.document_number + "'" + ')"><i class="fa fa-list-ul me-2"></i> Packing List</a>'
            if (value.is_receive_all == 1 && value.is_receive_close == null) {
                html += '<div class="text-center pe-2 ps-2 mt-2">'
                html += '<hr class="m-0">'
                html += '<button class="btn btn-sm btn-success w-100 mt-2 py-2" onclick="selesaiTerima(' + "'" + value.id + "'" + ')">Selesai Terima</button>'
                html += '<button class="btn btn-sm text-danger w-100 py-2 mt-2 border-0 super-small-text" onclick="batalTerima(' + "'" + value.id + "'" + ')">Batal Terima</button>'
                html += '</div>'
            }
            html += '</div>'
            html += '</td>'
            html += '</tr>'
            all_total_qty += parseInt(totalQty)
            all_total_qty_receive += parseInt(totalQtyReceive)
            all_total_weight += parseInt(totalWeight)
            all_total_weight_receive += parseInt(totalWeightReceive)
            b++
        })
        $('#bodyTable').html(html)
        for (let i = 0; i < b; i++) {
            Fancybox.bind('[data-fancybox="gallery' + i + '"]', {
                // Custom options for the first gallery
            });
        }
        footTable()
    }

    function footTable() {
        var html = ''
        html += '<tr>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center">Total</th>'
        html += '<th class="px-2 align-middle small text-center">' + number_format(all_total_qty) + '</th>'
        html += '<th class="px-2 align-middle small text-center">' + number_format(all_total_qty_receive) + '</th>'
        html += '<th class="px-2 align-middle small text-center">' + number_format(all_total_weight) + '</th>'
        html += '<th class="px-2 align-middle small text-center">' + number_format(all_total_weight_receive) + '</th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
        html += '<th class="px-2 align-middle small text-center"></th>'
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
            searching: true,
        })
        $('#custom-search-container').html($('.dataTables_filter'));
    }

    function cetakSuratJalan(id, document_number) {
        var text = '#SJ-' + id
        var qrcode = new QRCode("qrcode", {
            text: text,
            width: 100,
            height: 100,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        imgBase64Data = qrcode._oDrawing._elCanvas.toDataURL("image/png")
        var image = btoa(imgBase64Data)
        eval('var url = "<?= base_url() ?>page/cetakSuratJalan"')
        var params = "*$" + id + "*$" + document_number + "*$" + image
        window.open(url + '?params=' + encodeURIComponent(params), '_blank');
    }

    function selesaiTerima(id) {
        Swal.fire({
            text: 'Apakah Anda yakin ingin menyelesaikan penerimaan Surat Jalan ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                simpanDataTerimaSJ(id)
            }
        })
    }

    function batalTerima(id) {
        Swal.fire({
            text: 'Apakah Anda yakin ingin membatalkan penerimaan Surat Jalan ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                simpanDataBatalSJ(id)
            }
        })
    }

    function simpanDataTerimaSJ(id) {
        var type = 'POST'
        var button = '.btnSimpan'
        var url = '<?php echo api_produksi('setShipment'); ?>'
        var data = {
            shipment: [{
                "id": id,
                "is_receive_close": 1
            }]
        }
        kelolaData(data, type, url, button)
    }

    function simpanDataBatalSJ(id) {
        var type = 'POST'
        var button = '.btnSimpan'
        var url = '<?php echo api_produksi('setShipment'); ?>'
        var data = {
            shipment: [{
                "id": id,
                "is_receive_all": null
            }]
        }
        kelolaData(data, type, url, button)
    }

    function kelolaData(data, type, url, button) {
        $.ajax({
            url: url,
            type: type,
            data: data,
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error Data'
                });
                $(button).prop("disabled", false);
            },
            beforeSend: function() {
                $(button).prop("disabled", true);
            },
            success: function(response) {
                if (response.success == true) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Data Berhasil Tersimpan',
                        icon: 'success',
                    }).then((responses) => {
                        $(button).prop("disabled", false);
                        $('#modal').modal('hide')
                        loadData()
                    })
                }
            }
        });
    }

    function getPackingList(id, doc_num) {
        data_packing_list = []
        $.ajax({
            url: "<?= api_url('getHistoryShipmentItem'); ?>",
            method: "GET",
            dataType: 'JSON',
            data: {
                shipmentId: id,
                dataProfile: 'DETAIL',
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
                data_packing_list = response.data.history_shipment_item.data
                detailPackingList(id, doc_num)
            }
        })
    }

    function detailPackingList(id, doc_num) {
        $('#modal').modal('show')
        $('#modalDialog').addClass('modal-dialog modal-dialog-scrollable modal-lg');
        var html_header = '';
        html_header += '<h5 class="modal-title small">Packing List ' + doc_num + '</h5>';
        html_header += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $('#modalHeader').html(html_header);
        var html_body = '';
        html_body += '<div class="row">'
        html_body += '<div class="col-12 text-end">'
        // tombol cetak packing list
        html_body += '<button type="button" class="btn btn-outline-primary btn-sm small-text p-2 me-2" onclick="cetakPackingList( \'' + id + '\', \'' + doc_num + '\')"><i class="fa fa-print me-2"></i>Cetak Packing List</button>'
        html_body += '<button type="button" class="btn btn-outline-success btn-sm small-text p-2" onclick="excelPackingList( \'' + id + '\', \'' + doc_num + '\')"><i class="fa fa-file-excel-o me-2"></i>Excel Packing List</button>'
        html_body += '</div>'
        html_body += '<div class="col-12 table-responsive" id="dataPackingList">'
        html_body += '</div>'
        html_body += '</div>'
        $('#modalBody').html(html_body);
        var html_footer = '';
        html_footer += '<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>'
        $('#modalFooter').html(html_footer);
        dataPackingList(id)
    }

    function dataPackingList(id) {
        var html = '';
        html += '<table class="table table-bordered table-hover table-sm small w-100 tablePackingList" id="tablePackingList">'
        html += '<thead>'
        html += '<tr>'
        html += '<th class="align-middle small-text" width="10%">No</th>'
        // html += '<th class="align-middle small-text" width="20%">Tgl</th>'
        html += '<th class="align-middle small-text" width="40%">No. Bale</th>'
        html += '<th class="align-middle small-text" width="10%">QTY</th>'
        html += '<th class="align-middle small-text" width="10%">QTY Terima</th>'
        html += '<th class="align-middle small-text" width="10%">Berat</th>'
        html += '<th class="align-middle small-text" width="10%">Berat Terima</th>'
        html += '<th class="align-middle small-text" width="30%">Item</th>'
        html += '<th class="align-middle small-text" width="10%">Grade</th>'
        html += '</tr>'
        html += '</thead>'
        html += '<tbody>'
        html += '</tbody>'
        html += '<tfoot>'
        html += '</tfoot>'
        html += '</table>'
        $('#dataPackingList').html(html)
        dataTablePackingList(id)
    }

    function formatDate2(inputDate) {
        // Mengambil tanggal dari input
        const date = new Date(inputDate);

        // Mengambil hari, bulan, dan tahun dari objek Date
        let day = date.getDate();
        let month = date.getMonth() + 1; // Bulan dimulai dari 0, jadi ditambahkan 1
        let year = date.getFullYear();

        // Mengubah tahun ke dua digit terakhir
        year = year.toString().slice(-2);

        // Menambahkan 0 di depan hari dan bulan jika kurang dari 10
        if (day < 10) day = '0' + day;
        if (month < 10) month = '0' + month;

        // Menggabungkan hari, bulan, dan tahun sesuai format DD/MM/YY
        return `${day}/${month}/${year}`;
    }

    function dataTablePackingList(id) {
        var html = '';
        var a = 1
        var total = {
            qty: 0,
            qty_receive: 0,
            weight: 0,
            weight_receive: 0
        }
        data_packing_list.forEach(e => {
            html += '<tr>'
            html += '<td class="align-middle small-text text-center" width="10%">' + a++ + '</td>'
            html += '<td class="align-middle small-text" width="40%">' + formatDate2(e.inventory.date) + '-' + e.inventory.bale_number + '</td>'
            // html += '<td class="align-middle small-text text-center" width="20%">' + e.inventory.bale_number + '</td>'
            html += '<td class="align-middle small-text text-end" width="10%">' + number_format(roundToTwo(e.qty)) + '</td>'
            html += '<td class="align-middle small-text text-end" width="10%">' + number_format(roundToTwo(e.qty_receive)) + '</td>'
            html += '<td class="align-middle small-text text-end" width="10%">' + number_format(roundToTwo(e.weight)) + '</td>'
            html += '<td class="align-middle small-text text-end" width="10%">' + number_format(roundToTwo(e.weight_receive)) + '</td>'
            html += '<td class="align-middle small-text" width="30%">' + e.item.name + '</td>'
            html += '<td class="align-middle small-text text-center" width="10%">' + e.item_grade.name + '</td>'
            html += '</tr>'

            total.qty += e.qty
            total.qty_receive += e.qty_receive
            total.weight += e.weight
            total.weight_receive += e.weight_receive
        });
        $('#tablePackingList tbody').html(html)
        dataTablePackingListFooter(id, total)
    }

    function dataTablePackingListFooter(id, total) {
        var html = '';
        html += '<tr>'
        html += '<th class="align-middle small-text text-center" width="10%"></th>'
        html += '<th class="align-middle small-text text-end" width="40%">Total</th>'
        html += '<th class="align-middle small-text text-end" width="10%">' + number_format(roundToTwo(total.qty)) + '</th>'
        html += '<th class="align-middle small-text text-end" width="10%">' + number_format(roundToTwo(total.qty_receive)) + '</th>'
        html += '<th class="align-middle small-text text-end" width="10%">' + number_format(roundToTwo(total.weight)) + '</th>'
        html += '<th class="align-middle small-text text-end" width="10%">' + number_format(roundToTwo(total.weight_receive)) + '</th>'
        html += '<th class="align-middle small-text" width="30%"></th>'
        html += '<th class="align-middle small-text text-center" width="10%"></th>'
        html += '</tr>'
        $('#tablePackingList tfoot').html(html)
        $('#tablePackingList').DataTable({
            ordering: true, // Menonaktifkan pengurutan
            // pageLength: 200,
            paging: false,
            fixedHeader: true,
            searching: false,
            // scrollY: "400px",
            // scrollX: true,
            // scrollCollapse: true,
            "info": false, // Mematikan tampilan informasi
            "lengthChange": false
        })
    }

    function cetakPackingList(id, doc_num) {
        var url = "<?= base_url() ?>page/cetakPackingList"
        var params = "*$" + id + "*$" + doc_num
        window.open(url + '?params=' + encodeURIComponent(params), '_blank');
    }

    function excelPackingList(id, doc_num) {
        var url = '<?= base_url('report/excelPackingList') ?>';
        var params = "*$" + id + "*$" + doc_num
        window.open(url + '?params=' + encodeURIComponent(params), '_blank');
    }
</script>