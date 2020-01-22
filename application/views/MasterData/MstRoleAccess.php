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
                                <th class="sorting text-center sorting_disabled" rowspan="1" colspan="1" style="width: 102px;" aria-label="Action">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>