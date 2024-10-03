<link href="<?= base_url(); ?>assets/smm/purchase_order.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/invoice.css" rel="stylesheet" type="text/css">
<style>
    .text-rekom {
        color: #94B9DB !important;
    }

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
</style>
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
                <h1 class="text-dark fw-bolder mb-2" style="font-weight: 700 !important"><span class="text-orange">I</span>NVOICES <span class="text-orange">L</span>IST</h1>
            </div>
            <div class="col-4 text-end">
                <!-- <button type="button" class="btn btn-sm shadow-none btn-outline-primary" onclick="addNewPR()"><i class="fa fa-plus me-2"></i>Tambah Baru</button> -->
                <!-- <button type="button" class="btn btn-sm shadow-none btn-outline-dark" onclick="formReport()"><i class="fa fa-table"></i></button> -->
                <button type="button" class="btn btn-sm shadow-none btn-outline-dark" onclick="refresh()"><i class="fa fa-refresh"></i></button>
            </div>
            <div class="col-8">
                <p class="m-0 super-small-text">In Purchase Requisition section you can review and manage all requests with their details. You can view and edit many information such as of all orders, ordered product, send notifications, price, and make a purchase order. Only administrations and team leaders can reach. the changes you make will be approved after they are checked</p>
            </div>
            <div class="col-12 px-4" id="statusLine">

            </div>
            <div class="row me-0">
                <div class="col-12 pe-0">
                    <div class="table-responsible" id="dataTable">

                    </div>
                </div>
                <!-- <div class="col-4">
                    <div class="card shadow-none">
                        <div class="card-body">

                        </div>
                    </div>
                </div> -->
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
<script>
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

    function loadingReturn(text, height = null) {
        if (!height) {
            height = '100%'
        }
        var html = '<div class="row h-100"><div class="col-12 align-self-center text-center"><div class="card shadow-none" style="border:0px;height:' + height + ';"><div class="card-body h-100 p-5 m-5"><lottie-player style="margin:auto;width: 150px; height: 100%;" src="<?= base_url() ?>assets/json/loading.json" mode="bounce" background="transparent" speed="2" loop autoplay></lottie-player><p class="small"><i>' + text + '</i></p></div></div></div></div>'
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
        // Mengurangi 1 bulan dari bulan saat ini
        today.setMonth(today.getMonth() - 1);
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
        id_detail_clicked = ''
        newNumberInvoice = ''
        clearModal();
    })
    $(document).on('show.bs.modal', '.modal', function() {
        const zIndex = 1040 + 10 * $('.modal:visible').length;
        $(this).css('z-index', zIndex);
        setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
    });

    var user_id = '<?= $this->session->userdata('id') ?>'
    var warehouse_id = '<?= $this->session->userdata('warehouse_id') ?>'
    var admin_name = '<?= $this->session->userdata('name') ?>'
    var data_invoices = ""
    var data_invoice_detail = ""
    var data_invoice_detail_showed = []
    var data_load_page = {}
    var data_item = ""
    var data_supplier = ""
    var no_pr = ""
    var date_start = getFirstDate()
    var date_end = currentDate()
    var data_detail_invoices = {}
    var nilaiPajak = 0.005
    var id_detail_clicked = ''
    var is_pajak = false
    var is_harga_satuan = false
    var statusLineVariable = [{
            id: 0,
            name: 'All Data',
            selected: true,
            functions: 'countAllData()',
            getData: 'chooseDataAllData()'
        },

        {
            id: 1,
            name: 'Incomplete',
            selected: false,
            functions: 'countPending()',
            getData: 'chooseDataPending()'
        },
    ]
    $(document).ready(function() {
        loadData()
    })

    function loadData() {
        $.ajax({
            url: "<?= api_url('getAllInvoices'); ?>",
            method: "GET",
            dataType: 'JSON',
            data: {
                warehouseId: warehouse_id,
                dateStart: date_start,
                dateEnd: date_end,
                isActive: 1
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
                data_invoices = response['data']
                data_invoice_detail_showed = data_invoices.dataInvoice.data
                loadPageInvoicePrint()
            }
        })
    }

    function loadPageInvoicePrint() {
        $.ajax({
            url: "<?= api_url('loadPageInvoicePrint'); ?>",
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
            beforeSend: function() {},
            success: function(response) {
                showOverlay('hide')
                data_load_page = response['data']
                statusLine()
            }
        })
    }


    function refresh() {
        loadData()
    }
    var data_pr_showed = []


    function groupAndSum(arr, groupKeys, sumKeys) {
        return Object.values(
            arr.reduce((acc, curr) => {
                const group = groupKeys.map(k => curr[k]).join('-');
                acc[group] = acc[group] || Object.fromEntries(groupKeys.map(k => [k, curr[k]]).concat(sumKeys.map(k => [k, 0])));
                sumKeys.forEach(k => acc[group][k] += parseFloat(curr[k]));
                return acc;
            }, {})
        );
    }

    function statusLine() {
        var html = ''
        html += '<div class="row justify-content-between mt-4 mb-2">'
        // tab
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
        // tab
        html += '<div class="col-auto ps-0">'
        html += '<input class="form-select form-select-sm datepicker formFilter" type="text" id="dateRange" placeholder="Tanggal" autocomplete="off">'
        html += '</div>'
        html += '<div class="col-auto ps-0" id="custom-search-container">'
        html += '</div>'

        html += '</div>'
        html += '</div>'


        html += '</div>'
        $('#statusLine').html(html)
        setDaterange()
        dataTable()
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
                    refresh()
                });
            },
        })
    }

    function chooseDataAllData() {
        var data = data_invoices.dataInvoice.data
        return data
    }

    function countAllData() {
        return chooseDataAllData().length
    }


    function chooseDataPending() {
        var data = data_invoices.dataInvoiceIncomplete.data
        return data
    }

    function countPending() {
        return chooseDataPending().length
    }


    function statusLineSwitch(id, getData) {
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
        data_invoice_detail_showed = eval(getData)
        statusLine()
    }

    function dataTable() {
        var html = ''
        html += '<table class="table table-hover table-sm small w-100 mt-5" style="overflow-x: hidden;" id="tableDetail">'
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
        html += '<tr class="">'
        html += '<th class="align-middle small" style="background-color: white;">#</th>'
        html += '<th class="align-middle small" style="background-color: white;">No. Invoice</th>'
        html += '<th class="align-middle small" style="background-color: white;">Date</th>'
        html += '<th class="align-middle small" style="background-color: white;">Supplier</th>'
        html += '<th class="align-middle small" style="background-color: white;">Warehouse</th>'
        html += '<th class="align-middle small" style="background-color: white;">PD</th>'
        html += '<th class="align-middle small" style="background-color: white;">Total<br>QTY</th>'
        html += '<th class="align-middle small" style="background-color: white;">Total<br>Berat</th>'
        html += '<th class="align-middle small" style="background-color: white;">Total<br>Harga</th>'
        html += '<th class="align-middle small" style="background-color: white;">Notes</th>'
        html += '<th class="align-middle small" style="background-color: white;">Notes<br>Purchase</th>'
        html += '<th class="align-middle small" style="background-color: white;">User<br>Create</th>'
        html += '<th class="align-middle small" style="background-color: white;width:30px">Status</th>'
        html += '<th class="align-middle small" style="background-color: white;width:20px;"></th>'
        html += '</tr>'
        $('#headTable').html(html)
        bodyTable()
    }

    function deepCopy(obj) {
        return JSON.parse(JSON.stringify(obj));
    }
    var total_qty = 0
    var total_weight = 0
    var total_total = 0

    function bodyTable() {
        var html = ''
        var a = 1
        total_qty = 0
        total_weight = 0
        total_total = 0
        var dataFind = deepCopy(data_invoice_detail_showed)
        dataFind.forEach(e => {
            var badge = ''
            var bg = ''
            if (!e.is_ready_print && !e.is_complete) {
                badge = '<span class="badge rounded-pill bg-light-grey border border-dark-grey py-2 px-1 super-small-text text-dark-grey w-100">Proses Timbang</span>'
            } else if (e.is_ready_print && !e.is_complete) {
                badge = '<span class="badge rounded-pill bg-orange-light border border-orange py-2 px-1 super-small-text text-orange w-100">Siap Dicetak</span>'
            } else {
                if (e.is_complete) {
                    badge = '<span class="badge rounded-pill bg-success-light border border-green py-2 px-1 super-small-text text-green w-100">Selesai</span>'
                    bg = 'bg-light'
                } else {
                    badge = '<span class="badge rounded-pill bg-danger-light border border-red py-2 px-1 super-small-text text-red w-100">Dibatalkan</span>'
                }
            }
            html += '<tr>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-center" style="background-color: white;">' + a++ + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-center" style="background-color: white;">' + e.invoice + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-center" style="background-color: white;">' + formatDate(e.datetime) + ' ' + formatTime(e.datetime) + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text" style="background-color: white;">' + e.supplier.name + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-center" style="background-color: white;">' + e.warehouse.name + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-center" style="background-color: white;">' + e.tax_out_come + '</td>'
            if (!e.total) {
                e.total = 0
            }
            if (!e.weight) {
                e.weight = 0
            }
            if (!e.qty) {
                e.qty = 0
            }
            html += '<td class="' + bg + ' px-2 align-middle small-text text-end" style="background-color: white;">' + number_format(e.qty) + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-end" style="background-color: white;">' + number_format(e.weight) + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-end" style="background-color: white;">' + number_format(e.total) + '</td>'
            if (!e.note) {
                e.note = ''
            }
            if (!e.note_purchase) {
                e.note_purchase = ''
            }
            html += '<td class="' + bg + ' px-2 align-middle small-text" style="background-color: white;cursor: default;" title="' + e.note + '">' + shortenText(e.note, 20) + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text" style="background-color: white;cursor: default;" title="' + e.note_purchase + '">' + shortenText(e.note_purchase, 20) + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-center" style="background-color: white;">' + e.user_admin.name + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-end" style="background-color: white;">' + badge + '</td>'
            html += '<td class="' + bg + ' px-2 align-middle small-text text-center" style="background-color: white;">'
            html += '<button type="button" class="btn btn-outline-dark btn-sm p-1 small-text" onclick="viewDetail(' + "'" + e.id + "'" + ')"><i class="fa fa-pencil"></i></button>'
            html += '</td>'
            html += '</tr>'

            total_qty += e.qty
            total_weight += e.weight
            total_total += e.total
        });
        $('#bodyTable').html(html)
        footTable()
    }

    function footTable() {
        var html = ''
        html += '<tr>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
        html += '<th class="px-2 align-middle small text-center py-2">Total</th>'
        html += '<th class="px-2 align-middle small text-center py-2">' + number_format(total_qty) + '</th>'
        html += '<th class="px-2 align-middle small text-end py-2">' + number_format(total_weight) + '</th>'
        html += '<th class="px-2 align-middle small text-end py-2">' + number_format(total_total) + '</th>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
        html += '<th class="px-2 align-middle small text-center py-2"></th>'
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
            searching: true,
            "initComplete": function(settings, json) {
                $('div.dataTables_filter input').attr('placeholder', 'Search...');
            },
        })
        $('#custom-search-container').html($('.dataTables_filter'));
        if (id_detail_clicked) {
            headerInvoice(id_detail_clicked)
        }
    }

    function viewDetail(id = null) {
        id_detail_clicked = id
        $('#modal').modal('show')
        $('#modalDialog').addClass('modal-dialog modal-dialog-scrollable');
        var html_header = '';
        html_header += '<h5 class="modal-title small">Rincian Invoice</h5>';
        html_header += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $('#modalHeader').html(html_header);
        var html_body = '';
        html_body += '<div class="row">'
        html_body += '<div class="col-12 align-self-center" id="headerInvoice">'
        html_body += '</div>'
        html_body += '<div class="col-12" id="bodyInvoice">'
        html_body += '</div>'
        html_body += '</div>'
        $('#modalBody').html(html_body);
        headerInvoice(id)
    }

    function iconPrint() {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/></svg>'
        return html
    }
    var newNumberInvoice = ''

    function headerInvoice(id) {
        var data = data_invoices.dataInvoice.data.find((value, key) => {
            if (value.id == id) return true
        });
        data_detail_invoices = data
        var html = ''
        var line = '-'
        if (data.line) {
            line = data.line.name
        }
        var html_footer = '';
        var btnEditNumberInvoice = ''
        var btnHapusInvoice = ''
        html_footer += '<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>'
        if (!data.is_complete) {
            if (data.is_ready_print) {
                html_footer += '<button type="button" class="btn btn-outline-primary btn-sm" id="btnSimpan" onclick="simpanData(' + "'" + id + "'" + ',0)">Update Data</button>'
                html_footer += '<button type="button" class="btn btn-primary btn-sm" id="btnSimpanPrint" onclick="simpanData(' + "'" + id + "'" + ',0,true)">Update Data & Print</button>'
                btnEditNumberInvoice = '<span class="fa fa-pencil small ms-2 text-grey pointer" id="btnEditInvoiceNumber" onclick="editNumberInvoice(' + "'" + data.invoice + "'" + ')"></span>'
                btnHapusInvoice = '<a class="dropdown-item text-danger" onclick="deleteInvoice(' + id + ')"><i class="fa fa-trash text-danger me-2"></i> Hapus Invoice</a>'
            }
        } else {
            btnHapusInvoice = '<a class="dropdown-item text-danger" onclick="deleteInvoice(' + id + ')"><i class="fa fa-trash text-danger me-2"></i> Hapus Invoice</a>'
        }
        html += '<div class="row p-2">'
        html += '<div class="col-10">'

        html += '<p class="m-0 fw-bold text-grey-dark h3 d-flex align-items-center gap-2">'
        html += 'Invoice'
        // input
        html += '<span id="fieldEditInvoiceNumber">'
        html += '</span>'
        // input
        html += btnEditNumberInvoice
        html += '</p>'
        html += '<p class="m-0 small text-dark-grey">Created At ' + formatDateIndonesia(data.datetime) + ' | <span class="fw-bolder text-primary-payment"">' + line + '</span></p>'
        html += '</div>'
        html += '<div class="col-2 text-end align-self-center">'
        if (data.is_complete) {
            html += '<button class="btn p-0 shadow-none" onclick="printInvoice(' + "'" + id + "'" + ')">' + iconPrint() + '</button>'
            // html += '<button class="btn btn-sm btn-outline-dark-light shadow-none" style="border-color: #69707a;" onclick="printInvoice(' + "'" + id + "'" + ')">' + iconPrint() + '</button>'
        }
        if (btnHapusInvoice) {
            html += '<button class="btn pe-0 shadow-none" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>'
            // menu
            html += '<div class="dropdown-menu shadow-sm bg-light" aria-labelledby="dropdownMenuButton">'
            html += btnHapusInvoice
            html += '</div>'
            // menu
            html += '</div>'
        }
        html += '</div>'
        $('#headerInvoice').html(html)

        $('#modalFooter').html(html_footer);
        disabledEditNumberInvoice(data.invoice)
        bodyInvoice(data)
    }

    function bodyInvoice(data) {
        var html = ''
        html += '<div class="p-2 py-1">'
        // purchase detail
        html += '<div class="card shadow-none mb-2">'
        html += '<div class="card-header p-2 px-3 bg-primary-payment text-white">'
        html += '<p class="m-0 small-text fw-bold">Purchase Detail</p>'
        html += '</div>'
        html += '<div class="card-body" id="purchaseDetail">'
        html += '</div>'
        html += '<div class="card-footer p-2 px-4" id="totalAllDetail">'
        html += '</div>'
        html += '</div>'
        // purchase detail
        // purchase detail
        html += '<div class="card shadow-none mb-3">'
        html += '<div class="card-header p-2 px-3 bg-primary-payment text-white">'
        html += '<p class="m-0 small-text fw-bold">Payment Result</p>'
        html += '</div>'
        html += '<div class="card-body py-3" id="paymentResult">'
        html += '</div>'
        html += '</div>'
        // purchase detail
        // notes
        html += '<div class="card shadow-none border-0 mb-3">'
        html += '<div class="card-body p-0">'
        html += '<p class="m-0 super-small-text fw-bolder mb-2">Notes Purchase</p>'
        if (!data.note_purchase) {
            data.note_purchase = ''
        }
        html += '<textarea class="form-control form-control-sm" id="notes_purchase" rows="3" style="resize: none;">' + data.note_purchase + '</textarea>'
        html += '</div>'
        html += '</div>'
        // notes
        //setting
        html += '<p class="m-0 super-small-text fw-bolder text-primary-payment">Settings</p>'
        html += '<div class="row mt-2">'

        html += '<div class="col-8 mb-2">'
        html += '<p class="m-0 small text-grey-dark fw-bolder">Terapkan Pajak Daerah</p>'
        html += '<p class="m-0 small-text text-grey-dark">Terapkan pajak daerah pada invoice</p>'
        html += '</div>'
        html += '<div class="col-4 mb-2 pe-2 align-self-center text-end">'
        // button
        var checkedPajak = ''
        if (data.tax_out_come != 0) {
            checkedPajak = 'checked'
        }
        html += '<input type="checkbox" class="theme-checkbox" id="applyPajakDaerah" onchange="applyPajakDaerah()" ' + checkedPajak + '>'
        // button
        html += '</div>'

        html += '<div class="col-8 mb-2">'
        html += '<p class="m-0 small text-grey-dark fw-bolder">Cetak Harga Satuan</p>'
        html += '<p class="m-0 small-text text-grey-dark">Terapkan harga satuan pada saat Cetak Invoice</p>'
        html += '</div>'
        html += '<div class="col-4 mb-2 pe-2 align-self-center text-end">'
        // button
        html += '<input type="checkbox" class="theme-checkbox" id="applyHargaSatuan" onchange="applyHargaSatuan()"">'
        // button
        html += '</div>'

        html += '</div>'
        //setting
        if (!data.is_complete) {
            if (data.is_ready_print) {
                html += '<button class="btn btn-danger small-text w-100 mt-5 shadow-none" onclick="closeInvoice(' + data.id + ',1)">Close Invoice</button>'
                // html += '<button class="btn small-text w-100 my-1 text-danger shadow-none" id="btnHapus" onclick="deleteInvoice(' + data.id + ')"><i class="fa fa-trash me-2"></i>Hapus Invoice</button>'
                html += '<hr class="m-0" style="height: 0.5px">'
                html += '<button class="btn small-text w-100 my-1 text-dark-grey shadow-none" id="btnBatalMuat" onclick="batalMuat(' + data.id + ')"><i class="fa fa-times me-2"></i>Batal Selesai Timbang</button>'
            } else {
                html += '<div class="w-100 text-center mt-4">'
                html += '<i class="text-grey">Menunggu Proses Timbang</i>'
                html += '</div>'
            }
        } else {
            // html += '<button class="btn small-text w-100 mt-1 text-danger shadow-none" id="btnHapus" onclick="deleteInvoice(' + data.id + ')"><i class="fa fa-trash me-2"></i>Hapus Invoice</button>'
        }
        html += '</div>'
        $('#bodyInvoice').html(html)
        purchaseDetail(data)
    }

    function iconBox() {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16"><path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/></svg>'
        return html
    }

    function iconWight() {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-minecart-loaded" viewBox="0 0 16 16"><path d="M4 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2m0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4m8-1a1 1 0 1 1 0-2 1 1 0 0 1 0 2m0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4M.115 3.18A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 14 12H2a.5.5 0 0 1-.491-.408l-1.5-8a.5.5 0 0 1 .106-.411zm.987.82 1.313 7h11.17l1.313-7z"/><path fill-rule="evenodd" d="M6 1a2.498 2.498 0 0 1 4 0c.818 0 1.545.394 2 1 .67 0 1.552.57 2 1h-2c-.314 0-.611-.15-.8-.4-.274-.365-.71-.6-1.2-.6-.314 0-.611-.15-.8-.4a1.497 1.497 0 0 0-2.4 0c-.189.25-.486.4-.8.4-.507 0-.955.251-1.228.638q-.136.194-.308.362H3c.13-.147.401-.432.562-.545a1.6 1.6 0 0 0 .393-.393A2.5 2.5 0 0 1 6 1"/></svg>'
        return html
    }
    var subTotal = 0
    var totalAll = 0
    var totalBale = 0
    var totalWeight = 0
    var totalPajak = 0
    var unitName = ''

    function purchaseDetail(data) {
        var html = ''
        subTotal = 0
        totalBale = 0
        totalWeight = 0
        var a = 0
        var b = 1
        data.purchase_details.forEach(e => {
            if (!e.weight) {
                e.weight = 0
            }
            html += '<div class="row mb-3">'
            html += '<div class="col-1 pe-0 align-self-center">'
            html += '<p class="m-0 small-text">#' + b++ + '</p>'
            html += '</div>'
            html += '<div class="col-5 align-self-center">'
            html += '<p class="m-0 small-text fw-bolder">' + e.item.name + ' (' + e.grade.name + ')</p>'
            html += '<p class="m-0 small-text me-2">' + iconBox() + ' ' + number_format(e.qty) + ' ' + e.unit.name + ' <span class="ms-3 me-2">' + iconWight() + ' ' + number_format(e.weight) + ' kg</span></p>'
            html += '</div>'
            html += '<div class="col-3 align-self-center p-0">'
            html += '<div class="d-flex align-items-center">'
            html += '<span class="me-2">Rp.</span>'
            var harga_satuan = e.price
            var isHargaRecom = ''
            if (harga_satuan == null) {
                harga_satuan = 0
                var dataLoadPage = data_load_page.itemPrice.find((value, key) => {
                    if (value.item_id == e.item.id && value.item_grade_id == e.grade.id) return true
                });
                if (dataLoadPage) {
                    harga_satuan = dataLoadPage.price
                    isHargaRecom = 'text-rekom'
                }
            }
            if (!harga_satuan) {
                harga_satuan = 0
            }
            var price = parseFloat(harga_satuan) * parseFloat(e.weight)
            if (!data.is_complete && data.is_ready_print) {
                var stylenya = ''
            } else {
                var stylenya = 'readonly style="background-color:transparent !important"'
            }
            // console.log(harga_satuan)
            html += '<input class="form-control form-control-sm shadow-none border-0 nominal inputHargaSatuan ' + isHargaRecom + '" type="text" placeholder="0" value="' + harga_satuan + '" id="inputHargaSatuan' + a + '" data-id="' + a + '" data-weight="' + e.weight + '" oninput="updatePrice(' + "'" + a + "'" + ')" ' + stylenya + ' >'
            html += '</div>'
            html += '<hr class="m-0">'
            // html += isHargaRecom
            html += '</div>'
            html += '<div class="col-3 text-end align-self-center">'
            html += '<div class="d-flex align-items-center justify-content-between small-text fw-bolder">'
            html += '<span>Rp.</span>'
            html += '<p class="m-0" id="price' + a + '">' + number_format(roundToTwo(price)) + '</p>'
            html += '</div>'
            html += '</div>'
            html += '</div>'
            subTotal += price
            totalBale += e.qty
            totalWeight += e.weight
            unitName = e.unit.name
            a++
        });
        $('#purchaseDetail').html(html)
        $('.nominal').number(true);
        totalAllDetail(data)
    }

    function totalAllDetail(data) {
        var html = ''
        html += '<div class="row">'
        html += '<div class="col-7 text-end">'
        html += '<p class="m-0 small-text">Sub Total</p>'
        html += '</div>'
        html += '<div class="col-5 text-end">'
        html += '<p class="m-0 small fw-bold text-grey-dark">Rp. <span class="subTotalPrice">0</span></p>'
        html += '</div>'
        html += '</div>'
        $('#totalAllDetail').html(html)
        paymentResult(data)
    }

    function paymentResult(data) {
        var html = ''
        html += '<div class="row">'
        html += '<div class="col-7 mb-1">'
        html += '<p class="m-0">Sub Total (' + number_format(totalBale) + ' ' + unitName + ' - ' + number_format(totalWeight) + ' kg)</p>'
        html += '</div>'
        html += '<div class="col-5 mb-1 text-end">'
        html += '<p class="m-0 fw-bold text-grey-dark">Rp. <span class="subTotalPrice">0</span></p>'
        html += '</div>'
        html += '</div>'

        html += '<div class="row" id="fieldPajak">'
        html += '<div class="col-7 mb-1">'
        html += '<p class="m-0">PD 0.5% *</p>'
        html += '<p class="m-0 super-small-text text-danger">* Pajak Daerah 0.5% Ditanggung Supplier</p>'
        html += '</div>'
        html += '<div class="col-5 mb-1 text-end align-self-center">'
        totalPajak = subTotal * nilaiPajak
        html += '<p class="m-0 fw-bold text-grey-dark">- Rp. <span id="numTotalPajak">' + number_format(totalPajak) + '</span></p>'
        html += '</div>'
        html += '</div>'

        html += '<div class="row">'
        html += '<div class="col-12">'
        html += '<hr class="my-3">'
        html += '</div>'
        html += '</div>'

        html += '<div class="row">'
        html += '<div class="col-7 mb-1">'
        html += '<p class="m-0">Total Harga</p>'
        html += '</div>'
        html += '<div class="col-5 mb-1 text-end">'

        html += '<p class="m-0 fw-bolder text-grey-dark">Rp. <span id="totalHarga">0</span></p>'
        html += '</div>'
        html += '</div>'
        $('#paymentResult').html(html)
        subTotalPrice()
    }

    function applyPajakDaerah() {
        var boolean = $('#applyPajakDaerah').is(':checked')
        if (boolean) {
            is_pajak = true
            $('#fieldPajak').prop('hidden', false)
            showNumTotalPajak()
        } else {
            is_pajak = false
            $('#fieldPajak').prop('hidden', true)
        }
        totalHarga(boolean)
    }

    function showNumTotalPajak() {
        totalPajak = subTotal * nilaiPajak
        $('#numTotalPajak').html(number_format(roundToTwo(totalPajak)))
    }

    function applyHargaSatuan() {
        var boolean = $('#applyHargaSatuan').is(':checked')
        if (boolean) {
            is_harga_satuan = true
        } else {
            is_harga_satuan = false
        }
    }

    function totalHarga(is_pajak_active) {
        // console.log(subTotal)
        if (is_pajak_active) {
            totalAll = subTotal - totalPajak
        } else {
            totalAll = subTotal
        }
        $('#totalHarga').html(number_format(roundToTwo(totalAll)))
    }

    function updatePrice(id) {
        var value = $('#inputHargaSatuan' + id).val()
        var weight = $('#inputHargaSatuan' + id).data('weight')
        var price = value * weight
        $('#price' + id).html(number_format(roundToTwo(price)))
        subTotalPrice()
    }

    function subTotalPrice() {
        var total = 0
        $('.inputHargaSatuan').map(function() {
            var id = $(this).data('id')
            var value = $('#inputHargaSatuan' + id).val()
            var price = value * $('#inputHargaSatuan' + id).data('weight')
            total += parseFloat(price)
        });
        subTotal = total
        $('.subTotalPrice').html(number_format(roundToTwo(subTotal)))
        applyPajakDaerah()
    }

    function deleteInvoice(id) {
        Swal.fire({
            text: 'Apakah Anda yakin ingin menghapus Invoice ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                simpanDataHapus(id)
            }
        })
    }

    function closeInvoice(id, is_complete) {
        Swal.fire({
            text: 'Apakah Anda yakin ingin Closing Invoice ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                simpanData(id, is_complete)
            }
        })
    }

    function batalMuat(id) {
        Swal.fire({
            text: 'Apakah Anda yakin ingin Batalkan Muatan untuk Invoice ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                simpanDataBatalMuat(id)
            }
        })
    }

    function simpanData(id, is_complete, is_print = false) {
        var type = 'POST'
        var button = '#btnSimpan'
        var url = '<?php echo api_produksi('setInvoice'); ?>'
        var boolean = $('#applyPajakDaerah').is(':checked')
        var purchase_detail = []
        $('.inputHargaSatuan').each(function() {
            var idDetail = $(this).data('id')
            var value = $('#inputHargaSatuan' + idDetail).val()
            if (value == null) {
                value = 0
            }
            if (value == '') {
                value = null
            }
            var dataDetail = data_detail_invoices.purchase_details[idDetail].data_details
            dataDetail.forEach(e => {
                purchase_detail.push({
                    id: e.purchase_detail_id,
                    price: value,
                    updated_at: currentDateTime(),
                })
            });
        })
        var tax_out_come = null
        if (boolean) {
            tax_out_come = 0.5
        }
        var data = {
            purchase: [{
                id: id,
                tax_out_come: tax_out_come,
                total: totalAll,
                updated_at: currentDateTime(),
                note_purchase: $('#notes_purchase').val(),
            }],
            purchase_detail: purchase_detail,
        }
        if (is_complete) {
            data.purchase[0].is_complete = 1
            data.purchase[0].complete_at = currentDateTime()
            data.purchase[0].user_id_complete = user_id
        }
        if (newNumberInvoice) {
            data.purchase[0].invoice = newNumberInvoice
        }
        kelolaData(data, type, url, button, is_print, id)
    }

    function simpanDataHapus(id) {
        var type = 'POST'
        var button = '#btnHapus'
        var url = '<?php echo api_produksi('setInvoice'); ?>'
        var dataInvoice = data_invoices.dataInvoice.data.find((value, key) => {
            if (value.id == id) return true
        });
        var purchase_detail = []
        dataInvoice.purchase_details.forEach(el => {
            el.data_details.forEach(element => {
                purchase_detail.push(element.purchase_detail_id)
            });
        });
        var data = {
            deletedId: {
                purchaseDetail: purchase_detail,
                purchase: [id]
            }
        }
        // console.log(data)
        kelolaData(data, type, url, button, false, id)
    }

    function simpanDataBatalMuat(id) {
        var type = 'POST'
        var button = '#btnBatalMuat'
        var url = '<?php echo api_produksi('setInvoice'); ?>'
        var data = {
            purchase: [{
                id: id,
                is_ready_print: null,
                ready_print_at: null,
            }],
        }
        kelolaData(data, type, url, button, false, id)
    }

    function kelolaData(data, type, url, button, is_print, id) {
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
                        newNumberInvoice = ''
                        if (button == '#btnHapus') {
                            id_detail_clicked = ''
                            $('#modal').modal('hide')
                        }
                        loadData()
                        if (is_print) {
                            printInvoice(id)
                        }
                    })
                }
            }
        });
    }

    function printInvoice(id) {
        var text = '#INV-' + id
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
        if (data_load_page.userPayment) {
            var name = data_load_page.userPayment.name
        } else {
            var name = admin_name
        }
        eval('var url = "<?= base_url() ?>page/cetakInvoices"')
        var params = "*$" + id + "*$" + name + "*$" + data_detail_invoices.invoice + '*$' + is_pajak + '*$' + is_harga_satuan + '*$' + image
        window.open(url + '?params=' + encodeURIComponent(params), '_blank');
    }

    function editNumberInvoice(invoiceNumber) {
        var html = ''
        if (newNumberInvoice) {
            invoiceNumber = newNumberInvoice
        }
        html += '<input class="form-control form-control-lg p-0 border-0 shadow-none w-100 h3 fw-bold" type="text" autocomplete="off" id="nomorInvoiceManual" value="' + invoiceNumber + '" style="min-height:0px;border-radius:0px;min-width:210px;" oninput="inputNewInvoiceNumber()" onblur="disabledEditNumberInvoice(' + "'" + invoiceNumber + "'" + ')">'
        html += '<hr class="m-0 mt-1">'
        $('#fieldEditInvoiceNumber').html(html)
        $('#nomorInvoiceManual').focus();
        $('#btnEditInvoiceNumber').addClass('d-none');
    }

    function disabledEditNumberInvoice(invoiceNumber) {
        var html = ''
        if (newNumberInvoice) {
            invoiceNumber = newNumberInvoice
        }
        html += '<span class="text-primary-payment" id="invoiceAutoNumber">#' + invoiceNumber + '</span>'
        $('#fieldEditInvoiceNumber').html(html)
        $('#btnEditInvoiceNumber').removeClass('d-none');
    }

    function inputNewInvoiceNumber() {
        var invoiceNumber = $('#nomorInvoiceManual').val()
        newNumberInvoice = invoiceNumber
    }
</script>