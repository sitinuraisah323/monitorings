
<h3>Summary Alert Warning System <?php echo date('d-m-Y');  ?></h3>


<?php  
    $dateOST = date('d-m-Y',strtotime($date));
    $dateLastOST = date('d-m-Y', strtotime('-1 days', strtotime($date)));

                $ltvMinAll = 0;
                $ltvMaxAll = 0;
                $osMinAll = 0;
                $osMaxAll = 0;
                $dpdMinAll = 0;
                $dpdMaxAll = 0;
                $ticketMinAll = 0;
                $ticketMaxAll = 0;
                $mokerMinAll = 0;
                $mokerMaxAll = 0;
                $batalMaxAll = 0;
                $frequensiMinAll = 0;
                $frequensiMaxAll = 0;
                $oneobligorMinAll = 0;
                $oneobligorMaxAll = 0;
?>
<hr/>

<table class="table" border="1">
    <tr bgcolor="darkgrey">
                <td rowspan="2" align="center"  width="20">No</td>
                <td rowspan="2" align="center" width="100"> Area</td>
                <td rowspan="2" align="center" width="150"> Unit</td>
                <td colspan="2" align="center" width="100">LTV</td>
                <td colspan="2" align="center" width="120">Outstanding</td>
                <td colspan="2" align="center" width="120">DPD</td>
                <td colspan="2" align="center" width="200">Ticketsize</td>
                <td colspan="2" align="center" width="100">Frequensi per Nasabah</td>
                <td colspan="2" align="center" width="200">Modal Kerja</td>
                <td rowspan="2" align="center" width="60">Pembatalan</td>
                <td rowspan="2" align="center" width="60">Oneobligor</td>
            </tr>
            <tr>
                <td align="center" width="50" bgcolor="#d6d6c2">krg dr 92%</td>
                <td align="center" width="50" bgcolor="#d6d6c2">lbh dr 92%</td>
                <td align="center" width="60" bgcolor="#b8b894"> krg dr 5% </td>
                <td align="center" width="60" bgcolor="#b8b894"> lbh dr 5%</td>
                <td align="center" width="60" bgcolor="#d6d6c2">krg dr 5% </td>
                <td align="center" width="60" bgcolor="#d6d6c2">lbh dr 5%</td>
                <td align="center" width="100" bgcolor="#b8b894">bln sblmny</td>
                <td align="center" width="100" bgcolor="#b8b894">bln ini</td>
                <td align="center" width="50" bgcolor="#b8b894">krg dr 5Trx</td>
                <td align="center" width="50" bgcolor="#b8b894">lbh dr 5Trx</td>
                <td align="center" width="100" bgcolor="#b8b894">bln sblmnya</td>
                <td align="center" width="100" bgcolor="#b8b894">bln ini</td>

            </tr>
            
    <?php foreach($outstanding as $area => $datas):
    //    echo $datas->ltv->min;
        ?>

        
            <?php 
                //initial 
                $ltvMinArea = 0;
                $ltvMaxArea = 0;
                $osMinArea = 0;
                $osMaxArea = 0;
                $dpdMinArea = 0;
                $dpdMaxArea = 0;
                $ticketMinArea = 0;
                $ticketMaxArea = 0;
                $mokerMinArea = 0;
                $mokerMaxArea = 0;
                $batalMaxArea = 0;
                $frequensiMinArea = 0;
                $frequensiMaxArea = 0;
                $oneobligorMinArea = 0;
                $oneobligorMaxArea = 0;

            ?>
            <?php $no_ = 0;?>
            <?php foreach($datas as $data): $no_++;?>
            <?php

                $ltvMinArea += $data->ltv->min;
                $ltvMaxArea += $data->ltv->max;
                $osMinArea += $data->outstanding->min;
                $osMaxArea += $data->outstanding->max;
                $dpdMinArea += $data->dpd->min;
                $dpdMaxArea += $data->dpd->max;
                $ticketMinArea += $data->ticketsize->min;
                $ticketMaxArea += $data->ticketsize->max;
                $mokerMinArea += $data->moker->min;
                $mokerMaxArea += $data->moker->max;
                $batalMaxArea += $data->batal->max;
                $frequensiMinArea += $data->frequensi->min;
                $frequensiMaxArea += $data->frequensi->max;
                $oneobligorMinArea += $data->oneobligor->min;
                $oneobligorMaxArea += $data->oneobligor->max;
            ?>
            <tr>
                <td align="center"><?php echo $no_; ?></td>
                <td align="left"> <?php echo $data->area;?></td>
                <td align="left"> <?php echo $data->name;?></td>

                <td align="center"><?php echo $data->ltv->min;?></td>
                <td align="center" <?php if($data->ltv->max != 0){ ?> bgcolor="red" <?php } ?> ><?php echo number_format($data->ltv->max,0);?></td>
                <td align="center"><?php echo $data->outstanding->min;?>%</td>
                <td align="center" <?php if($data->outstanding->max != 0){ ?> bgcolor="red" <?php } ?>><?php echo $data->outstanding->max;?>%</td>
                <td align="center"><?php echo $data->dpd->min;?>%</td>
                <td align="center" <?php if($data->dpd->max != 0){ ?> bgcolor="red" <?php } ?> ><?php echo $data->dpd->max;?>%</td>
                <td align="right"><?php echo number_format($data->ticketsize->min); ?></td>
                <td align="right" ><?php echo number_format($data->ticketsize->max);?></td>

                <td align="center"><?php echo $data->frequensi->min;?></td>
                <td align="center" <?php if($data->frequensi->max != 0){ ?> bgcolor="red" <?php } ?>><?php echo $data->frequensi->max;?></td>
                <td align="right"><?php echo number_format($data->moker->min);?></td>
                <td align="right" ><?php echo number_format($data->moker->max);?></td>
                <td align="center" <?php if($data->batal->max != 0){ ?> bgcolor="red" <?php } ?> ><?php echo $data->batal->max;?></td>
                <td align="center" <?php if($data->oneobligor->max != 0){ ?> bgcolor="red" <?php } ?> ><?php echo $data->oneobligor->max;?></td>

            </tr>
            <?php endforeach;?>
           
            <tr bgcolor="#ffff00">
                <td align="right" colspan="3"> Total_</td>
                <td align="center"><?php echo $ltvMinArea; ?></td>
                <td align="center" ><?php echo $ltvMaxArea; ?></td>
                <td align="center"><?php echo $osMinArea; ?>%</td>
                <td align="center"><?php echo $osMaxArea; ?>%</td>
                <td align="center"><?php echo $dpdMinArea; ?>%</td>
                <td align="center"><?php echo $dpdMaxArea; ?>%</td>
                <td align="right"><?php echo number_format($ticketMinArea); ?></td>
                <td align="right"><?php echo number_format($ticketMaxArea); ?></td>
                <td align="center"><?php echo $frequensiMinArea; ?></td>
                <td align="center"><?php echo $frequensiMaxArea; ?></td>
                <td align="right"><?php echo number_format($mokerMinArea); ?></td>
                <td align="right"><?php echo number_format($mokerMaxArea); ?></td>
                <td align="center"><?php echo $batalMaxArea; ?></td>
                <td align="center"><?php echo $oneobligorMaxArea; ?></td>
            </tr>

            <?php
                $ltvMinAll += $ltvMinArea;
                $ltvMaxAll += $ltvMaxArea;
                $osMinAll += $osMinArea;
                $osMaxAll += $osMaxArea;
                $dpdMinAll += $dpdMinArea;
                $dpdMaxAll += $dpdMaxArea;
                $ticketMinAll += $ticketMinArea;
                $ticketMaxAll += $ticketMaxArea;
                $mokerMinAll += $mokerMinArea;
                $mokerMaxAll += $mokerMaxArea;
                $batalMaxAll += $batalMaxArea;
                $frequensiMinAll += $frequensiMinArea;
                $frequensiMaxAll += $frequensiMaxArea;
                $oneobligorMaxAll += $oneobligorMaxArea;
            ?>
   
    <?php endforeach;?>
    </table>
    <br/><br/>
    <table class="table" border="1"> 
    <tr bgcolor="#D4D5D5">
        <td colspan="10" align="center" width="1230">Summary Alert Warning System</td>
    </tr>  
    <tr bgcolor="darkgrey">
                <td rowspan="2" align="center"  width="20">No</td>
                <td rowspan="2" align="center" width="100"> Area</td>
                <td rowspan="2" align="center" width="150"> Unit</td>
                <td colspan="2" align="center" width="100">LTV</td>
                <td colspan="2" align="center" width="120">Outstanding</td>
                <td colspan="2" align="center" width="120">DPD</td>
                <td colspan="2" align="center" width="200">Ticketsize</td>
                <td colspan="2" align="center" width="100">Frequensi per Nasabah</td>
                <td colspan="2" align="center" width="200">Modal Kerja</td>
                <td rowspan="2" align="center" width="60">Pembatalan</td>
                <td rowspan="2" align="center" width="60">Oneobligor</td>
            </tr>
            <tr>
                <td align="center" width="50" bgcolor="#d6d6c2">krg dr 92%</td>
                <td align="center" width="50" bgcolor="#d6d6c2">lbh dr 92%</td>
                <td align="center" width="60" bgcolor="#b8b894"> krg dr 5% </td>
                <td align="center" width="60" bgcolor="#b8b894"> lbh dr 5%</td>
                <td align="center" width="60" bgcolor="#d6d6c2">krg dr 5% </td>
                <td align="center" width="60" bgcolor="#d6d6c2">lbh dr 5%</td>
                <td align="center" width="100" bgcolor="#b8b894">Minimum</td>
                <td align="center" width="100" bgcolor="#b8b894">Maximum</td>
                <td align="center" width="50" bgcolor="#b8b894">krg dr 5Trx</td>
                <td align="center" width="50" bgcolor="#b8b894">lbh dr 5Trx</td>
                <td align="center" width="100" bgcolor="#b8b894">Minimum</td>
                <td align="center" width="100" bgcolor="#b8b894">Maximum</td>

            </tr>  
            
            <tr bgcolor="#ffff00">
                <td align="right" colspan="3"> Total_</td>
                <td align="center"><?php echo $ltvMinAll; ?></td>
                <td align="center" ><?php echo $ltvMaxAll; ?></td>
                <td align="center"><?php echo $osMinAll; ?>%</td>
                <td align="center"><?php echo $osMaxAll; ?>%</td>
                <td align="center"><?php echo $dpdMinAll; ?>%</td>
                <td align="center"><?php echo $dpdMaxAll; ?>%</td>
                <td align="right"><?php echo number_format($ticketMinAll); ?></td>
                <td align="right"><?php echo number_format($ticketMaxAll); ?></td>
                <td align="center"><?php echo $frequensiMinAll; ?></td>
                <td align="center"><?php echo $frequensiMaxAll; ?></td>
                <td align="right"><?php echo number_format($mokerMinAll); ?></td>
                <td align="right"><?php echo number_format($mokerMaxAll); ?></td>
                <td align="center"><?php echo $batalMaxAll; ?></td>
                <td align="center"><?php echo $oneobligorMaxAll; ?></td>
            </tr>
</table>


<h3> Approval Deviasi <?php echo date('d-m-Y');  ?></h3>


<?php  
    $dateOST = date('d-m-Y',strtotime($date));
    $dateLastOST = date('d-m-Y', strtotime('-1 days', strtotime($date)));
   
                $ltvCabangAll = 0;
                $sewaCabangAll = 0;
                $adminCabangAll = 0;
                $oneobligorCabangAll = 0;
                $limitCabangAll = 0;

                $ltvAreasAll = 0;
                $sewaAreasAll = 0;
                $adminAreasAll = 0;
                $oneobligorAreasAll = 0;
                $limitAreasAll = 0;

                $ltvRegionalAll = 0;
                $sewaRegionalAll = 0;
                $adminRegionalAll = 0;
                $oneobligorRegionalAll = 0;
                $limitRegionalAll = 0;

                $ltvPusatAll = 0;
                $sewaPusatAll = 0;
                $adminPusatAll = 0;
                $oneobligorPusatAll = 0;
                $limitPusatAll = 0;
                
?>
<hr/>

<table class="table" border="1">
    <tr bgcolor="darkgrey">
                <td rowspan="2" align="center"  width="20">No</td>
                <td rowspan="2" align="center" width="100"> Area</td>
                <td rowspan="2" align="center" width="150"> Unit</td>
                <td colspan="5" align="center" width="250">Cabang</td>
                <td colspan="5" align="center" width="250">Area</td>
                <td colspan="5" align="center" width="250">Regional</td>
                <td colspan="5" align="center" width="250">Pusat</td>
            </tr>
            <tr>
                <td align="center" width="50" bgcolor="#d6d6c2">LTV</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Sewa</td>
                <td align="center" width="50" bgcolor="#b8b894"> Admin</td>
                <td align="center" width="50" bgcolor="#b8b894"> Oneobligor</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Limit Trx </td>
                <td align="center" width="50" bgcolor="#d6d6c2">LTV</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Sewa</td>
                <td align="center" width="50" bgcolor="#b8b894"> Admin</td>
                <td align="center" width="50" bgcolor="#b8b894"> Oneobligor</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Limit Trx </td>
                <td align="center" width="50" bgcolor="#d6d6c2">LTV</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Sewa</td>
                <td align="center" width="50" bgcolor="#b8b894"> Admin</td>
                <td align="center" width="50" bgcolor="#b8b894"> Oneobligor</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Limit Trx </td>
                <td align="center" width="50" bgcolor="#d6d6c2">LTV</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Sewa</td>
                <td align="center" width="50" bgcolor="#b8b894"> Admin</td>
                <td align="center" width="50" bgcolor="#b8b894"> Oneobligor</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Limit Trx </td>

            </tr>
            
    <?php foreach($outstanding as $area => $datas):
    //    echo $datas->ltv->min;
        ?>
            <?php 
                //initial 
                $ltvCabang = 0;
                $sewaCabang = 0;
                $adminCabang = 0;
                $oneobligorCabang = 0;
                $limitCabang = 0;

                $ltvAreas = 0;
                $sewaAreas = 0;
                $adminAreas = 0;
                $oneobligorAreas = 0;
                $limitAreas = 0;

                $ltvRegional = 0;
                $sewaRegional = 0;
                $adminRegional = 0;
                $oneobligorRegional = 0;
                $limitRegional = 0;

                $ltvPusat = 0;
                $sewaPusat = 0;
                $adminPusat = 0;
                $oneobligorPusat = 0;
                $limitPusat = 0;
                

            ?>
            <?php $no_ = 0;?>
            <?php foreach($datas as $data): $no_++;?>
            <?php

                $ltvCabang += $data->cabang->ltv;
                $sewaCabang += $data->cabang->sewa;
                $adminCabang += $data->cabang->admin;
                $oneobligorCabang += $data->cabang->oneobligor;
                $limitCabang += $data->cabang->limit;

                $ltvAreas += $data->areas->ltv;
                $sewaAreas += $data->areas->sewa;
                $adminAreas += $data->areas->admin;
                $oneobligorAreas += $data->areas->oneobligor;
                $limitAreas += $data->areas->limit;

                $ltvRegional += $data->regional->ltv;
                $sewaRegional += $data->regional->sewa;
                $adminRegional += $data->regional->admin;
                $oneobligorRegional += $data->regional->oneobligor;
                $limitRegional += $data->regional->limit;

                $ltvPusat += $data->pusat->ltv;
                $sewaPusat += $data->pusat->sewa;
                $adminPusat += $data->pusat->admin;
                $oneobligorPusat += $data->pusat->oneobligor;
                $limitPusat += $data->pusat->limit;

            ?>
            <tr>
                <td align="center"><?php echo $no_; ?></td>
                <td align="left"> <?php echo $data->area;?></td>
                <td align="left"> <?php echo $data->name;?></td>

                <td align="center"><?php echo $data->cabang->ltv;?></td>
                <td align="center"><?php echo $data->cabang->sewa;?></td>
                <td align="center"><?php echo $data->cabang->admin;?></td>
                <td align="center"><?php echo $data->cabang->oneobligor;?></td>
                <td align="center"><?php echo $data->cabang->limit;?></td>

                <td align="center"><?php echo $data->areas->ltv;?></td>
                <td align="center"><?php echo $data->areas->sewa;?></td>
                <td align="center"><?php echo $data->areas->admin;?></td>
                <td align="center"><?php echo $data->areas->oneobligor;?></td>
                <td align="center"><?php echo $data->areas->limit;?></td>

                <td align="center"><?php echo $data->regional->ltv;?></td>
                <td align="center"><?php echo $data->regional->sewa;?></td>
                <td align="center"><?php echo $data->regional->admin;?></td>
                <td align="center"><?php echo $data->regional->oneobligor;?></td>
                <td align="center"><?php echo $data->regional->limit;?></td>

                <td align="center"><?php echo $data->pusat->ltv;?></td>
                <td align="center"><?php echo $data->pusat->sewa;?></td>
                <td align="center"><?php echo $data->pusat->admin;?></td>
                <td align="center"><?php echo $data->pusat->oneobligor;?></td>
                <td align="center"><?php echo $data->pusat->limit;?></td>
            </tr>
            <?php endforeach;?>
           
            <tr bgcolor="#ffff00">
                <td align="right" colspan="3"> Total_</td>
                <td align="center"><?php echo $ltvCabang; ?></td>
                <td align="center" ><?php echo $sewaCabang; ?></td>
                <td align="center"><?php echo $adminCabang; ?></td>
                <td align="center"><?php echo $oneobligorCabang; ?></td>
                <td align="center"><?php echo $limitCabang; ?></td>
                
                <td align="center"><?php echo $ltvAreas; ?></td>
                <td align="center" ><?php echo $sewaAreas; ?></td>
                <td align="center"><?php echo $adminAreas; ?></td>
                <td align="center"><?php echo $oneobligorAreas; ?></td>
                <td align="center"><?php echo $limitAreas; ?></td>

                <td align="center"><?php echo $ltvRegional; ?></td>
                <td align="center" ><?php echo $sewaRegional; ?></td>
                <td align="center"><?php echo $adminRegional; ?></td>
                <td align="center"><?php echo $oneobligorRegional; ?></td>
                <td align="center"><?php echo $limitRegional; ?></td>

                <td align="center"><?php echo $ltvPusat; ?></td>
                <td align="center" ><?php echo $sewaPusat; ?></td>
                <td align="center"><?php echo $adminPusat; ?></td>
                <td align="center"><?php echo $oneobligorPusat; ?></td>
                <td align="center"><?php echo $limitPusat; ?></td>
                
            </tr>

            <?php
                $ltvCabangAll += $ltvCabang;
                $sewaCabangAll += $sewaCabang;
                $adminCabangAll += $adminCabang;
                $oneobligorCabangAll += $oneobligorCabang;
                $limitCabangAll += $limitCabang;

                $ltvAreasAll += $ltvAreas;
                $sewaAreasAll += $sewaAreas;
                $adminAreasAll += $adminAreas;
                $oneobligorAreasAll += $oneobligorAreas;
                $limitAreasAll += $limitAreas;

                $ltvRegionalAll += $ltvRegional;
                $sewaRegionalAll += $sewaRegional;
                $adminRegionalAll += $adminRegional;
                $oneobligorRegionalAll += $oneobligorRegional;
                $limitRegionalAll += $limitRegional;

                $ltvPusatAll += $ltvPusat;
                $sewaPusatAll += $sewaPusat;
                $adminPusatAll += $adminPusat;
                $oneobligorPusatAll += $oneobligorPusat;
                $limitPusatAll += $limitPusat;
            ?>
   
    <?php endforeach;?>
    </table>
    <br/><br/>
    <table class="table" border="1"> 
    <tr bgcolor="#D4D5D5">
        <td colspan="10" align="center" width="1270">Summary Alert Warning System</td>
    </tr>  
    <tr bgcolor="darkgrey">
                <td rowspan="2" align="center"  width="20">No</td>
                <td rowspan="2" align="center" width="100"> Area</td>
                <td rowspan="2" align="center" width="150"> Unit</td>
                <td colspan="5" align="center" width="250">Cabang</td>
                <td colspan="5" align="center" width="250">Area</td>
                <td colspan="5" align="center" width="250">Regional</td>
                <td colspan="5" align="center" width="250">Pusat</td>
            </tr>
            <tr>
                <td align="center" width="50" bgcolor="#d6d6c2">LTV</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Sewa</td>
                <td align="center" width="50" bgcolor="#b8b894"> Admin</td>
                <td align="center" width="50" bgcolor="#b8b894"> Oneobligor</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Limit Trx </td>
                <td align="center" width="50" bgcolor="#d6d6c2">LTV</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Sewa</td>
                <td align="center" width="50" bgcolor="#b8b894"> Admin</td>
                <td align="center" width="50" bgcolor="#b8b894"> Oneobligor</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Limit Trx </td>
                <td align="center" width="50" bgcolor="#d6d6c2">LTV</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Sewa</td>
                <td align="center" width="50" bgcolor="#b8b894"> Admin</td>
                <td align="center" width="50" bgcolor="#b8b894"> Oneobligor</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Limit Trx </td>
                <td align="center" width="50" bgcolor="#d6d6c2">LTV</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Sewa</td>
                <td align="center" width="50" bgcolor="#b8b894"> Admin</td>
                <td align="center" width="50" bgcolor="#b8b894"> Oneobligor</td>
                <td align="center" width="50" bgcolor="#d6d6c2">Limit Trx </td>

            </tr>
            
           <tr bgcolor="#ffff00">
                <td align="right" colspan="3"> Total_</td>
                <td align="center"><?php echo $ltvCabangAll; ?></td>
                <td align="center" ><?php echo $sewaCabangAll; ?></td>
                <td align="center"><?php echo $adminCabangAll; ?></td>
                <td align="center"><?php echo $oneobligorCabangAll; ?></td>
                <td align="center"><?php echo $limitCabangAll; ?></td>
                
                <td align="center"><?php echo $ltvAreasAll; ?></td>
                <td align="center" ><?php echo $sewaAreasAll; ?></td>
                <td align="center"><?php echo $adminAreasAll; ?></td>
                <td align="center"><?php echo $oneobligorAreasAll; ?></td>
                <td align="center"><?php echo $limitAreasAll; ?></td>

                <td align="center"><?php echo $ltvRegionalAll; ?></td>
                <td align="center" ><?php echo $sewaRegionalAll; ?></td>
                <td align="center"><?php echo $adminRegionalAll; ?></td>
                <td align="center"><?php echo $oneobligorRegionalAll; ?></td>
                <td align="center"><?php echo $limitRegionalAll; ?></td>

                <td align="center"><?php echo $ltvPusatAll; ?></td>
                <td align="center" ><?php echo $sewaPusatAll; ?></td>
                <td align="center"><?php echo $adminPusatAll; ?></td>
                <td align="center"><?php echo $oneobligorPusatAll; ?></td>
                <td align="center"><?php echo $limitPusatAll; ?></td>
                
            </tr>
</table>


