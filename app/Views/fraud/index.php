<?php echo $this->extend('layouts/administrator');?>

<?php echo $this->section('content');?>

<section class="section">

    <div class="row ">
      <div id="osCabang" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-12">
                                <div class="card-content">

                                    <div id="chartSelect" style="height: 370px; max-width: 920px; margin: 0px auto;">
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <!-- <img src="<?php echo base_url();?>/assets-panel/img/banner/4.png" alt=""> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    <div class="col-lg-3" >
                        <select class="form-control" name="category" id="category">
                            <option value="0">Select Category</option>
                            <option value="A">LTV</option>
                            <option value="B">Outstanding</option>
                            <option value="C">Ticketsize</option>
                            <option value="D">Frequensi</option>
                            <option value="E">Saldo DPD</option>
                            <option value="F">Modal Kerja</option>
                            <option value="G">Saldo Kas</option>
                            <option value="H">Transaksi Batal</option>
                            <option value="I">Approval</option>
                            <option value="J">Oneobligor</option>
                        </select>

                    </div>
                </div>
                <div class="card-header">
                  <div id="selectTiering" class="col-lg-3" style=" display: none;">
                        <select class="form-control" name="tiering" id="tiering">
                            <option value="0">Select Tiering</option>
                            <option value="A">Up 10rb - 20jt</option>
                            <option value="B">Up 20,01jt - 50jt</option>
                            <option value="C">Up 50,01jt - 100jt</option>
                            <option value="D">Up 100,01jt - 150jt</option>
                            <option value="E">Up 150,01jt - 250jt</option>
                              <option value="F">Up 250,01 - 2M</option>
                        </select>

                    </div>

                <div id="selectFrequensi"  class="col-lg-3" style=" display: none;">
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                            <span class="form-control input-group-text">>=</span>
                      </div>
                        <input type="text" class="form-control text-right"  aria-label="Amount (to the nearest dollar)" id="frequensi" name="frequensi" value='5' placeholder="Angka Frequensi">
                      <div class="input-group-append">
                            <span class="form-control input-group-text">X</span>
                      </div>
                    </div>
                  </div>
                </div>


                <!-- <div id="selectStatus" class="col-lg-3" style=" display: none;">
                        <select class="form-control" name="status" id="status">
                            <option value="all">Select Status </option>
                            <option value="0"> Dibawah Pagukas </option>
                            <option value="1"> Diatas Pagukas </option>
                        </select>
                </div> -->

                <div id="selectNasabah" class="col-lg-3" style=" display: none;">
                        <select class="form-control" name="nasabah" id="nasabah">
                            <option value="all">Select nasabah </option>
                            <!-- <option value="0"> Dibawah Pagukas </option>
                            <option value="1"> Diatas Pagukas </option> -->
                        </select>
                </div>

                <div id="selectStatus"  class="col-lg-3" style=" display: none;">
                  <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                            <span class="form-control input-group-text">Rp</span>
                      </div>
                        <input type="text" class="form-control text-right"  aria-label="Amount (to the nearest dollar)" id="status" name="status" value='30.000.000' placeholder="Rupiah">
                      <!-- <div class="input-group-append">
                            <span class="form-control input-group-text"></span>
                      </div> -->
                    </div>
                  </div>
                </div>

                <div id="selectLimit"  class="col-lg-3" style=" display: none;">
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                            <span class="form-control input-group-text">>=</span>
                      </div>
                        <input type="text" class="form-control text-right"  aria-label="Amount (to the nearest dollar)" id="limit" name="limit" value='5' placeholder="Angka Persentase">
                      <div class="input-group-append">
                            <span class="form-control input-group-text">%</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="selectLimitLtv"  class="col-lg-3" style=" display: none;">
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                            <span class="form-control input-group-text">>=</span>
                      </div>
                        <input type="text" class="form-control text-right"  aria-label="Amount (to the nearest dollar)" id="limitLtv" name="limitLtv" value='92' placeholder="Angka Persentase">
                      <div class="input-group-append">
                            <span class="form-control input-group-text">%</span>
                      </div>
                    </div>
                  </div>
                </div>



                    <div id="selectLimitRp" class="col-lg-3" style=" display: none;">
                        <select class="form-control" name="limitRp" id="limitRp">
                            <option value="0">Select Limit</option>
                            <option value="A"> 0 - 5jt </option>
                            <option value="B"> 5 - 10jt </option>
                            <option value="C"> > 10jt</option>
                            <!-- <option value="D"> > 92%</option>                             -->
                        </select>
                    </div>
                              
                    <div id="selectApproval" class="col-lg-2" style=" display: none;">
                        <select class="form-control" name="approval" id="approval">
    
                            <option value="all">All Approval</option>
                            <option value="0">Cabang</option>
                            <option value="1">Area</option>								
                            <option value="2">Regional</option>
                            <option value="3">Pusat</option>                                            
                        </select>
                    </div>

                    <div id="selectDeviasi"  class="col-lg-2" style=" display: none;">
                        <select class="form-control" name="deviasi" id="deviasi">
                            <option value="all">All Deviasi</option>
                            <option value="0">LTV</option>
                            <option value="1">Sewa</option>								
                            <option value="2">Admin</option>
                            <option value="3">One Obligor</option>
                            <option value="5">Limit Transaksi</option>
                        </select>

                    </div>

                    <div id="selectProduct"  class="col-lg-2" style=" display: none;">
                        <select class="form-control" name="product" id="product">
                            <option value="all">All Product</option>
                            <option value="0">Gadai Reguler</option>
                            <option value="1">Gadai Reguler GHTS</option>
                            <option value="2">Gadai Opsi Bulanan</option>								
                            <option value="3">Gadai Smartphone</option>
                            <option value="4">Gadai Cicilan</option>
                        </select>

                    </div>

                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="dateStart" id="dateStart" value="<?php echo date('Y-m-01') ?>" />
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="dateEnd" id="dateEnd" value="<?php echo date('Y-m-d') ?>" />
                    </div>

                    <!-- <div class="card-header-action">
                        <div id="count" class="dropdown dropdown-list-toggle">
                            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i
                                    data-feather="eye"></i>
                               
                            </a>
                            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                                <div class="dropdown-header">
                                    Dilihat Oleh:
                                    <div class="float-right">
                                    </div>
                                </div>
                                <div class="dropdown-list-content dropdown-list-message">

                                    <?php foreach($view as $views){ 
                                        
                                ?>
                                    <a href="#" class="dropdown-item"> <span class="dropdown-item-desc"> <span
                                                class="message-user"><?php echo $views->username; ?></span>
                                            <span class="time">
                                                <?php //echo $diff->d;?> hari yang lalu
                                            </span>
                                        </span>
                                    </a>
                                    <?php } ?>
                                </div>
                                <div class="dropdown-footer text-center">
                                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
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
                      <!-- <a href="#" onclick="openModal()" class="btn btn-info" data-target="#modal-catalog-category" data-toggle="modal">Add</a> -->
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          
                          <tr>
                             <th class="text-righ">Unit</th>
                                    <th class="text-righ">CIF</th>
                                    <th class="text-righ">SGE</th>
                                    <th class="text-righ">Tanggal Kredit</th>
                                    <th class="text-righ">Tanggal Tempo</th>
                                    <th class="text-righ">Tanggal Lunas</th>
                                    <th class='text-right'>Taksiran</th>
                                    <th class="text-right">UP</th>
                                    <th class='text-right'>Admin</th>
                                    <th class='text-right'>Taksiran</th>
                                    <th class="text-right">UP</th>
                                    <th class='text-right'>Admin</th>
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
             category();
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

              category();
            
    });
    
    $('[name="units_id"]').on('change', function() {
              category();
    });

    $('[name="category"]').on('change', function() {
      
      category();
    });
    $('[name="dateStart"]').on('change', function() {
              category();
    });
    $('[name="dateEnd"]').on('change', function() {
             category();
    });

    $('[name="approval"]').on('change', function() {
              category();
    });
    $('[name="deviasi"]').on('change', function() {
             category();
    });
    $('[name="product"]').on('change', function() {
             category();
    });
    $('[name="limit"]').on('change', function() {
             category();
    });
    $('[name="limitLtv"]').on('change', function() {
             category();
    });
    $('[name="limitRp"]').on('change', function() {
             category();
    });
    $('[name="frequensi"]').on('change', function() {
             category();
    });
    $('[name="status"]').on('change', function() {
             category();
    });
     $('[name="tiering"]').on('change', function() {
             category();
    });
    

     function approval(){
      var approval = document.getElementById('selectApproval');
        approval.style.display = "inline";
    }
    function removeApproval(){
      var approval = document.getElementById('selectApproval');
        approval.style.display = "none";
    }
    function deviasi(){
      var deviasi = document.getElementById('selectDeviasi');
        deviasi.style.display = "inline";
    }
    function removeDeviasi(){
      var deviasi = document.getElementById('selectDeviasi');
        deviasi.style.display = "none";
    }
    function product(){
      var product = document.getElementById('selectProduct');
        product.style.display = "inline";
    }
    function removeProduct(){
      var product = document.getElementById('selectProduct');
        product.style.display = "none";
    }
    function limit(){
      var limit = document.getElementById('selectLimit');
        limit.style.display = "inline";
    }
    function removeLimit(){
      var limit = document.getElementById('selectLimit');
        limit.style.display = "none";
    }
    function limitLtv(){
      var limit = document.getElementById('selectLimitLtv');
        limit.style.display = "inline";
    }
    function removeLimitLtv(){
      var limit = document.getElementById('selectLimitLtv');
        limit.style.display = "none";
    }
    function limitRp(){
      var limitRp = document.getElementById('selectLimitRp');
        limitRp.style.display = "inline";
    }
    function removeLimitRp(){
      var limitRp = document.getElementById('selectLimitRp');
        limitRp.style.display = "none";
    }
    function frequensi(){
      var frequensi = document.getElementById('selectFrequensi');
        frequensi.style.display = "inline";
    }
    function removeFrequensi(){
      var frequensi = document.getElementById('selectFrequensi');
        frequensi.style.display = "none";
    }
    function status(){
      var status = document.getElementById('selectStatus');
        status.style.display = "inline";
    }
    function removeStatus(){
      var status = document.getElementById('selectStatus');
        status.style.display = "none";
    }
    function tiering(){
      var tiering = document.getElementById('selectTiering');
        tiering.style.display = "inline";
    }
    function removeTiering(){
      var tiering = document.getElementById('selectTiering');
        tiering.style.display = "none";
    }

    function removeGrafik(){
      var osCabang = document.getElementById('osCabang');
        osCabang.style.display = "none";
    }

    function category(){
      if($('#category').val()=='A'){  removeApproval(); removeDeviasi(); removeProduct(); removeFrequensi(); removeStatus(); removeTiering(); removeLimit();
         limitLtv(); 
         removeGrafik(); getLtv(); initDataTable();}
       else if($('#category').val()=='B'){ removeApproval(); removeDeviasi(); removeProduct(); removeFrequensi(); removeStatus(); removeTiering(); removeLimitLtv(); 
        limit(); 
        removeGrafik(); getOs(); initDataTableB(); }
       else if($('#category').val()=='C'){ removeApproval(); removeDeviasi(); removeProduct(); removeLimit(); removeLimitLtv(); removeStatus(); removeFrequensi(); removeTiering(); removeGrafik(); getTicketsize(); initDataTableC();}
       else if($('#category').val()=='D'){ removeApproval(); removeDeviasi(); removeProduct(); removeLimit(); removeLimitLtv(); removeStatus(); removeTiering(); frequensi(); removeGrafik();  initDataTableD();}
       else if($('#category').val()=='E'){ removeApproval(); removeDeviasi(); removeProduct(); removeFrequensi(); removeStatus(); removeTiering(); removeLimitLtv();
        limit(); 
        removeGrafik(); getDpd(); initDataTableE();}
       else if($('#category').val()=='F'){ removeApproval(); removeDeviasi(); removeProduct(); removeLimit(); removeLimitLtv(); removeFrequensi(); removeStatus(); removeTiering(); removeGrafik(); getMoker(); initDataTableF();}
       else if($('#category').val()=='G'){ removeApproval(); removeDeviasi(); removeProduct(); removeLimit(); removeLimitLtv(); removeFrequensi(); removeTiering(); removeGrafik(); status();  getSaldo(); initDataTableG();}
       else if($('#category').val()=='H'){ removeApproval(); removeDeviasi(); removeProduct(); removeLimit(); removeLimitLtv(); removeFrequensi(); removeStatus(); removeTiering(); removeGrafik(); getTrxBatal(); initDataTableH();}
       else if($('#category').val()=='I'){ removeLimit(); removeFrequensi(); removeStatus(); removeLimitLtv(); removeTiering(); approval(); deviasi(); product(); removeGrafik(); getApproval(); initDataTableI();}
       else if($('#category').val()=='J'){ removeLimit(); removeFrequensi(); removeStatus(); removeLimitLtv(); removeApproval(); removeDeviasi(); removeProduct(); tiering(); removeGrafik();  initDataTableJ();}      
       else{ removeApproval(); removeDeviasi(); removeProduct(); removeLimit(); removeLimitLtv(); removeFrequensi(); removeStatus(); removeTiering(); removeGrafik(); initDataTable();}
    }

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
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           
           var limit = $('#limitLtv').val();
          //  if(limit == NULL){
          //   limit = 'all';
          //  }
          console.log(limit);
          console.log(dateEnd);

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/fraud/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limit}`, 
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
                      
                      { data: "area_id", title: "PT", 
                        render: function ( data, type, row ) {
                            if(data == "61611e1d8614149f281503a8" ){
                                return 'GHTS';
                            }
                            if(data == "60c6befbe64d1e2428630162" ){
                                return 'GCDA';
                            }
                            if(data == "60c6bfcce64d1e242863024a" ){
                                return 'GCAM';
                            }
                            if(data == "62280b69861414b1beffc464" ){
                                return 'GJRM';
                            }
                            if(data == "60c6bfa6e64d1e2428630213" ){
                                return 'GCTA';
                            }
                            if(data == "60c6bf2ce64d1e2428630199" ){
                                return 'GTAM III';
                            }
                            if(data == "60c6bf63e64d1e24286301d9" ){
                                return 'GTAM II';
                            }
                            if(data == "6296cca7861414086c6ba4d4" ){
                                return 'GTAM I';
                            }                            
                        }
                      },
                      { data: "office_name", title: "Unit",  },
                      { data: "month", title: "Month",
                        render: function( data, type, row ) {
                          return months[data-1];
                        }
                      },
                      { data: "year", title: "Year",  },
                      { data: "total", title: "Jumlah Trx",  },
                       {  title: 'Aksi', width: "15", 
                        data:function(data){
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('fraud/detailFraud')?>/" + data.office_id + "/" +  data.month + "/" +  data.year + "/" +  data.limit + "'>Detail</a></td>";
                        }
                      },
                       { data: "total", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "total", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "total", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "total", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "total", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "total", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                     
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Montly - LTV',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Montly - LTV',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Montly - LTV',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Montly - LTV',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
            } );
        
        }

        // kenaikan OS > 5%
        const initDataTableB = ()=>{
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var limit = $('#limit').val();

          console.log(limit, 'limit');
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/outstanding/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limit}`, 
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
                      
                      { data: "unit", title: "Unit"},
                      { data: "month", title: "Month",
                        render: function( data, type, row ) {
                          return months[data-1];
                        }
                      },
                      { data: "year", title: "Year" },
                      { data: "noa_1", title: "Noa Sebelumnya " ,
                        render: function ( data, type, row ) {      
                                return convertToRupiah(data);                            
                        }
                      },
                      { data: "os_1", title: "Os Sebelumnya ",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "noa", title: "Noa  ",
                        render: function ( data, type, row ) {      
                                return  convertToRupiah(data);                            
                        }
                      },
                      { data: "os", title: "Outstanding  ",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "persentase", title: "Persentase",
                        render: function(data, type, row){
                          return row.persentase.toFixed(2) + " %";
                        }
                      },
                      {  title: 'Aksi', 
                        data:function(data){
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('fraud/detail')?>/" + data.office_id + "/" +  data.date + "'>Detail</a></td>";
                        }
                      },
                      { data: "os", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "os", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "os", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      
                      
                      
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Outstanding',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Outstanding',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Outstanding',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Outstanding',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
            } );
        
        }

        // TicketSize 
        const initDataTableC = ()=>{
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var limitRp = $('#limitRp').val();

          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/ticketsize/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limitRp}`, 
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
                      
                      { data: "area_id", title: "PT",
                        render: function ( data, type, row ) {
                            if(data == "61611e1d8614149f281503a8" ){
                                return 'GHTS';
                            }
                            if(data == "60c6befbe64d1e2428630162" ){
                                return 'GCDA';
                            }
                            if(data == "60c6bfcce64d1e242863024a" ){
                                return 'GCAM';
                            }
                            if(data == "62280b69861414b1beffc464" ){
                                return 'GJRM';
                            }
                            if(data == "60c6bfa6e64d1e2428630213" ){
                                return 'GCTA';
                            }
                            if(data == "60c6bf2ce64d1e2428630199" ){
                                return 'GTAM III';
                            }
                            if(data == "60c6bf63e64d1e24286301d9" ){
                                return 'GTAM II';
                            }
                            if(data == "6296cca7861414086c6ba4d4" ){
                                return 'GTAM I';
                            }                            
                        }
                      },
                      { data: "office_name", title: "Unit" },
                      { data: "month", title: "Month",
                        render: function( data, type, row ) {
                          return months[data-1];
                        }
                      },
                      { data: "year", title: "Year" },
                      { data: "noa", title: " Noa" },
                      { data: "up", title: "UP",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "ticketsize", title: " Ticketsize" ,
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                       {  title: 'Aksi', 
                        data:function(data){
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('fraud/detailTicketsize')?>/" + data.office_id + "/" +  data.month + "/" +  data.year + "'>Detail</a></td>";
                        }
                      },
                      { data: "ticketsize", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "ticketsize", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "ticketsize", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "ticketsize", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      
                      
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Ticketsize',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Ticketsize',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Ticketsize',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Ticketsize',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
            } );
        
        }

         // frequensi transactions 
        const initDataTableD = ()=>{
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var frequensi = $('#frequensi').val();
          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/frequensi/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${frequensi}`, 
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
                  
                  { data: "area_id", title: "PT",
                        render: function ( data, type, row ) {
                            if(data == "61611e1d8614149f281503a8" ){
                                return 'GHTS';
                            }
                            if(data == "60c6befbe64d1e2428630162" ){
                                return 'GCDA';
                            }
                            if(data == "60c6bfcce64d1e242863024a" ){
                                return 'GCAM';
                            }
                            if(data == "62280b69861414b1beffc464" ){
                                return 'GJRM';
                            }
                            if(data == "60c6bfa6e64d1e2428630213" ){
                                return 'GCTA';
                            }
                            if(data == "60c6bf2ce64d1e2428630199" ){
                                return 'GTAM III';
                            }
                            if(data == "60c6bf63e64d1e24286301d9" ){
                                return 'GTAM II';
                            }
                            if(data == "6296cca7861414086c6ba4d4" ){
                                return 'GTAM I';
                            }
                            
                        }
                        },
                      { data: "office_name", title: "Unit" },
                      { data: "month", title: "Month",
                        render: function( data, type, row ) {
                          return months[data-1];
                        }
                      },
                      { data: "year", title: "Year" },
                      { data: "cif_number", title: "No CIF" },
                      { data: "name", title: "Nasabah" },
                      { data: "identity_number", title: "KTP" },
                      // { data: "phone_number", title: "No Handphone" },
                      { data: "noa", title: "Total trx" },
                      { data: "up", title: "Total UP",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      
                      {
                        data:function(data){
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('fraud/detail_frequensi')?>/" + data.office_id + "/" +  data.identity_number + "/" +  data.month + "/" +  data.year + "'>Detail</a></td>";
                          // return `   <button  onclick="detail_frequensi(${data.identity_number})" class="btn btn-info btn-edit">Detail</button>
                          //             `;
                        }
                      },
                      
                      { data: "up", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "up", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      
                      
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Frequensi Transaksi',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Frequensi Transaksi',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Frequensi Transaksi',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Frequensi Transaksi',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
            } );
        
        }

         // kenaikan DPD > 5%
        const initDataTableE = ()=>{
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var limit = $('#limit').val();
          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/dpd/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limit}`, 
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
                      
                      { data: "unit", title: "Unit"},
                      { data: "month", title: "Month",
                        render: function( data, type, row ) {
                          return months[data-1];
                        }
                      },
                      { data: "year", title: "Year" },
                      { data: "noa_os", title: "Noa OS " ,
                        // render: function ( data, type, row ) {      
                        //         return convertToRupiah(data);                            
                        // }
                      },
                      { data: "outstanding", title: "Outstanding ",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "noa_1", title: "Noa Sebelumnya " ,
                        render: function ( data, type, row ) {      
                                return convertToRupiah(data);                            
                        }
                      },
                      { data: "os_1", title: "DPD Sebelumnya ",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "noa", title: "Noa  ",
                        render: function ( data, type, row ) {      
                                return  convertToRupiah(data);                            
                        }
                      },
                      { data: "os", title: "DPD  ",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      { data: "persentase_os", title: "% ( trhdp OS )",
                        render: function(data, type, row){
                          return row.persentase_os.toFixed(2) + " %";
                        }
                      },
                       { data: "persentase", title: "% ( trhdp dpd sblmnya )",
                        render: function(data, type, row){
                          return row.persentase.toFixed(2) + " %";
                        }
                      },
                      {  title: 'Aksi', 
                        data:function(data){
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('fraud/detail_dpd')?>/" + data.office_id + "/" +  data.date + "'>Detail</a></td>";
                        }
                      },
                      
                      
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - DPD',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - DPD',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - DPD',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - DPD',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
            } );
        
        }

         // Moker 
        const initDataTableF = ()=>{
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/moker/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}`, 
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
                      
                      { data: "area_name", title: "PT"},
                      { data: "office_name", title: "Unit "},
                      { data: "month", title: "Month ",
                        render: function( data, type, row ) {
                          return months[data-1];
                        }
                      },
                      { data: "year", title: "Year"},
                      {  data: "moker", title: "Total Moker",
                        render: function ( data, type, row ) {      
                                return "<td class='text-right'>Rp " + convertToRupiah(data) + "</td>";                            
                        }
                      },
                      {  data: "jumlah", title: "Jumlah (x)",
                       
                      },
                      
                      {  title: 'Aksi', 
                        data:function(data){
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('fraud/detailMoker')?>/" + data.office_id + "/" +  data.month + "/" +  data.year + "'>Detail</a></td>";
                        }
                      },
                       { data: "moker", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                       { data: "moker", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "moker", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "moker", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "moker", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      
                      
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Modal Kerja',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Modal Kerja',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Modal Kerja',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Modal Kerja',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
            } );
        
        }

  

         // Saldo Kas 
        const initDataTableG = ()=>{
          var saldolimit = 0;
          var status = document.getElementById('status');
          status.addEventListener('keyup', function(e) {
            var saldo = document.getElementById('status');
            saldo.value = formatRupiah(saldo.value);

            var saldolimit = $("#status").val();

            if (saldolimit) {
                saldolimit = formatNumber(saldolimit);
            } else {
                saldolimit = 0;
            }
            console.log('Saldo',saldolimit);
              
          });
          var saldolimit = $("#status").val();

            if (saldolimit) {
                saldolimit = formatNumber(saldolimit);
            } else {
                saldolimit = 0;
            }
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var status = $('#status').val();
           
          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable = $('#table-1').DataTable( {
                ordering: true,
                dom: 'Bfrtip', 
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/saldokas/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${saldolimit}`, 
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
                      
                      { data: "area_id", title: "PT", 
                        render: function ( data, type, row ) {
                            if(data == "61611e1d8614149f281503a8" ){
                                return 'GHTS';
                            }
                            if(data == "60c6befbe64d1e2428630162" ){
                                return 'GCDA';
                            }
                            if(data == "60c6bfcce64d1e242863024a" ){
                                return 'GCAM';
                            }
                            if(data == "62280b69861414b1beffc464" ){
                                return 'GJRM';
                            }
                            if(data == "60c6bfa6e64d1e2428630213" ){
                                return 'GCTA';
                            }
                            if(data == "60c6bf2ce64d1e2428630199" ){
                                return 'GTAM III';
                            }
                            if(data == "60c6bf63e64d1e24286301d9" ){
                                return 'GTAM II';
                            }
                            if(data == "6296cca7861414086c6ba4d4" ){
                                return 'GTAM I';
                            }                            
                        }
                        },
                      { data: "office_name", title: "Unit "},
                      { data: "office_code", title: "Code "},
                      { data: "date_open", title: "Date"},
                      { data: "saldo", title: "Pagukas", 
                        render: function ( data, type, row ) {      
                                return "<td class='text-right'>Rp " + convertToRupiah(data) + "</td>";                            
                        }
                      },
                      {  data: "remaining_balance", title: "Saldo Akhir", 
                        render: function ( data, type, row ) {      
                                return "<td class='text-right'>Rp " + convertToRupiah(data) + "</td>";                            
                        }
                      },

                      { data: "status", title: "Status",
                        render: function ( data, type, row ) {  
                          if(data == 0){
                            return "<div class='badge badge-info badge-shadow'>Dibawah</div>";
                          }else{    
                            return "<div class='badge badge-danger badge-shadow'>Diatas</div>";                            
                          }
                        }
                      },
                      
                      { data: "percentase", title: "Percentase", 
                        render: function ( data, type, row ) {      
                                return data.toFixed(2) + "%";                            
                        }
                      },
                      { data: "percentase", title: "",
                        render: function(data, type, row){
                          return " ";
                        }
                      },
                      { data: "percentase", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "percentase", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "percentase", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      
                      
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Saldo Kas',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Saldo Kas',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Saldo Kas',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Saldo Kas',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
            } );
        
        }

        // Transaksi Batal
        const initDataTableH = ()=>{
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
          console.log(dateStart);
          console.log(dateEnd);

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/trxBatal/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}`, 
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
                      
                      // { data: "office_name", title: "No"},
                      { data: "area_id", title: "PT",
                        render: function ( data, type, row ) {
                            if(data == "61611e1d8614149f281503a8" ){
                                return 'GHTS';
                            }
                            if(data == "60c6befbe64d1e2428630162" ){
                                return 'GCDA';
                            }
                            if(data == "60c6bfcce64d1e242863024a" ){
                                return 'GCAM';
                            }
                            if(data == "62280b69861414b1beffc464" ){
                                return 'GJRM';
                            }
                            if(data == "60c6bfa6e64d1e2428630213" ){
                                return 'GCTA';
                            }
                            if(data == "60c6bf2ce64d1e2428630199" ){
                                return 'GTAM III';
                            }
                            if(data == "60c6bf63e64d1e24286301d9" ){
                                return 'GTAM II';
                            }
                            if(data == "6296cca7861414086c6ba4d4" ){
                                return 'GTAM I';
                            }                            
                        }
                      },
                      { data: "office_name", title: "Unit" },
                      { data: "month", title: "Month",
                        render: function( data, type, row ) {
                          return months[data-1];
                        }
                      },
                      { data: "year", title: "Year" },
                      { data: "up", title: "Total Pinjaman",
                        render: function ( data, type, row ) {      
                                return "<td class='text-right'>Rp " + convertToRupiah(data) + "</td>";                            
                        }
                      },
                      { data: "total", title: "Jumlah Trx" },
                      
                       {  title: 'Aksi', 
                        data:function(data){
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('fraud/detailTrxBatal')?>/" + data.office_id + "/" +  data.month + "/" +  data.year + "'>Detail</a></td>";
                        }
                      },
                      
                      { data: "year", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "year", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "year", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "year", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "year", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Pembatalan Transaksi',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Pembatalan Transaksi',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Pembatalan Transaksi',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Pembatalan Transaksi',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
            } );
        
        }

         //  Deviasi & Approval
        const initDataTableI = ()=>{
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
          
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var approval = $('#approval').val();
          var deviasi = $('#deviasi').val();
          var product = $('#product').val();

          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

          dataTable = $('#table-1').DataTable( {
                // serverSide: true,
                ordering: true,
                // searching: true,
                dom: 'Bfrtip', 
                // pageLength: 25,  
                bDestroy: true,             
                ajax:  {
                    url: `<?php echo base_url();?>/api/transactions/fraud/approval/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${approval}/${deviasi}/${product}`, 
                    // type:post,
                    // data:{approval:approval, deviasi:deviasi},
                    dataFilter: function(data){
                        var json = jQuery.parseJSON(data);
                        json.recordsTotal = json.message.totalRecord;
                        json.recordsFiltered = json.message.totalRecord;
                        json.data = json.data;            
                        return JSON.stringify( json ); // return JSON string
                    },  
                    
                },                   
                columns: [
                  
                  { data: "area_id", title: "PT",
                        render: function ( data, type, row ) {
                            if(data == "61611e1d8614149f281503a8" ){
                                return 'GHTS';
                            }
                            if(data == "60c6befbe64d1e2428630162" ){
                                return 'GCDA';
                            }
                            if(data == "60c6bfcce64d1e242863024a" ){
                                return 'GCAM';
                            }
                            if(data == "62280b69861414b1beffc464" ){
                                return 'GJRM';
                            }
                            if(data == "60c6bfa6e64d1e2428630213" ){
                                return 'GCTA';
                            }
                            if(data == "60c6bf2ce64d1e2428630199" ){
                                return 'GTAM III';
                            }
                            if(data == "60c6bf63e64d1e24286301d9" ){
                                return 'GTAM II';
                            }
                            if(data == "6296cca7861414086c6ba4d4" ){
                                return 'GTAM I';
                            }
                            
                        }
                        },
                        { data: "office_name", title: "Unit" },
                      { data: "month", title: "Month",
                        render: function( data, type, row ) {
                          // console.log(row);
                          // console.log(type);
                          // console.log(data);
                          return months[data-1];

                        }
                      },
                      { data: "year", title: "Year" },
                      { data: "deviasi", title: "Deviasi",
                        render: function( data, type, row ) {
                          if(data == "all"){ data = "All"; }
                          if(data == "0"){ data = "LTV"; }
                          if(data == "1"){ data = "Sewa"; }
                          if(data == "2"){ data = "Admin"; }
                          if(data == "3"){ data = "One Obligor"; }
                          if(data == "5"){ data = "Limit Transaksi"; }
                          return data;
                        }
                      },
                      { data: "approval", title: "Approval",
                        render: function( data, type, row ) {
                          if(data == "all"){ data = "All"; }
                          if(data == "0"){ data = "Cabang"; }
                          if(data == "1"){ data = "Area"; }
                          if(data == "2"){ data = "Regional"; }
                          if(data == "3"){ data = "Pusat"; }
                          return data;
                        }
                      },
                      { data: "jumlah", title: "Jumlah" },
                      
                      
                      {
                        data:function(data){
                          return "<td class='btn btn-info btn-edit'><a class='btn btn-info btn-edit' target='_blank'href='<?php echo base_url('fraud/detailApproval')?>/" + data.office_id + "/" +  data.month + "/" +  data.year + "/" +  data.approval + "/" +  data.deviasi + "/" +  data.product + "'>Detail</a></td>";
                        
                        }
                      },
                      
                      { data: "jumlah", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },

                      { data: "jumlah", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "jumlah", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "jumlah", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      
                      
                  ], 
                  buttons: [
                     {
                          extend: 'copy',
                          title: 'Monthly - Deviasi & Approval',
                          exportOptions: { orthogonal: 'export' }
                      },
                      {
                          extend: 'excel',
                          title: 'Monthly - Deviasi & Approval',
                         exportOptions: { orthogonal: 'export' },
                         autoFilter: true,
                      },
                      {
                          extend: 'print',
                          title: 'Monthly - Deviasi & Approval',
                           exportOptions: { orthogonal: 'export' },
                      },
                      {
                          extend: 'pdf',
                          title: 'Monthly - Deviasi & Approval',
                           exportOptions: { orthogonal: 'export' },
                           orientation: 'landscape',
                          pageSize: 'LEGAL'
                      },
                      
                  ], 
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

          dataTable = $('#table-1').DataTable( {
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
                      
                      { data: "area_id", title: "PT",
                        render: function ( data, type, row ) {
                            if(data == "61611e1d8614149f281503a8" ){
                                return 'GHTS';
                            }
                            if(data == "60c6befbe64d1e2428630162" ){
                                return 'GCDA';
                            }
                            if(data == "60c6bfcce64d1e242863024a" ){
                                return 'GCAM';
                            }
                            if(data == "62280b69861414b1beffc464" ){
                                return 'GJRM';
                            }
                            if(data == "60c6bfa6e64d1e2428630213" ){
                                return 'GCTA';
                            }
                            if(data == "60c6bf2ce64d1e2428630199" ){
                                return 'GTAM III';
                            }
                            if(data == "60c6bf63e64d1e24286301d9" ){
                                return 'GTAM II';
                            }
                            if(data == "6296cca7861414086c6ba4d4" ){
                                return 'GTAM I';
                            }
                            
                        }
                      },
                      { data: "office_name", title: "Unit"},
                      { data: "cif_number", title: "CIF"},
                      { data: "customer_name", title: "Nasabah"},
                      { data: "identity_number", title: "No KTP"},
                      { data: "phone_number", title: "No Handphone"},
                      { data: "noa", title: "Noa"},
                      { data: "up", title: "Total UP",
                        render: function ( data, type, row ) {      
                                return 'Rp ' + convertToRupiah(data);                            
                        }
                      },
                      
                      {
                        data:function(data){
                          return `   <button  onclick="detailOneobligor(${data.identity_number})" class="btn btn-info btn-edit">Detail</button>
                                      `;
                        }
                      },
                      { data: "up", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "up", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
                        }
                      },
                      { data: "up", title: "", width: "1",
                         render: function( data, type, row ) {
                          return ' ';
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
            } );

          
        }

        const detailOneobligor = (identity_number)=>{
          window.open('<?php echo base_url();?>/fraud/detailOneobligor/' + identity_number, '_blank');
        }

        const detail = (office_id, date)=>{
          console.log(office_id, date);
          window.open('<?php echo base_url();?>/fraud/detail/' + office_id + '/' + dateEnd, '_blank');
        }
        const detail_frequensi = (office_id, date)=>{
          console.log(office_id, date);
          window.open('<?php echo base_url();?>/fraud/detail_frequensi/' + office_id + '/' + dateEnd, '_blank');
        }

    function toolTipContent(e) {
        var str = "";
        var total = 0;
        var str2, str3;
        for (var i = 0; i < e.entries.length; i++) {
            var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i]
                .dataSeries
                .name + "</span>: Rp <strong>" + convertToRupiah(e.entries[i].dataPoint.y) + "</strong><br/>";
            total = e.entries[i].dataPoint.y + total;
            str = str.concat(str1);
        }
        str2 = `<span style = 'color:DodgerBlue;'><strong>" ${e.entries[0].dataPoint.x.getDate()} ${months[e.entries[0].dataPoint.x.getMonth()]} ${e.entries[0].dataPoint.x.getFullYear()} 
            "</strong></span><br/>`;
        total = Math.round(total * 100) / 100;
        str3 = "<span style = 'color:Tomato'>Total:</span><strong> Rp " + convertToRupiah(total) + "</strong><br/>";
        return (str2.concat(str)).concat(str3);
    }

    
    function toggleDataSeries(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chart.render();
    }

    function toolTipTotal(e) {
        
        console.log("data e",e);
        var str = "";
        var total = 0;
        var str2, str3;
        for (var i = 0; i < e.entries.length; i++) {
            var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i]
                .dataSeries
                .name + "</span>:  <strong>" + convertToRupiah(e.entries[i].dataPoint.y) + "</strong><br/>";
            total = e
                .entries[i].dataPoint.y + total;
            str = str.concat(str1);
        }
        // str2 = `<span style = 'color:DodgerBlue;'><strong>" ${e.entries[0].dataPoint.x.getDate()} ${months[e.entries[0].dataPoint.x.getMonth()]} ${e.entries[0].dataPoint.x.getFullYear()} 
        //     "</strong></span><br/>`;
        str2 = `<span style = 'color:black;'><strong>" ${e.entries[0].dataPoint.label}
            "</strong></span><br/><br>=========================<br>`;
        total = convertToRupiah(Math.round(total * 100) / 100);
        str3 =
            "<span style = 'color:Tomato'>=========================<br><br><strong>Total:</span> " + total + "</strong><br/>";
        return (str2.concat(str)).concat(str3);
    }

    function toolTipPersentase(e) {
        
        // console.log("data e",e);
        var str = "";
        var total = 0;
        var str2, str3;
        for (var i = 0; i < e.entries.length; i++) {
            var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i]
                .dataSeries
                .name + "</span>:  <strong>" + e.entries[i].dataPoint.y + " % </strong><br/>";
            total = e
                .entries[i].dataPoint.y + total;
            str = str.concat(str1);
        }
        // str2 = `<span style = 'color:DodgerBlue;'><strong>" ${e.entries[0].dataPoint.x.getDate()} ${months[e.entries[0].dataPoint.x.getMonth()]} ${e.entries[0].dataPoint.x.getFullYear()} 
        //     "</strong></span><br/>`;
        str2 = `<span style = 'color:black;'><strong>" ${e.entries[0].dataPoint.label}
            "</strong></span><br/><br>=========================<br>`;
        total = Math.round(total * 100) / 100;
        str3 =
            "<span style = 'color:Tomato'>=========================<br><br><strong>Total:</span> " + total + " % </strong><br/>";
        return (str2.concat(str)).concat(str3);
    }

  function getLtv(){
 
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    var selectArea = $('#area_id').val();
    var selectBox = $('#branch_id').val();

    var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           
           var limitLtv = $('#limitLtv').val();

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/fraud/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limitLtv}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                total += parseInt(item.os);
                limit = item.limit;
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    name: item.office_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: months[item.month-1] + ' ' + item.year,
                    y: +item.total,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "LTV >= " + limitLtv + "%", 
                },
                axisY: {
                    title: "Jumlah"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipTotal                
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

    function getOs(){
 
        var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var limit = $('#limit').val();

          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/outstanding/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limit}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                // total += parseInt(item.os);
                // limit = item.limit;
                const index = build.findIndex(f => {
                    return f.name == item.unit
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    // yValueFormatString: "#0.0'%'",
                    name: item.unit,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                if(item.persentase >= 5){
                    template.dataPoints.push({
                        label: months[item.month-1] + ' ' + item.year,
                        y: +item.persentase,
                        indexLabel: "high", markerColor: "red", markerType: "triangle",
                    });
                }else{
                    template.dataPoints.push({
                        label: months[item.month-1] + ' ' + item.year,
                        y: +item.persentase,

                    });
                }
                

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Outstanding", 
                },
                axisY: {
                    title: "persentase (%)",
                    // title: "Percent",
                    suffix: "%",
                    lineColor: "#C0504E",
                    tickColor: "#C0504E",
                    labelFontColor: "#C0504E"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipPersentase                
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

    function getDpd(){
 
        var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var limit = $('#limit').val();

          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/dpd/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limit}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                // total += parseInt(item.os);
                // limit = item.limit;
                const index = build.findIndex(f => {
                    return f.name == item.unit
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    // yValueFormatString: "#0.0'%'",
                    name: item.unit,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                if(item.persentase_os > 5){
                    template.dataPoints.push({
                        label: months[item.month-1] + ' ' + item.year,
                        y: +item.persentase_os,
                        indexLabel: "high", markerColor: "red", markerType: "triangle",
                    });
                }else{
                    template.dataPoints.push({
                        label: months[item.month-1] + ' ' + item.year,
                        y: +item.persentase_os,
                    });
                }
                

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "DPD", 
                },
                axisY: {
                    title: "DPD",
                    suffix: "%",
                    lineColor: "#C0504E",
                    tickColor: "#C0504E",
                    labelFontColor: "#C0504E"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipPersentase                
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

    function getTicketsize(){
 
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    var selectArea = $('#area_id').val();
    var selectBox = $('#branch_id').val();

    var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           
           var limit = $('#limit').val();

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/ticketsize/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limit}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                total += parseInt(item.os);
                limit = item.limit;
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    name: item.office_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: months[item.month-1] + ' ' + item.year,
                    y: +item.ticketsize,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Ticketsize", 
                },
                axisY: {
                    title: "Ticketsize"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipTotal                
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

    function getFrequensi(){
 
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

   var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var frequensi = $('#frequensi').val();
          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/frequensi/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${frequensi}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                total += parseInt(item.noa);
                frequensi = item.frequensi;
                const index = build.findIndex(f => {
                    return f.name == item.name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    name: item.name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: months[item.month-1] + ' ' + item.year,
                    y: +item.noa,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Frequensi >= " + frequensi + "Trx", 
                },
                axisY: {
                    title: "Frequensi"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipTotal                
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }


    function getMoker(){
 
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    var selectArea = $('#area_id').val();
    var selectBox = $('#branch_id').val();

    var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           
           var limit = $('#limit').val();

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/moker/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${limit}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                total += parseInt(item.moker);
                limit = item.limit;
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    name: item.office_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: months[item.month-1] + ' ' + item.year,
                    y: +item.moker,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Modal Kerja", 
                },
                axisY: {
                    title: "Modal Kerja"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipTotal                
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

    function getSaldo(){
 
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    var saldolimit = 0;
          var status = document.getElementById('status');
          status.addEventListener('keyup', function(e) {
            var saldo = document.getElementById('status');
            saldo.value = formatRupiah(saldo.value);

            var saldolimit = $("#status").val();

            if (saldolimit) {
                saldolimit = formatNumber(saldolimit);
            } else {
                saldolimit = 0;
            }
            console.log('Saldo',saldolimit);
              
          });
          var saldolimit = $("#status").val();

            if (saldolimit) {
                saldolimit = formatNumber(saldolimit);
            } else {
                saldolimit = 0;
            }
           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
           var status = $('#status').val();
           
          console.log(dateStart);
          console.log(dateEnd);
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/saldokas/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${saldolimit}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                total += parseInt(item.os);
                // limit = item.status;
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    name: item.office_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                if(item.percentase > 100){
                    template.dataPoints.push({
                        label: item.date_open,
                        y: +item.percentase,
                        indexLabel: "high",markerColor: "red", markerType: "triangle",
                    });
                }else{
                    template.dataPoints.push({
                    label: item.date_open,
                    y: +item.percentase,
                    // indexLabel: "highest",markerColor: "red", markerType: "triangle",
                });
                }
               

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Saldo Kas >= Rp " + status, 
                },
                axisY: {
                    title: "persentase (%)",
                    // title: "Percent",
                    suffix: "%",
                    lineColor: "#C0504E",
                    tickColor: "#C0504E",
                    labelFontColor: "#C0504E"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipPersentase               
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

    function getTrxBatal(){
 
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    var selectArea = $('#area_id').val();
    var selectBox = $('#branch_id').val();

    var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/trxBatal/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                total += parseInt(item.total);
                // limit = item.limit;
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    name: item.office_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: months[item.month-1] + ' ' + item.year,
                    y: +item.total,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Transaksi Batal", 
                },
                axisY: {
                    title: "Jumlah"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipTotal                
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

    function getApproval(){
 
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    // var selectArea = $('#area_id').val();
    // var selectBox = $('#branch_id').val();

    // var units = $('#units_id').val();
    //        var date = $('#date').val();
    //        var branch = $('#branch_id').val();
    //        var area = $('#area_id').val();
    //        let no = 0;
    //        var category = $('#category').val();
    //        var dateStart = $('#dateStart').val();
    //        var dateEnd = $('#dateEnd').val();
           
    //        var limit = $('#limit').val();

           var units = $('#units_id').val();
           var date = $('#date').val();
           var branch = $('#branch_id').val();
           var area = $('#area_id').val();
           let no = 0;
           var category = $('#category').val();
           var dateStart = $('#dateStart').val();
           var dateEnd = $('#dateEnd').val();
          
          var dateStartNew = new Date(dateStart);
          var dateEndNew = new Date(dateEnd);
          var approval = $('#approval').val();
          var deviasi = $('#deviasi').val();
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/approval/${area}/${branch}/${units}/${category}/${dateStart}/${dateEnd}/${approval}/${deviasi}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var deviasi = 0;
            var approval = 0;

            data.forEach(item => {
                total += parseInt(item.os);

                          if(item.deviasi == "all"){ deviasi = "All"; }
                          if(item.deviasi == "0"){ deviasi = "LTV"; }
                          if(item.deviasi == "1"){ deviasi = "Sewa"; }
                          if(item.deviasi == "2"){ deviasi = "Admin"; }
                          if(item.deviasi == "3"){ deviasi = "One Obligor"; }
                          if(item.deviasi == "5"){ deviasi = "Limit Transaksi"; }
                        
                          if(item.approval == "all"){ approval = "All"; }
                          if(item.approval == "0"){ approval = "Cabang"; }
                          if(item.approval == "1"){ approval = "Area"; }
                          if(item.approval == "2"){ approval = "Regional"; }
                          if(item.approval == "3"){ approval = "Pusat"; }

                
                
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    name: item.office_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    // x: new Date(item.year, item.month-1), 
                    label: months[item.month-1] + ' ' + item.year,
                    y: +item.jumlah,
                    // x: months[item.month-1] + ' ' + item.year,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Deviasi " + deviasi + " Approval " + approval, 
                },
                axisY: {
                    title: "jumlah"
                },
               
                toolTip: {
                    shared: true,
                    content: toolTipTotal,                 
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

    function getOneobligor(){
 
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

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
          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];

    // Units
    axios.get(`<?php echo base_url();?>/api/transactions/fraud/oneobligor/${area}/${branch}/${units}/${dateStart}/${dateEnd}/${tiering}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            var total = 0;
            var limit = 0;
            data.forEach(item => {
                total += parseInt(item.os);
                limit = item.limit;
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    xValueFormatString: "MMM YYYY",
                    name: item.customer_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: item.office_name,
                    y: +item.up,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelect", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Oneobligor", 
                },
                axisY: {
                    title: "Oneobligor"
                },
                axisX: {
                // interval: 1,
                intervalType: "month"
            },
                toolTip: {
                    shared: true,
                    content: toolTipTotal                
                  },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: build,

            });

            chart.render();
        }).catch(err => {
            console.log(err)
        })
    }

        removeApproval(); removeDeviasi(); removeFrequensi(); removeStatus(); removeTiering(); removeLimit(); limitLtv(); removeGrafik(); getLtv();
        initDataTable();
    </script>

<!-- Add New Javascript -->
<script>
// function chartOs() {
    // Select option
    

        


</script>

<?php echo $this->endSection();?>