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
                    <h4>Atur Privilege</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>Menu</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php if($menus):?>
                                <?php foreach($menus as $menu):?>
                                    <tr>
                                        <td><?php echo $menu->name;?></td>
                                        <td>
                                            <select onchange="changePrivileges(event)" className="form-control" data-level="<?php echo $idLevel;?>" data-menu="<?php echo $menu->id;?>">
                                               <option value="">--Pilih Hak Access--</option>
                                                <?php foreach(['WRITE'=>'Write','READ'=>'Read','DENIED'=>"Denied"] as $key => $value):?>
                                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif;?>
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
    <script src="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>/assets-panel/bundles/jquery-ui/jquery-ui.min.js"></script>
    <!-- <script src="<?php echo base_url();?>/assets-panel/js/page/datatables.js"></script> -->
    <script src="<?php echo base_url();?>/assets-panel/bundles/sweetalert/sweetalert.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo base_url();?>/assets-panel/js/page/sweetalert.js"></script>

    <script type="text/javascript">
        var dataTable;

        const initData = ()=>{
            axios.get(`<?php echo base_url();?>/api/settings/levelsprivileges?level_id=<?php echo $idLevel;?>`).then(res=>{
                res.data.data.forEach(data=>{
                    $(`[data-menu="${data.menu_id}"]`).val(data.access);
                })
            })
        }

        const changePrivileges = (event)=>{
            const access = event.target.value;
            const level_id = event.target.dataset.level;
            const menu_id =  event.target.dataset.menu;
            const form = new FormData();
            form.append('access',access);
            form.append('level_id',level_id);
            form.append('menu_id',menu_id);
            axios.post(`<?php echo base_url();?>/api/settings/levelsprivileges/insertOrUpdate`,form).then(res=>{
            })
        }

        initData();


    </script>
<?php echo $this->endSection();?>
