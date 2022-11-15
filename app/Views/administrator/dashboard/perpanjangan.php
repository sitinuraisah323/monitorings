<?php echo $this->extend('layouts/administrator');?>

<?php echo $this->section('content');?>

<section class="section">

    <div class="row ">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card card-danger">
                <div class="card-header">
                     <?php if ( session()->get( 'user' )->level == 'unit' ):?>
                    <input type = 'hidden' id='units_id' name = 'units_id' value = "<?php echo session()->get('user')->office_id;?>">
                <?php elseif ( session()->get( 'user' )->level == 'kasir' ):?>
                    <input type = 'hidden' id='units_id' name = 'units_id' value = "<?php echo session()->get('user')->office_id;?>">
                <?php elseif ( session()->get( 'user' )->level == 'area' ):?>
                    <input type = 'hidden' id='area_id' name = 'area_id' value = "<?php echo session()->get('user')->area_id;?>">

                    <div class="col-lg-3">
                        <select class="form-control" name="branch_id" id="branch_id">
                            <option value="0">Select Cabang</option>
                        </select>
                    
                    </div>

                    <div class="col-lg-3">
                        <select class="form-control" name="units_id" id="units_id" onchange="getOutstanding()">
                            <option value="0">Select Units</option>
                        </select>

                    </div>
                <?php elseif ( session()->get( 'user' )->level == 'cabang' ):?>
                    <input type = 'hidden' id='branch_id' name = 'branch_id' value = "<?php echo session()->get('user')->branch_id;?>">

                    <div class="col-lg-3">
                        <select class="form-control" name="units_id" id="units_id" onchange="getOutstanding()">
                            <option value="0">Select Units</option>
                        </select>

                    </div>
                <?php else:?>
                    <div class="col-lg-3">
                        <select class="form-control" name="area_id" id="area_id">
                            <option value="">Select Area</option>
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
                        

                    </div>

                    <div class="col-lg-3">
                        <select class="form-control" name="units_id" id="units_id" onchange="getOutstanding()">
                            <option value="0">Select Units</option>
                        </select>

                    </div>
                <?php endif ; ?>

                    <input type="hidden" name="user_id" id="user_id" value="<?php echo session('user')->level ?>" />
                    <input type="hidden" name="level" id="level" value="<?php echo session('user')->level ?>" />


                    <div class="card-header-action">
                        <div id="count" class="dropdown dropdown-list-toggle">
                            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i
                                    data-feather="eye"></i>
                                <!-- <span id="count" class="badge headerBadge1">
                                    6 </span> -->
                            </a>
                            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                                <div class="dropdown-header">
                                    Dilihat Oleh:
                                    <div class="float-right">
                                        <!-- <a href="#">Dilihat oleh :</a> -->
                                    </div>
                                </div>
                                <div class="dropdown-list-content dropdown-list-message">

                                    <?php foreach($view as $views){ 
                                        
                                //         $awal  = $views->updated_at;
                                // $akhir = now(); // waktu sekarang
                                // $diff  = date_diff( $awal, $akhir );
                                ?>
                                    <a href="#" class="dropdown-item"> <span class="dropdown-item-desc"> <span
                                                class="message-user"><?php echo $views->username; ?></span>
                                            <!-- <span class="time messege-text">Please check your mail !!</span> -->
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
                    </div>

                </div>
            </div>
        </div>

<!-- All Noa -->
        <div id='noaNasional' class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-6">
                                <div class="card-content">
                                    <!-- <h5 class="font-15">Dashboard Outstanding Nasional</h5> -->
                                    <div id="chartNoa" style="height: 370px; max-width: 920px; margin: 0px auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- All Os -->
        <div id='osNasional' class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-6">
                                <div class="card-content">
                                    <!-- <h5 class="font-15">Dashboard Outstanding Nasional</h5> -->
                                    <div id="chartOs" style="height: 370px; max-width: 920px; margin: 0px auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Area Noa -->
        <div id="noaArea" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" style=" display: none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-6">
                                <div class="card-content">
                                    <div id="chartSelectAreaNoa"
                                        style="height: 370px; max-width: 920px; margin: 0px auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Area Os -->
        <div id="osArea" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" style=" display: none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-6">
                                <div class="card-content">
                                    <div id="chartSelectArea"
                                        style="height: 370px; max-width: 920px; margin: 0px auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Cabang Noa -->
        <div id="noaCabang" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" style=" display: none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-6">
                                <div class="card-content">

                                    <div id="chartSelectNoa" style="height: 370px; max-width: 920px; margin: 0px auto;">
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

<!-- Cabang Os -->
        <div id="osCabang" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12" style=" display: none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-6">
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

<!-- Unit -->
        <div id="osUnit" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-6">
                                <div class="card-content">
                                    <div id="chartUnits" style="height: 370px; max-width: 920px; margin: 0px auto;">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Saldo -->
        <div id="saldo" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" style=" display: none;">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md- col-sm-12 col-xs-12 pr-0 pt-6">
                                <div class="card-content">


                                    <div id="chartSaldo" style="height: 370px; max-width: 920px; margin: 0px auto;">
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

    </div>


</section>

<!-- Modal Detail Trx -->
<form class="modal fade" id="modal-catalog-category" tabindex="-1" role="dialog"
    aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Detail Transaksi</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">CIF</th>
                                    <th>Nasabah</th>
                                    <th class="text-center">SGE</th>
                                    <th class="text-center">Tanggal Kredit</th>
                                    <th class="text-center">Tanggal Tempo</th>
                                    <th class="text-center">Tanggal Lunas</th>
                                    <th class='text-right'>Taksiran</th>
                                    <th class="text-right">UP</th>
                                    <th class='text-right'>Admin</th>
                                    <th class="text-center">LTV</th>
                                    <th class='text-right'>Sewa Modal</th>
                                    <th class='text-center'>Produk</th>
                                    <th class='text-center'>Barang Jaminan</th>
                                    <th class='text-center' width='30%'>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect btn-save">Save</button> -->
                <button id="closemodal" class="btn btn-primary m-t-15 waves-effect btn-save" data-dismiss="modal">close</button>
                </div>
          </div>
            </div>
        </div>
    </div>
    </div>
</form>
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
// function chartOs() {
    var level = $('#level').val();

    if(level == 'area'){
        CabangbyArea();
    }
    if(level == 'cabang'){
        UnitsByCabang();
    }

    function CabangbyArea() {
         var area = $('#area_id').val();
        var branch = document.getElementById('branch_id');
        let array = [];
        // var url_data = $('#url_get_cabang').val() + '/' + area;
        axios.get(`<?php echo base_url();?>/api/dashboard/getBranch/${area}`).then(
            res => {
                const {
                    data
                } = res.data;
                // console.log('test');
                // console.log(build);
                data.forEach(item => {

                    var opt = document.createElement("option");
                    opt.value = item.branch_id;
                    opt.text = item.cabang;
                    branch.appendChild(opt);


                })
            });
    }
    function UnitsByCabang(){
        var branch = $('#branch_id').val();
        var units = document.getElementById('units_id');
        let array = [];
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
    }

    // Select option
    $('[name="area_id"]').on('change', function() {
        var area = $(this).val();
        var branch = document.getElementById('branch_id');
        let array = [];
        // var url_data = $('#url_get_cabang').val() + '/' + area;
        axios.get(`<?php echo base_url();?>/api/dashboard/getBranch/${area}`).then(
            res => {
                const {
                    data
                } = res.data;
                // console.log('test');
                // console.log(build);
                data.forEach(item => {

                    var opt = document.createElement("option");
                    opt.value = item.branch_id;
                    opt.text = item.cabang;
                    branch.appendChild(opt);


                })
            });
    });



    $('[name="branch_id"]').on('change', function() {
        var branch = $(this).val();
        var units = document.getElementById('units_id');
        let array = [];
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
    });

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }

    // function toolIndexLabel(e) {
        
    //     console.log("indexLabel e",e);
    //     var str = "";
    //     var total = 0;
    //     var str2, str3;
    //     var os_1 = 0;
    //     var percen = 0;
    //     // for (var i = 0; i < e.entries.length; i++) {
            
    //         percen = (e.entries[1].dataPoint.y - e.entries[0].dataPoint.y) / e.entries[0].dataPoint.y * 100;
    //         os_1 = e.entries[i].dataPoint.y
    //     // }
        
    //     return percen + "%";
    // }

    function toolTipTotal(e) {
        
        console.log("data e",e);
        var str = "";
        var total = 0;
        var str2, str3;
        for (var i = 0; i < e.entries.length; i++) {
            var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i]
                .dataSeries
                .name + "</span>: Rp <strong>" + convertToRupiah(e.entries[i].dataPoint.y) + "</strong><br/>";
            total = e
                .entries[i].dataPoint.y + total;
            str = str.concat(str1);
        }
        str2 = `<span style = 'color:black;'><strong>" ${e.entries[0].dataPoint.label}
            "</strong></span><br/><br>=========================<br>`;
        total = convertToRupiah(Math.round(total * 100) / 100);
        str3 =
            "<span style = 'color:Tomato'>=========================<br><br><strong>Total:</span> Rp " + total + "</strong><br/>";
        return (str2.concat(str)).concat(str3);
    }

    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
        'Oktober',
        'November', 'Desember'
    ]

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

    $("#closemodal").on('click', function () {
            location.reload(true);
        });

        const openModal = (date, units) => {
            axios.get(`<?php echo base_url();?>/api/dashboard/perpanjangan_bydate/${date}/${units}`).then(res => {
                            const {
                                data
                            } = res.data;

                            buatTabel = "";
                            let a= 0;
                            data.forEach(item => {
                                console.log('sge');
                                console.log(item.sge);
                                
                                buatTabel += "<tr>"
                                            + "<td>" + (a+1) + "</td>"
                                            + "<td>" + item.unit + "</td>"
                                            + "<td>" + item.cif_number + "</td>"
                                            + "<td>" + item.customer_name + "</td>"
                                            + "<td>" + item.sge + "</td>"
                                            + "<td>" + item.Tgl_Kredit + "</td>"
                                            + "<td>" + item.Tgl_Jatuh_Tempo + "</td>"
                                            + "<td>" + item.Tgl_Lunas + "</td>"
                                            + "<td>" + item.taksiran + "</td>"
                                            + "<td>" + item.up + "</td>"
                                            + "<td>" + item.admin + "</td>"
                                            + "<td>" + item.ltv + "</td>"
                                            + "<td>" + item.sewa_modal + "</td>"
                                            + "<td>" + item.product_name + "</td>"
                                            + "<td>" + item.bj + "</td>"
                                            + "<td width='30%'>" + item.description + "</td>"                
                                    + "<tr/>";
                                a++;
                            })
                            document.getElementsByTagName("table")[0].innerHTML += buatTabel;            
                        }).then(res => $('#modal-catalog-category').modal('show'))
        }


window.onload = function() {

     var selectArea = $('#area_id').val();
    var selectBox = $('#branch_id').val();
    var units = $('#units_id').val();

    var level = $('#level').val();
    if(level == 'area'){
        getArea();
    }else if(level == 'cabang'){
        getCabang();
    }else if(level == 'unit'){
        getUnits();
        getSaldo();
    }else if(level == 'kasir'){
        getUnits();
        getSaldo();
    }else{
        getNasional();
    }
}

function getNasional(){
     var noaNasional = document.getElementById('noaNasional');
    noaNasional.style.display = "inline";
    var osNasional = document.getElementById('osNasional');
    osNasional.style.display = "inline";
// All OS
    axios.get(`<?php echo base_url();?>/api/dashboard/getPerpanjangan`).then(res => {
        const {
            data
        } = res.data;
        const build = [];
        // console.log(res);
        // console.log('build first 1');
        // console.log(build);
        var total = 0;
        var y_1 = 0;
        data.forEach(item => {

            total += parseInt(item.os);
            const index = build.findIndex(f => {
                return f.name == item.area;
            });
            // console.log(index);
            // indexLbl = (item.os - y_1)/y_1*100;
            // console.log(indexLbl);
            const template = index > -1 ? build[index] : {
                type: 'spline',
                name: item.area,
                showInLegend: 'true',
                // indexLabel: indexLbl,
                dataPoints: [],
            }
            template.dataPoints.push({
                label: item.contract_date,
                y: +item.os,
                // indexLabel: toolIndexLabel
            });

            if (index > -1) {
                build[index] = template;
            } else {
                build.push(template)
            }
            y_1 = item.os;
        })
        var chart = new CanvasJS.Chart("chartOs", {
            animationEnabled: true,
            exportEnabled: true,
            title: {
                text: "Perpanjangan Nasional  " 
            },
            axisY: {
                title: "Perpanjangan"
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
    

    // AllNoa
    axios.get(`<?php echo base_url();?>/api/dashboard/getPerpanjangan`).then(
        res => {
            const {
                data
            } = res.data;
            const build = [];
            // console.log(res);
            // console.log('build first 3');
            // console.log(build);
            var total = 0;
            var cabang = '';

            // data = JSON.parse(data);
            data.forEach(item => {
                total += parseInt(item.noa);
                const index = build.findIndex(f => {
                    return f.name == item.area
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    name: item.area,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: item.contract_date,
                    y: +item.noa,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartNoa", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Noa Perpanjangan Area " 
                },
                axisY: {
                    title: "Noa"
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
</script>

<script>
function getOutstanding() {

      //menampilkan grafik
    // var noaArea = document.getElementById('noaArea');
    // noaArea.style.display = "inline";
    // var osArea = document.getElementById('osArea');
    // osArea.style.display = "inline";
    // var noaCabang = document.getElementById('noaCabang');
    // noaCabang.style.display = "inline";
    // var osCabang = document.getElementById('osCabang');
    // osCabang.style.display = "inline";
    // var osUnit = document.getElementById('osUnit');
    // osUnit.style.display = "inline";
    // var saldo = document.getElementById('saldo');
    // saldo.style.display = "inline";


    var user_id = $('#user_id').val();
    var view_id = 6;
    var selectArea = $('#area_id').val();
    var selectBox = $('#branch_id').val();
    var units = $('#units_id').val();

    console.log("selectBox");
    // console.log(selectBox);

    axios.get(`<?php echo base_url();?>/api/dashboard/getInsertView/${user_id}/${view_id}`).then(
        res => {
            const {
                data
            } = res.data;
        }).catch(err => {
        console.log(err)
    })

    var level = $('#level').val();
    if(level == 'area'){
        getCabang();
        getUnits();
        getSaldo();
    }else if(level == 'cabang'){
        getUnits();
        getSaldo();
    }else if(level == 'unit'){
    
    }else if(level == 'kasir'){
    }else{
        getArea();
        getCabang();
        getUnits();
        getSaldo();

    }
}

function getArea(){

     var noaArea = document.getElementById('noaArea');
    noaArea.style.display = "inline";
    var osArea = document.getElementById('osArea');
    osArea.style.display = "inline";

    var selectArea = $('#area_id').val();

    // AreaNoa
    axios.get(`<?php echo base_url();?>/api/dashboard/getPerpanjanganArea/${selectArea}`).then(
        res => {
            const {
                data
            } = res.data;
            const build = [];
            // console.log(res);
            // console.log('build first 3');
            // console.log(build);
            var total = 0;
            var cabang = '';

            // data = JSON.parse(data);
            data.forEach(item => {
                total += parseInt(item.noa);
                const index = build.findIndex(f => {
                    return f.name == item.cabang
                });
                console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    name: item.cabang,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: item.contract_date,
                    y: +item.noa,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelectAreaNoa", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Noa Perpanjangan Area "
                },
                axisY: {
                    title: "Noa"
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

    // Area
    axios.get(`<?php echo base_url();?>/api/dashboard/getPerpanjanganArea/${selectArea}`).then(
        res => {
            const {
                data
            } = res.data;
            const build = [];
            // console.log(res);
            // console.log('build first 4');
            // console.log(build);
            var total = 0;
            data.forEach(item => {
                total += parseInt(item.os);
                const index = build.findIndex(f => {
                    return f.name == item.cabang
                });
                console.log(index)
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    name: item.cabang,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: item.contract_date,
                    y: +item.os,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelectArea", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Perpanjangan Area  " 
                },
                axisY: {
                    title: "Perpanjangan"
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

function getCabang(){
    var noaCabang = document.getElementById('noaCabang');
    noaCabang.style.display = "inline";
    var osCabang = document.getElementById('osCabang');
    osCabang.style.display = "inline";

    var selectArea = $('#area_id').val();
    var selectBox = $('#branch_id').val();
    // UnitsNoa
    axios.get(`<?php echo base_url();?>/api/dashboard/getPerpanjanganCabang/${selectArea}/${selectBox}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            // console.log(res);
            // console.log('build first 5');
            // console.log(build);
            var total = 0;
            data.forEach(item => {
                total += parseInt(item.noa);
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    name: item.office_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: item.contract_date,
                    y: +item.noa,
                });

                if (index > -1) {
                    build[index] = template;
                } else {
                    build.push(template)
                }
            })
            var chart = new CanvasJS.Chart("chartSelectNoa", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Noa Perpanjangan Cabang "
                },
                axisY: {
                    title: "Noa"
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

    // Units
    axios.get(`<?php echo base_url();?>/api/dashboard/getPerpanjanganCabang/${selectArea}/${selectBox}`)
        .then(res => {
            const {
                data
            } = res.data;
            const build = [];
            // console.log(res);
            // console.log('build first 6');
            // console.log(build);
            var total = 0;
            data.forEach(item => {
                total += parseInt(item.os);
                const index = build.findIndex(f => {
                    return f.name == item.office_name
                });
                // console.log(index);
                const template = index > -1 ? build[index] : {
                    type: 'spline',
                    name: item.office_name,
                    showInLegend: 'true',
                    dataPoints: [],
                }
                template.dataPoints.push({
                    label: item.contract_date,
                    y: +item.os,
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
                    text: "Perpanjangan Cabang  " 
                },
                axisY: {
                    title: "Perpanjangan"
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

    function getUnits(){
                var osUnit = document.getElementById('osUnit');
    osUnit.style.display = "inline";

    var units = $('#units_id').val();
    //os Reguler, opsi, smartphone
    axios.get(`<?php echo base_url();?>/api/dashboard/getPerpanjanganSelectUnits/${units}`).then(res => {
        const {
            data
        } = res.data;
        const build = [];
        const reguler = [];
        const smartphone = [];
        const instalment = [];
        const opsi = [];
        var unit = '';

        console.log('new intanceof instance');
        // console.log(res.data)
        console.log(reguler);
        // console.log(smartphone);
        // console.log(opsi);
        // console.log(instalment);
        data.forEach(
            item => {

                unit = item.office_name;
                // console.log('office' + item.office_name)
                const a = reguler.findIndex(f => {
                    return f.name == 'Reguler';
                });
                const b = opsi.findIndex(f => {
                    return f.name == 'Opsi';
                });
                const c = instalment.findIndex(f => {
                    return f.name == 'Cicilan';
                });
                const d = smartphone.findIndex(f => {
                    return f.name == 'Smartphone';
                });


                const reg = a > -1 ? reguler[a] : {
                    yValueFormatString: "#,###",
                    type: "stackedColumn",
                    showInLegend: true,
                    color: "#B6B1A8",
                    name: "Reguler",
                    click: function(e) {
                        var units = $('#units_id').val();
                        const month = e.dataPoint.x.getMonth();
                        const bulan = month+1;
                        var date = e.dataPoint.x.getDate();
                      window.open('<?php echo base_url();?>/monitoring/perpanjangan/detail/' + date + '/' + units, '_blank');
                        win.focus(); 
                    },
                    dataPoints: []
                }
                const ops = b > -1 ? opsi[b] : {
                    yValueFormatString: "#,###",

                    type: "stackedColumn",
                    showInLegend: true,
                    color: "#EDCA93",
                    name: "Opsi",
                    click: function(e) {
                        var units = $('#units_id').val();
                        const month = e.dataPoint.x.getMonth();
                        const bulan = month+1;
                        var date = e.dataPoint.x.getDate();
                       window.open('<?php echo base_url();?>/monitoring/perpanjangan/detail/' + date + '/' + units, '_blank');
                        win.focus(); 
                    },
                    dataPoints: []
                }
                const instal = c > -1 ? instalment[c] : {
                    yValueFormatString: "#,###",
                    type: "stackedColumn",
                    showInLegend: true,
                    color: "#695A42",
                    name: "Cicilan",
                    click: function(e) {

                        var units = $('#units_id').val();
                        const month = e.dataPoint.x.getMonth();
                        const bulan = month+1;
                        var date = e.dataPoint.x.getDate();
                       window.open('<?php echo base_url();?>/monitoring/perpanjangan/detail/' + date + '/' + units, '_blank');
                        win.focus(); 
                    },
                    dataPoints: []
                }
                const smart = d > -1 ? smartphone[d] : {
                    yValueFormatString: "#,###",
                    type: "stackedColumn",
                    showInLegend: true,
                    color: "#EDCA93",
                    name: "Smartphone",
                    click: function(e) {
                        var units = $('#units_id').val();
                        const month = e.dataPoint.x.getMonth();
                        const bulan = month+1;
                        var date = e.dataPoint.x.getDate();
                       window.open('<?php echo base_url();?>/monitoring/perpanjangan/detail/' + date + '/' + units, '_blank');
                        win.focus(); 
                    },

                    dataPoints: []
                }
                // console.log(reg);
                // console.log(ops);
                // console.log(instal);
                // console.log(smart);

                reg.dataPoints.push({
                    x: new Date(item.contract_date),
                    y: +item.os_reguler
                });
                ops.dataPoints.push({
                    x: new Date(item.contract_date),
                    y: +item.os_opsi
                });
                instal.dataPoints.push({
                    x: new Date(item.contract_date),
                    y: +item.os_instal
                });
                smart.dataPoints.push({
                    x: new Date(item.contract_date),
                    y: +item.os_smartphone
                });

                if (a > -1) {
                    reguler[a] = reg;
                } else {
                    reguler.push(reg)
                }
                if (b > -1) {
                    opsi[b] = ops;
                } else {
                    opsi.push(ops)
                }
                if (c > -1) {
                    instalment[c] = instal;
                } else {
                    instalment.push(instal)
                }
                if (d > -1) {
                    smartphone[d] = smart;

                } else {
                    smartphone.push(smart)
                }
                unit = item.office_name;

            })

        var chart = new CanvasJS.Chart("chartUnits", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Perpanjangan Unit " + unit,
                fontFamily: "arial black",
                fontColor: "#695A42"
            },
            axisX: {
                interval: 1,
                // intervalType: "year"
            },
            axisY: {
                // valueFormatString: "$#0bn",
                gridColor: "#B6B1A8",
                tickColor: "#B6B1A8"
            },
            toolTip: {
                shared: true,
                content: toolTipContent
            },
            data: [...reguler,
                ...opsi,
                ...instalment,
                ...smartphone,
            ]
        });
        // console.log(reguler, opsi, hp);
        chart.render();
    }).catch(err => {
        console.log(err)
    })

}

    
function getSaldo(){
    var saldo = document.getElementById('saldo');
    saldo.style.display = "inline";

    var units = $('#units_id').val();
    //Saldo
    axios.get(`<?php echo base_url();?>/api/dashboard/getSaldo/${units}`).then(
        res => {
            const {
                data
            } = res.data;
            // console.log('data');
            // console.log(res.data);

            const awal = [];

            var total = 0;
            var unit = '';
            var saldo = 0;
            console.log('saldo')
            console.log(awal);
            data.forEach(item => {
                unit = item.office_name;
                saldo = item.saldo;
                const a = awal.findIndex(f => {
                    return f.name == 'Saldo Akhir';
                });


                const templateAwal = a > -1 ? awal[a] : {
                    yValueFormatString: "#,### Units",
                    xValueFormatString: "YYYY-MM-DD",
                    type: "spline",
                    // showInLegend: true,
                    // color: "#B6B1A8",
                    name: "Saldo Akhir",
                    dataPoints: []
                }

                templateAwal.dataPoints.push({
                    x: new Date(item.date_open),
                    y: +item.remaining_balance
                });

                if (a > -1) {
                    awal[a] = templateAwal;
                } else {
                    awal.push(templateAwal);
                }



            });


            var chart = new CanvasJS.Chart("chartSaldo", {
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Saldo Kas Unit " + unit,
                    fontFamily: "arial black",
                    fontColor: "#695A42"
                },
                axisY: {
                    title: "Saldo",
                    valueFormatString: "#0,,.",
                    suffix: "jt",
                    stripLines: [{
                        value: saldo,
                        label: "Maximum ( " +convertToRupiah(saldo) + " )",
                    }]
                },

                data: [...awal, ]
            });


            chart.render();
        }).catch(err => {
        console.log(err)
    })

}



</script>
<?php echo $this->endSection();?>