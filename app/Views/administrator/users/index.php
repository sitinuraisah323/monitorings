<?php echo $this->extend('layouts/administrator');?>

<?php echo $this->section('csslibraies')?>
<link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/bundles/datatables/datatables.min.css">
<link rel="stylesheet"
    href="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<?php echo $this->endSection();?>

<?php echo $this->section('content');?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User List</h4>
                        <div class="card-header-action">
                            <a href="#" onclick="openModal()" class="btn btn-info" data-target="#modal-catalog-category"
                                data-toggle="modal">Add</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <!-- <th>Name</th> -->
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<form onsubmit="submitform(event)" class="modal fade" id="modal-catalog-category" tabindex="-1" role="dialog"
    aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Form Harga Emas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                    <label for="id_level">Level</label>
                    <select type="text" class="form-control" name="id_level" id="id_level">

                    </select>
                </div>
                <div class="form-group">
                    <label for="first_name">Nama Depan</label>
                    <input type="text" class="form-control" name="first_name" id="first_name">
                </div>
                <div class="form-group">
                    <label for="last_name">Nama Belakang</label>
                    <input type="text" class="form-control" name="last_name" id="last_name">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary m-t-15 waves-effect btn-save">Save</button>
            </div>
        </div>
    </div>
    </div>
</form>
<?php echo $this->endsection();?>

<?php echo $this->section('jslibraies')?>
<script src="<?php echo base_url();?>/assets-panel/bundles/datatables/datatables.min.js"></script>
<script
    src="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
</script>
<script src="<?php echo base_url();?>/assets-panel/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- <script src="<?php echo base_url();?>/assets-panel/js/page/datatables.js"></script> -->
<script src="<?php echo base_url();?>/assets-panel/bundles/sweetalert/sweetalert.min.js"></script>
<!-- Page Specific JS File -->
<script src="<?php echo base_url();?>/assets-panel/js/page/sweetalert.js"></script>

<script type="text/javascript">
var dataTable;
const formClear = () => {
    $('#modal-catalog-category').find('[name="id"]').val("");
    $('#modal-catalog-category').find('[name="username"]').val("");
    // $('#modal-catalog-category').find('[name="first_name"]').val("");
    // $('#modal-catalog-category').find('[name="last_name"]').val("");
    $('#modal-catalog-category').find('[name="email"]').val("");
    $('#modal-catalog-category').find('[name="password"]').val("");
}
const openModal = () => {
    formClear();

    $('#modal-catalog-category').modal('show');
}

$('#upload-file').on('change', function(event) {
    $('#modal-catalog-category').find('.btn-save').addClass('d-none');
    let file = event.target.files[0];
    let formData = new FormData();
    formData.append('file', file);
    axios.post(`<?php echo base_url();?>/api/filedrives/upload`, formData).then(res => {
        let id = res.data.data.id;
        $('#id_file_drive').val(id);
    }).then(res => {
        $('#modal-catalog-category').find('.btn-save').removeClass('d-none');
    })
});

const submitform = (event) => {
    event.preventDefault();
    let formData = new FormData(event.target);
    let id = $('#modal-catalog-category').find('[name="id"]').val();
    if (id === '') {
        axios.post(`<?php echo base_url();?>/api/auth/insert`, formData).then(res => {
            let status = res.data.status;
            let data = res.data.data;
            if (status === 422) {
                let message = Object.values(data)[0];
                swal('Validasi Inputan', message, 'error');
                return;
            }
            formClear();
            dataTable.ajax.reload();
            $('#modal-catalog-category').modal('hide');
        });
    } else {
        axios.post(`<?php echo base_url();?>/api/auth/updated`, formData).then(res => {
            let status = res.data.status;
            let data = res.data.data;
            if (status === 422) {
                let message = Object.values(data)[0];
                swal('Validasi Inputan', message, 'error');
                return;
            }
            formClear();
            dataTable.ajax.reload();
            $('#modal-catalog-category').modal('hide');
        });
    }
}

const initDataTable = () => {
    dataTable = $('#table-1').DataTable({
        serverSide: true,
        ordering: true,
        searching: true,
        ajax: {
            url: `<?php echo base_url();?>/api/auth`,
            dataFilter: function(data) {
                var json = jQuery.parseJSON(data);
                json.recordsTotal = json.message.totalRecord;
                json.recordsFiltered = json.message.totalRecord;
                json.data = json.data;
                return JSON.stringify(json); // return JSON string
            },
        },
        columns: [{
                //     data: "first_name"
                // },
                // {
                data: "username"
            },
            {
                data: "email"
            },
            {
                data: function(data) {
                    return `<button  onclick="btnEdit(${data.id})" class="btn btn-info btn-edit">Edit</button>
                                 <button  onclick="btnDelete(${data.id})"  class="btn btn-danger btn-delete">Hapus</button>`;
                }
            }
        ],
        scrollY: 200,
        scroller: {
            loadingIndicator: true
        },
    });
}

const btnDelete = (id) => {
    axios.get(`<?php echo base_url();?>/api/auth/view/${id}`).then(res => {
        swal({
            title: 'Are you sure?',
            text: `Once deleted, you will not be able to recover ${res.data.data.name}!`,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                axios.get(`<?php echo base_url();?>/api/auth/deleted/${id}`).then(res => {
                    swal(`Poof! ${res.data.data.name} has been deleted!`, {
                        icon: 'success',
                    });
                    dataTable.ajax.reload();
                });
            } else {
                swal('Your imaginary file is safe!');
            }
        });
    })

}

const btnEdit = (id) => {
    axios.get(`<?php echo base_url();?>/api/auth/view/${id}`).then(res => {
        $('#modal-catalog-category').find('[name="id"]').val(res.data.data.id);
        $('#modal-catalog-category').find('[name="username"]').val(res.data.data.username);
        // $('#modal-catalog-category').find('[name="first_name"]').val(res.data.data.first_name);
        // $('#modal-catalog-category').find('[name="last_name"]').val(res.data.data.last_name);
        $('#modal-catalog-category').find('[name="email"]').val(res.data.data.email);
        $('#modal-catalog-category').find('[name="id_level"]').val(res.data.data.id_level);
    }).then(res => $('#modal-catalog-category').modal('show'))
}

axios.get(`<?php echo base_url();?>/api/settings/levels`).then(res => {
    $('[name="id_level"]').append(`<option value="">--Pilih Level--</option>`)
    res.data.data.forEach(data => {
        $('[name="id_level"]').append(`<option value="${data.id}">${data.level}</option>`)
    })
})


initDataTable();
</script>
<?php echo $this->endSection();?>