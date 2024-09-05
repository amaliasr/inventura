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
                <h1 class="text-dark fw-bolder m-0" style="font-weight: 900 !important">RECAP WAREHOUSE STOCK</h1>
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
                                <p class="fw-bolder small-text m-0">Data Profile</p>
                                <select class="selectpicker w-100" data-live-search="true" data-actions-box="true" data-selected-text-format="count > 1" id="selectMapping" title="Pilih Tipe Data">
                                    <option value="0" selected>Detail</option>
                                    <option value="1">Summary</option>
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
    var kerangka_mapping = null
    var data_report_mapping = []
    var data_report_mapping_showed = []
    var is_mapping = 0
    var date_start = getFirstDate()
    var date_end = currentDate()
    var selectedChild = []
    var parent = [{
            name: 'QTY',
            variable: 'qty',
        },
        {
            name: 'Weight',
            variable: 'weight',
        }
    ]
    var child = [{
            name: 'Start',
            variable: 'start',
        },
        {
            name: 'Purchase',
            variable: 'purchase',
        },
        {
            name: 'Receive',
            variable: 'receive',
        },
        {
            name: 'Production',
            variable: 'production',
        },
        {
            name: 'Send',
            variable: 'send',
        },
        {
            name: 'Material',
            variable: 'material',
        }, {
            name: 'Adjust In',
            variable: 'adjust_in'
        }, {
            name: 'Adjust Out',
            variable: 'adjust_out'
        }, {
            name: 'End',
            variable: 'end'
        }
    ]
    var childMapping = [{
            name: 'Start',
            variable: 'start',
        }, {
            name: 'IN',
            variable: 'IN',
        },
        {
            name: 'OUT',
            variable: 'IN',
        }, {
            name: 'End',
            variable: 'end'
        }
    ]
    var statusLineFirst = {
        id: 0,
        name: 'All Data',
        selected: true,
        functions: 'countAllData()',
        getData: 'chooseDataAllData()'
    }
    var statusLineVariable = []
    var dataGroup = []
    $(document).ready(function() {
        $('#dataTable').html(emptyReturn('Belum Melakukan Pencarian atau Bisa Langsung Download File'))
        $('select').selectpicker();
        loadData()
    })

    function chooseDataAllData(id = null) {
        if (id == null) {
            var data = data_report_mapping
        } else {
            var data = data_report_mapping.filter((v, k) => {
                if (v.item.id == id) return true
            })
        }
        return data
    }

    function countAllData(id = null) {
        return chooseDataAllData(id).length
    }

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
        setDaterange()
        dateRangeString()

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

    function deepCopy(obj) {
        return JSON.parse(JSON.stringify(obj));
    }

    function simpanData() {
        // ----------------------------------------- //
        var type = 'GET'
        var button = '.btnSimpan'
        var url = '<?php echo api_url('getRecapStock'); ?>'
        var data = {
            dateStart: date_start,
            dateEnd: date_end,
            warehouseId: warehouse_id,
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
                data_report = response.data.recapStock.data
                kerangka_mapping = response.data.mappingMutation
                if (data_report) {
                    if (data_report.length) {
                        arrangeVariable()
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

    function arrangeVariable() {
        is_mapping = $('#selectMapping').val()
        mapping(is_mapping)
    }

    function transformData(data, schema) {
        return data.map(item => {
            const transformQtyOrWeight = (obj) => {
                let transformedObj = {};
                for (let key in schema) {
                    transformedObj[key] = schema[key].reduce((sum, field) => {
                        return sum + (obj[field] || 0);
                    }, 0);
                }
                return transformedObj;
            };

            return {
                item: item.item,
                item_grade: item.item_grade,
                qty: transformQtyOrWeight(item.qty),
                weight: transformQtyOrWeight(item.weight)
            };
        });
    }

    function mapping(is_mapping) {
        dataGroup = []
        statusLineVariable = []
        var data = deepCopy(data_report)
        var ker_mapping = {
            'start': ['start'],
            "IN": [
                "purchase",
                "receive",
                "production",
                "adjust_in"
            ],
            "OUT": [
                "send",
                "material",
                "adjust_out"
            ],
            'end': ['end'],
        }
        if (is_mapping == 1) {
            selectedChild = childMapping
            data_report_mapping = transformData(data, ker_mapping)
        } else {
            selectedChild = child
            data_report_mapping = data
        }
        data_report_mapping_showed = data_report_mapping
        dataGroup = transformDataIntoGroupItem(data_report_mapping)
        var a = 1
        statusLineVariable.push(statusLineFirst)
        dataGroup.forEach(e => {
            statusLineVariable.push({
                id: e.id,
                name: e.code,
                selected: false,
                functions: 'countAllData(' + e.id + ')',
                getData: 'chooseDataAllData(' + e.id + ')'
            })
        });
        statusLine()
    }

    function transformDataIntoGroupItem(data) {
        const result = [];
        const uniqueItems = {};

        data.forEach(entry => {
            const {
                id,
                name,
                code,
                alias
            } = entry.item;

            if (!uniqueItems[id]) {
                uniqueItems[id] = {
                    id,
                    name,
                    code,
                    alias
                };
            }
        });

        for (const key in uniqueItems) {
            result.push(uniqueItems[key]);
        }

        return result;
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
        data_report_mapping_showed = eval(getData)
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
        html += '</div>'
        $('#statusLine').html(html)
        updatedStructure()
    }

    function updatedStructure() {
        dataTable()
    }

    function dataTable() {
        var html = ''
        html += '<table class="table table-bordered table-hover table-sm small w-100" id="tableDetail">'
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
        html += '<th class="align-middle text-center small-text bg-white" rowspan="2">#</th>'
        html += '<th class="align-middle text-center small-text bg-white" rowspan="2">Item</th>'
        html += '<th class="align-middle text-center small-text bg-white" rowspan="2">Grade</th>'
        parent.forEach(e => {
            html += '<th class="align-middle text-center small-text bg-white" colspan="' + selectedChild.length + '">' + e.name + '</th>'
        });

        html += '</tr>'
        html += '<tr>'

        parent.forEach(e => {
            selectedChild.forEach(el => {
                html += '<th class="align-middle text-center small-text bg-white">' + el.name + '</th>'
            })
        })
        html += '</tr>'
        $('#headTable').html(html)
        bodyTable()
    }
    var total = {}

    function bodyTable() {
        var html = ''
        total = {}
        var dataFind = deepCopy(data_report_mapping_showed)
        $.each(dataFind, function(key, value) {
            html += '<tr>'
            html += '<td class="bg-white align-middle small-text text-center">' + (parseInt(key) + 1) + '</td>'
            html += '<td class="bg-white align-middle small-text">' + value.item.code + ' - ' + value.item.name + '</td>'
            html += '<td class="bg-white align-middle small-text text-center">' + value.item_grade.name + '</td>'
            parent.forEach(e => {
                selectedChild.forEach(el => {
                    if (!total[e.variable]) {
                        total[e.variable] = {}
                    }
                    if (!total[e.variable][el.variable]) {
                        total[e.variable][el.variable] = 0
                    }
                    total[e.variable][el.variable] += value[e.variable][el.variable]
                    html += '<td class="bg-white align-middle small-text text-center">' + value[e.variable][el.variable] + '</td>'
                })
            })
            html += '</tr>'
        })
        $('#bodyTable').html(html)
        footTable()
    }

    function footTable() {
        var html = ''
        html += '<tr>'
        html += '<th class="bg-white align-middle small-text text-end"></th>'
        html += '<th class="bg-white align-middle small-text text-end"></th>'
        html += '<th class="bg-white align-middle small-text text-end">Total</th>'
        parent.forEach(e => {
            selectedChild.forEach(el => {
                html += '<th class="bg-white align-middle small-text text-center">' + number_format(total[e.variable][el.variable]) + '</th>'
            })
        });
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
            fixedColumns: {
                left: 3
            },
            "initComplete": function(settings, json) {
                $('div.dataTables_filter input').attr('placeholder', 'Search...');
            },
        })
    }

    function exportExcel() {
        var mappingId = $('#selectMapping').val()
        var url = '<?= base_url('report/excelWarehouseStockRecap') ?>';
        var params = "*$" + warehouse_id + "*$" + date_start + "*$" + date_end + "*$" + mappingId
        window.open(url + '?params=' + encodeURIComponent(params), '_blank');
    }

    function roundToOne(num) {
        return +(Math.round(num + "e+1") + "e-1");
    }
</script>