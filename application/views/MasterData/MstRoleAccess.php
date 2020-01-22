<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item active">Master Role Access</li>
</ol>
<h1 class="page-header">Master Role Access</h1>
<div class="row p-2">
    <div class="col-md-12 px-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-8 pull-left">
                        <button onclick="Add()" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button> </div>
                    <div class="col-md-4 pull-right">
                        <div class="input-group">
                            <input type="text" id="search" name="search" class="form-control" placeholder="Cari.." onkeyup="Search()">
                        </div>
                    </div>
                </div>
                <div class="row m-0 table-responsive">
                    <table id="DtPermission" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" width="100%" aria-describedby="DtUsers_info" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th class="text-center sorting_asc" style="width: 30px;">No</th>
                                <th class="text-center sorting">Permission</th>
                                <th class="text-center sorting">Status</th>
                                <th class="text-center sorting_disabled"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT USER-->
<div class="modal fade" id="MAddEditForm" tabindex="-1" role="dialog" aria-labelledby="edituser" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FAddEditForm" data-parsley-validate="true" data-parsley-errors-messages-disabled onsubmit="return false">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="username">Role Name *</label>
                            <input type="text" class="form-control" name="USERGROUPNAME" id="USERGROUPNAME" placeholder="Role Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fullname">Status *</label>
                            <select class="form-control" name="ISACTIVE" id="ISACTIVE" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <fieldset class="well mb-0">
                        <legend class="well-legend">Menu Access</legend>
                        <div class="row m-0 table-responsive">
                            <table id="DtAccess" class="table table-bordered table-hover dataTable" role="grid" width="100%">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" aria-sort="ascending" style="width: 30px;">No</th>
                                        <th class="sorting">Menu</th>
                                        <th class="sorting">Menu Parent</th>
                                        <th class="sorting"><input type="checkbox" id="vie"> View</th>
                                        <th class="sorting"><input type="checkbox" id="add"> Add</th>
                                        <th class="sorting"><input type="checkbox" id="edi"> Edit</th>
                                        <th class="sorting"><input type="checkbox" id="del"> Delete</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" onclick="Save()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
//    var ADDS = <?php // echo $ACCESS['ADDS'];                       ?>;
//    var EDITS = <?php // echo $ACCESS['EDITS'];                       ?>;
//    var DELETES = <?php // echo $ACCESS['DELETES'];                       ?>;
    var USERNAME = "<?php echo $SESSION->FCCODE; ?>";
    var table, USERGROUPID, ACTION, table2;
    if (!$.fn.DataTable.isDataTable('#DtPermission')) {
        $('#DtPermission').DataTable({
            "processing": true,
            "ajax": {
                "url": "<?php echo site_url('IPermission/ShowData') ?>",
                "contentType": "application/json",
                "type": "POST",
                "data": function () {
                    var d = {};
                    return JSON.stringify(d);
                },
                "dataSrc": function (ext) {
                    if (ext.status == 200) {
                        return ext.result.data;
                    } else if (ext.status == 504) {
                        alert(ext.result.data);
                        location.reload();
                        return [];
                    } else {
                        console.info(ext.result.data);
                        return [];
                    }
                }
            },
            "columns": [{
                    "data": null,
                    "className": "text-center",
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {"data": "USERGROUPNAME"},
                {
                    "data": null,
                    "className": "text-center",
                    "render": function (data, type, row, meta) {
                        var html = '';
                        if (data.ISACTIVE == 1) {
                            html += '<span class="badge badge-pill badge-success">Aktif</span>';
                        } else {
                            html += '<span class="badge badge-pill badge-danger">Tidak Aktif</span>';
                        }
                        return html;
                    }
                },
                {
                    "data": null,
                    "className": "text-center",
                    "render": function (data, type, row, meta) {
                        var html = '';
//                        if (EDITS == 1) {
                        html += '<button class="btn btn-success btn-icon btn-circle btn-sm edit" title="Edit" style="margin-right: 5px;">\n\
                                        <i class="fa fa-edit" aria-hidden="true"></i>\n\
                                     </button>';
//                        }
                        return html;
                    }
                }
            ],
            responsive: {
                details: {
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.hidden ?
                                    '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                    '<td>' + col.title + '</td> ' +
                                    '<td>:</td> ' +
                                    '<td>' + col.data + '</td>' +
                                    '</tr>' :
                                    '';
                        }).join('');
                        return data ? $('<table/>').append(data) : false;
                    }
                }
            },
            "bFilter": true,
            "bPaginate": true,
            "bLengthChange": false,
            "bInfo": true,
            "columnDefs": [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: -1
                }
            ]
        });
        $('#DtPermission thead th').addClass('text-center');
        table = $('#DtPermission').DataTable();
        table.on('click', '.edit', function () {
            $tr = $(this).closest('tr');
            var data = table.row($tr).data();
            $('.modal-title').text('Add Menu Permission');
            $('#USERGROUPNAME').val(data.USERGROUPNAME);
            $('#ISACTIVE').val(data.ISACTIVE);
            USERGROUPID = data.USERGROUPID;
//            LoadDtAccess();
//            $('#FAddEditForm').parsley().reset();
            ACTION = 'EDIT';
            $('.modal-footer .btn-success').text('Update');
            $('#MAddEditForm').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
        $("#DtPermission_filter").remove();
        var Search = function () {
            table.search($('#search').val().toString(), true, false, true).draw();
        };
    }
    var Add = function () {
        $('.modal-title').text('Add Menu Permission');
        $('#USERGROUPNAME').val('');
        $('#ISACTIVE').val(1);
        USERGROUPID = 0;
        LoadDtAccess();
//        $('#FAddEditForm').parsley().reset();
        ACTION = 'ADD';
        $('.modal-footer .btn-success').text('Save');
        $('#MAddEditForm').modal({
            backdrop: 'static',
            keyboard: false
        });
    };
    var LoadDtAccess = function () {
        if (!$.fn.DataTable.isDataTable('#DtAccess')) {
            $('#DtAccess').DataTable({
                "processing": true,
                "ajax": {
                    "url": "<?php echo site_url('IPermission/GetListAccess') ?>",
                    "contentType": "application/json",
                    "type": "POST",
                    "data": function () {
                        var d = {};
                        d.USERGROUPID = USERGROUPID;
                        return JSON.stringify(d);
                    },
                    "dataSrc": function (ext) {
                        if (ext.status == 200) {
                            return ext.result.data;
                        } else if (ext.status == 504) {
                            alert(ext.result.data);
                            location.reload();
                            return [];
                        } else {
                            console.info(ext.result.data);
                            return [];
                        }
                    }
                },
                "columns": [{
                        "data": null,
                        "className": "text-center",
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "MENUNAME"
                    },
                    {
                        "data": "MENUPARENTNAME"
                    },
                    {
                        "data": null,
                        "className": "text-center",
                        "orderable": false,
                        render: function (data, type, row, meta) {
                            if (data.VIEWS == 1) {
                                return '<input type="checkbox" class="views" checked>';
                            } else {
                                return '<input type="checkbox" class="views">';
                            }

                        }
                    },
                    {
                        "data": null,
                        "className": "text-center",
                        "orderable": false,
                        render: function (data, type, row, meta) {
                            if (data.ADDS == 1) {
                                return '<input type="checkbox" class="adds" checked>';
                            } else {
                                return '<input type="checkbox" class="adds">';
                            }
                        }
                    },
                    {
                        "data": null,
                        "className": "text-center",
                        "orderable": false,
                        render: function (data, type, row, meta) {
                            if (data.EDITS == 1) {
                                return '<input type="checkbox" class="edits" checked>';
                            } else {
                                return '<input type="checkbox" class="edits">';
                            }
                        }
                    },
                    {
                        "data": null,
                        "className": "text-center",
                        "orderable": false,
                        render: function (data, type, row, meta) {
                            if (data.DELETES == 1) {
                                return '<input type="checkbox" class="deletes" checked>';
                            } else {
                                return '<input type="checkbox" class="deletes">';
                            }
                        }
                    }
                ],
                responsive: {
                    details: {
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.hidden ?
                                        '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                        '<td>' + col.title + '</td> ' +
                                        '<td>:</td> ' +
                                        '<td>' + col.data + '</td>' +
                                        '</tr>' :
                                        '';
                            }).join('');
                            return data ? $('<table/>').append(data) : false;
                        }
                    }
                },
                "bFilter": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bInfo": false
            });
            table2 = $('#DtAccess').DataTable();
            table2.on('change', '.views', function () {
                $tr = $(this).closest('tr');

                var data = table2.row($tr).data();
                if (this.checked) {
                    data.VIEWS = "1";
                } else {
                    data.VIEWS = "0";
                }
            });
            table2.on('change', '.adds', function () {
                $tr = $(this).closest('tr');

                var data = table2.row($tr).data();
                if (this.checked) {
                    data.ADDS = "1";
                } else {
                    data.ADDS = "0";
                }
            });
            table2.on('change', '.edits', function () {
                $tr = $(this).closest('tr');

                var data = table2.row($tr).data();
                if (this.checked) {
                    data.EDITS = "1";
                } else {
                    data.EDITS = "0";
                }
            });
            table2.on('change', '.deletes', function () {
                $tr = $(this).closest('tr');

                var data = table2.row($tr).data();
                if (this.checked) {
                    data.DELETES = "1";
                } else {
                    data.DELETES = "0";
                }
            });
        } else {
            table2.ajax.reload();
        }
        $('#vie').prop("checked", false);
        $('#add').prop("checked", false);
        $('#edi').prop("checked", false);
        $('#del').prop("checked", false);
    };
    $('#vie').on('change', function () {
        if (this.checked) {
            $('#DtAccess .views').prop("checked", true);
        } else {
            $('#DtAccess .views').prop("checked", false);
        }
        $('#DtAccess .views').change();
    });
    $('#add').on('change', function () {
        if (this.checked) {
            $('#DtAccess .adds').prop("checked", true);
        } else {
            $('#DtAccess .adds').prop("checked", false);
        }
        $('#DtAccess .adds').change();
    });
    $('#edi').on('change', function () {
        if (this.checked) {
            $('#DtAccess .edits').prop("checked", true);
        } else {
            $('#DtAccess .edits').prop("checked", false);
        }
        $('#DtAccess .edits').change();
    });
    $('#del').on('change', function () {
        if (this.checked) {
            $('#DtAccess .deletes').prop("checked", true);
        } else {
            $('#DtAccess .deletes').prop("checked", false);
        }
        $('#DtAccess .deletes').change();
    });
    var Save = function () {
        if ($('#FAddEditForm').parsley().validate()) {
            $("#loader").show();
            $('#FAddEditForm .btn-success').attr('disabled', true);
            var dt = dttable(table2.data());
            $.ajax({
                dataType: "JSON",
                type: "POST",
                url: "<?php echo site_url('IPermission/Save'); ?>",
                data: {
                    DATA: dt,
                    USERGROUPID: USERGROUPID,
                    USERGROUPNAME: $('#USERGROUPNAME').val(),
                    ISACTIVE: $('#ISACTIVE').val(),
                    ACTION: ACTION,
                    USERNAME: USERNAME
                },
                success: function (response) {
                    $("#loader").hide();
                    if (response.status == 200) {
                        swal({
                            title: 'Information',
                            text: response.result.data.toString(),
                            icon: 'success',
                            timer: 2000,
                            button: {
                                visible: true
                            }
                        }).then(function () {
                            $('#MAddEditForm').modal('hide');
                            table.ajax.reload();
                            $('#FAddEditForm .btn-success').removeAttr('disabled');
                        });
                    } else if (response.status == 504) {
                        alert(response.result.data);
                        location.reload();
                    } else {
                        $("#loader").hide();
                        swal({
                            title: 'Information',
                            text: response.result.data.toString(),
                            icon: 'warning',
                            button: {
                                text: 'Close',
                                value: true,
                                visible: true
                            }
                        }).then(function () {
                            $('#FAddEditForm .btn-success').removeAttr('disabled');
                        });
                    }
                },
                error: function (e) {
                    $("#loader").hide();
                    console.info(e);
                    swal({
                        title: 'Error system',
                        text: 'Please contact administrator.',
                        icon: 'error',
                        button: {
                            text: 'Close',
                            value: true,
                            visible: true
                        }
                    }).then(function () {
                        $('#FAddEditForm .btn-success').removeAttr('disabled');
                    });
                }
            });
        }
    };

    function dttable(data) {
        var dt = [];
        for (var index = 0; index < data.length; ++index) {
            if (data[index].MENUCODE == undefined || data[index].MENUCODE == null || data[index].MENUCODE == '') {
            } else {
                dt.push(data[index]);
            }
        }
        return dt;
    }
</script>