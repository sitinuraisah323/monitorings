<?php namespace App\Controllers\Api;
use App\Controllers\Api\BaseApiController;
use App\Models\MonitoringOsView;
use App\Models\PawnTransactions;
use CodeIgniter\Format\JSONFormatter;
use DateTime;
use CodeIgniter\Database\Postgre\Connection;

use App\Middleware\Authenticated;
use App\Models\Area;
use App\Models\MonitoringDefrosting;
use App\Models\MonitoringDpd;
use App\Models\MonitoringOs;
use App\Models\MonitoringRepayment;
use App\Models\NonTransactionalTransactions;
use App\Models\Units;
use Prophecy\Doubler\ClassPatch\DisableConstructorPatch;


/**
* Class Users
* @package App\Controllers\Api
* @author Bagus Aditia Setiawan
* @contact 081214069289
* @copyright saeapplication.com
*/

class Dashboard extends BaseApiController
 {
   public function __construct()
    {
        $db =  \Config\Database::connect(); // default database group
        $this->dbtests      = \Config\Database::connect('tests');
		$this->dbaccounting = \Config\Database::connect('accounting');
		$this->units = new \App\Models\Units();
        $this->cabang = new \App\Models\Cabang();
		$this->pawnTransactions = new \App\Models\PawnTransactions();
        $this->saldo = new \App\Models\DailyCash();
        $this->outstanding = new \App\Models\MonitoringOs();
        $this->defrosting = new \App\Models\MonitoringDefrosting();
        $this->repayment = new \App\Models\MonitoringRepayment();
        $this->dpd = new \App\Models\MonitoringDpd();
        $this->OsView= new \App\Models\MonitoringOsView();
        $this->DailyCash = new \App\Models\DailyCash();
        $this->NonTransactionalTransactions = new \App\Models\NonTransactionalTransactions();
        
        

    }
    public $modelName = '\App\Models\Products';

    /**
    * @var array
    * column of name table database
    * name of param post
    */
    //    [
    //        'column'    => 'value'
    // ]

    public $fillSearch = [
        // 'title'            => 'title',
        // 'url'              => 'url',
        // 'embedded'         => 'embedded',
    ];

    /**
    * @var array
    * column of name table database
    * name of param post
    */
    //    [
    //        'column'    => 'value'
    // ]
    public $fillWhere = [
        // 'name'              => 'name',
    ];

    //    [
    //        'name' => [
    //        'label'  => 'Name',
    //        'rules'  => 'required',
    //        'errors' => [
    //        'required' => 'Required Name '
    // ]
    // ],
    public $validateInsert = [
        // 'title' => [
        //     'label'  => 'title',
        //     'rules'  => 'required',
        //     'errors' => [
        //         'required' => 'Judul harus di isi'
        // ]
        // ],
        // 'embedded' => [
        //     'label'  => 'embedded',
        //     'rules'  => 'required',
        //     'errors' => [
        //         'required' => 'Embedded harus di isi'
        // ]
        // ]
    ];

    public $validateUpdate = [
        // 'id' => [
        //     'label'  => 'id',
        //     'rules'  => 'required',
        //     'errors' => [
        //         'required' => 'Id harus di isi'
        // ]
        // ],
        // 'title' => [
        //     'label'  => 'title',
        //     'rules'  => 'required',
        //     'errors' => [
        //         'required' => 'title harus di isi'
        // ]
        // ],
        // 'embedded' => [
        //     'label'  => 'embedded',
        //     'rules'  => 'required',
        //     'errors' => [
        //         'required' => 'embedded harus di isi'
        // ]
        // ]
    ];

    /**
    * @var array
    * column of name table database
    * name of param post
    */
    //    [
    //        'column'    => 'value'
    // ]
    public $fillableInsert = [
        // 'title'              => 'title',
        // 'url'                => 'url',
        // 'embedded'           => 'embedded'
    ];

    /**
    * @var array
    * column of name table database
    * name of param post
    */
    //    [
    //        'column'    => 'value'
    // ]

    public $fillableIupdate = [
        // 'title'              => 'title',
        // 'url'                => 'url',
        // 'embedded'           => 'embedded'
    ];

    //    product
    public $content = 'Devicelog';

    public function index()
 {

        if ( $this->model ) {
            $sumScan = ( new \App\Models\Devicelog )->countAllResults();
            $buyback = ( new \App\Models\Buyback )->where( 'type', 'Buy Back' )->countAllResults();
            $excange = ( new \App\Models\Buyback )->where( 'type', 'Online Exchange' )->countAllResults();
            $data = [
                'sum_scan'  => $sumScan,
                'buyback'  => $buyback,
                'exchange'  => $excange,
                'visitor'  => $sumScan,
            ];
            return $this->sendResponse( $data, 200 );
        }
        return $this->sendResponse( 'Model Not Found', 400, 'Model Not Found '.$this->model );

    }
    //--------------------------------------------------------------------

    public  function getInsertView($user_id, $view_id){
        $check = $this->OsView->where('view_id', $view_id)->where('user_id', $user_id)->first();
			
			if($check){
				$news = new MonitoringOsView();
				$update = $news->update($check->id, [
                	'view_id'	=> $view_id,
					'user_id'	=> $user_id,
                    'updated_at'	=> date("Y-m-d H:i:s")
            ]);
			
			}else{	

				$news = new MonitoringOsView();
           		 $news->insert([
                	'view_id'	=> $view_id,
					'user_id'	=> $user_id
            	]);

				
			}
    }
    public function getOutstanding(){

        $month = (int) date('m');
        $year = (int) date('Y'); 

        $def = [];

        $no = 0;
        $noa_opsi = 0;
        $os_opsi = 0;
        $noa_instal = 0;
        $os_instal = 0;
        $noa_smartphone = 0;
        $os_smartphone = 0;
        $b = 0;
        $d = date('d');
        if($d<=9){
        $d = substr($d,-1);
        }
        $area = new \App\Models\Area();
        $areasAll = $area->select('area_id')->groupBy('area_id')->findAll();
        foreach ($areasAll as $areaId){
        for($a=1; $a<=$d; $a++){
            if($a<=9){
            $date = date('Y-m-0'.$a);
            }else{
                $date = date('Y-m-'.$a);
            }
            
            // if($date <= date('Y-m-d') ){

                // var_dump($areaId->area_id);
                // var_dump($date);
                // exit;
        // =================================================
                //Regular
                    $akumulasiRegular = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.area_id =', $areaId->area_id)
                    ->where('pawn_transactions.contract_date <=', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
                    // ->groupBy('pawn_transactions.area_id')
                    ->findAll();


                    //repayment Regular
                    $akumulasiRegularRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.area_id =', $areaId->area_id)
                    ->where('pawn_transactions.repayment_date >', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
                    ->findAll();

                    // var_dump("reg",$akumulasiRegular,"========================");
                    // var_dump("regg",$akumulasiRegularRepayment,"========================") ;
                    // var_dump("Instal",$akumulasiInstalment,"========================");
                    // var_dump("Install",$akumulasiInstalmentRepayment,"========================") ;
                    // var_dump("Opsi",$akumulasiOpsi,"========================");
                    // var_dump("Opsii",$akumulasiOpsiRepayment,"========================") ;
                    // var_dump("Smart", $akumulasiSmartphone,"========================");
                    // var_dump("smartp",$akumulasiSmartphoneRepayment,"========================") ;
                    
                    // // var_dump("yesss", $akumulasiActive,"========================");
                    // // var_dump("yess",$akumulasiRepayment,"========================") ;
                    
                    // exit;

                $name = '';
                $area_name = '';

                    if($akumulasiRegular){
                        foreach($akumulasiRegular as $data){
                            $areas = $area->where('area_id', $areaId->area_id)->first();
                            $def[$b]['area'] = $areas->area;
                                $noa_reguler = $data->noa;
                                $os_reguler = $data->os;
                                    
                            $name = $areaId->area_id;
                        $area_name = $areas->area;
                        }
                    }else{
                        $noa_reguler = 0;
                        $os_reguler = 0;
                        // $name = $data->area_id;
                        // $area_name = $areas->area;
                    }

                    if($akumulasiRegularRepayment){
                        foreach ($akumulasiRegularRepayment as $data){
                            $areas = $area->where('area_id', $areaId->area_id)->first();
                            $def[$b]['area'] = $areas->area;
                            $def[$b]['area_id'] = $areaId->area_id;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = $data->noa + $noa_reguler;
                                $def[$b]['os'] = $data->os + $os_reguler;
                                    
                            $name = $areaId->area_id;
                            $area_name = $areas->area;
                            $b++;
                        }
                    }else{
                                $def[$b]['area'] = $area_name;
                                $def[$b]['area_id'] = $name;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = 0 + $noa_reguler;
                                $def[$b]['os'] = 0 + $os_reguler;
                                $b++;
                    }

                    

                }
            
        }
        //   var_dump($def); exit;

        return $this->sendResponse($def, 200);
}

    public function getOutstandingAll(){
        $month = date('m');
        $area='60c6bfa6e64d1e2428630213';
        $sumOs = $this->outstanding->select(' branch_id, date, sum(noa) as noa, sum(os) as os ')
			// ->from('pawn_transactions ')
			->join('units', 'units.office_id = monitoring_os.office_id')
            // ->join('branches', 'branches.areas.id=units.id_area')
            ->where('MONTH(date)', $month)
            ->where('area_id', $area)
            ->groupBy('branch_id')	
            ->groupBy('date')	
            // ->where('areas.id', 1)
            ->findAll();
          

return $this->sendResponse($sumOs, 200);
}

public function getOutstandingUnits(){
$month = date('m');
$branch='60c6bffde64d1e2428630281';
$sumOs = $this->outstanding->select(' units.office_name, date, sum(noa) as noa, sum(os) as os ')
// ->from('pawn_transactions ')
->join('units', 'units.office_id = monitoring_os.office_id')
// ->join('branches', 'branches.areas.id=units.id_area')
->where('MONTH(date)', $month)
->where('units.branch_id', $branch)
->groupBy('units.office_name')
->groupBy('date')
// ->where('areas.id', 1)
->findAll();
// var_dump($sumOs); exit;

return $this->sendResponse($sumOs, 200);
}

public function getOutstandingSelectArea($area){

 $month = (int) date('m');
        $year = (int) date('Y'); 

        $def = [];

        $no = 0;
        $noa_opsi = 0;
        $os_opsi = 0;
        $noa_instal = 0;
        $os_instal = 0;
        $noa_smartphone = 0;
        $os_smartphone = 0;
        $b = 0;
        $d = date('d');
        if($d<=9){
        $d = substr($d,-1);
        }
        $branch = new \App\Models\Cabang();
        $branchAll = $branch->select('branch_id')->where('area_id', $area)->groupBy('branch_id')->findAll();
        foreach ($branchAll as $branchId){
        for($a=1; $a<=$d; $a++){
            if($a<=9){
            $date = date('Y-m-0'.$a);
            }else{
                $date = date('Y-m-'.$a);
            }
            
            // if($date <= date('Y-m-d') ){

                // var_dump($areaId->area_id);
                // var_dump($date);
                // exit;
        // =================================================
                //Regular
                    $akumulasiRegular = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.branch_id =', $branchId->branch_id)
                    ->where('pawn_transactions.contract_date <=', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
                    // ->groupBy('pawn_transactions.area_id')
                    ->findAll();


                    //repayment Regular
                    $akumulasiRegularRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.branch_id =', $branchId->branch_id)
                    ->where('pawn_transactions.repayment_date >', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
                    ->findAll();

                    // var_dump("reg",$akumulasiRegular,"========================");
                    // var_dump("regg",$akumulasiRegularRepayment,"========================") ;
                    // var_dump("Instal",$akumulasiInstalment,"========================");
                    // var_dump("Install",$akumulasiInstalmentRepayment,"========================") ;
                    // var_dump("Opsi",$akumulasiOpsi,"========================");
                    // var_dump("Opsii",$akumulasiOpsiRepayment,"========================") ;
                    // var_dump("Smart", $akumulasiSmartphone,"========================");
                    // var_dump("smartp",$akumulasiSmartphoneRepayment,"========================") ;
                    
                    // // var_dump("yesss", $akumulasiActive,"========================");
                    // // var_dump("yess",$akumulasiRepayment,"========================") ;
                    
                    // exit;

                $name = '';
                $area_name = '';

                    if($akumulasiRegular){
                        foreach($akumulasiRegular as $data){
                            $areas = $branch->where('branch_id', $branchId->branch_id)->first();
                            $def[$b]['cabang'] = $areas->cabang;
                                $noa_reguler = $data->noa;
                                $os_reguler = $data->os;
                                    
                            $name = $branchId->branch_id;
                        $area_name = $areas->cabang;
                        }
                    }else{
                        $noa_reguler = 0;
                        $os_reguler = 0;
                        // $name = $data->area_id;
                        // $area_name = $areas->area;
                    }

                    if($akumulasiRegularRepayment){
                        foreach ($akumulasiRegularRepayment as $data){
                            $areas = $branch->where('branch_id', $branchId->branch_id)->first();
                            $def[$b]['cabang'] = $areas->cabang;
                            $def[$b]['branch_id'] = $branchId->branch_id;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = $data->noa + $noa_reguler;
                                $def[$b]['os'] = $data->os + $os_reguler;
                                    
                            $name = $branchId->branch_id;
                            $area_name = $areas->cabang;
                            $b++;
                        }
                    }else{
                                $def[$b]['cabang'] = $area_name;
                                $def[$b]['branch_id'] = $name;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = 0 + $noa_reguler;
                                $def[$b]['os'] = 0 + $os_reguler;
                                $b++;
                    }

                    

                }
            
        }
        //   var_dump($def); exit;

        return $this->sendResponse($def, 200);
}

public function getOutstandingSelect($area,$branch){

// $month = date('m');
// $sumOs = $this->outstanding->select(' units.office_name, date, sum(noa) as noa, sum(os) as os ')
// // ->from('pawn_transactions ')
// ->join('units', 'units.office_id = monitoring_os.office_id')
// ->join('areas', 'areas.id=units.id_area')
// ->join('cabang', 'cabang.id=units.id_cabang')
// ->where('MONTH(date)', $month)
// ->where('areas.id', $area)
// ->where('cabang.id', $branch)
// ->groupBy('units.office_name')
// ->groupBy('date')
// // ->where('areas.id', 1)
// ->findAll();
// // var_dump($sumOs); exit;

// return $this->sendResponse($sumOs, 200);

 $month = (int) date('m');
        $year = (int) date('Y'); 

        $def = [];

        $no = 0;
        $noa_opsi = 0;
        $os_opsi = 0;
        $noa_instal = 0;
        $os_instal = 0;
        $noa_smartphone = 0;
        $os_smartphone = 0;
        $b = 0;
        $d = date('d');
        if($d<=9){
        $d = substr($d,-1);
        }
        $units = new \App\Models\Units();
        $officeAll = $units->select('office_id')->where('branch_id', $branch)->groupBy('office_id')->findAll();
        foreach ($officeAll as $officeId){
        for($a=1; $a<=$d; $a++){
            if($a<=9){
            $date = date('Y-m-0'.$a);
            }else{
                $date = date('Y-m-'.$a);
            }
            
            // if($date <= date('Y-m-d') ){

                // var_dump($areaId->area_id);
                // var_dump($date);
                // exit;
        // =================================================
                //Regular
                    $akumulasiRegular = $this->pawnTransactions->select('office_name, count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.office_id =', $officeId->office_id)
                    ->where('pawn_transactions.contract_date <=', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
                    ->groupBy('pawn_transactions.office_name')
                    ->findAll();


                    //repayment Regular
                    $akumulasiRegularRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.office_id =',  $officeId->office_id)
                    ->where('pawn_transactions.repayment_date >', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
                    ->groupBy('pawn_transactions.office_name')
                    ->findAll();

                $name = '';
                $area_name = '';

                    if($akumulasiRegular){
                        foreach($akumulasiRegular as $data){
                            // $areas = $units->where('branch_id',  $officeId->office_id)->first();
                            $def[$b]['office_name'] = $data->office_name;
                                $noa_reguler = $data->noa;
                                $os_reguler = $data->os;
                                    
                            $name =  $officeId->office_id;
                        $area_name = $data->office_name;
                        }
                    }else{
                        $noa_reguler = 0;
                        $os_reguler = 0;
                        // $name = $data->area_id;
                        // $area_name = $areas->area;
                    }

                    if($akumulasiRegularRepayment){
                        foreach ($akumulasiRegularRepayment as $data){
                            // $areas = $branch->where('branch_id', $branchId->branch_id)->first();
                            $def[$b]['office_name'] = $data->office_name;
                            // $def[$b]['branch_id'] = $branchId->branch_id;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = $data->noa + $noa_reguler;
                                $def[$b]['os'] = $data->os + $os_reguler;
                                    
                            // $name = $branchId->branch_id;
                            $area_name = $data->office_name;
                            $b++;
                        }
                    }else{
                                $def[$b]['office_name'] = $area_name;
                                // $def[$b]['branch_id'] = $name;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = 0 + $noa_reguler;
                                $def[$b]['os'] = 0 + $os_reguler;
                                $b++;
                    }

                    

                }
            
        }
        //   var_dump($def); exit;

        return $this->sendResponse($def, 200);
}

public function getOutstandingSelectUnits($units){

$month = (int) date('m');
$year = (int) date('Y'); 

$def = [];

$no = 0;
$noa_opsi = 0;
$os_opsi = 0;
$noa_instal = 0;
$os_instal = 0;
$noa_smartphone = 0;
$os_smartphone = 0;

for($a=1; $a<=31; $a++){
    if($a<=9){
    $date = date('Y-m-0'.$a);
    }else{
        $date = date('Y-m-'.$a);
    }

// =================================================
           //Regular
			$akumulasiRegular = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $units)
           ->like('pawn_transactions.product_name', 'Gadai Reguler%')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
            ->groupBy('office_name')
			->findAll();


			//repayment Regular
			$akumulasiRegularRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $units)
            ->like('pawn_transactions.product_name', 'Gadai Reguler%')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
			->findAll();

            //smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
            ->groupBy('office_name')
			->findAll();


			//repayment smartphone
			$akumulasiSmartphoneRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
			->findAll();

            //Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
            ->groupBy('office_name')
			->findAll();


			//repayment Instalment
			$akumulasiInstalmentRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
			->findAll();

            //Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
            ->groupBy('office_name')
			->findAll();


			//repayment Opsi
			$akumulasiOpsiRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
			->findAll();


			


            // var_dump("reg",$akumulasiRegular,"========================");
            // var_dump("regg",$akumulasiRegularRepayment,"========================") ;
            // var_dump("Instal",$akumulasiInstalment,"========================");
            // var_dump("Install",$akumulasiInstalmentRepayment,"========================") ;
            // var_dump("Opsi",$akumulasiOpsi,"========================");
            // var_dump("Opsii",$akumulasiOpsiRepayment,"========================") ;
            // var_dump("Smart", $akumulasiSmartphone,"========================");
            // var_dump("smartp",$akumulasiSmartphoneRepayment,"========================") ;
            
            // // var_dump("yesss", $akumulasiActive,"========================");
            // // var_dump("yess",$akumulasiRepayment,"========================") ;
            
            // exit;

        $name = '';
        if($date <= date('Y-m-d') ){
            if($akumulasiRegular){
                foreach($akumulasiRegular as $data){
                    
                        $noa_reguler = $data->noa;
                        $os_reguler = $data->os;
                            
                    $name = $data->office_name;
                }
            }else{
                $noa_reguler = 0;
                $os_reguler = 0;
            }

            if($akumulasiRegularRepayment){
                foreach ($akumulasiRegularRepayment as $data){
                    $def[$a-1]['office_name'] = $data->office_name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_reguler'] = $data->noa + $noa_reguler;
                        $def[$a-1]['os_reguler'] = $data->os + $os_reguler;
                            
                    $name = $data->office_name;
                }
            }else{
                        $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_reguler'] = 0 + $noa_reguler;
                        $def[$a-1]['os_reguler'] = 0 + $os_reguler;
            }

            if($akumulasiOpsi){
                foreach ($akumulasiOpsi as  $opsi){
                
                    $noa_opsi = $opsi->noa;
                    $os_opsi = $opsi->os;
                }

            }else{
                        
                        $noa_opsi = 0;
                        $os_opsi = 0;
            }

            if($akumulasiOpsiRepayment){
                foreach ($akumulasiOpsiRepayment as  $opsi){
                    $def[$a-1]['office_name'] = $opsi->office_name;
                    $def[$a-1]['contract_date'] = $date;
                    $def[$a-1]['noa_opsi'] = $opsi->noa + $noa_opsi;
                    $def[$a-1]['os_opsi'] = $opsi->os + $os_opsi;
                }

            }else{
                        $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_opsi'] = 0 + $noa_opsi;
                        $def[$a-1]['os_opsi'] = 0 + $os_opsi;
            }

            if($akumulasiInstalment){
                foreach ($akumulasiInstalment as  $instal){
                
                    $noa_instal = $instal->noa;
                    $os_instal = $instal->os;
                }
            }else{
            
                        $noa_instal = 0;
                        $os_instal = 0;
            }


            if($akumulasiInstalmentRepayment){
                foreach ($akumulasiInstalmentRepayment as  $instal){
                    $def[$a-1]['office_name'] = $instal->office_name;
                    $def[$a-1]['contract_date'] = $date;
                    $def[$a-1]['noa_instal'] = $instal->noa + $noa_instal;
                    $def[$a-1]['os_instal'] = $instal->os + $os_instal;
                }
            }else{
                $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_instal'] = 0 + $noa_instal;
                        $def[$a-1]['os_instal'] = 0  + $os_instal;
            }

            if($akumulasiSmartphone){
                foreach ($akumulasiSmartphone as  $smartphone){
                
                    $noa_smartphone = $smartphone->noa;
                    $os_smartphone = $smartphone->os;
                }
            }else{
            
                        $noa_smartphone = 0;
                        $os_smartphone = 0;
            }

            if($akumulasiSmartphoneRepayment){
                foreach ($akumulasiSmartphoneRepayment as  $smartphone){
                    $def[$a-1]['office_name'] = $smartphone->office_name;
                    $def[$a-1]['contract_date'] = $date;
                    $def[$a-1]['noa_smartphone'] = $smartphone->noa + $noa_smartphone;
                    $def[$a-1]['os_smartphone'] = $smartphone->os + $os_smartphone;
                }
            }else{
                $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_smartphone'] = 0 + $noa_smartphone;
                        $def[$a-1]['os_smartphone'] = 0 + $os_smartphone;
            }

        }else{
                        $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_reguler'] = 0;
                        $def[$a-1]['os_reguler'] = 0;
                        $def[$a-1]['noa_opsi'] = 0;
                        $def[$a-1]['os_opsi'] = 0;
                        $def[$a-1]['noa_instal'] = 0;
                        $def[$a-1]['os_instal'] = 0;
                        $def[$a-1]['noa_smartphone'] = 0;
                        $def[$a-1]['os_smartphone'] = 0;
        }
    
}

//   var_dump($def); exit;

return $this->sendResponse($def, 200);
}

public function getPencairan(){

$month = date('m');
$year = date('Y');
    $sumOs = $this->pawnTransactions->select('area_id, contract_date, count(loan_amount) as noa, sum(loan_amount) as os')
                ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
                ->where("EXTRACT(YEAR FROM contract_date)", $year )
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->groupBy('area_id')
                ->groupBy('contract_date')
                ->findAll();
                
    $no = 0;
    foreach($sumOs as $data){
    $area = new \App\Models\Area();
    $areas = $area->where('area_id', $data->area_id)->first();
        $def[$no] = array (
            'contract_date'=> $data->contract_date,
            'area_id' => $data->area_id,
            'area' => $areas->area,
            'noa'  => $data->noa,
            'os' => $data->os,
        );
        $no++;
    }

    return $this->sendResponse($def, 200);
}


public function getPencairanArea($area){
    $month = date('m');
    $year = date('Y');
    $sumOs = $this->pawnTransactions->select(' branch_id, contract_date, count(loan_amount) as noa, sum(loan_amount) as os ')
                ->where('pawn_transactions.area_id', $area)
                ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
                ->where("EXTRACT(YEAR FROM contract_date)", $year )
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->groupBy('branch_id')
                ->groupBy('contract_date')
                ->findAll();
                
                
    // $data = array();
    $no = 0;
    foreach($sumOs as $data){
    $cab = new \App\Models\Cabang();
    $cabang = $cab->where('branch_id', $data->branch_id)->first();
        $def[$no] = array (
            'contract_date'=> $data->contract_date,
            'branch_id' => $data->branch_id,
            'cabang' => $cabang->cabang,
            'noa'  => $data->noa,
            'os' => $data->os,
        );
        $no++;
    }

    return $this->sendResponse($def, 200);
}

public function getPencairanCabang($area,$branch){
$month = date('m');
$year = date('Y');

$sumOs = $this->pawnTransactions->select(' office_name, contract_date, count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.branch_id', $branch)
            ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            ->where("EXTRACT(YEAR FROM contract_date)", $year )
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();


return $this->sendResponse($sumOs, 200);
}

public function getPencairanSelectUnits($units){
$month = (int) date('m');
$year = (int) date('Y'); 

$def = [];

$no = 0;
$noa_opsi = 0;
$os_opsi = 0;
$noa_instal = 0;
$os_instal = 0;
$noa_smartphone = 0;
$os_smartphone = 0;

for($a=1; $a<=31; $a++){
    $date = date('Y-m-0'.$a);

//smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('office_name, contract_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            // ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('contract_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();
            

		//Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('office_name, contract_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            //     ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('contract_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();

		
		//Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('office_name, contract_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            // ->where("EXTRACT(YEAR FROM date_open)", $year )
            ->where('contract_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();

			
		//Regular
			$akumulasiRegular = $this->pawnTransactions->select('office_name, contract_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
 		 	->like('pawn_transactions.product_name', 'Gadai Reguler%')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            // ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('contract_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();

$name = '';
if($akumulasiRegular){
    foreach ($akumulasiRegular as $data){
        $def[$a-1]['office_name'] = $data->office_name;
            $def[$a-1]['contract_date'] = $data->contract_date;
            $def[$a-1]['noa_reguler'] = $data->noa;
            $def[$a-1]['os_reguler'] = $data->os;
                
        $name = $data->office_name;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['contract_date'] = $date;
            $def[$a-1]['noa_reguler'] = 0;
            $def[$a-1]['os_reguler'] = 0;
}

if($akumulasiOpsi){
    foreach ($akumulasiOpsi as  $opsi){
         $def[$a-1]['office_name'] = $opsi->office_name;
        $def[$a-1]['contract_date'] = $opsi->contract_date;
        $def[$a-1]['noa_opsi'] = $opsi->noa;
        $def[$a-1]['os_opsi'] = $opsi->os;
    }

}else{
            $def[$a-1]['office_name'] = $name;
            $def[$a-1]['contract_date'] = $date;
            $def[$a-1]['noa_opsi'] = 0;
            $def[$a-1]['os_opsi'] = 0;
}

if($akumulasiInstalment){
    foreach ($akumulasiInstalment as  $instal){
         $def[$a-1]['office_name'] = $instal->office_name;
        $def[$a-1]['contract_date'] = $instal->contract_date;
         $def[$a-1]['noa_instal'] = $instal->noa;
        $def[$a-1]['os_instal'] = $instal->os;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['contract_date'] = $date;
            $def[$a-1]['noa_instal'] = 0;
            $def[$a-1]['os_instal'] = 0;
}

if($akumulasiSmartphone){
    foreach ($akumulasiSmartphone as  $smartphone){
         $def[$a-1]['office_name'] = $smartphone->office_name;
        $def[$a-1]['contract_date'] = $smartphone->contract_date;
         $def[$a-1]['noa_smartphone'] = $smartphone->noa;
        $def[$a-1]['os_smartphone'] = $smartphone->os;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['contract_date'] = $date;
            $def[$a-1]['noa_smartphone'] = 0;
            $def[$a-1]['os_smartphone'] = 0;
}
    
}

//   var_dump($def); exit;

return $this->sendResponse($def, 200);
}

public function getRepayment(){

$month = date('m');
$year = date('Y');
    $sumOs = $this->pawnTransactions->select('area_id, repayment_date, count(loan_amount) as noa, sum(loan_amount) as os')
                ->where("EXTRACT(MONTH FROM pawn_transactions.repayment_date)", $month )
                ->where("EXTRACT(YEAR FROM repayment_date)", $year )
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('pawn_transactions.payment_status', true)
                ->groupBy('area_id')
                ->groupBy('repayment_date')
                ->findAll();
                
    $no = 0;
    foreach($sumOs as $data){
    $area = new \App\Models\Area();
    $areas = $area->where('area_id', $data->area_id)->first();
        $def[$no] = array (
            'repayment_date'=> $data->repayment_date,
            'area_id' => $data->area_id,
            'area' => $areas->area,
            'noa'  => $data->noa,
            'os' => $data->os,
        );
        $no++;
    }

    return $this->sendResponse($def, 200);

}

public function getRepaymentArea($area){

$month = date('m');
    $year = date('Y');
    $sumOs = $this->pawnTransactions->select(' branch_id, repayment_date, count(loan_amount) as noa, sum(loan_amount) as os ')
                ->where('pawn_transactions.area_id', $area)
                ->where("EXTRACT(MONTH FROM pawn_transactions.repayment_date)", $month )
                ->where("EXTRACT(YEAR FROM repayment_date)", $year )
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                 ->where('pawn_transactions.payment_status', true)
                ->groupBy('branch_id')
                ->groupBy('repayment_date')
                ->findAll();
                
                
    // $data = array();
    $no = 0;
    foreach($sumOs as $data){
    $cab = new \App\Models\Cabang();
    $cabang = $cab->where('branch_id', $data->branch_id)->first();
        $def[$no] = array (
            'repayment_date'=> $data->repayment_date,
            'branch_id' => $data->branch_id,
            'cabang' => $cabang->cabang,
            'noa'  => $data->noa,
            'os' => $data->os,
        );
        $no++;
    }

    return $this->sendResponse($def, 200);

}

public function getRepaymentCabang($area,$branch){

$month = date('m');
$year = date('Y');

$sumOs = $this->pawnTransactions->select(' office_name, repayment_date, count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.branch_id', $branch)
            ->where("EXTRACT(MONTH FROM pawn_transactions.repayment_date)", $month )
            ->where("EXTRACT(YEAR FROM repayment_date)", $year )
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
             ->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
            ->groupBy('repayment_date')
			->findAll();


return $this->sendResponse($sumOs, 200);
}

public function getRepaymentSelectUnits($units){
$month = date('m');

$month = (int) date('m');
$year = (int) date('Y'); 

$def = [];

$no = 0;
$noa_opsi = 0;
$os_opsi = 0;
$noa_instal = 0;
$os_instal = 0;
$noa_smartphone = 0;
$os_smartphone = 0;

for($a=1; $a<=31; $a++){
    $date = date('Y-m-0'.$a);

//smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('office_name, repayment_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            // ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('repayment_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();
            

		//Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('office_name, repayment_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            //     ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('repayment_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)
			->groupBy('office_name')
            ->groupBy('repayment_date')
			->findAll();


		
		//Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('office_name, repayment_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.repayment_date)", $month )
            // ->where("EXTRACT(YEAR FROM date_open)", $year )
            ->where('repayment_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)
			->groupBy('office_name')
            ->groupBy('repayment_date')
			->findAll();

			
		//Regular
			$akumulasiRegular = $this->pawnTransactions->select('office_name, repayment_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
 		 	->like('pawn_transactions.product_name', 'Gadai Reguler%')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.repayment_date)", $month )
            // ->where("EXTRACT(YEAR FROM repayment_date)", $year )
            ->where('repayment_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)
			->groupBy('office_name')
            ->groupBy('repayment_date')
			->findAll();

$name = '';
if($akumulasiRegular){
    foreach ($akumulasiRegular as $data){
        $def[$a-1]['office_name'] = $data->office_name;
            $def[$a-1]['repayment_date'] = $data->repayment_date;
            $def[$a-1]['noa_reguler'] = $data->noa;
            $def[$a-1]['os_reguler'] = $data->os;
                
        $name = $data->office_name;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['repayment_date'] = $date;
            $def[$a-1]['noa_reguler'] = 0;
            $def[$a-1]['os_reguler'] = 0;
}

if($akumulasiOpsi){
    foreach ($akumulasiOpsi as  $opsi){
         $def[$a-1]['office_name'] = $opsi->office_name;
        $def[$a-1]['repayment_date'] = $opsi->repayment_date;
        $def[$a-1]['noa_opsi'] = $opsi->noa;
        $def[$a-1]['os_opsi'] = $opsi->os;
    }

}else{
            $def[$a-1]['office_name'] = $name;
            $def[$a-1]['repayment_date'] = $date;
            $def[$a-1]['noa_opsi'] = 0;
            $def[$a-1]['os_opsi'] = 0;
}

if($akumulasiInstalment){
    foreach ($akumulasiInstalment as  $instal){
         $def[$a-1]['office_name'] = $instal->office_name;
        $def[$a-1]['repayment_date'] = $instal->repayment_date;
         $def[$a-1]['noa_instal'] = $instal->noa;
        $def[$a-1]['os_instal'] = $instal->os;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['repayment_date'] = $date;
            $def[$a-1]['noa_instal'] = 0;
            $def[$a-1]['os_instal'] = 0;
}

if($akumulasiSmartphone){
    foreach ($akumulasiSmartphone as  $smartphone){
         $def[$a-1]['office_name'] = $smartphone->office_name;
        $def[$a-1]['repayment_date'] = $smartphone->repayment_date;
         $def[$a-1]['noa_smartphone'] = $smartphone->noa;
        $def[$a-1]['os_smartphone'] = $smartphone->os;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['repayment_date'] = $date;
            $def[$a-1]['noa_smartphone'] = 0;
            $def[$a-1]['os_smartphone'] = 0;
}
    
}

//   var_dump($def); exit;

return $this->sendResponse($def, 200);
}


public function getDpd(){

$month = (int) date('m');
        $year = (int) date('Y'); 

        $def = [];

        $no = 0;
        $noa_opsi = 0;
        $os_opsi = 0;
        $noa_instal = 0;
        $os_instal = 0;
        $noa_smartphone = 0;
        $os_smartphone = 0;
        $b = 0;
        $d = date('d');
        if($d<=9){
        $d = substr($d,-1);
        }
        $area = new \App\Models\Area();
        $areasAll = $area->select('area_id')->groupBy('area_id')->findAll();
        foreach ($areasAll as $areaId){
        for($a=1; $a<=$d; $a++){
            if($a<=9){
            $date = date('Y-m-0'.$a);
            }else{
                $date = date('Y-m-'.$a);
            }
            
           
                //Regular
                    $akumulasiRegular = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.area_id =', $areaId->area_id)
                    ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
                    // ->groupBy('pawn_transactions.area_id')
                    ->findAll();


                    //repayment Regular
                    $akumulasiRegularRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.area_id =', $areaId->area_id)
                    ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
                    ->findAll();


                $name = '';
                $area_name = '';

                    if($akumulasiRegular){
                        foreach($akumulasiRegular as $data){
                            $areas = $area->where('area_id', $areaId->area_id)->first();
                            $def[$b]['area'] = $areas->area;
                                $noa_reguler = $data->noa;
                                $os_reguler = $data->os;
                                    
                            $name = $areaId->area_id;
                        $area_name = $areas->area;
                        }
                    }else{
                        $noa_reguler = 0;
                        $os_reguler = 0;
                        // $name = $data->area_id;
                        // $area_name = $areas->area;
                    }

                    if($akumulasiRegularRepayment){
                        foreach ($akumulasiRegularRepayment as $data){
                            $areas = $area->where('area_id', $areaId->area_id)->first();
                            $def[$b]['area'] = $areas->area;
                            $def[$b]['area_id'] = $areaId->area_id;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = $data->noa + $noa_reguler;
                                $def[$b]['os'] = $data->os + $os_reguler;
                                    
                            $name = $areaId->area_id;
                            $area_name = $areas->area;
                            $b++;
                        }
                    }else{
                                $def[$b]['area'] = $area_name;
                                $def[$b]['area_id'] = $name;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = 0 + $noa_reguler;
                                $def[$b]['os'] = 0 + $os_reguler;
                                $b++;
                    }

                    

                }
            
        }
        //   var_dump($def); exit;

        return $this->sendResponse($def, 200);
}

public function getDpdArea($area){

$month = (int) date('m');
        $year = (int) date('Y'); 

        $def = [];

        $no = 0;
        $noa_opsi = 0;
        $os_opsi = 0;
        $noa_instal = 0;
        $os_instal = 0;
        $noa_smartphone = 0;
        $os_smartphone = 0;
        $b = 0;
        $d = date('d');
        if($d<=9){
        $d = substr($d,-1);
        }
        $branch = new \App\Models\Cabang();
        $branchAll = $branch->select('branch_id')->where('area_id', $area)->groupBy('branch_id')->findAll();
        foreach ($branchAll as $branchId){
        for($a=1; $a<=$d; $a++){
            if($a<=9){
            $date = date('Y-m-0'.$a);
            }else{
                $date = date('Y-m-'.$a);
            }
            
        // =================================================
                //Regular
                    $akumulasiRegular = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.branch_id =', $branchId->branch_id)
                    ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
                    // ->groupBy('pawn_transactions.area_id')
                    ->findAll();


                    //repayment Regular
                    $akumulasiRegularRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.branch_id =', $branchId->branch_id)
                    ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
                    ->findAll();

                $name = '';
                $area_name = '';

                    if($akumulasiRegular){
                        foreach($akumulasiRegular as $data){
                            $areas = $branch->where('branch_id', $branchId->branch_id)->first();
                            $def[$b]['cabang'] = $areas->cabang;
                                $noa_reguler = $data->noa;
                                $os_reguler = $data->os;
                                    
                            $name = $branchId->branch_id;
                        $area_name = $areas->cabang;
                        }
                    }else{
                        $noa_reguler = 0;
                        $os_reguler = 0;
                        // $name = $data->area_id;
                        // $area_name = $areas->area;
                    }

                    if($akumulasiRegularRepayment){
                        foreach ($akumulasiRegularRepayment as $data){
                            $areas = $branch->where('branch_id', $branchId->branch_id)->first();
                            $def[$b]['cabang'] = $areas->cabang;
                            $def[$b]['branch_id'] = $branchId->branch_id;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = $data->noa + $noa_reguler;
                                $def[$b]['os'] = $data->os + $os_reguler;
                                    
                            $name = $branchId->branch_id;
                            $area_name = $areas->cabang;
                            $b++;
                        }
                    }else{
                                $def[$b]['cabang'] = $area_name;
                                $def[$b]['branch_id'] = $name;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = 0 + $noa_reguler;
                                $def[$b]['os'] = 0 + $os_reguler;
                                $b++;
                    }

                    

                }
            
        }
        //   var_dump($def); exit;

        return $this->sendResponse($def, 200);
}

public function getDpdCabang($area,$branch){

 $month = (int) date('m');
        $year = (int) date('Y'); 

        $def = [];

        $no = 0;
        $noa_opsi = 0;
        $os_opsi = 0;
        $noa_instal = 0;
        $os_instal = 0;
        $noa_smartphone = 0;
        $os_smartphone = 0;
        $b = 0;
        $d = date('d');
        if($d<=9){
        $d = substr($d,-1);
        }
        $units = new \App\Models\Units();
        $officeAll = $units->select('office_id')->where('branch_id', $branch)->groupBy('office_id')->findAll();
        foreach ($officeAll as $officeId){
        for($a=1; $a<=$d; $a++){
            if($a<=9){
            $date = date('Y-m-0'.$a);
            }else{
                $date = date('Y-m-'.$a);
            }
            
            // if($date <= date('Y-m-d') ){

                // var_dump($areaId->area_id);
                // var_dump($date);
                // exit;
        // =================================================
                //Regular
                    $akumulasiRegular = $this->pawnTransactions->select('office_name, count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.office_id =', $officeId->office_id)
                    ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
                    ->groupBy('pawn_transactions.office_name')
                    ->findAll();

                    //repayment Regular
                    $akumulasiRegularRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
                    ->where('pawn_transactions.office_id =',  $officeId->office_id)
                    ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
                    ->groupBy('pawn_transactions.office_name')
                    ->findAll();

                $name = '';
                $area_name = '';

                    if($akumulasiRegular){
                        foreach($akumulasiRegular as $data){
                            // $areas = $units->where('branch_id',  $officeId->office_id)->first();
                            $def[$b]['office_name'] = $data->office_name;
                                $noa_reguler = $data->noa;
                                $os_reguler = $data->os;
                                    
                            $name =  $officeId->office_id;
                        $area_name = $data->office_name;
                        }
                    }else{
                        $noa_reguler = 0;
                        $os_reguler = 0;
                        // $name = $data->area_id;
                        // $area_name = $areas->area;
                    }

                    if($akumulasiRegularRepayment){
                        foreach ($akumulasiRegularRepayment as $data){
                            // $areas = $branch->where('branch_id', $branchId->branch_id)->first();
                            $def[$b]['office_name'] = $data->office_name;
                            // $def[$b]['branch_id'] = $branchId->branch_id;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = $data->noa + $noa_reguler;
                                $def[$b]['os'] = $data->os + $os_reguler;
                                    
                            // $name = $branchId->branch_id;
                            $area_name = $data->office_name;
                            $b++;
                        }
                    }else{
                        if($noa_reguler != 0){
                                $def[$b]['office_name'] = $area_name;
                                // $def[$b]['branch_id'] = $name;
                                $def[$b]['contract_date'] = $date;
                                $def[$b]['noa'] = 0 + $noa_reguler;
                                $def[$b]['os'] = 0 + $os_reguler;
                                $b++;

                        }
                    }

                    

                }
            
        }
        //   var_dump($def); exit;

        return $this->sendResponse($def, 200);
}

public function getDpdSelectUnits($units){

$month = (int) date('m');
$year = (int) date('Y'); 

$def = [];

$no = 0;
$noa_opsi = 0;
$os_opsi = 0;
$noa_instal = 0;
$os_instal = 0;
$noa_smartphone = 0;
$os_smartphone = 0;

for($a=1; $a<=31; $a++){
    if($a<=9){
    $date = date('Y-m-0'.$a);
    }else{
        $date = date('Y-m-'.$a);
    }

// =================================================
           //Regular
			$akumulasiRegular = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $units)
            ->like('pawn_transactions.product_name', 'Gadai Reguler%')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
            ->groupBy('office_name')
			->findAll();


			//repayment Regular
			$akumulasiRegularRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $units)
            ->like('pawn_transactions.product_name', 'Gadai Reguler%')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
			->findAll();

            //smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
            ->groupBy('office_name')
			->findAll();


			//repayment smartphone
			$akumulasiSmartphoneRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
			->findAll();

            //Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
            ->groupBy('office_name')
			->findAll();


			//repayment Instalment
			$akumulasiInstalmentRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
			->findAll();

            //Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
			->where('pawn_transactions.payment_status', false)
            ->groupBy('office_name')
			->findAll();


			//repayment Opsi
			$akumulasiOpsiRepayment = $this->pawnTransactions->select('office_name,count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
            ->groupBy('office_name')
			->findAll();


			


            // var_dump("reg",$akumulasiRegular,"========================");
            // var_dump("regg",$akumulasiRegularRepayment,"========================") ;
            // var_dump("Instal",$akumulasiInstalment,"========================");
            // var_dump("Install",$akumulasiInstalmentRepayment,"========================") ;
            // var_dump("Opsi",$akumulasiOpsi,"========================");
            // var_dump("Opsii",$akumulasiOpsiRepayment,"========================") ;
            // var_dump("Smart", $akumulasiSmartphone,"========================");
            // var_dump("smartp",$akumulasiSmartphoneRepayment,"========================") ;
            
            // // var_dump("yesss", $akumulasiActive,"========================");
            // // var_dump("yess",$akumulasiRepayment,"========================") ;
            
            // exit;

        $name = '';
        if($date <= date('Y-m-d') ){
            if($akumulasiRegular){
                foreach($akumulasiRegular as $data){
                    
                        $noa_reguler = $data->noa;
                        $os_reguler = $data->os;
                            
                    $name = $data->office_name;
                }
            }else{
                $noa_reguler = 0;
                $os_reguler = 0;
            }

            if($akumulasiRegularRepayment){
                foreach ($akumulasiRegularRepayment as $data){
                    $def[$a-1]['office_name'] = $data->office_name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_reguler'] = $data->noa + $noa_reguler;
                        $def[$a-1]['os_reguler'] = $data->os + $os_reguler;
                            
                    $name = $data->office_name;
                }
            }else{
                        $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_reguler'] = 0 + $noa_reguler;
                        $def[$a-1]['os_reguler'] = 0 + $os_reguler;
            }

            if($akumulasiOpsi){
                foreach ($akumulasiOpsi as  $opsi){
                
                    $noa_opsi = $opsi->noa;
                    $os_opsi = $opsi->os;
                }

            }else{
                        
                        $noa_opsi = 0;
                        $os_opsi = 0;
            }

            if($akumulasiOpsiRepayment){
                foreach ($akumulasiOpsiRepayment as  $opsi){
                    $def[$a-1]['office_name'] = $opsi->office_name;
                    $def[$a-1]['contract_date'] = $date;
                    $def[$a-1]['noa_opsi'] = $opsi->noa + $noa_opsi;
                    $def[$a-1]['os_opsi'] = $opsi->os + $os_opsi;
                }

            }else{
                        $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_opsi'] = 0 + $noa_opsi;
                        $def[$a-1]['os_opsi'] = 0 + $os_opsi;
            }

            if($akumulasiInstalment){
                foreach ($akumulasiInstalment as  $instal){
                
                    $noa_instal = $instal->noa;
                    $os_instal = $instal->os;
                }
            }else{
            
                        $noa_instal = 0;
                        $os_instal = 0;
            }


            if($akumulasiInstalmentRepayment){
                foreach ($akumulasiInstalmentRepayment as  $instal){
                    $def[$a-1]['office_name'] = $instal->office_name;
                    $def[$a-1]['contract_date'] = $date;
                    $def[$a-1]['noa_instal'] = $instal->noa + $noa_instal;
                    $def[$a-1]['os_instal'] = $instal->os + $os_instal;
                }
            }else{
                $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_instal'] = 0 + $noa_instal;
                        $def[$a-1]['os_instal'] = 0  + $os_instal;
            }

            if($akumulasiSmartphone){
                foreach ($akumulasiSmartphone as  $smartphone){
                
                    $noa_smartphone = $smartphone->noa;
                    $os_smartphone = $smartphone->os;
                }
            }else{
            
                        $noa_smartphone = 0;
                        $os_smartphone = 0;
            }

            if($akumulasiSmartphoneRepayment){
                foreach ($akumulasiSmartphoneRepayment as  $smartphone){
                    $def[$a-1]['office_name'] = $smartphone->office_name;
                    $def[$a-1]['contract_date'] = $date;
                    $def[$a-1]['noa_smartphone'] = $smartphone->noa + $noa_smartphone;
                    $def[$a-1]['os_smartphone'] = $smartphone->os + $os_smartphone;
                }
            }else{
                $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_smartphone'] = 0 + $noa_smartphone;
                        $def[$a-1]['os_smartphone'] = 0 + $os_smartphone;
            }

        }else{
                        $def[$a-1]['office_name'] = $name;
                        $def[$a-1]['contract_date'] = $date;
                        $def[$a-1]['noa_reguler'] = 0;
                        $def[$a-1]['os_reguler'] = 0;
                        $def[$a-1]['noa_opsi'] = 0;
                        $def[$a-1]['os_opsi'] = 0;
                        $def[$a-1]['noa_instal'] = 0;
                        $def[$a-1]['os_instal'] = 0;
                        $def[$a-1]['noa_smartphone'] = 0;
                        $def[$a-1]['os_smartphone'] = 0;
        }
    
}

//   var_dump($def); exit;

return $this->sendResponse($def, 200);
}


function getCabang($area){
if($area){
$data = $this->cabang->select('id, cabang')->where('id_area', $area)->findAll();
return $this->sendResponse($data, 200);
}else{
    
}
}

function getUnits($branch){

$data = $this->units->select('id, name')->where('id_cabang', $branch)->findAll();
return $this->sendResponse($data, 200);

}

function getBranch($area){

$data = $this->cabang->select('id, cabang, branch_id')->where('area_id', $area)->findAll();
return $this->sendResponse($data, 200);

}

function getOffice($branch){

$data = $this->units->select('id, name, office_id, code ')->where('branch_id', $branch)->findAll();
return $this->sendResponse($data, 200);

}


function getCountView($view_id){
    $data = $this->OsView->select('count(id) as count')->where('view_id', $view_id)->findAll();
return $this->sendResponse($data, 200);
}


//Saldo
public function getSaldo($units){

$date = date('m');
$year = date('Y');
$month = (int) $date;
$year = (int) $year;
$data = [];

$saldo = $this->DailyCash->select('office_id, office_name, date_open, opening_balance, remaining_balance')
			->where('daily_cashes.office_id', $units)
			->where("EXTRACT(MONTH FROM date_open)", $month )
            ->where("EXTRACT(YEAR FROM date_open)", $year )
            ->orderBy('date_open', 'asc')
            ->orderBy('id', 'asc')
			->findAll();

    $no = 0;
    foreach($saldo as $data){
    $pagu = new \App\Models\Pagukas();
    $saldo = $pagu->where('office_id', $data->office_id)->first();
    if($saldo){
        $saldo = $saldo->saldo;
    }else{
        $saldo = 0;
    }
        $def[$no] = array (
            'office_name'=> $data->office_name,
            'date_open' => $data->date_open,
            'opening_balance'  => $data->opening_balance,
            'remaining_balance' => $data->remaining_balance,
            'saldo'  => $saldo,           
        );
        $no++;
    }

    return $this->sendResponse($def, 200);

return $this->sendResponse($saldo, 200);
}

//Pengeluaran

public function getPengeluaran(){

$month = date('m');
$year = date('Y');
    $sumOs = $this->NonTransactionalTransactions
                ->select("area_id, date_trunc('day',created_at)::date as created_at, sum(amount) as amount, 
                (select transaction_type from non_transactionals where non_transactionals.transaction_type = 1 limit 1) as address,
                ")
                // ->join('non_transactionals', 'non_transactionals.id=non_transactional_transactions.non_transactional_id')
                // ->join('non_transactional_items', 'non_transactional_items.non_transactional_id=non_transactionals.id')
                // ->join('accounts', 'accounts.id=non_transactional_items.account_id')
                ->where("EXTRACT(MONTH FROM non_transactional_transactions.created_at)", $month )
                ->where("EXTRACT(YEAR FROM non_transactional_transactions.created_at)", $year )
                // ->where('non_transactionals.transaction_type', 1)
                // ->where('non_transactional_items.region_id', 'non_transactional_transactions.region_id')
                ->groupBy('area_id')
                ->groupBy("date_trunc('day',created_at)::date")
                ->findAll();

                // var_dump($sumOs); exit;
                
    $no = 0;
    foreach($sumOs as $data){
    $area = new \App\Models\Area();
    $areas = $area->where('area_id', $data->area_id)->first();
        $def[$no] = array (
            'created_at'=> $data->created_at,
            'area_id' => $data->area_id,
            'area' => $areas->area,
            'amount'  => $data->amount,
            'type'  => $data->address,
            
        );
        $no++;
    }

    return $this->sendResponse($def, 200);
}


public function getPengeluaranArea($area){

    
$month = date('m');
$year = date('Y');
    $sumOs = $this->NonTransactionalTransactions
                ->select("branch_id, date_trunc('day',created_at)::date as created_at, sum(amount) as amount, 
                (select transaction_type from non_transactionals where non_transactionals.transaction_type = 1 limit 1) as address,
                ")
                // ->join('non_transactionals', 'non_transactionals.id=non_transactional_transactions.non_transactional_id')
                // ->join('non_transactional_items', 'non_transactional_items.non_transactional_id=non_transactionals.id')
                // ->join('accounts', 'accounts.id=non_transactional_items.account_id')
                ->where('non_transactional_transactions.area_id', $area)
                ->where("EXTRACT(MONTH FROM non_transactional_transactions.created_at)", $month )
                ->where("EXTRACT(YEAR FROM non_transactional_transactions.created_at)", $year )
                // ->where('non_transactionals.transaction_type', 1)
                // ->where('non_transactional_items.region_id', 'non_transactional_transactions.region_id')
                ->groupBy('branch_id')
                ->groupBy("date_trunc('day',created_at)::date")
                ->findAll();
                
                
    // $data = array();
    $no = 0;
    foreach($sumOs as $data){
    $cab = new \App\Models\Cabang();
    $cabang = $cab->where('branch_id', $data->branch_id)->first();
        $def[$no] = array (
            'created_at'=> $data->created_at,
            'branch_id' => $data->branch_id,
            'cabang' => $cabang->cabang,
            'amount'  => $data->amount,
            'type'  => $data->address,
        );
        $no++;
    }

    return $this->sendResponse($def, 200);
}

public function getPengeluaranCabang($area,$branch){
$month = date('m');
$year = date('Y');

// $news = new NonTransactionalTransactions();
// var_dump($news->getPengeluaranCabang($branch)); exit();

    $sumOs = $this->NonTransactionalTransactions
                ->select("office_name, date_trunc('day',created_at)::date as created_at, sum(amount) as amount, 
                (select transaction_type from non_transactionals where non_transactionals.transaction_type = 1 limit 1) as address,
                ")
                // ->join('non_transactionals', 'non_transactionals.id=non_transactional_transactions.non_transactional_id')
                // ->join('non_transactional_items', 'non_transactional_items.non_transactional_id=non_transactionals.id')
                // ->join('accounts', 'accounts.id=non_transactional_items.account_id')
                ->where('non_transactional_transactions.branch_id', $branch)
                ->where("EXTRACT(MONTH FROM non_transactional_transactions.created_at)", $month )
                ->where("EXTRACT(YEAR FROM non_transactional_transactions.created_at)", $year )
                // ->where('non_transactionals.transaction_type', 1)
                // ->where('non_transactional_items.region_id', 'non_transactional_transactions.region_id')
                ->groupBy('office_name')
                ->groupBy("date_trunc('day',created_at)::date")
                ->findAll();
                

return $this->sendResponse($sumOs, 200);
}
// End Pengeluaran

//Perpanjangan
public function getPerpanjangan(){

$month = date('m');
$year = date('Y');
    $sumOs = $this->pawnTransactions->select('area_id, contract_date, count(loan_amount) as noa, sum(loan_amount) as os')
                ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
                ->where("EXTRACT(YEAR FROM contract_date)", $year )
                ->where('pawn_transactions.parent_sge !=', null)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->groupBy('area_id')
                ->groupBy('contract_date')
                ->findAll();
                
    $no = 0;
    foreach($sumOs as $data){
    $area = new \App\Models\Area();
    $areas = $area->where('area_id', $data->area_id)->first();
        $def[$no] = array (
            'contract_date'=> $data->contract_date,
            'area_id' => $data->area_id,
            'area' => $areas->area,
            'noa'  => $data->noa,
            'os' => $data->os,
        );
        $no++;
    }

    return $this->sendResponse($def, 200);
}


public function getPerpanjanganArea($area){
    $month = date('m');
    $year = date('Y');
    $sumOs = $this->pawnTransactions->select(' branch_id, contract_date, count(loan_amount) as noa, sum(loan_amount) as os ')
                ->where('pawn_transactions.area_id', $area)
                ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
                ->where("EXTRACT(YEAR FROM contract_date)", $year )
                ->where('pawn_transactions.parent_sge !=', null)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->groupBy('branch_id')
                ->groupBy('contract_date')
                ->findAll();
                
                
    // $data = array();
    $no = 0;
    foreach($sumOs as $data){
    $cab = new \App\Models\Cabang();
    $cabang = $cab->where('branch_id', $data->branch_id)->first();
        $def[$no] = array (
            'contract_date'=> $data->contract_date,
            'branch_id' => $data->branch_id,
            'cabang' => $cabang->cabang,
            'noa'  => $data->noa,
            'os' => $data->os,
        );
        $no++;
    }

    return $this->sendResponse($def, 200);
}

public function getPerpanjanganCabang($area,$branch){
$month = date('m');
$year = date('Y');

$sumOs = $this->pawnTransactions->select(' office_name, contract_date, count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.branch_id', $branch)
            ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('pawn_transactions.parent_sge !=', null)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();


return $this->sendResponse($sumOs, 200);
}

public function getPerpanjanganSelectUnits($units){
$month = (int) date('m');
$year = (int) date('Y'); 

$def = [];

$no = 0;
$noa_opsi = 0;
$os_opsi = 0;
$noa_instal = 0;
$os_instal = 0;
$noa_smartphone = 0;
$os_smartphone = 0;

for($a=1; $a<=31; $a++){
    $date = date('Y-m-0'.$a);

//smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('office_name, contract_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.parent_sge !=', null)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            // ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('contract_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();
            

		//Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('office_name, contract_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.parent_sge !=', null)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            //     ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('contract_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();


		
		//Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('office_name, contract_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.parent_sge !=', null)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            // ->where("EXTRACT(YEAR FROM date_open)", $year )
            ->where('contract_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();

			
		//Regular
			$akumulasiRegular = $this->pawnTransactions->select('office_name, contract_date,count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.parent_sge !=', null)
 		 	->like('pawn_transactions.product_name', 'Gadai Reguler%')
			// ->where("EXTRACT(MONTH FROM pawn_transactions.contract_date)", $month )
            // ->where("EXTRACT(YEAR FROM contract_date)", $year )
            ->where('contract_date', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->groupBy('office_name')
            ->groupBy('contract_date')
			->findAll();

$name = '';
if($akumulasiRegular){
    foreach ($akumulasiRegular as $data){
        $def[$a-1]['office_name'] = $data->office_name;
            $def[$a-1]['contract_date'] = $data->contract_date;
            $def[$a-1]['noa_reguler'] = $data->noa;
            $def[$a-1]['os_reguler'] = $data->os;
                
        $name = $data->office_name;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['contract_date'] = $date;
            $def[$a-1]['noa_reguler'] = 0;
            $def[$a-1]['os_reguler'] = 0;
}

if($akumulasiOpsi){
    foreach ($akumulasiOpsi as  $opsi){
         $def[$a-1]['office_name'] = $opsi->office_name;
        $def[$a-1]['contract_date'] = $opsi->contract_date;
        $def[$a-1]['noa_opsi'] = $opsi->noa;
        $def[$a-1]['os_opsi'] = $opsi->os;
    }

}else{
            $def[$a-1]['office_name'] = $name;
            $def[$a-1]['contract_date'] = $date;
            $def[$a-1]['noa_opsi'] = 0;
            $def[$a-1]['os_opsi'] = 0;
}

if($akumulasiInstalment){
    foreach ($akumulasiInstalment as  $instal){
         $def[$a-1]['office_name'] = $instal->office_name;
        $def[$a-1]['contract_date'] = $instal->contract_date;
         $def[$a-1]['noa_instal'] = $instal->noa;
        $def[$a-1]['os_instal'] = $instal->os;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['contract_date'] = $date;
            $def[$a-1]['noa_instal'] = 0;
            $def[$a-1]['os_instal'] = 0;
}

if($akumulasiSmartphone){
    foreach ($akumulasiSmartphone as  $smartphone){
         $def[$a-1]['office_name'] = $smartphone->office_name;
        $def[$a-1]['contract_date'] = $smartphone->contract_date;
         $def[$a-1]['noa_smartphone'] = $smartphone->noa;
        $def[$a-1]['os_smartphone'] = $smartphone->os;
    }
}else{
    $def[$a-1]['office_name'] = $name;
            $def[$a-1]['contract_date'] = $date;
            $def[$a-1]['noa_smartphone'] = 0;
            $def[$a-1]['os_smartphone'] = 0;
}
    
}

//   var_dump($def); exit;

return $this->sendResponse($def, 200);
}
//End Perpanjangan


public function pencairan_bydate($date, $units)
	{
        $date = date('Y-m-0'.$date);

        // var_dump($date);
        // var_dump($units); exit;
        
		$data = $this->pawnTransactions->select("office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
			->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            // var_dump($data); exit;
			return $this->sendResponse($data, 200); 
	}

    public function repayment_bydate($date, $units)
	{
        
        $date = date('Y-m-0'.$date);

        // var_dump($date);
        // var_dump($units); exit;
        
		$data = $this->pawnTransactions->select("office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
			->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.repayment_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            // var_dump($data); exit;
			return $this->sendResponse($data, 200); 
	}

    public function perpanjangan_bydate($date, $units)
	{
        $date = date('Y-m-0'.$date);

        // var_dump($date);
        // var_dump($units); exit;
        
		$data = $this->pawnTransactions->select("office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
            
            ->where('pawn_transactions.parent_sge !=', null)
			->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            // var_dump($data); exit;
			return $this->sendResponse($data, 200); 
	}


    // Dashboard

    

    public function countOneobligor()
	{
        $month = date('m');
        $year = date('Y');

        $pawn = new PawnTransactions();
		$pawn->select(' area_id, office_code, lower(office_name) as office_name,customers.name as customer_name, customers.cif_number, customers.identity_number, 
           (select phone_number from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as phone_number, 
           count(loan_amount) as noa,sum(loan_amount) as up')
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
            ->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('payment_status', FALSE)
            ->groupBy('area_id')
            ->groupBy('office_code')
            ->groupBy('office_name')
            ->groupBy('cif_number')
            ->groupBy('customers.name')
            ->groupBy('customers.identity_number')
            ->groupBy('phone_number')
            ->having('sum(loan_amount) >= 250000000')
            ->orderBy('area_id', 'asc')
            ->orderBy('office_name', 'asc')
            ->orderBy('sum(loan_amount)', 'desc');
			
              if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $pawn->where('pawn_transactions.office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $pawn->where('pawn_transactions.branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $pawn->where('pawn_transactions.area_id', session()->get( 'user' )->area_id );
              }

            $data = $pawn->countAllResults();
            

            // var_dump($data); exit;

			return $this->sendResponse($data, 200); 
	}

    public function outstandingAll()
	{

        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }

        $month = date('m');
        $def = [];

        for($i = 1; $i<= $month; $i++){
            if($month == $i){
                $date = date('Y-m-d');
                $bulan = date('m');
            }else{
                if(strlen($i) ==  1 ){
                    $bulan = '0'.$i;
                    $date1 = date('Y-0'.$i.'-01');
                    $date = date ('Y-m-t', strtotime ($date1));
                }else{
                    $date1 = date('Y-'.$i.'-01');
                    $date = date ('Y-m-t', strtotime ($date1));
                    $bulan = $i;
                }  
            }         
            $data = $this->get_os($date);

            $def[$i-1]['date'] =  $date;
            $def[$i-1]['month'] =  $bulan;
            $def[$i-1]['noa'] =  $data['noa'];
            $def[$i-1]['os'] =  $data['os'];

        }

			return $this->sendResponse($def, 200);
	}

    public function get_os($date)
	{
        
		 $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
		// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false);

            if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $this->pawnTransactions->where('office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $this->pawnTransactions->where('branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $this->pawnTransactions->where('area_id', session()->get( 'user' )->area_id );
              }

			$akumulasiActive = $this->pawnTransactions->first();

             
			$this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os')
		// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true);
			
            if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $this->pawnTransactions->where('office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $this->pawnTransactions->where('branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $this->pawnTransactions->where('area_id', session()->get( 'user' )->area_id );
              }

            $akumulasiRepayment = $this->pawnTransactions->first();
            

            //Cicilan
		$this->pawnTransactions->select('count(pawn_transactions.id) as noa, sum(installment_items.installment_amount) as angsuran')
                        ->join('installment_items', 'installment_items.pawn_transaction_id=pawn_transactions.id')
                        ->where('installment_items.payment_date <=', $date)
                        ->where('pawn_transactions.payment_status', false);

            if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $this->pawnTransactions->where('office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $this->pawnTransactions->where('branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $this->pawnTransactions->where('area_id', session()->get( 'user' )->area_id );
              }

            $installment = $this->pawnTransactions->first();

			$data = [
				'noa' => $akumulasiActive->noa + $akumulasiRepayment->noa,
				'os' => $akumulasiActive->os + $akumulasiRepayment->os - $installment->angsuran
			];
			return $data;
	}

    public function installment(){
        $this->pawnTransactions->select('sum(installment_amount) as angsuran')
        ->where('')
    }

    public function dpdAll()
	{
        $month = date('m');
        $def = [];

        for($i = 1; $i<= $month; $i++){
            if($month == $i){
                $date = date('Y-m-d');
                $bulan = date('m');
            }else{
                if(strlen($i) ==  1 ){
                    $bulan = '0'.$i;
                    $date1 = date('Y-0'.$i.'-01');
                    $date = date ('Y-m-t', strtotime ($date1));
                }else{
                    $date1 = date('Y-'.$i.'-01');
                    $date = date ('Y-m-t', strtotime ($date1));
                    $bulan = $i;
                }  
            }         
            $data = $this->get_dpd($date);

            $def[$i-1]['date'] =  $date;
            $def[$i-1]['month'] =  $bulan;
            $def[$i-1]['noa'] =  $data['noa'];
            $def[$i-1]['os'] =  $data['os'];

        }

			return $this->sendResponse($def, 200); 
	}

    public function get_dpd($date)
	{
        $noa = 0;
        $os = 0;


             if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $this->pawnTransactions->where('office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $this->pawnTransactions->where('branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $this->pawnTransactions->where('area_id', session()->get( 'user' )->area_id );
              }

		 $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false);

        $akumulasiActive = $this->pawnTransactions->first();
            
       
        if($akumulasiActive){
            $noa += $akumulasiActive->noa;
            $os += $akumulasiActive->os;

            // echo $date;
            // echo $akumulasiActive->noa.'|';
            //     echo $akumulasiActive->os.'|Active';
        }
           


             if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $this->pawnTransactions->where('office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $this->pawnTransactions->where('branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $this->pawnTransactions->where('area_id', session()->get( 'user' )->area_id );
              }

			$this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os')
			 ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date >', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true);

        $akumulasiRepayment = $this->pawnTransactions->first();
              
             
        
            
            if($akumulasiRepayment){
                $noa += $akumulasiRepayment->noa;
                $os += $akumulasiRepayment->os;

                // echo $date;
                // echo $akumulasiRepayment->noa.'|';
                // echo $akumulasiRepayment->os.'|Repay';
            }

			

			$data = [
				'noa' => $noa,
				'os' => $os
			];
            // var_dump($data); exit;
			return $data;

            
	}

    public function deviasiAll()
	{
        $month = date('m');
        $year = date('Y');

        $pawn = new PawnTransactions();
		$pawn->select('EXTRACT(MONTH from contract_date) as month, EXTRACT(YEAR from contract_date) as year,  count(transaction_deviations.id) as noa, sum(loan_amount) as os')
        ->join(' transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(YEAR from contract_date) ', $year)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
                ->groupBy('EXTRACT(MONTH from contract_date)')
                ->groupBy('EXTRACT(YEAR from contract_date)');
			
              if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $pawn->where('pawn_transactions.office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $pawn->where('pawn_transactions.branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $pawn->where('pawn_transactions.area_id', session()->get( 'user' )->area_id );
              }
              
            $data = $pawn->findAll();
            

            // var_dump($data); exit;

			return $this->sendResponse($data, 200); 
	}

    public function oneobligorAll()
	{
        $month = date('m');
        $year = date('Y');

        $pawn = new PawnTransactions();
		$pawn->select(' area_id, office_code, lower(office_name) as office_name,customers.name as customer_name, customers.cif_number, customers.identity_number, 
           (select phone_number from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as phone_number, 
           count(loan_amount) as noa,sum(loan_amount) as up')
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
            ->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('payment_status', FALSE)
            ->groupBy('area_id')
            ->groupBy('office_code')
            ->groupBy('office_name')
            ->groupBy('cif_number')
            ->groupBy('customers.name')
            ->groupBy('customers.identity_number')
            ->groupBy('phone_number')
            ->having('sum(loan_amount) >= 250000000')
            ->orderBy('area_id', 'asc')
            ->orderBy('office_name', 'asc')
            ->orderBy('sum(loan_amount)', 'desc');

            $data = $pawn->countAllResults();
            

            // var_dump($data); exit;

			return $this->sendResponse($data, 200); 
	}

    public function ltvAll()
	{
        $month = date('m');
        $year = date('Y');

		$data = $this->pawnTransactions->select(" EXTRACT(MONTH FROM contract_date) as month, count(loan_amount) as noa, sum(loan_amount) as os
				")
            ->where('EXTRACT(YEAR FROM contract_date) ', $year)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.product_name !=','Gadai Cicilan')
			->where('pawn_transactions.deleted_at', null)
            ->where('maximum_loan_percentage >' , 92)
            ->groupBy('EXTRACT(YEAR FROM contract_date) ', $year)
            ->groupBy('EXTRACT(MONTH FROM contract_date) ', $month);
			
              if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $this->pawnTransactions->where('pawn_transactions.office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $this->pawnTransactions->where('pawn_transactions.branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $this->pawnTransactions->where('pawn_transactions.area_id', session()->get( 'user' )->area_id );
              }
              
            $data = $this->pawnTransactions->findAll();

			return $this->sendResponse($data, 200); 
	}

    public function batalAll()
	{
        $month = date('m');
        $year = date('Y');

		$this->pawnTransactions->select(" EXTRACT(MONTH FROM contract_date) as month, count(loan_amount) as noa, sum(loan_amount) as os
				")
		    ->where('EXTRACT(YEAR FROM contract_date) ', $year)
            // ->where('EXTRACT(MONTH FROM contract_date) ', $month)
			->groupStart()
                ->where('pawn_transactions.transaction_type', 4)
                ->orGroupStart()
                    ->Where('pawn_transactions.deleted_at !=', null)
                ->groupEnd()
            ->groupEnd()
            ->groupBy('EXTRACT(MONTH FROM contract_date) ')
            ->groupBy('EXTRACT(YEAR FROM contract_date) ');
			
              if ( session()->get( 'user' )->level == 'unit' OR session()->get( 'user' )->level == 'kasir' ){
                $this->pawnTransactions->where('pawn_transactions.office_id', session()->get( 'user' )->office_id );
              }elseif ( session()->get( 'user' )->level == 'cabang' ){
                $this->pawnTransactions->where('pawn_transactions.branch_id', session()->get( 'user' )->branch_id );
              }elseif ( session()->get( 'user' )->level == 'area' ){
                $this->pawnTransactions->where('pawn_transactions.area_id', session()->get( 'user' )->area_id );
              }
              
            $data = $this->pawnTransactions->findAll();
            // var_dump($data);exit;

			return $this->sendResponse($data, 200); 
	}

}