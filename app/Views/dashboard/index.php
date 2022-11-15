<?php echo $this->extend('layouts/administrator');?>

<?php echo $this->section('content');?>

<section class="section">
        <div class="row">

            <div class="col-xl-12 col-lg-12">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">
                          <div class="col-xl-3 col-lg-3">
                          <input class='form-control' type="month" name='month' and id='month' value = '<?php echo date('Y-m'); ?>'>
                          
                        </div>
                        </h6>
                        <h6 id='summary' class="text-muted mb-0"> <?php 
                        $hour = date('H');
                        $minute = date('i');
                          $day = date('D');
                          $dayList = array(
                              'Sun' => 'Minggu',
                              'Mon' => 'Senin',
                              'Tue' => 'Selasa',
                              'Wed' => 'Rabu',
                              'Thu' => 'Kamis',
                              'Fri' => 'Jumat',
                              'Sat' => 'Sabtu'
                          );
                      // if(session('user')->username == 'admin' ){
                        
                        ?>
                      
                      <?php 
                      // } 
                      
                      ?>
                    
                    </h6> 
                      
                      
                        <!-- <span id= 'countOs' class="font-weight-bold mb-0">0</span> -->
                      </div>
                      <div class="col-auto">
                        <!-- <div class="card-circle l-bg-purple text-white"> -->
                          <i data-feather="calendar"></i> <?php echo $dayList[$day].', '; echo date('d');  ?> <?php  echo date('F');  ?> <?php echo date('Y');  ?>
                          <br>
                          <i data-feather="clock"></i> <?php echo $hour.' : '; echo $minute;  ?> 
                        <!-- </div> -->
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <!-- <span id='noaOs' class="text-success mr-2"><i class="fa fa-arrow-up"></i>0</span>
                      <span class="text-nowrap">Noa</span> -->
                    </p>
                  </div>
                </div>
              </div>

            <div class="col-xl-4 col-lg-4">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Outstanding</h6>
                        <span id= 'countOs' class="font-weight-bold mb-0">0</span>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-purple text-white">
                          <i class="fas fa-dollar-sign"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <span id='noaOs' class="text-success mr-2"><i class="fa fa-arrow-up"></i>0</span>
                      <span class="text-nowrap">Noa</span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">DPD</h6>
                        <span id='countDpd' class="font-weight-bold mb-0">0</span>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-cyan text-white">
                          <i class="far fa-chart-bar"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <span id='noaDpd' class="text-success mr-2"><i class="fa fa-arrow-up"></i>0</span>
                      <span class="text-nowrap">Noa</span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Deviasi</h6>
                        <span id='countDeviasi' class="font-weight-bold mb-0">0</span>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-green text-white">
                          <i class="fas fa-briefcase"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 15%</span> -->
                      <span class="text-nowrap">Selama Bulan <?php echo date('M'); ?></span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Oneobligor</h6>
                        <span id='countOneobligor' class="font-weight-bold mb-0">0</span>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-green text-white">
                          <i class="fas fa-hiking"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 5.4%</span>
                      <span class="text-nowrap">Since last month</span> -->
                    </p>
                  </div>
                </div>
              </div>
              <div  class="col-xl-4 col-lg-4">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">LTV</h6>
                        <span id='countLtv' class="font-weight-bold mb-0">0</span>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-orange text-white">
                          <i class="fas fa-drafting-compass"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 15%</span>
                      <span class="text-nowrap">Since last month</span> -->
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Pembatalan</h6>
                        <span id='countBatal' class="font-weight-bold mb-0">0</span>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-red text-white">
                          <i class="fas fa-close"></i>
                        </div>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 5.4%</span>
                      <span class="text-nowrap">Since last month</span> -->
                    </p>
                  </div>
                </div>
              </div>
            
            <div id = 'viewOs'  class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                <div class="card">
                    <div class="card-header">
                    <h4>Outstanding Chart</h4>
                  </div>
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-12">
                                    <div class="card-content">

                                        <div id="chartOutstandingAll" style="height: 370px; max-width: 920px; margin: 0px auto;">
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
            
            <div id = 'viewDpd'   class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                <div class="card">
                    <div class="card-header">
                    <h4>DPD Chart</h4>
                  </div>
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-12">
                                    <div class="card-content">

                                        <div id="chartDpd" style="height: 370px; max-width: 920px; margin: 0px auto;">
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
              
            <div id = 'viewDeviasi'  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                <div class="card">
                    <div class="card-header">
                    <h4>Deviasi Chart</h4>
                  </div>
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-12">
                                    <div class="card-content">

                                        <div id="chartDeviasi" style="height: 370px; max-width: 920px; margin: 0px auto;">
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

            <!-- <div  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-12">
                                    <div class="card-content">

                                        <div id="chartOneobligor" style="height: 370px; max-width: 920px; margin: 0px auto;">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 pl-0">
                                    <div class="banner-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div id = 'viewLtv'  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                <div class="card">
                    <div class="card-header">
                    <h4>LTV Chart</h4>
                  </div>
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-12">
                                    <div class="card-content">

                                        <div id="chartLtv" style="height: 370px; max-width: 920px; margin: 0px auto;">
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

            <div id ='viewBatal' class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                <div class="card">
                    <div class="card-header">
                    <h4>Pembatalan Chart</h4>
                  </div>
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
                                    </div>
                                </div>
                            </div>
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
<!-- Add New Javascript -->
<script>
$('[name="month"]').on('change', function() {

  console.log(month);
});

// const summary = () => {

  var summary = document.getElementById('summary');
    var month = $('#month').val();
    
  var a = document.createElement("a");
          a.setAttribute("class", "nav-link nav-link-lg ion-ios-reload");
          a.setAttribute("href", `<?php echo base_url();?>/Generate/Summary/index/${month}`);
          a.textContent = 'Download Summary';
          summary.appendChild(a);

                // var opt = document.createElement("span");
                // // opt.value = item.id;
                // opt.text = item.count;
                // count.appendChild(opt);

// }
    function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
}


    //CountOneobligor
    axios.get(`<?php echo base_url();?>/api/dashboard/countOneobligor`).then(
        res => {
            const {
                data
            } = res.data;
            console.log('oneobligorog', res.data.data);
            

                var count = document.getElementById('countOneobligor');
                count.textContent = convertToRupiah(res.data.data) + ' (Nasabah)';

                
        }).catch(err => {
        console.log(err)
    })


    //Grafik

          var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
              'Oktober',
              'November', 'Desember'
          ];
        
     // OutstandingAll
    axios.get(`<?php echo base_url();?>/api/dashboard/outstandingAll`).then(
        res => {
            const {
                data
            } = res.data;
           
            if(data.length == 0){

                var viewOs = document.getElementById('viewOs');
                viewOs.style.display = "none";
                
            }

            const awal = [];

            var noa = 0;
            var os = 0;
            data.forEach(item => {
               
                date = new Date();
                if(item.month == date.getMonth() + 1){
                    noa = item.noa;
                     os = item.os;
                }else{
                    noa = 0;
                     os = 0;
                }

                const a = awal.findIndex(f => {
                    return f.name == 'LTV';
                });


                const templateAwal = a > -1 ? awal[a] : {
                    
                    type: "spline",
                    yValueFormatString: "#,### ",
                    xValueFormatString: "MMM",
                    name: "LTV",
                    dataPoints: []
                }

                templateAwal.dataPoints.push({
                    label: months[item.month-1],
                    y: +item.os
                });

                if (a > -1) {
                    awal[a] = templateAwal;
                } else {
                    awal.push(templateAwal);
                }
            });

            var count = document.getElementById('countOs');
            document.getElementById("noaOs").innerHTML=convertToRupiah(noa);
            count.textContent = 'Rp ' + convertToRupiah(os) ;

                
            var chart = new CanvasJS.Chart("chartOutstandingAll", {
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Outstanding",
                    fontFamily: "arial black",
                    fontColor: "#695A42"
                },
                axisY: {
                    title: "Jumlah",
                    lineColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontColor: "#4F81BC"
                },
               
                data: [...awal, ]
            });


            chart.render();
        }).catch(err => {
        console.log(err)
    })

     // DPD
    axios.get(`<?php echo base_url();?>/api/dashboard/dpdAll`).then(
        res => {
            const {
                data
            } = res.data;
           

            if(data.length == 0){

                var viewDpd = document.getElementById('viewDpd');
                viewDpd.style.display = "none";
                
            }
            const awal = [];

            
            var noa = 0;
            var os = 0;
            data.forEach(item => {
               
                date = new Date();
                if(item.month == date.getMonth() + 1){
                    noa = item.noa;
                     os = item.os;
                }else{
                    noa = 0;
                     os = 0;
                }
               
                const a = awal.findIndex(f => {
                    return f.name == 'DPD';
                });


                const templateAwal = a > -1 ? awal[a] : {
                    
                    type: "line",
                    yValueFormatString: "#,### ",
                    xValueFormatString: "MMM",
                    name: "DPD",

                    // showInLegend: true,
                    // markerType: "square",
                    color: "#F08080",
                    dataPoints: []
                }

                templateAwal.dataPoints.push({
                    label: months[item.month-1],
                    y: +item.os
                });

                if (a > -1) {
                    awal[a] = templateAwal;
                } else {
                    awal.push(templateAwal);
                }
            });


            var count = document.getElementById('countDpd');
                count.textContent = 'Rp ' + convertToRupiah(os);
                document.getElementById("noaDpd").innerHTML=convertToRupiah(noa);


            var chart = new CanvasJS.Chart("chartDpd", {
                exportEnabled: true,
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "DPD",
                    fontFamily: "arial black",
                    fontColor: "#695A42"
                },
                axisY: {
                    title: "Jumlah",
                    lineColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    crosshair: {
                        enabled: true
                    }
                },
                toolTip:{
                    shared:true
                },  
                // legend:{
                //     cursor:"pointer",
                //     verticalAlign: "bottom",
                //     horizontalAlign: "left",
                //     dockInsidePlotArea: true,
                //     itemclick: toogleDataSeries
                // },
               

                data: [...awal, ]
            });


            chart.render();
        }).catch(err => {
        console.log(err)
    })

     // Deviasi
    axios.get(`<?php echo base_url();?>/api/dashboard/deviasiAll`).then(
        res => {
            const {
                data
            } = res.data;
           
            if(data.length == 0){

                var viewDeviasi = document.getElementById('viewDeviasi');
                viewDeviasi.style.display = "none";
                
            }

            const awal = [];

            
            var noa = 0;
            var os = 0;
            data.forEach(item => {
               
                date = new Date();
                if(item.month == date.getMonth() + 1){
                    noa = item.noa;
                     os = item.os;
                }else{
                    noa = 0;
                     os = 0;
                }
               
                const a = awal.findIndex(f => {
                    return f.name == 'LTV';
                });


                const templateAwal = a > -1 ? awal[a] : {
                    
                    type: "line",
                    yValueFormatString: "#,### trx",
                    xValueFormatString: "MMM",
                    name: "LTV",
                    // color: "DarkGreen",

                    dataPoints: []
                }

                templateAwal.dataPoints.push({
                    label: months[item.month-1],
                    y: +item.noa
                });

                if (a > -1) {
                    awal[a] = templateAwal;
                } else {
                    awal.push(templateAwal);
                }
            });

            var count = document.getElementById('countDeviasi');
                count.textContent = convertToRupiah(noa) + ' (x)';

            var chart = new CanvasJS.Chart("chartDeviasi", {
                exportEnabled: true,
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Deviasi",
                    fontFamily: "arial black",
                    fontColor: "#695A42"
                },
                axisY: {
                    title: "Jumlah",
                    lineColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontColor: "#4F81BC"
                },
               

                data: [...awal, ]
            });


            chart.render();
        }).catch(err => {
        console.log(err)
    })

    // Oneobligor
    axios.get(`<?php echo base_url();?>/api/dashboard/oneobligorAll`).then(
        res => {
            const {
                data
            } = res.data;
           

            const awal = [];

            
            var noa = 0;
            var os = 0;
            data.forEach(item => {
               
                date = new Date();
                if(item.month == date.getMonth() + 1){
                    noa = item.noa;
                     os = item.os;
                }else{
                    noa = 0;
                     os = 0;
                }
               
                const a = awal.findIndex(f => {
                    return f.name == 'LTV';
                });


                const templateAwal = a > -1 ? awal[a] : {
                    
                    type: "spline",
                    yValueFormatString: "#,### trx",
                    xValueFormatString: "MMM",
                    name: "LTV",
                    dataPoints: []
                }

                templateAwal.dataPoints.push({
                    label: months[item.month-1],
                    y: +item.noa
                });

                if (a > -1) {
                    awal[a] = templateAwal;
                } else {
                    awal.push(templateAwal);
                }
            });


            var chart = new CanvasJS.Chart("chartOneobligor", {
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Oneobligor",
                    fontFamily: "arial black",
                    fontColor: "#695A42"
                },
                axisY: {
                    title: "Nasabah",
                    lineColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontColor: "#4F81BC"
                },
               

                data: [...awal, ]
            });


            chart.render();
        }).catch(err => {
        console.log(err)
    })

     // LTV
    axios.get(`<?php echo base_url();?>/api/dashboard/ltvAll`).then(
        res => {
            const {
                data
            } = res.data;                     

            // console.log(data.length);
            if(data.length == 0){

                var viewLtv = document.getElementById('viewLtv');
                viewLtv.style.display = "none";
                
            }
                const awal = [];
                
                var noa = 0;
                var os = 0;
                data.forEach(item => {
                
                    date = new Date();
                    if(item.month == date.getMonth() + 1){
                        noa = item.noa;
                    }else{
                        noa = 0;
                    }
                
                    const a = awal.findIndex(f => {
                        return f.name == 'LTV';
                    });


                    const templateAwal = a > -1 ? awal[a] : {
                        
                        type: "spline",
                        yValueFormatString: "#,### trx",
                        xValueFormatString: "MMM",
                        name: "LTV",
                        dataPoints: []
                    }

                    templateAwal.dataPoints.push({
                        label: months[item.month-1],
                        y: +item.noa
                    });

                    if (a > -1) {
                        awal[a] = templateAwal;
                    } else {
                        awal.push(templateAwal);
                    }
                });


            

            
            var count = document.getElementById('countLtv');
                count.textContent = convertToRupiah(noa) + '(x)';

            var chart = new CanvasJS.Chart("chartLtv", {
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "LTV ",
                    fontFamily: "arial black",
                    fontColor: "#695A42"
                },
                axisY: {
                    title: "Jumlah",
                    lineColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontColor: "#4F81BC"
                },
               

                data: [...awal, ]
            });


            chart.render();
        }).catch(err => {
        console.log(err)
    })

    // Pembatalan
    axios.get(`<?php echo base_url();?>/api/dashboard/batalAll`).then(
        res => {
            const {
                data
            } = res.data;
           
            if(data.length == 0){

                var viewBatalan = document.getElementById('viewBatalan');
                viewBatalan.style.display = "none";
                
            }

            const awal = [];

            
            var noa = 0;
            var os = 0;
            data.forEach(item => {
               
                date = new Date();
                if(item.month == date.getMonth() + 1){
                    noa = item.noa;
                }else{
                    noa = 0;
                }
                
                // os = item.os;
               
                const a = awal.findIndex(f => {
                    return f.name == 'Pembatalan';
                });


                const templateAwal = a > -1 ? awal[a] : {
                    
                    type: "spline",
                    yValueFormatString: "#,### trx",
                    xValueFormatString: "MMM",
                    name: "Pembatalan",
                    color: "#F08080",
                    dataPoints: []
                }

                templateAwal.dataPoints.push({
                    label: months[item.month-1],
                    y: +item.noa
                });

                if (a > -1) {
                    awal[a] = templateAwal;
                } else {
                    awal.push(templateAwal);
                }
            });
            
            document.getElementById("countBatal").innerHTML=convertToRupiah(noa) + ' (x)';

            var chart = new CanvasJS.Chart("chartSelect", {
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Pembatalan ",
                    fontFamily: "arial black",
                    fontColor: "#695A42"
                },
                axisY: {
                    title: "Jumlah",
                    lineColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontColor: "#4F81BC"
                },
               

                data: [...awal, ]
            });


            chart.render();
        }).catch(err => {
        console.log(err)
    })

    //Revenue
var options = {
  chart: {
    exportEnabled: true,
    height: 230,
    type: "line",
    shadow: {
      enabled: true,
      color: "#000",
      top: 18,
      left: 7,
      blur: 10,
      opacity: 1
    },
    toolbar: {
      show: false
    }
  },
  colors: ["#3dc7be", "#ffa117"],
  dataLabels: {
    enabled: true
  },
  stroke: {
    curve: "smooth"
  },
  series: [{
    name: "High - 2019",
    data: [5, 15, 14, 36, 32, 32]
  },
//   {
//     name: "Low - 2019",
//     data: [7, 11, 30, 18, 25, 13]
//   }
  ],
  grid: {
    borderColor: "#e7e7e7",
    row: {
      colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
      opacity: 0.0
    }
  },
  markers: {
    size: 6
  },
  xaxis: {
    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],

    labels: {
      style: {
        colors: "#9aa0ac"
      }
    }
  },
  yaxis: {
    title: {
      text: "Income"
    },
    labels: {
      style: {
        color: "#9aa0ac"
      }
    },
    min: 5,
    max: 40
  },
  legend: {
    position: "top",
    horizontalAlign: "right",
    floating: true,
    offsetY: -25,
    offsetX: -5
  }
};

var chart = new ApexCharts(document.querySelector("#revenue"), options);

chart.render();

</script>

<?php echo $this->endSection();?>
