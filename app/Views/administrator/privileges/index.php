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
                        <h4>Atur Privilege</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Level</th>
                                        <th>Status</th>
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

<?php echo $this->endsection();?>

<?php echo $this->section('jslibraies')?>
<script src="<?php echo base_url();?>/assets-panel/bundles/datatables/datatables.min.js"></script>
<script src="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
</script>
<script src="<?php echo base_url();?>/assets-panel/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- <script src="<?php echo base_url();?>/assets-panel/js/page/datatables.js"></script> -->
<script src="<?php echo base_url();?>/assets-panel/bundles/sweetalert/sweetalert.min.js"></script>
<!-- Page Specific JS File -->
<script src="<?php echo base_url();?>/assets-panel/js/page/sweetalert.js"></script>

<script type="text/javascript">
var dataTable;

const initDataTable = () => {
    dataTable = $('#table-1').DataTable({
        serverSide: true,
        ordering: true,
        searching: true,
        ajax: {
            url: `<?php echo base_url();?>/api/settings/levels`,
            dataFilter: function(data) {
                var json = jQuery.parseJSON(data);
                json.recordsTotal = json.message.totalRecord;
                json.recordsFiltered = json.message.totalRecord;
                json.data = json.data;
                return JSON.stringify(json); // return JSON string
            },
        },
        columns: [{
                data: "id"
            },
            {
                data: "level"
            },
            {
                data: "status"
            },
            {
                data: function(data) {
                    return `<button  onclick="btnEdit(${data.id})" class="btn btn-info btn-edit">Atur</button>`;

                }
            }
        ],
        scrollY: 200,
        scrollX: 200,
        scroller: {
            loadingIndicator: true
        },
    });
}


const btnEdit = (id) => {
    location.href = `<?php echo base_url('administrator/settings/privileges');?>/config/${id}`;
}

initDataTable();
</script>
<?php echo $this->endSection();?>