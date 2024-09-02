<link href="<?= base_url(); ?>assets/smm/report.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/datatable_custom.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css">
<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>


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
                <h1 class="text-dark fw-bolder m-0" style="font-weight: 900 !important">HISTORY PURCHASE</h1>
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
                                <p class="fw-bolder small-text m-0">Supplier</p>
                                <select class="selectpicker w-100" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 1" id="selectSupplier" title="Pilih Supplier" onchange="arrangeVariable()">
                                </select>
                            </div>
                            <div class="col-auto ps-0">
                                <p class="fw-bolder small-text m-0">Data Profile</p>
                                <select class="selectpicker w-100" data-live-search="true" data-actions-box="true" id="selectDataProfile" onchange="arrangeVariable()">
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
                    </div>
                </div>
            </div>

            <div class="col-12 mb-2">
                <div class="card shadow-none border-radius-20">
                    <div class="card-body">
                        <p class="fw-bolder m-0">Detail</p>
                        <div class="table-responsible" id="dataTable">

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
    var date_start = getFirstDate()
    var date_end = currentDate()
    var itemId = []
    var supplierId = []
    var dataProfile = ''
    var data_user = {}
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
            url: "<?= api_url('loadPageRecapReportPurchase'); ?>",
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
        selectSupplier()
    }

    function selectSupplier() {
        var html = ''
        data_user.supplier.forEach(e => {
            var select = ''
            select = 'selected'
            html += '<option value="' + e.id + '" ' + select + '>' + e.name + '</option>'
        });
        $('#selectSupplier').html(html)
        $('#selectSupplier').selectpicker('refresh');
        $('#selectSupplier').selectpicker({

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
        arrangeVariable()
    }

    function arrangeVariable() {
        itemId = $('#selectItem').map(function() {
            return $(this).val();
        }).get()
        supplierId = $('#selectSupplier').map(function() {
            return $(this).val();
        }).get()
        dataProfile = $('#selectDataProfile').val()
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

    function simpanData() {
        // ----------------------------------------- //
        var type = 'GET'
        var button = '.btnSimpan'
        var url = '<?php echo api_url('getHistoryPurchaseDetail'); ?>'
        var data = {
            dateStart: date_start,
            dateEnd: date_end,
            warehouse_id: warehouse_id,
            itemIds: itemId,
            supplierIds: supplierId,
            dataProfile: dataProfile,
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
                data_report = response.data.history_purchase_detail.data
                if (data_report) {
                    if (data_report.length) {
                        updatedStructure()
                    } else {
                        // tidak ada data
                        $('#dataTable').html(notFoundReturn('Data Tidak Ditemukan'))
                    }
                } else {
                    $('#dataTable').html(notFoundReturn('Data Tidak Ditemukan'))
                }
            }
        });
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
            html += '<th class="align-middle text-center small-text bg-white">Bale Number</th>'
        }
        html += '<th class="align-middle text-center small-text bg-white">Supplier</th>'
        html += '<th class="align-middle text-center small-text bg-white">Item</th>'
        if (dataProfile == 'ITEM GRADE') {
            html += '<th class="align-middle text-center small-text bg-white">Grade</th>'
        }
        html += '<th class="align-middle text-center small-text bg-white">Unit</th>'
        html += '<th class="align-middle text-center small-text bg-white">QTY</th>'
        html += '<th class="align-middle text-center small-text bg-white">Weight</th>'
        html += '<th class="align-middle text-center small-text bg-white">Price</th>'
        html += '<th class="align-middle text-center small-text bg-white">Tax Out Come</th>'
        html += '<th class="align-middle text-center small-text bg-white">Total</th>'
        if (dataProfile == 'DETAIL') {
            html += '<th class="align-middle text-center small-text bg-white">Grade Cutoff</th>'
            html += '<th class="align-middle text-center small-text bg-white">Grade Latest</th>'
        }
        html += '</tr>'
        $('#headTable').html(html)
        bodyTable()
    }

    var total_qty = 0
    var total_weight = 0
    var total_price = 0
    var total_tax_out_come = 0
    var total_total = 0

    function bodyTable() {
        var html = ''
        total_qty = 0
        total_weight = 0
        total_price = 0
        total_tax_out_come = 0
        total_total = 0
        $.each(data_report, function(key, value) {
            if (!value.tax_out_come) {
                value.tax_out_come = 0
            }
            if (!value.price) {
                value.price = 0
            }
            if (!value.total) {
                value.total = 0
            }
            html += '<tr>'
            html += '<td class="bg-white align-middle small-text text-center">' + (parseInt(key) + 1) + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + formatDate(value.datetime) + ' ' + formatTime(value.datetime) + '</td>'
            if (dataProfile == 'DETAIL') {
                html += '<td class="bg-white align-middle small-text text-center">' + value.bale_number + '</td>'
            }
            html += '<td class="bg-white align-middle small-text">' + value.supplier.name + '</td>'
            html += '<td class="bg-white align-middle small-text">' + value.item.code + ' - ' + value.item.name + '</td>'
            if (dataProfile == 'ITEM GRADE') {
                html += '<td class="bg-white align-middle small-text text-center">' + value.grade.name + '</td>'
            }
            html += '<td class="bg-white align-middle small-text text-center">' + value.unit.name + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.qty + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.weight + '</td>'
            html += '<td class="bg-white align-middle small-text text-end">' + number_format(value.price) + '</td>'
            html += '<td class="bg-white align-middle small-text text-end">' + number_format(value.tax_out_come) + '</td>'
            html += '<td class="bg-white align-middle small-text text-end">' + number_format(value.total) + '</td>'
            if (dataProfile == 'DETAIL') {
                var grade_cutoff = ''
                var grade_latest = ''
                if (value.grade_cutoff) {
                    grade_cutoff = value.grade_cutoff.name
                }
                if (value.grade_latest) {
                    grade_latest = value.grade_latest.name
                }
                html += '<td class="bg-white align-middle small-text text-center">' + grade_cutoff + '</td>'
                html += '<td class="bg-white align-middle small-text text-center">' + grade_latest + '</td>'
            }
            html += '</tr>'
            total_qty += parseInt(value.qty)
            total_weight += parseFloat(value.weight)
            total_price += parseFloat(value.price)
            total_tax_out_come += parseFloat(value.tax_out_come)
            total_total += parseFloat(value.total)
        })
        $('#bodyTable').html(html)
        footTable()
    }

    function footTable() {
        var html = ''
        html += '<tr>'
        if (dataProfile == 'ITEM') {
            html += '<th class="bg-white align-middle small-text text-end" colspan="5">Total</th>'
        } else {
            html += '<th class="bg-white align-middle small-text text-end" colspan="6">Total</th>'
        }
        html += '<th class="bg-white align-middle small-text text-center">' + number_format(total_qty) + '</th>'
        html += '<th class="bg-white align-middle small-text text-center">' + number_format(total_weight) + '</th>'
        html += '<th class="bg-white align-middle small-text text-end">' + number_format(total_price) + '</th>'
        html += '<th class="bg-white align-middle small-text text-end">' + number_format(total_tax_out_come) + '</th>'
        html += '<th class="bg-white align-middle small-text text-end">' + number_format(total_total) + '</th>'
        if (dataProfile == 'DETAIL') {
            html += '<th class="bg-white align-middle small-text text-end"></th>'
            html += '<th class="bg-white align-middle small-text text-end"></th>'
        }
        html += '</tr>'
        $('#footTable').html(html)
        $('#tableDetail').DataTable({
            ordering: false, // Menonaktifkan pengurutan
            pageLength: 200,
            scrollY: "600px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedHeader: true,
            paging: false,
            "initComplete": function(settings, json) {
                $('div.dataTables_filter input').attr('placeholder', 'Search...');
            },
        })
    }

    function exportExcel() {
        var url = '<?= base_url('report/excelPurchaseHistory') ?>';
        var params = "*$" + warehouse_id + "*$" + date_start + "*$" + date_end + "*$" + itemId + "*$" + supplierId + "*$" + dataProfile
        window.open(url + '?params=' + encodeURIComponent(params), '_blank');
    }

    function roundToOne(num) {
        return +(Math.round(num + "e+1") + "e-1");
    }
</script>