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
              
            
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="boxs mail_listing">
                    <div class="inbox-body no-pad">
                      <section class="mail-list">

                        <div class="mail-sender">
                          <div class="mail-heading">
                            <h4 class="vew-mail-header">
                                <span>
                                    <a href="<?php echo base_url('administrator/notifications'); ?>" class="col-dark-gray waves-effect" title="back"
                                      data-toggle="tooltip">
                                      <div class="preview">
                                                    <div class="icon-preview">
                                                        <i class="fas fa-arrow-circle-left"></i>
                                                    </div>
                                                </div>
                                    </a>
                                </span>
                              <b><?php echo $notifications->message; ?></b>
                               
                            </h4>
                            <a class="media-body">
                              <small style="color: blue;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Unit: <?php echo $notifications->office_name; ?></small>
                            </a>
                          <hr>
                          <div class="media">
                            
                            <div class="media-body">
                              <span class="date pull-right" id="date3"></span>                              
                            </div>
                          </div>                          
                        </div>
                        <br>

                        <input type="hidden" id="id_notif" name="id_notif" value="<?php echo $id ?>" />
                        <input type="hidden" id="office_id" name="office_id" value="<?php echo $notifications->office_id; ?>" />

                        <input type="hidden" id="saldo" name="saldo" value="<?php echo $notifications->saldo; ?>" />
                        <input type="hidden" id="date" name="date" value="<?php echo $notifications->created_at; ?>" />

                        <div class="view-mail p-t-20">
                            <p>Saldo Kas Unit <?php echo $notifications->office_name; ?> pada tanggal <span id='date1'></span> senilai 
                                <a href="#" id="saldoya"></a>.
                            </p><br>
                          <p>
                            Saldo Saat ini :                           
                          </p>
                          
                        </div>

    <!-- Grafik Saldo -->
                        <div class="view-mail p-t-20">
                            <div  class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

                        <!-- <div class="attachment-mail">
                          <p>
                            <span>
                              <i class="fa fa-paperclip"></i> 3 attachments — </span>
                            <a href="#">Download all attachments</a> |
                            <a href="#">View all images</a>
                          </p>
                          <div class="row">
                            <div class="col-md-2">
                              <a href="#">
                                <img class="img-thumbnail img-responsive" alt="attachment"
                                  src="assets/img/users/user-1.png">
                              </a>
                              <a class="name" href="#"> IMG_001.png
                                <span>20KB</span>
                              </a>
                            </div>
                            <div class="col-md-2">
                              <a href="#">
                                <img class="img-thumbnail img-responsive" alt="attachment"
                                  src="assets/img/users/user-3.png">
                              </a>
                              <a class="name" href="#"> IMG_002.png
                                <span>22KB</span>
                              </a>
                            </div>
                            <div class="col-md-2">
                              <a href="#">
                                <img class="img-thumbnail img-responsive" alt="attachment"
                                  src="assets/img/users/user-4.png">
                              </a>
                              <a class="name" href="#"> IMG_003.png
                                <span>28KB</span>
                              </a>
                            </div>
                          </div>
                        </div>
                        <div class="replyBox m-t-20">
                          <p class="p-b-20">click here to
                            <a href="#">Reply</a> or
                            <a href="#">Forward</a>
                          </p>
                        </div> -->
                      </section>
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

<script >
    function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
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
            window.open('<?php echo base_url();?>/administrator/notifications/saldo/' + $id, '_blank');
        }

window.onload = function() {
    

    //Hour
    var created_at = $('#date').val();
    lengthDate = created_at.length;
    hour = created_at.substring(lengthDate-8, lengthDate);
    console.log('hor', hour);
    
    //Date
    var date = new Date(created_at);
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    dateLeft =  date.getDate() + ' ' +  months[date.getMonth()] + ' ' + date.getFullYear() + ' Pukul ' + hour;
    dateRight = date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear() + ' ' + hour;
    //Date Hour
    var date3 = document.getElementById('date3');
    date3.textContent = dateRight;
    //Date Hour2
    var date1 = document.getElementById('date1');
    date1.textContent = dateLeft;



    // Saldo
    var saldo = $('#saldo').val();
    var length = saldo.length;
    // console.log('length',length-4);
    var saldo = saldo.substring(0, length-4);
        // console.log('saldo',saldo);

    var saldoya = document.getElementById('saldoya');

    saldoya.textContent = "Rp " + convertToRupiah(saldo);
    var units = $('#office_id').val();

    console.log(units);
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
var id = $('#id_notif').val();
    updateRead(id);
   
    </script>
<?php echo $this->endSection();?>