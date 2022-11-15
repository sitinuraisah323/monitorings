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
                    <h4>Detail OS</h4>
                    <div class="card-header-action">
                      <!-- <a href="#" onclick="openModal()" class="btn btn-info" data-target="#modal-catalog-category" data-toggle="modal">Add</a> -->
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                           <th class="text-center">Produk</th>
                                    <th class="text-center">Jenis BJ</th>
                                    <!-- <th class="text-center">Code</th> -->
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">CIF</th>
                                    <th class="text-center">SGE</th>
                                    <th class='text-right'>Nasabah</th>
                                    <th class="text-right">Tgl Kredit</th>
                                    <th class='text-right'>Tgl Jatuh Tempo</th>
                                    <th class="text-center">Tgl Lelang</th>
                                    <th class='text-right'> Taksiran</th>
                                    <th class='text-center'>Pinjaman</th>
                                    <th class='text-center'>LTV</th>
                                    <th class='text-center'>Admin</th>
                                    <th class='text-center'> Rate</th>
                                    <!-- <th class='text-center'>Tipe Gadai</th> -->
                                    <!-- <th class='text-center'> Status</th> -->
                                    <th class='text-center'> Tipe Gadai</th>
                                    <th class='text-center' >Description</th>
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
            
            <input type="hidden" name="office_id" id="office_id" value="<?php echo $office_id; ?>" />   
            <input type="hidden" name="date" id="date" value="<?php echo $date; ?>" />            


</section>

<form onsubmit="submitform(event)" class="modal fade" id="modal-catalog-category" tabindex="-1" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
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
                    <label for="level">Level</label>
                    <input type="text" class="form-control" name="level" id="level">
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description">
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
    <script src="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>/assets-panel/bundles/jquery-ui/jquery-ui.min.js"></script>
    <!-- <script src="<?php echo base_url();?>/assets-panel/js/page/datatables.js"></script> -->
    <script src="<?php echo base_url();?>/assets-panel/bundles/sweetalert/sweetalert.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo base_url();?>/assets-panel/js/page/sweetalert.js"></script>

  <script src="<?php echo base_url();?>/assets/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/datatables/export-tables/buttons.flash.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/datatables/export-tables/jszip.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/datatables/export-tables/pdfmake.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/datatables/export-tables/vfs_fonts.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
  <script src="<?php echo base_url();?>/assets/js/page/datatables.js"></script>

    <script type="text/javascript">
        var dataTable;

        function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }

        const formClear =  ()=>{
          $('#modal-catalog-category').find('[name="id"]').val('');
          $('#modal-catalog-category').find('[name="level"]').val('');
          $('#modal-catalog-category').find('[name="description"]').val('');
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
          event.preventDefault();
          let formData = new FormData(event.target);
          let id = $('#modal-catalog-category').find('[name="id"]').val();
          if(id === ''){
            axios.post(`<?php echo base_url();?>/api/settings/levels/insert`, formData).then(res=>{
                let status = res.data.status;
                let data = res.data.data;
                console.log('trans',data);
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
            axios.post(`<?php echo base_url();?>/api/settings/levels/updated`, formData).then(res=>{
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
           
           var office_id = $('#office_id').val();
            var date = $('#date').val();
           let no = 0;
           

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,               
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/detail_os/${office_id}/${date}`, 
                    dataFilter: function(data){
                        var json = jQuery.parseJSON(data);
                        json.recordsTotal = json.message.totalRecord;
                        json.recordsFiltered = json.message.totalRecord;
                        json.data = json.data;            
                        return JSON.stringify( json ); // return JSON string
                    },  
                },                   
                columns: [
                      { data: "product_name" },
                      { data: "insurance_item_name" },
                      // { data: "office_code" },
                      { data: "office_name" },
                      { data: "cif_number" },
                      { data: "sge" },
                      { data: "name" },
                      { data: "contract_date" },
                      { data: "due_date" },
                      { data: "auction_date" },
                      { data: "estimated_value",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "loan_amount",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "angsuran",
                        render: function ( data, type, row ) { 
                          if(row.product_name == 'Gadai Cicilan'){
                            return convertToRupiah(row.angsuran);
                          }else{
                            return '-';
                          }     
                        }
                      },
                      { data: "sisa",
                        render: function ( data, type, row ) { 
                          if(row.product_name == 'Gadai Cicilan'){
                            return convertToRupiah(row.loan_amount - row.angsuran)
                          }else{
                            return convertToRupiah(row.loan_amount);
                          }     
                        }
                      },
                      
                      { data: "ltv",
                        render: function ( data, type, row ) {      
                                return data + '% ';                            
                        }
                      },
                      { data: "admin_fee",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "rate",
                        render: function ( data, type, row ) {      
                                return data + '% ';                            
                        }
                      },

                      
                       { data: "parent_sge",
                        render: function ( data, type, row ) {  
                          if(row.parent_sge){
                            return 'Gadai Ulang';
                          }else{
                            return 'Gadai Baru';
                          }
                          
                        }
                      },
                      
                      { data: "description",
                        render: function ( data, type, row ) {  
                          if(row.notes){
                            return row.notes;
                          }
                          if(row.description){
                            return row.description;
                          }
                        }
                      },
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Detail Outstanding',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Detail Outstanding',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Detail Outstanding',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Detail Outstanding',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
                  
            } );
        
        }

        const btnDelete = (id)=>{
          axios.get(`<?php echo base_url();?>/api/settings/levels/view/${id}`).then(res=>{
              swal({
              title: 'Are you sure?',
              text: `Once deleted, you will not be able to recover ${res.data.data.level}!`,
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                  axios.get(`<?php echo base_url();?>/api/settings/levels/deleted/${id}`).then(res=>{
                    swal(`Poof! ${res.data.data.level} has been deleted!`, {
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
          axios.get(`<?php echo base_url();?>/api/settings/levels/view/${id}`).then(res=>{
            $('#modal-catalog-category').find('[name="id"]').val(res.data.data.id);
            $('#modal-catalog-category').find('[name="level"]').val(res.data.data.level);
            $('#modal-catalog-category').find('[name="description"]').val(res.data.data.description);
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
