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
                    <h4>Notifications</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      
                      <table class="table table-hover" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">
                              
                            </th>
                            <th >
                              
                            </th>
                            <th class="hidden-xs">
                              
                            </th>
                            <th class="text-center">
                              
                            </th>
                            <th class="text-center">
                              
                            </th>
                            <th class="text-center">
                             
                            </th>
                            <th class="text-center">
                             
                            </th>
                            <th class="text-center">
                             
                            </th>
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

        function updateRead($id){
          console.log('ya id',$id);
           axios.get(`<?php echo base_url();?>/api/notifications/getUpdateRead/${$id}`).then(
            res => {
                const {
                    data
                } = res.data;
            }).catch(err => {
            console.log(err)
            })
            window.open('<?php echo base_url();?>/notifications/saldo/' + $id, '_blank');
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
          dataTable = $('#table-1').DataTable( {
                serverSide: true,
                ordering: true,
                searching: true,
                ajax:  {
                    url: `<?php echo base_url();?>/api/notifications`, 
                    dataFilter: function(data){
                        var json = jQuery.parseJSON( data );
                        json.recordsTotal = json.message.totalRecord;
                        json.recordsFiltered = json.message.totalRecord;
                        json.data = json.data;            
                        return JSON.stringify( json ); // return JSON string
                    },  
                },                   
                columns: [
                      { data: "id",
                        render: function(data) {
                          return "<a href='<?php echo base_url('/notifications/saldo')?>/" + data + "'> ";
                        }
                      },
                      { data: "read",
                        render: function(data) {
                          if (data == '0'){
                            return "<td class='hidden-xs'><i class='material-icons' style='color: orange; '>star</i></td>";
                          }else{
                            return "<td class='hidden-xs'><i class='material-icons'>star_border</i></td>";
                          }
                        }
                      },
                      { data: "office_name" },
                      {
                        data: "type",
                        render: function(data){

                          return "<span class='badge badge-primary'>" + data + "</span>"
                        }
                      },
                      { data: "message",
                        render : function(data, type, row ){

                          return "<td class='max-texts'><a target='_blank' href='<?php echo base_url('/notifications/saldo')?>/" + row.id + "'>" + data + "</a></td>";
                        }
                      },
                      { data: "read",
                        render: function(data) {
                            return "<td class='hidden-xs'><i class='material-icons'>attach_file</i></td>";
                         
                        }
                      },
                      { data: "date",
                        render: function(data){
                          const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                          
                          date = new Date(data);
                          let month = months[date.getMonth()];
                          
                          return date.getDate() + ' ' + month + ' ' + date.getFullYear() + "</a>";
                        }
                      },
                      {
                        data:function(data){
                          <?php 
                          if(session('user')->username === 'admin' ){?>

                          return    ` <button  onclick="btnDelete(${data.id})" class="btn col-dark-gray waves-effect m-r-20" title="Delete"
                                      data-toggle="tooltip">
                                      <i class="material-icons">delete</i>
                                    </button>  `;
                          <?php }else{ ?>
                            return ' ';
                         <?php } ?>
                        }
                        
                      }
                  ],   
            } );
        }

        const btnDelete = (id)=>{
          axios.get(`<?php echo base_url();?>/api/notifications/view/${id}`).then(res=>{
              swal({
              title: 'Are you sure?',
              text: `Once deleted, you will not be able to recover ${res.data.data.office_name}!`,
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                  axios.get(`<?php echo base_url();?>/api/notifications/deleted/${id}`).then(res=>{
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

        function updateRead($id){
          console.log('ya id',$id);
           axios.get(`<?php echo base_url();?>/api/notifications/getUpdateRead/${$id}`).then(
            res => {
                const {
                    data
                } = res.data;
            }).catch(err => {
            console.log(err)
            })
        }

        initDataTable();
    </script>
<?php echo $this->endSection();?>