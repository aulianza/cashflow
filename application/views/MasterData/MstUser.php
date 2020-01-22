<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item active">Master User</li>
</ol>
<h1 class="page-header">Master User</h1>
<div class="row p-2">
    <div class="col-md-12 px-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-8 pull-left">
                        <button onclick="Add()" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button> 
                    </div>
                    <div class="col-md-4 pull-right">
                        <div class="input-group">
                            <input type="text" id="search" name="search" class="form-control" placeholder="Cari.." onkeyup="Search()">
                        </div>
                    </div>
                </div>
                <div class="row m-0 table-responsive">
                    <table id="DtUsers" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" width="100%" aria-describedby="DtUsers_info" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th class="text-center sorting_asc" style="width: 30px;">No</th>
                                <th class="text-center sorting">Username</th>
                                <th class="text-center sorting">Full Name</th>
                                <th class="text-center sorting">Permission</th>
                                <th class="text-center sorting">Status</th>
                                <th class="text-center sorting">Start Date</th>
                                <th class="text-center sorting">Expired Date</th>
                                <th class="sorting text-center sorting_disabled" style="width: 102px;" aria-label="Action">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="MAddEditForm" tabindex="-1" role="dialog" aria-labelledby="edituser" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FAddEditForm" data-parsley-validate="true" data-parsley-errors-messages-disabled onsubmit="return false" class="m-0">
                <div class="modal-body">
                    <div class="alert alert-danger aulianza-300" role="alert">
                        This is a danger alert—check it out!
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="fccode">Username *</label>
                            <input type="text" class="form-control" name="FCCODE" id="FCCODE" placeholder="Username" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fcpassword">Password *</label>
                            <input type="text" class="form-control" name="FCPASSWORD" id="FCPASSWORD" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="fcfullname">Full Name *</label>
                            <input type="text" class="form-control" name="FCFULLNAME" id="FCFULLNAME" placeholder="Full Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fcpermission">Permission *</label>
                            <input type="text" class="form-control" name="USERGROUPID" id="USERGROUPID" placeholder="Permission" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="startdate">Start Date *</label>
                            <input type="text" class="form-control" name="VALID_FROM" id="VALID_FROM" placeholder="Start Date" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="expireddate">Expired Date *</label>
                            <input type="text" class="form-control" name="VALID_UNTIL" id="VALID_UNTIL" placeholder="Expired Date" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" onclick="Save()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
//    var ADDS = <?php // echo $ACCESS['ADDS'];            ?>;
//    var EDITS = <?php // echo $ACCESS['EDITS'];            ?>;
//    var DELETES = <?php // echo $ACCESS['DELETES'];            ?>;
    var USERNAMEUPDATE = "<?php echo $SESSION->FCCODE; ?>";
    var table;
    if (!$.fn.DataTable.isDataTable('#DtUsers')) {
        $('#DtUsers').DataTable({
            "processing": true,
            "ajax": {
                "url": "<?php echo site_url('IUsers/ShowData') ?>",
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
                {"data": "FCCODE"},
                {"data": "FULLNAME"},
                {"data": "USERGROUPNAME"},
                {
                    "data": "ISACTIVE",
                    "className": "text-center"
                },
                {
                    "data": "VALID_FROM",
                    "className": "text-center"
                },
                {
                    "data": "VALID_UNTIL",
                    "className": "text-center"
                },
                {
                    "data": null,
                    "className": "text-center",
                    "orderable": false,
                    render: function (data, type, row, meta) {
                        var html = '';
//                        if (EDITS == 1 || DELETES == 1 || ADDS == 1) {
//                            html += '<button class="btn btn-info btn-icon btn-circle btn-sm assign" title="Assign Complaint" style="margin-right: 5px;">\n\
//                                       <i class="fa fa-exchange" aria-hidden="true"></i>\n\
//                                     </button>';
//                        }
//                        if (EDITS == 1) {
//                            html += '<button class="btn btn-success btn-icon btn-circle btn-sm edit" title="Edit" style="margin-right: 5px;">\n\
//                                        <i class="fa fa-edit" aria-hidden="true"></i>\n\
//                                     </button>';
//                        }
//                        if (DELETES == 1 && data.USERNAME.toUpperCase() != 'ADMIN') {
//                            html += '<button class="btn btn-danger btn-icon btn-circle btn-sm delete" title="Delete">\n\
//                                        <i class="fa fa-trash" aria-hidden="true"></i>\n\
//                                     </button>';
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
                    targets: 1
                },
                {
                    responsivePriority: 3,
                    targets: -1
                }
            ]
        });
        $('#DtUsers thead th').addClass('text-center');
        table = $('#DtUsers').DataTable();
        table.on('click', '.edit', function () {
            $tr = $(this).closest('tr');
            var data = table.row($tr).data();
            $('.alert').hide();
            $('.modal-title').text('Edit Data Master Users');
            $('#NIK').val(data.NIK);
            $('#USERNAME').val(data.USERNAME);
            $('#FULLNAME').val(data.FULLNAME);
            $('#EMAIL').val(data.EMAIL);
            $('#PASSWORD').val(data.PASSWORD);
            $('#PHONE').val(data.PHONE);
            $('#ROLECODE').val(data.ROLECODE);
            $('#COMPANYCODE').val(data.COMPANYCODE);
            if (data.COMPANYCODE == '' || data.COMPANYCODE == null || data.COMPANYCODE == undefined) {
                $('#COMPANYCODE').val('');
                $('#BUSINESSCODE').val('');
            } else {
                $.ajax({
                    dataType: "JSON",
                    type: "POST",
                    url: "<?php echo site_url('IMstBusiness/DataActive'); ?>",
                    data: {
                        COMPANYCODE: $('#COMPANYCODE').val()
                    },
                    success: function (response) {
                        var html = '';
                        if (response.status == 200) {
                            $.each(response.result.data, function (index, value) {
                                html += '<option value="' + value.BUSINESSCODE + '">' + value.BUSINESSNAME + '</option>';
                            });
                            $(html).insertAfter("#BUSINESSCODE option:first");
                            $('#BUSINESSCODE').val(data.BUSINESSCODE);
                            if (data.COMPANYCODE == '' || data.COMPANYCODE == null || data.COMPANYCODE == undefined) {
                                $('#BUSINESSCODE').val('');
                            }
                        } else if (response.status == 504) {
                            alert(response.result.data);
                            location.reload();
                        } else {
                            swal({
                                title: 'Information',
                                text: response.result.data.toString(),
                                icon: 'warning',
                                button: {
                                    text: 'Close',
                                    value: true,
                                    visible: true
                                }
                            });
                        }
                    },
                    error: function (e) {
                        console.info(e);
                        swal({
                            title: 'Information',
                            text: 'Connection Failed !!!',
                            icon: 'error',
                            button: {
                                text: 'Close',
                                value: true,
                                visible: true
                            }
                        });
                    }
                });
            }
            $('#DIVISIONCODE').val(data.DIVISIONCODE);
            if (data.DIVISIONCODE == '' || data.DIVISIONCODE == null || data.DIVISIONCODE == undefined) {
                $('#DIVISIONCODE').val('');
            }
            $('#SIGNATUR').val(data.SIGNATUR);
            $('#FLAG_ACTIVE').val(data.FLAG_ACTIVE);
            if (data.FLAG_ACTIVE == 1 || data.FLAG_ACTIVE == 2) {
                $('#FLAG_ACTIVE').val(1);
            }
            $('#USERNAME').attr("readonly", "true");
            $('#FAddEditForm').parsley().reset();
            ACTION = 'EDIT';
            $('.modal-footer .btn-success').text('Update');
            $('#MAddEditForm').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
        $("#DtUsers_filter").remove();
        var Search = function () {
            table.search($('#search').val().toString(), true, false, true).draw();
        };
    }
    var Add = function () {
        $('.alert').hide();
        $('.modal-title').text('Add Data Master Users');
        $('#FCCODE').val('');
        $('#FCPASSWORD').val('');
        $('#FULLNAME').val('');
        $('#USERGROUPID').val('');
        $('#ISACTIVE').val('FALSE');
        $('#VALID_FROM').val('');
        $('#VALID_UNTIL').val('');
//        $('#FAddEditForm').parsley().reset();
        $('#FCCODE').removeAttr("readonly");
        $('.modal-footer .btn-success').text('Save');
        ACTION = 'ADD';
        $('#MAddEditForm').modal({
            backdrop: 'static',
            keyboard: false
        });
    };
</script>