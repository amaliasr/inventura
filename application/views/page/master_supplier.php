<link href="<?= base_url(); ?>assets/smm/purchase_order.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/invoice.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
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
    .circular-landscape:hover img {
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
                <h1 class="text-dark fw-bolder mb-2" style="font-weight: 700 !important">Master Supplier</h1>
            </div>
            <div class="col-4 text-end">
                <button type="button" class="btn btn-sm shadow-none btn-outline-primary" onclick="addNewData()"><i class="fa fa-plus me-2"></i>Tambah Baru</button>
                <button type="button" class="btn btn-sm shadow-none btn-outline-dark" onclick="loadData()"><i class="fa fa-refresh"></i></button>
            </div>
            <div class="col-8">
            </div>
            <div class="row me-0 mt-3">
                <div class="col-12 pe-0">
                    <div class="table-responsible" id="dataTable">

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
    var user_id = '<?= $this->session->userdata('id') ?>'
    var warehouse_id = '<?= $this->session->userdata('warehouse_id') ?>'
    var admin_name = '<?= $this->session->userdata('name') ?>'
    var data_master = ""
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
    var linkPhoto = ''
    $(document).ready(function() {
        loadData()
    })

    function loadData() {
        $.ajax({
            url: "<?= api_url('getSupplier'); ?>",
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
                data_master = response.data.supplier
                loadPage()
            }
        })
    }

    function loadPage() {
        $.ajax({
            url: "<?= api_url('loadPageMasterSupplier'); ?>",
            method: "GET",
            dataType: 'JSON',
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
                linkPhoto = response.data.folder.supplier
                dataTable()
            }
        })
    }

    function refresh() {
        loadData()
    }
    var data_pr_showed = []

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
        html += '<th class="align-middle small" style="background-color: white;">Photo</th>'
        html += '<th class="align-middle small" style="background-color: white;">Name</th>'
        html += '<th class="align-middle small" style="background-color: white;">Alias</th>'
        html += '<th class="align-middle small" style="background-color: white;">Address</th>'
        html += '<th class="align-middle small" style="background-color: white;">Created At</th>'
        html += '<th class="align-middle small" style="background-color: white;">Updated At</th>'
        html += '<th class="align-middle small" style="background-color: white;">Phone</th>'
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
        var dataFind = deepCopy(data_master)
        dataFind.forEach(e => {
            html += '<tr>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">' + a++ + '</td>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">'
            if (!e.doc_photo) {
                var pict = '<?= base_url('assets/image/jpg/no_pict.jpg') ?>'
            } else {
                var pict = linkPhoto + '' + e.doc_photo
            }
            //picture
            html += '<div class="circular-landscape" href="' + pict + '" data-fancybox data-caption="Single image">'
            html += '<img src="' + pict + '" class="w-100 h-100 pointer" alt="Supplier Photo">'
            html += '</div>'
            //picture
            html += '</td>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">' + e.name + '</td>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">' + e.alias + '</td>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">' + ifNull(e.address) + '</td>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">' + ifNullDate(e.created_at) + '</td>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">' + ifNullDate(e.updated_at) + '</td>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">' + ifNull(e.phone) + '</td>'
            html += '<td class="px-2 align-middle small-text text-center" style="background-color: white;">'
            html += '<button type="button" class="btn btn-outline-dark btn-sm p-1 small-text" onclick="addNewData(' + "'" + e.id + "'" + ')"><i class="fa fa-pencil"></i></button>'
            html += '</td>'
            html += '</tr>'
        });
        $('#bodyTable').html(html)
        Fancybox.bind("[data-fancybox]", {
            // Your custom options
        });
        footTable()
    }

    function ifNull(data) {
        if (!data) {
            data = ''
        }
        return data
    }

    function ifNullDate(data) {
        if (!data) {
            data = ''
        } else {
            data = getDateTime(data)
        }
        return data
    }

    function footTable() {
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
    }

    function addNewData(id = '') {
        id_detail_clicked = id
        $('#modal').modal('show')
        $('#modalDialog').addClass('modal-dialog modal-dialog-scrollable');
        var html_header = '';
        html_header += '<h5 class="modal-title small">Manage Supplier</h5>';
        html_header += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $('#modalHeader').html(html_header);
        var html_body = '';
        html_body += '<div class="row">'
        html_body += '<div class="col-12" id="bodyInvoice">'
        html_body += '</div>'
        html_body += '</div>'
        $('#modalBody').html(html_body);
        var html_footer = '';
        html_footer += '<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>'
        html_footer += '<button type="button" class="btn btn-primary btn-sm" id="btnSimpan" onclick="simpanData(' + "'" + id + "'" + ')">Simpan</button>'
        $('#modalFooter').html(html_footer);
        bodyInvoice(id)
    }

    function iconPrint() {
        var html = ''
        html += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/></svg>'
        return html
    }
    var newNumberInvoice = ''

    function bodyInvoice(id) {
        var data = data_master.find((value, key) => {
            if (value.id == id) return true
        });
        if (data) {
            var name = ifNull(data.name)
            var alias = ifNull(data.alias)
            var address = ifNull(data.address)
            var phone = ifNull(data.phone)
            var doc_photo = data.doc_photo
            if (!doc_photo) {
                doc_photo = '<?= base_url('assets/image/jpg/no_pict.jpg') ?>'
            } else {
                doc_photo = linkPhoto + '' + doc_photo
            }
        } else {
            var name = ''
            var alias = ''
            var address = ''
            var phone = ''
        }
        var html = ''
        html += '<div class="row justify-content-center p-3 pt-1">'
        if (data) {
            // preview image
            html += '<div class="col-12 text-center mb-3">'
            html += '<img id="previewImage" src="' + doc_photo + '" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover; border-radius: 100px;">'
            html += '<h5 class="m-0 mt-2 fw-bolder">' + name + '</h5>'
            html += '</div>'
            // preview image
        }
        // name
        html += '<div class="col-3 align-self-start mb-2">'
        html += '<p class="m-0 small-text fw-bolder">Name</p>'
        html += '</div>'
        html += '<div class="col-9 align-self-center mb-2">'
        html += '<input type="text" class="form-control form-control-sm" value="' + name + '" id="fillname" autocomplete="off" placeholder="Fill Name" required>'
        html += '</div>'
        // name
        // alias
        html += '<div class="col-3 align-self-start mb-2">'
        html += '<p class="m-0 small-text fw-bolder">Alias</p>'
        html += '</div>'
        html += '<div class="col-9 align-self-center mb-2">'
        html += '<input type="text" class="form-control form-control-sm" value="' + alias + '" id="fillalias" autocomplete="off" placeholder="Fill Alias" required>'
        html += '</div>'
        // alias
        // address
        html += '<div class="col-3 align-self-start mb-2">'
        html += '<p class="m-0 small-text fw-bolder">Address</p>'
        html += '</div>'
        html += '<div class="col-9 align-self-center mb-2">'
        html += '<textarea class="form-control form-control-sm" id="filladdress" rows="3" autocomplete="off" placeholder="Fill Address" required>' + address + '</textarea>'
        html += '</div>'
        // address
        // phone
        html += '<div class="col-3 align-self-start mb-2">'
        html += '<p class="m-0 small-text fw-bolder">Phone</p>'
        html += '</div>'
        html += '<div class="col-9 align-self-center mb-2">'
        html += '<input type="text" class="form-control form-control-sm" value="' + phone + '" id="fillphone" autocomplete="off" placeholder="Fill Phone" required oninput="validatePhoneInput(this)">'
        html += '</div>'
        // phone
        // upload image
        html += '<div class="col-3 align-self-start mb-2">'
        html += '<p class="m-0 small-text fw-bolder">Upload Image</p>'
        html += '</div>'
        html += '<div class="col-9 mb-2">'
        html += '<input type="file" class="form-control form-control-sm" id="fileInput" accept="image/*">'
        html += '</div>'
        // upload image
        if (id) {
            // delete
            html += '<div class="col-12 text-end">'
            html += '<button type="button" class="btn btn-sm small-text p-0 text-danger shadow-none" id="btnHapus" onclick="deleteMaster(' + id + ')">Hapus Data ini ?</button>'
            html += '</div>'
            // delete
        }
        html += '</div>'
        $('#bodyInvoice').html(html)
    }

    function validatePhoneInput(input) {
        // Hapus karakter yang bukan angka
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    function deleteMaster(id) {
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

    function createCodeId() {
        var date = (new Date).getTime()
        return date;
    }

    function generateFileName(file) {
        // Ambil ekstensi file asli
        var extension = file.name.split('.').pop();
        // Buat nama baru berdasarkan datetime
        var now = new Date();
        var formattedDate = now.getFullYear() +
            ('0' + (now.getMonth() + 1)).slice(-2) +
            ('0' + now.getDate()).slice(-2) + "_" +
            ('0' + now.getHours()).slice(-2) +
            ('0' + now.getMinutes()).slice(-2) +
            ('0' + now.getSeconds()).slice(-2);

        return 'photo_' + formattedDate + '.' + extension; // contoh: file_20240913_123456.jpg
    }

    function simpanData(id = null) {
        var fileInput = $('#fileInput')[0];
        if (fileInput.files.length > 0) {
            // Jika ada file, upload gambar dulu
            // Jika ada file, buat nama file baru dengan datetime
            var originalFile = fileInput.files[0];
            var newFileName = generateFileName(originalFile); // Nama file baru
            var renamedFile = new File([originalFile], newFileName, {
                type: originalFile.type
            });
            uploadImage(renamedFile, function(imagePath) {
                // Setelah upload berhasil, lanjutkan menyimpan data supplier
                submitSupplierData(id, imagePath);
            });
        } else {
            // Jika tidak ada gambar, langsung simpan data supplier
            submitSupplierData(id, null);
        }
    }

    function uploadImage(file, callback) {
        var formData = new FormData();
        formData.append('image', file);
        formData.append('folder', 'supplier');

        $.ajax({
            url: '<?php echo api_produksi('doUpload'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Ambil path gambar dari respons
                    var imagePath = file.name; // Sesuaikan dengan respons API
                    callback(imagePath);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal mengupload gambar!'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengupload gambar!'
                });
            }
        });
    }

    function submitSupplierData(id, imagePath) {
        // console.log(imagePath)
        var type = 'POST'
        var button = '#btnSimpan'
        var url = '<?php echo api_produksi('setSupplier'); ?>'
        var data = {
            "supplier": [{
                name: $('#fillname').val(),
                alias: $('#fillalias').val(),
                phone: $('#fillphone').val(),
                address: $('#filladdress').val(),
                updated_at: currentDateTime(),
            }],
        }
        if (imagePath) {
            // Tambahkan path gambar ke data supplier jika ada
            data.supplier[0].doc_photo = imagePath;
        }
        if (!id) {
            data['supplier'][0]['created_at'] = currentDateTime()
        } else {
            data['supplier'][0]['id'] = id
        }
        // Gunakan FormData untuk mengirim JSON dan file gambar (jika ada)
        // var formData = new FormData();
        // formData.append('data', JSON.stringify(data)); // Konversi objek ke JSON string
        kelolaData(data, type, url, button, id, 'add')
    }

    function simpanDataHapus(id) {
        var type = 'POST'
        var button = '#btnHapus'
        var url = '<?php echo api_produksi('setSupplier'); ?>'
        var data = {
            "deletedId": {
                "supplier": [id]
            }
        }
        kelolaData(data, type, url, button, id, 'hapus')
    }


    function kelolaData(data, type, url, button, id, status) {
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
                        var dataRespons = response.data.supplier[0]
                        if (status == 'add') {
                            if (id) {
                                // jika id nya masih ada, maka data_master id itu diganti baru datanya
                                for (var i = 0; i < data_master.length; i++) {
                                    if (data_master[i].id == id) {
                                        data_master[i] = dataRespons
                                    }
                                }
                            } else {
                                // jika id nya tidak ada
                                data_master.push(dataRespons)
                            }
                        } else {
                            // jika hapus, maka menghapus data master di id itu
                            for (var i = 0; i < data_master.length; i++) {
                                if (data_master[i].id == id) {
                                    data_master.splice(i, 1)
                                }
                            }
                        }
                        $(button).prop("disabled", false);
                        id_detail_clicked = ''
                        $('#modal').modal('hide')
                        dataTable()
                    })
                }
            }
        });
    }
</script>