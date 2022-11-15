<?php echo $this->extend('layouts/administrator');?>

<?php echo $this->section('csslibraies')?>
  <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<?php echo $this->endSection();?>

<?php echo $this->section('content');?>
<section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Pagukas List</h4>
                    <div class="card-header-action">
                      <a href="#" onclick="openModal()" class="btn btn-info" data-target="#modal-catalog-category" data-toggle="modal">Add</a>
                    </div>
                  </div>
                  <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <!-- <th>Units</th> -->
                                        <th>Units</th>
                                        <th>Saldo</th>
                                        <th>Aksi</th>
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
                <h5 class="modal-title" id="formModal">Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                    <label for="saldo">Menu</label>
                    <select class="form-control" name="office_id" id="office_id">
                            <option value="">Select Units</option>
                            <?php foreach($units as $data){ ?>
                            <option value="<?php echo $data->office_id; ?>"><?php echo $data->office_name; ?></option>
                            </option>
                            <?php  } ?>
                    </select>
                  <input type="hidden" name="office_name" id='office_name' value="">

                </div>
                
                <div class="form-group">
                    <label for="saldo">Menu</label>
                    <input type="text" class="form-control" name="saldo" id="saldo">
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
<script src="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
</script>
<script src="<?php echo base_url();?>/assets-panel/bundles/jquery-ui/jquery-ui.min.js"></script>
<!-- <script src="<?php echo base_url();?>/assets-panel/js/page/datatables.js"></script> -->
<script src="<?php echo base_url();?>/assets-panel/bundles/sweetalert/sweetalert.min.js"></script>
<!-- Page Specific JS File -->
<script src="<?php echo base_url();?>/assets-panel/js/page/sweetalert.js"></script>

 <script type="text/javascript">
        var dataTable;
        const formClear =  ()=>{
          $('#modal-catalog-category').find('[name="id"]').val('');
          $('#modal-catalog-category').find('[name="office_id"]').val('');
           $('#modal-catalog-category').find('[name="office_name"]').val('');
          $('#modal-catalog-category').find('[name="saldo"]').val('');
        }
        const openModal = ()=>{
          formClear();
          
          $('#modal-catalog-category').modal('show');
        }

        $('#upload-file').on('change', function(event){
          $('#modal-catalog-category').find('.btn-save').addClass('d-none');
          let file = event.target.files[0];
          let formData = new FormData();
          formData.append('file', file);
          axios.post(`<?php echo base_url();?>/api/filedrives/upload`, formData).then(res=>{
            let id = res.data.data.id;
            $('#id_file_drive').val(id);
          }).then(res=>{
            $('#modal-catalog-category').find('.btn-save').removeClass('d-none');
          })
        });

        const submitform = (event)=>{
          el = document.getElementById('office_id');
          selectedText = el.options[el.selectedIndex].text;

           var name = document.getElementById('office_name');
           name.value = selectedText;
          
          let office_name = $('#modal-catalog-category').find('[name="office_name"]').val();
              console.log('name', office_name); 
          event.preventDefault();
          let formData = new FormData(event.target);
          let id = $('#modal-catalog-category').find('[name="id"]').val();
          
          if(id === ''){
            axios.post(`<?php echo base_url();?>/api/settings/pagukas/insert`, formData).then(res=>{
                let status = res.data.status;
                let data = res.data.data;
               if(status === 422){
                  let message = Object.values(data)[0];
                  swal('Validasi Inputan', message, 'error');
                  return;
                }
                formClear();
                dataTable.ajax.reload();
                $('#modal-catalog-category').modal('hide');
            });
          }else{
            axios.post(`<?php echo base_url();?>/api/settings/pagukas/updated`, formData).then(res=>{
                let status = res.data.status;
                let data = res.data.data;
                if(status === 422){
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

        const initDataTable = ()=>{
          dataTable = $('#table-1').DataTable( {
                serverSide: true,
                ordering: true,
                searching: true,
                ajax:  {
                    url: `<?php echo base_url();?>/api/settings/pagukas`, 
                    dataFilter: function(data){
                        var json = jQuery.parseJSON( data );
                        json.recordsTotal = json.message.totalRecord;
                        json.recordsFiltered = json.message.totalRecord;
                        json.data = json.data;            
                        return JSON.stringify( json ); // return JSON string
                    },  
                },                   
                columns: [
                      { data: "id" },   
                      // { data: "office_id" },
                      { data: "office_name" },
                      { data: "saldo",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      {
                        data:function(data){
                          return    `   <button  onclick="btnEdit(${data.id})" class="btn btn-info btn-edit">Edit</button>
                                      <button  onclick="btnDelete(${data.id})" class="btn btn-danger btn-delete">Delete</button>`;
                        }
                      }
                  ],   
            } );
        }

        const btnDelete = (id)=>{
          axios.get(`<?php echo base_url();?>/api/settings/pagukas/view/${id}`).then(res=>{
              swal({
              title: 'Are you sure?',
              text: `Once deleted, you will not be able to recover ${res.data.data.office_name}!`,
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                  axios.get(`<?php echo base_url();?>/api/settings/pagukas/deleted/${id}`).then(res=>{
                    swal(`Poof! ${res.data.data.office_name} has been deleted!`, {
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

        const btnEdit = (id)=>{
          axios.get(`<?php echo base_url();?>/api/settings/pagukas/view/${id}`).then(res=>{
            $('#modal-catalog-category').find('[name="id"]').val(res.data.data.id);
            $('#modal-catalog-category').find('[name="office_id"]').val(res.data.data.office_id);
            $('#modal-catalog-category').find('[name="office_name"]').val(res.data.data.office_name);
            $('#modal-catalog-category').find('[name="saldo"]').val(res.data.data.saldo);
            }).then(res=>  $('#modal-catalog-category').modal('show'))
        }

        const btnHistory = (id)=>{
          url = `<?php echo base_url();?>/api/settings/levelshistories?id_price_lm=${id}`;
          dataTableHistory.ajax.url(url).load();
          $('#modal-history').modal('show');
        }

        initDataTable();
    </script>
<?php echo $this->endSection();?>
