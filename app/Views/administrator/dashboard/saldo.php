<?php echo $this->extend('layouts/administrator');?>

<?php echo $this->section('content');?>

<section class="section">

    <div class="row">

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
                                    <a href=" #" class="dropdown-item"> <span class="dropdown-item-desc"> <span
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

        <div id="saldo" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;">
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
    </div>

    <input type="hidden" name="url_get_cabang" id="url_get_cabang"
        value="<?php echo base_url('generate/office/getCabang') ?>" />
    <input type="hidden" name="url_get_units" id="url_get_units"
        value="<?php echo base_url('api/datamaster/units/get_unit_bycabang') ?>" />

</section>

<?php echo $this->endsection();?>

<?php echo $this->section('jslibraies')?>
<script src="<?php echo base_url();?>/assets-panel/bundles/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>/assets-panel/js/modules/dashboard/index.js"></script>
<script src="<?php echo base_url();?>/assets-panel/bundles/datatables/datatables.min.js"></script>
<script
    src="<?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js">
</script>
<script src="<?php echo base_url();?>/assets-panel/bundles/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>/assets-panel/bundles/sweetalert/sweetalert.min.js"></script>

<!-- Add New Javascript -->
<script>

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
            console.log('test');
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
            console.log('test');
            // console.log(build);
            data.forEach(item => {

                var opt = document.createElement("option");
                opt.value = item.office_id;
                opt.text = item.name;
                units.appendChild(opt);


            })
        });
});
</script>
<script>
function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
}

var getOutstanding;
var selectUnits = 1;

window.onload = function() {


    var count = document.getElementById('count');
    var view_id = 5;
    axios.get(`<?php echo base_url();?>/api/dashboard/getCountView/${view_id}`).then(
        res => {
            const {
                data
            } = res.data;

            data.forEach(item => {
                console.log('count');
                console.log(item.count);

                var closeSpan = document.createElement("span");
                closeSpan.setAttribute("class", "badge headerBadge1");
                closeSpan.textContent = item.count;

            })
        }).catch(err => {
        console.log(err)
    })

    

    var level = $('#level').val();
    if(level == 'unit'){
        getOutstanding();
    }
    if(level == 'kasir'){
        getOutstanding();
    }



}

function getOutstanding() {

      //menampilkan grafik
    
    var saldo = document.getElementById('saldo');
    saldo.style.display = "inline";

    var user_id = $('#user_id').val();
    var view_id = 5;
    var selectArea = $('#area_id').val();
    var selectBox = $('#branch_id').val();
    var units = $('#units_id').val();

    console.log("selectBox");
    console.log(selectBox);

    axios.get(`<?php echo base_url();?>/api/dashboard/getInsertView/${user_id}/${view_id}`).then(
        res => {
            const {
                data
            } = res.data;
        }).catch(err => {
        console.log(err)
    })

    axios.get(`<?php echo base_url();?>/api/dashboard/getSaldo/${units}`).then(
        res => {
            const {
                data
            } = res.data;
            console.log('data');
            console.log(res.data);

            const awal = [];

            var total = 0;
            var unit = '';
            var saldo  = 0;
            console.log(awal)
            data.forEach(item => {
                // total += parseInt(item.os);
                // const index = build.findIndex(f => {
                //     return f.name == item.office_name;
                // });
                unit = item.office_name;
                saldo = parseInt(item.saldo);
                const a = awal.findIndex(f => {
                    return f.name == 'Saldo Akhir';
                });


                const templateAwal = a > -1 ? awal[a] : {
                    type: "line",
                    xValueFormatString: "DD MMM YYYY",
                    color: "#F08080",
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



            })


            var chart = new CanvasJS.Chart("chartSaldo", {
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Saldo Kas Unit " + unit,
                    fontFamily: "arial black",
                    fontColor: "#695A42"
                },
                axisX:{
                    valueFormatString: "DD MMM"
                },
                axisY: {
                    title: "Saldo",
                    includeZero: false,
                    stripLines: [{
                        value: saldo,
                        label: "Maximum ( " + convertToRupiah(saldo) + " )", 
                    }]
                    // title: "Saldo",
                    // valueFormatString: "#0,,.",
                    // suffix: "jt",
                    // stripLines: [{
                    //     value: 50000000,
                    //     label: "Maximum"
                    // }]
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