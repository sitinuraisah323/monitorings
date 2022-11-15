<?php echo $this->extend('layouts/administrator');?>

<?php echo $this->section('content');?>

<section class="section">

    <div class="row ">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card card-danger">
                <div class="card-header">
                    <div class="col-lg-3">
                        <select class="form-control" name="area_id" id="area_id">
                            <option value="0">Select Area</option>
                            <?php foreach($areas as $area){ ?>
                            <option value="<?php echo $area->area_id; ?>"><?php echo $area->area; ?></option>
                            </option>
                            <?php  } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" name="branch_id" id="branch_id">
                            <option value="0">Select Cabang</option>
                        </select>
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo session('user')->id ?>" />

                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" name="units_id" id="units_id">
                            <option value="0">Select Units</option>
                        </select>
                    </div>
                    
                </div>
                <div class="card-header">
                  

                    <!-- <div class="col-lg-3">
                        <input type="date" class="form-control" name="dateStart" id="dateStart" value="<?php echo date('Y-m-01') ?>" />
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="dateEnd" id="dateEnd" value="<?php echo date('Y-m-d') ?>" />
                    </div> -->

                    

                </div>
            </div>
        </div>

        <!-- table -->
        <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Data Transaksi</h4>
                    <div class="card-header-action">
                      <a href="#summary-chart" data-tab="summary-tab" class="btn " onclick = "reloadTable1()" id="reload2">Sistem Lama</a>
                      <a href="#summary-text" data-tab="summary-tab" class="btn active" onclick = "reloadTable2()" id="reload1">Sistem Baru</a>
                    </div>
                    
                  </div>
                  <div id = 'message'>

                  <input type='hidden' name='sistem' id='sistem' />
                  </div>
                  <div class="card-body">
                    <div class="summary">

                      <!-- table sistem baru -->
                      <div class="summary-item active" data-tab-group="summary-tab" id="summary-text" >
                        <!-- <div class="col-12">
                <div class="card"> -->
                        <div class="card-header">
                          <h4></h4>
                          <div class="card-header-action">
                            <!-- <a href="#" onclick="openModal()" class="btn btn-info" data-target="#modal-catalog-category" data-toggle="modal">Add</a> -->
                              <!-- <select class="form-control" name="status" id="status">
                                  <option value="FALSE">Select Status</option>
                                  <option value="all">All</option>
                                  <option value="FALSE">Aktif</option>
                                  <option value="TRUE">Lunas</option>
                              </select> -->

                          
                          </div>
                        </div>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          
                          <tr>
                         
                                    <th class="text-righ">CIF</th>
                                    <th class="text-righ">SGE</th>
                                    <th class="text-righ">Tanggal Kredit</th>
                                    <th class="text-righ">Tanggal Tempo</th>
                                    <th class="text-righ">Tanggal Lunas</th>
                                    <th class='text-right'>Taksiran</th>
                                    <th class="text-right">UP</th>
                                    <th class='text-right'></th>
                          </tr>
                       </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  </div>

                      <!-- tabel sis. lama -->
                      <div class="summary-chart " data-tab-group="summary-tab" id="summary-chart">
                        
                        <div class="card-header">
                          <h4></h4>
                          <div class="card-header-action">
                              
                          </div>
                        </div>

                        <div class="card-body">
                          <!-- table -->
                          <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                              <thead>
                                <tr>
                                    <th class="text-righ">CIF</th>
                                    <th class="text-righ">SGE</th>
                                    <th class="text-righ">Tanggal Kredit</th>
                                    <th class="text-righ">Tanggal Tempo</th>
                                    <th class="text-righ">Tanggal Lunas</th>
                                    <th class='text-right'>Taksiran</th>
                                    <th class="text-right">UP</th>
                                    <th class='text-right'></th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              
                            </table>
                          </div>
                        </div>
                        <!-- End table -->
                      </div>
                </div>
              </div>
             


    </div>


</section>

<?php echo $this->endsection();?>

<?php echo $this->section('jslibraies')?>
<script src="<?php echo base_url();?>/assets-panel/bundles/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>/assets-panel/js/modules/dashboard/index.js"></script>
<script src="<?php echo base_url();?>/assets-panel/bundles/datatables/datatables.min.js"></script>
<script src="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
</script>
<script src="<?php echo base_url();?>/assets-panel/bundles/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>/assets-panel/bundles/sweetalert/sweetalert.min.js"></script>


<script type="text/javascript">
var sistem = $('#sistem').val('new');    

  const reloadTable1= () => {
    var sistem = $('#sistem').val('old');    
    dataTable.ajax.reload();
  }
  const reloadTable2= () => {
    var sistem = $('#sistem').val('new'); 
    dataTable1.ajax.reload();
  }

//add
//   $('#reload1').on('click', function() {
//          dataTable.ajax.reload();
//   }
//  $('#reload2').on('click', function() {
//          dataTable1.ajax.reload();
//   }
var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

   var user_id = $('#user_id').val();
    var view_id = 8;
    axios.get(`<?php echo base_url();?>/api/dashboard/getInsertView/${user_id}/${view_id}`).then(
        res => {
            const {
                data
            } = res.data;
        }).catch(err => {
        console.log(err)
    })

      var dataTable;
      var dataTable1;

        $('[name="area_id"]').on('change', function() {
        var area = $(this).val();
        var branch = document.getElementById('branch_id');
        var units = document.getElementById('units_id');
        let array = [];

         $("#branch_id").empty(); 
          $("#units_id").empty(); 
                var opt = document.createElement("option");
                    opt.value = '0';
                    opt.text = 'All';
                    branch.append(opt);
                     $("#units_id").empty(); 
                var opt = document.createElement("option");
                    opt.value = '0';
                    opt.text = 'All';
                    units.appendChild(opt);
        // var url_data = $('#url_get_cabang').val() + '/' + area;
        
        axios.get(`<?php echo base_url();?>/api/dashboard/getBranch/${area}`).then(
            res => {
                const {
                    data
                } = res.data;

                data.forEach(item => {

                    var opt = document.createElement("option");
                    opt.value = item.branch_id;
                    opt.text = item.cabang;
                    branch.appendChild(opt);
                })
            });
             initDataTableJ();
             initDataTable();
    });



    $('[name="branch_id"]').on('change', function() {
        var branch = $(this).val();
        var units = document.getElementById('units_id');
        let array = [];
        
         $("#units_id").empty(); 
                var opt = document.createElement("option");
                    opt.value = '0';
                    opt.text = 'All';
                    units.appendChild(opt);
        // var url_data = $('#url_get_c').val() + '/' + area;
        axios.get(`<?php echo base_url();?>/api/dashboard/getOffice/${branch}`).then(
            res => {
                const {
                    data
                } = res.data;
                data.forEach(item => {
                    var opt = document.createElement("option");
                    opt.value = item.office_id;
                    opt.text = item.name;
                    units.appendChild(opt);
                })
            });

              initDataTableJ();
              initDataTable();
            
    });
    
    $('[name="units_id"]').on('change', function() {
              initDataTableJ();
              initDataTable();
    });

    // $('[name="category"]').on('change', function() {
      
    //   initDataTableJ();
    //   initDataTable();
    // });
    $('[name="dateStart"]').on('change', function() {
              initDataTableJ();
              initDataTable();
    });
    $('[name="dateEnd"]').on('change', function() {
             initDataTableJ();
             initDataTable();
    });

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }
    function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}

function formatNumber(angka) {
    var clean = angka.replace(/\D/g, '');
    return clean;
}

        // ltv > 92%
        const initDataTable = ()=>{
             //
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var tiering = 0;
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
          
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var approval = $('#approval').val();
          var deviasi = $('#deviasi').val();

          var nasabah = $('#nasabah').val();

          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable1 = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,    
                        
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/oneobligor/${area}/${branch}/${units}/${dateStart}/${dateEnd}/${tiering}`, 
                    // type:post,
                    dataFilter: function(data){
                        var json = jQuery.parseJSON(data);
                        json.recordsTotal = json.message.totalRecord;
                        json.recordsFiltered = json.message.totalRecord;
                        json.data = json.data;            
                        return JSON.stringify( json ); // return JSON string
                    },  
                   
                },  
                                 
                columns: [
                      
                      
                      { data: "cif_number", title: "CIF"},
                      { data: "customer_name", title: "Nasabah"},
                      { data: "identity_number", title: "No KTP"},
                      { data: "residence_address", title: "Kota", 
                        // render: function( data, type, row){
                          
                        //   if(data.search(",") == -1){
                        //   return data;
                        //   }else{
                        //   var explode = data.split(",");
                        //    city = explode[3];
                        //   return city;
                        //   }
                        // }
                      },
                      { data: "phone_number", title: "No Handphone"},
                      { data: "noa", title: "Noa"},
                      { data: "up", title: "Total UP",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      
                      {
                        data:function(data){
                          var sistem = $('#sistem').val(); 
                          console.log(sistem);
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('monitoring/oneobligor/detail')?>/" + data.identity_number + "/" +  sistem + "'>Detail</a></td>";
                          // return `   <button  onclick="detailOneobligor(${data.identity_number})" class="btn btn-info btn-edit">Detail</button>
                          //             `;
                        }
                      },
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Oneobligor',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Oneobligor',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Oneobligor',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Oneobligor',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
                  language: {
                      searchPlaceholder: "Masukan Nasabah/KTP/CIF"
                  }
            } );

        
        }

        //Oneobligor',
        const initDataTableJ = ()=>{

           //
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var tiering = $('#tiering').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
          
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var approval = $('#approval').val();
          var deviasi = $('#deviasi').val();

          var nasabah = $('#nasabah').val();

          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable = $('#table-2').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,   
                searchPlaceholder: "By Nasabah/KTP/CIF",           
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/oneobligorGhanet/${area}/${branch}/${units}/${dateStart}/${dateEnd}/${tiering}`, 
                    // type:post,
                    dataFilter: function(data){
                        var json = jQuery.parseJSON(data);
                        json.recordsTotal = json.message.totalRecord;
                        json.recordsFiltered = json.message.totalRecord;
                        json.data = json.data;            
                        return JSON.stringify( json ); // return JSON string
                    },  
                   
                },                   
                columns: [
                      
                      
                      { data: "no_cif", title: "CIF"},
                      { data: "customer_name", title: "Nasabah"},
                      { data: "nik", title: "No KTP"},
                      { data: "city", title: "Kota"},
                      { data: "phone_number", title: "No Handphone"},
                      { data: "noa", title: "Noa"},
                      { data: "up", title: "Total UP",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      
                      {
                        data:function(data){
                          // return `   <button  onclick="detailOneobligor(${data.nik})" class="btn btn-info btn-edit">Detail</button>
                          //             `;
                          var sistem = $('#sistem').val(); 
                          console.log(sistem);
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('monitoring/oneobligor/detail')?>/" + data.nik + "/" +  sistem + "'>Detail</a></td>";

                        }
                      },

                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Oneobligor',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Oneobligor',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Oneobligor',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Oneobligor',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
                  language: {
                      searchPlaceholder: "By Nasabah/KTP/CIF"
                  }
            } );

          
        }

        const detailOneobligor = (identity_number)=>{
          window.open('<?php echo base_url();?>/fraud/detailOneobligor/' + identity_number +'/' + sistem , '_blank');
        }

        const detail = (office_id, date)=>{
          console.log(office_id, date);
          window.open('<?php echo base_url();?>/fraud/detail/' + office_id + '/' + dateEnd, '_blank');
        }
        const detail_frequensi = (office_id, date)=>{
          console.log(office_id, date);
          window.open('<?php echo base_url();?>/fraud/detail_frequensi/' + office_id + '/' + dateEnd, '_blank');
        }

        //Oneobligor',
        const first = ()=>{
         var message = document.getElementById('message');

                var opt = document.createElement("h4");
                    opt.value = 'Data akan muncul setelah difilter !!!';
                    opt.text = 'Data akan muncul setelah difilter !!!';
                    message.append(opt);
                    //  $("#units_id").empty(); 
                // var opt = document.createElement("option");
                //     opt.value = '0';
                //     opt.text = 'All';
                //     units.appendChild(opt);
          
        }


        first();
        // initDataTable();
    </script>

<!-- Add New Javascript -->
<script>
// function chartOs() {
    // Select option
    

        


</script>

<?php echo $this->endSection();

          
?>

