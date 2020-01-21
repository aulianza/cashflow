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
                        <button onclick="Add()" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button> </div>
                    <div class="col-md-4 pull-right">
                        <div class="input-group">
                            <input type="text" id="search" name="search" class="form-control" placeholder="Cari.." onkeyup="Search()">
                        </div>
                    </div>
                </div>
                <div class="row m-0 table-responsive">
                    <div id="DtUsers_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6"></div>
                            <div class="col-sm-12 col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="DtUsers" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" width="100%" aria-describedby="DtUsers_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="text-center sorting_asc" style="width: 30px;" tabindex="0" aria-controls="DtUsers" rowspan="1" colspan="1" aria-label="No: activate to sort column descending" aria-sort="ascending">No</th>
                                            <th class="text-center sorting" tabindex="0" aria-controls="DtUsers" rowspan="1" colspan="1" style="width: 149px;" aria-label="Full Name: activate to sort column ascending">Full Name</th>
                                            <th class="text-center sorting" tabindex="0" aria-controls="DtUsers" rowspan="1" colspan="1" style="width: 218px;" aria-label="Email: activate to sort column ascending">Email</th>
                                            <th class="text-center sorting" tabindex="0" aria-controls="DtUsers" rowspan="1" colspan="1" style="width: 87px;" aria-label="Username: activate to sort column ascending">Username</th>
                                            <th class="text-center sorting" tabindex="0" aria-controls="DtUsers" rowspan="1" colspan="1" style="width: 93px;" aria-label="Permission: activate to sort column ascending">Permission</th>
                                            <th class="text-center sorting" tabindex="0" aria-controls="DtUsers" rowspan="1" colspan="1" style="width: 53px;" aria-label="Status: activate to sort column ascending">Status</th>
                                            <th class="sorting text-center sorting_disabled" rowspan="1" colspan="1" style="width: 102px;" aria-label="Action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd">
                                            <td class="text-center sorting_1" tabindex="0">1</td>
                                            <td>Administrator</td>
                                            <td></td>
                                            <td>ADMIN</td>
                                            <td class=" text-center">Administrator</td>
                                            <td class=" text-center"><span class="badge badge-pill badge-success">Aktif</span></td>
                                            <td class=" text-center"><button class="btn btn-info btn-icon btn-circle btn-sm assign" title="Assign Complaint" style="margin-right: 5px;">
                                                    <i class="fa fa-exchange" aria-hidden="true"></i>
                                                </button><button class="btn btn-success btn-icon btn-circle btn-sm edit" title="Edit" style="margin-right: 5px;">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </button></td>
                                        </tr>
                                      
                                    </tbody>
                                </table>
                                <div id="DtUsers_processing" class="dataTables_processing card" style="display: none;">Processing...</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="DtUsers_info" role="status" aria-live="polite">Showing 1 to 4 of 4 entries</div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="DtUsers_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled" id="DtUsers_previous"><a href="#" aria-controls="DtUsers" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                                        <li class="paginate_button page-item active"><a href="#" aria-controls="DtUsers" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                                        <li class="paginate_button page-item next disabled" id="DtUsers_next"><a href="#" aria-controls="DtUsers" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        App.init();
    });
</script>