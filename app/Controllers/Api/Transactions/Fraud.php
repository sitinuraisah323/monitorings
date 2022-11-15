<?php namespace App\Controllers\Api\Transactions;
use App\Controllers\Api\BaseApiController;
use App\Models\Cabang;
use App\Models\DailyCash;
use App\Models\JournalEntries;
use App\Models\PawnTransactions;
use App\Models\Regular;
use App\Models\Units;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Fraud extends BaseApiController
{
    public function __construct()
    {
        $db =  \Config\Database::connect(); // default database groupnding
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
         $this->JournalEntries = new \App\Models\JournalEntries();
         $this->pagukas = new \App\Models\Pagukas();
        
        

    }

    public $modelName = '\App\Models\PawnTransactions';

       /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]

    public $fillSearch = [
        'sge'              => 'sge',
    ];

    public $searchValue = 'sge';

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillWhere = [
        'office_name'       => 'units',
        'contract_date'   => '2022-09-01'
    ];

//    [
//        'name' => [
//        'label'  => 'Name',
//        'rules'  => 'required',
//        'errors' => [
//        'required' => 'Required Name '
//        ]
//    ],
    public $validateInsert = [
        // 'level' => [
        //     'label'  => 'level',
        //     'rules'  => 'required',
        // ],
        // 'description' => [
        //     'label'  => 'description',
        //     'rules'  => 'required',
        // ]
    ];

    public $validateUpdate = [
        // 'id' => [
        //     'label'  => 'id',
        //     'rules'  => 'required',
        //     'errors' => [
        //         'required' => 'Id harus di isi'
        //     ]
        // ],
        // 'level' => [
        //     'label'  => 'level',
        //     'rules'  => 'required',
        // ],
        // 'description' => [
        //     'label'  => 'description',
        //     'rules'  => 'required',
        // ]
    ];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillableInsert = [
        // 'level'              => 'level',
        // 'description' => 'description'
    ];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]


    public $fillableIupdate = [
        // 'level'              => 'level',
        // 'description' => 'description'
    ];

//    product
    public $content = 'Setting Level';
    //--------------------------------------------------------------------

 public function fraud($area, $branch, $units, $category, $dateStart, $dateEnd, $limit)
	{
        $monthStart = date('m', strtotime($dateStart));
        $monthEnd = date('m', strtotime($dateEnd));
        $yearStart = date('Y', strtotime($dateStart));
        $yearEnd = date('Y', strtotime($dateEnd));

        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
			// ->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            if($area != '0'){
            $pawn->where('area_id', $area);
            }
            if($branch != '0'){
            $pawn->where('branch_id', $branch);
            }
            if($units != '0'){
            $pawn->where('office_id', $units);
            }
           


            $pawn->select(" '$limit' as limit, area_id, office_id, office_name, EXTRACT(MONTH FROM contract_date) as month, EXTRACT(YEAR FROM contract_date) as year, count(id) as total")
            ->where('EXTRACT(YEAR FROM contract_date) >=', $yearStart)
            ->where('EXTRACT(YEAR FROM contract_date) <=', $yearEnd)
            ->where('EXTRACT(MONTH FROM contract_date) >=', $monthStart)
            ->where('EXTRACT(MONTH FROM contract_date) <=', $monthEnd)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.product_name !=','Gadai Cicilan')
			->where('pawn_transactions.deleted_at', null)
            // ->where('maximum_loan_percentage >' , $limit)
			->groupBy('EXTRACT(MONTH FROM contract_date)')
            ->groupBy('EXTRACT(YEAR FROM contract_date)')
            ->groupBy('area_id')
            ->groupBy('office_name')
            ->groupBy('office_id')
            ->groupBy('limit')
            ->orderBy('office_name', 'ASC')
            ->orderBy('EXTRACT(MONTH FROM contract_date) ASC');

            if($limit != 'all'){ $pawn->where('maximum_loan_percentage >', $limit); }

            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}


    public function detailFraud($office_id, $month, $year, $limit)
	{
        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
             ->where('pawn_transactions.office_id', $office_id)           
            ->where('EXTRACT(MONTH FROM contract_date) ', $month)
            ->where('EXTRACT(YEAR FROM contract_date) ', $year)
            ->where('maximum_loan_percentage >' , 92)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)       
			->where('pawn_transactions.product_name !=','Gadai Cicilan')
			->where('pawn_transactions.deleted_at', null)->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

           
            $pawn->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.payment_status, pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
          ->where('pawn_transactions.office_id', $office_id)           
            ->where('EXTRACT(MONTH FROM contract_date) ', $month)
            ->where('EXTRACT(YEAR FROM contract_date) ', $year)
            // ->where('maximum_loan_percentage >' , $limit)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)       
			->where('pawn_transactions.product_name !=','Gadai Cicilan')
			->where('pawn_transactions.deleted_at', null)
            ->orderBy('pawn_transactions.sge', 'asc');
			
            if($limit){ $pawn->where('maximum_loan_percentage >', $limit); }


            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}

   public function outstanding($area, $branch, $units, $category, $dateStart, $dateEnd, $limit)
	{

        if(is_null(session()->get('logged_in'))){
            return $this->sendResponse('No Authenticated', 403, 'No Authenticated');

        }

        $def = [];
            $c = 0;
            $totalRecordAktif = 0;
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
			// ->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;
            $unit = '';
            
            $areas = new \App\Models\Units();
             $unit = $areas->select('*')->findAll();
            if($area != '0'){

            $unit = $areas->select('*')->where('area_id', $area)->findAll();
            }
            if($branch != '0'){
            
            $unit = $areas->select('*')->where('branch_id', $branch)->findAll();
            }
            if($units != '0'){
           
            $unit = $areas->select('*')->where('office_id', $units)->findAll();
            }

        //selisih bulan
        $dateS = date_create($dateStart);
        $dateE = date_create($dateEnd);

        $selisih = date_diff($dateS, $dateE);

        // echo $selisih->m.' bulan';

        $month = date('Y-m-t', strtotime($dateEnd));

        for($a = 0; $a <= $selisih->m; $a++){
            $b = $a+1;
            $month_1 = date('Y-m-t', strtotime('-'.$b.' month', strtotime($dateEnd)));
            $month = date('Y-m-t', strtotime('-'.$a.' month', strtotime($dateEnd)));

            // echo $month; exit;
            foreach($unit as $data){
                $os_1 = $this->get_os($data->office_id, $month_1);
                
                $os = $this->get_os($data->office_id, $month);

                $angsuran_1 = $this->get_angsuran($data->office_id, $month_1);

                $angsuran = $this->get_angsuran($data->office_id, $month);

                    if($os_1['os'] != 0){
                        $persentase = (($os['os'] - $angsuran['angsuran'])  - ($os_1['os']) - $angsuran_1['angsuran']) / ($os_1['os'] - $angsuran_1['angsuran']) * 100;
                        // echo $persentase; 
                    }else{
                        $persentase = 0;
                    }

                        if($persentase > $limit){
                            $totalRecordAktif ++;
                            $def[$c]['office_id'] =  $data->office_id;
                            $def[$c]['unit'] =  $data->office_name;
                            $def[$c]['noa'] =  $os['noa'];
                            $def[$c]['os'] =  $os['os'] - $angsuran['angsuran'];
                            $def[$c]['noa_1'] =  $os_1['noa'];
                            $def[$c]['os_1'] =  $os_1['os'] - $angsuran_1['angsuran'];
                            $def[$c]['persentase'] =  round($persentase,2);
                            $def[$c]['month'] =  date('m', strtotime($month));
                            $def[$c]['year'] =  date('Y', strtotime($month));
                            $def[$c]['date'] =  $month;
                            $c++;
                        }
                        // print_r($def);

            }
// exit;
        }
       
            
            return $this->sendResponse($def,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
	}

    public function get_os($office_id, $date)
	{
		$akumulasiActive = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
		// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();

			$akumulasiRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os')
		// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();

			

			$data = [
				'noa' => $akumulasiActive->noa + $akumulasiRepayment->noa,
				'os' => $akumulasiActive->os + $akumulasiRepayment->os
			];
			return $data;
	}

     public function get_angsuran($office_id, $date){
        
        $angsuran = $this->pawnTransactions->select('count(pawn_transactions.id) as noa, sum(installment_items.installment_amount) as angsuran')
        ->join('installment_items', 'installment_items.pawn_transaction_id=pawn_transactions.id')
        ->where('office_id', $office_id)
        ->where('installment_items.payment_date <=', $date)
        ->where('pawn_transactions.payment_status', false)
        ->first();

        $data = [
            'noa' => $angsuran->noa,
            'angsuran' => $angsuran->angsuran
        ];

        // print_r($data); exit;
        
        return $data;
    }
   

    public function getAngsuran(){
        $this->pawnTransactions->select('installment_items')
        ->where('installment_items.payment_date <=', $date)
        ->where('installment_')

    }

    public function detail_os($office_id, $date)
	{
  
        //   $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecordAktif = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)->countAllResults();

        $totalRecordRepay = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.repayment_date >', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)->countAllResults();

        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif + $totalRecordRepay;

       

        // $date = '2022-09-01';
        // $units = '60c6ca91e64d1e242863095a';

        // var_dump($date);
        // var_dump($units); exit;
        
		$aktif = $this->pawnTransactions->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
           ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
            ->where('pawn_transactions.transaction_type !=', 5)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            //repayment Regular
            $repay = $this->pawnTransactions->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
           ->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.contract_date <=', $date)
            ->where('pawn_transactions.repayment_date >', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
            ->where('pawn_transactions.transaction_type !=', 5)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            $aktifCicilan = $this->pawnTransactions->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description,
                (select sum(installment_amount) from installment_items where pawn_transactions.id=installment_items.pawn_transaction_id and payment_date <= '$date' limit 1) as angsuran,
                ")
           ->where('pawn_transactions.transaction_type', 5)
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            //repayment Regular
            $repayCicilan = $this->pawnTransactions->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
                (select sum(installment_amount) from installment_items where pawn_transactions.id=installment_items.pawn_transaction_id and payment_date <= '$date' limit 1) as angsuran,
                ")
           ->where('pawn_transactions.transaction_type ', 5)
                ->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.contract_date <=', $date)
            ->where('pawn_transactions.repayment_date >', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();
            
                  $data = array_merge($aktif,$repay, $aktifCicilan,$repayCicilan);
// var_dump($result);exit;
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif + $totalRecordRepay,
            ]);
	}

    function ticketsize($area, $branch, $units, $category, $dateStart, $dateEnd, $limitRp)
    {

        $monthStart = date('m', strtotime($dateStart));
        $monthEnd = date('m', strtotime($dateEnd));
        $yearStart = date('Y', strtotime($dateStart));
        $yearEnd = date('Y', strtotime($dateEnd));

        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
            ->where('EXTRACT(YEAR FROM contract_date) >=', $yearStart)
            ->where('EXTRACT(YEAR FROM contract_date) <=', $yearEnd)
            ->where('EXTRACT(MONTH FROM contract_date) >=', $monthStart)
            ->where('EXTRACT(MONTH FROM contract_date) <=', $monthEnd)
			->where('pawn_transactions.status !=', 5)
            ->where('pawn_transactions.status !=', 4)
            ->where('pawn_transactions.transaction_type !=', 4)
            ->where('pawn_transactions.deleted_at', null)
			->groupBy('EXTRACT(MONTH FROM contract_date)')
            ->groupBy('EXTRACT(YEAR FROM contract_date)')
            ->groupBy('area_id')
            ->groupBy('office_name')
            ->groupBy('office_id')->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            if($area != '0'){
            $pawn->where('area_id', $area);
            }
            if($branch != '0'){
            $pawn->where('branch_id', $branch);
            }
            if($units != '0'){
            $pawn->where('office_id', $units);
            }
            if($limitRp == 'A'){
                $pawn->where('sum(pawn_transactions.loan_amount)/count(pawn_transactions.loan_amount) <=', 5000000);
            }
            if($limitRp == 'B'){
                $pawn->where('sum(pawn_transactions.loan_amount)/count(pawn_transactions.loan_amount) >', 5000000);
                $pawn->where('sum(pawn_transactions.loan_amount)/count(pawn_transactions.loan_amount) <', 10000000);
            }
            if($limitRp == 'C'){
                $pawn->where('sum(pawn_transactions.loan_amount)/count(pawn_transactions.loan_amount) >', 10000000);
            }


            $pawn->select("  area_id, office_id, office_name, EXTRACT(MONTH FROM contract_date) as month, EXTRACT(YEAR FROM contract_date) as year, count(id) as noa, sum(loan_amount) as up, sum(loan_amount)/count(loan_amount)  as ticketsize ")
            ->where('EXTRACT(YEAR FROM contract_date) >=', $yearStart)
            ->where('EXTRACT(YEAR FROM contract_date) <=', $yearEnd)
            ->where('EXTRACT(MONTH FROM contract_date) >=', $monthStart)
            ->where('EXTRACT(MONTH FROM contract_date) <=', $monthEnd)
			->where('pawn_transactions.status !=', 5)
            ->where('pawn_transactions.status !=', 4)
            ->where('pawn_transactions.transaction_type !=', 4)
            ->where('pawn_transactions.deleted_at', null)
            // ->where('sum(pawn_transactions.loan_amount)/count(pawn_transactions.loan_amount) <=', 5000000)
			->groupBy('EXTRACT(MONTH FROM contract_date)')
            ->groupBy('EXTRACT(YEAR FROM contract_date)')
            ->groupBy('area_id')
            ->groupBy('office_name')
            ->groupBy('office_id')
            ->orderBy('office_name', 'ASC')
            ->orderBy('EXTRACT(MONTH FROM contract_date) ASC');

           

            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);



        
        
    }

    function detailTicketsize($office_id, $month, $year){
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
             ->where('pawn_transactions.office_id', $office_id)           
            ->where('EXTRACT(MONTH FROM contract_date) ', $month)
            ->where('EXTRACT(YEAR FROM contract_date) ', $year)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            $pawn->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
             ->where('pawn_transactions.office_id', $office_id)           
            ->where('EXTRACT(MONTH FROM contract_date) ', $month)
            ->where('EXTRACT(YEAR FROM contract_date) ', $year)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null);
           

            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
    }

    function frequensi($area, $branch, $units, $category, $dateStart, $dateEnd, $frequensi )
    {

        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
        $monthStart = date('m', strtotime($dateStart));
        $monthEnd = date('m', strtotime($dateEnd));
        $yearStart = date('Y', strtotime($dateStart));
        $yearEnd = date('Y', strtotime($dateEnd));
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
            ->where('pawn_transactions.contract_date >=', $dateStart)
            ->where('pawn_transactions.contract_date <=', $dateEnd)
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
		// ->having('sum(loan_amount) >= 250000000')
		->orderBy('area_id', 'asc')
		->orderBy('office_name', 'asc')
		->orderBy('sum(loan_amount)', 'desc')->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;
            $unit = '';
            
            $areas = new \App\Models\Units();
             $unit = $areas->select('*')->findAll();
            if($area != '0'){
            // $pawn->where('area_id', $area);
            // $areasAll = $area->select('area_id')->groupBy('area_id')->findAll();
        
            $unit = $areas->select('*')->where('area_id', $area)->findAll();
            }
            if($branch != '0'){
            // $pawn->where('branch_id', $branch);
            
            $unit = $areas->select('*')->where('branch_id', $branch)->findAll();
            }
            if($units != '0'){
            // $pawn->where('office_id', $units);
           
            $unit = $areas->select('*')->where('office_id', $units)->findAll();
            }
            // $units  = $area->findAll();
            // var_dump($unit); exit;
            $def = [];
            $a = 0;
            $totalRecordAktif = 0;
            $dateStartrepay = '';
        if($dateStart){
            // $pawn->where('contract_date >=', $dateStart);
            foreach($unit as $data){
                $start = $pawn->select('EXTRACT(MONTH FROM contract_date) as month, EXTRACT(YEAR FROM contract_date) as year, customers.name as name, customers.cif_number, customers.identity_number, (select phone_number from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as phone_number, count(loan_amount) as noa,sum(loan_amount) as up')
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
            ->where('pawn_transactions.office_id', $data->office_id)
            ->where('pawn_transactions.contract_date >=', $dateStart)
                ->where('pawn_transactions.contract_date <=', $dateEnd)
            ->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            // ->where('count(customers.identity_number) >', 5)
		->groupBy('area_id')
		->groupBy('office_code')
		->groupBy('office_name')
		->groupBy('customers.cif_number')
		->groupBy('customers.name')
        ->groupBy('customers.identity_number')
        ->groupBy('phone_number')
        ->groupBy('EXTRACT(MONTH FROM contract_date)')
        ->groupBy('EXTRACT(YEAR FROM contract_date)')
		->having("count(loan_amount) >=", $frequensi )
		->orderBy('area_id', 'asc')
		->orderBy('office_name', 'asc')
		->orderBy('sum(loan_amount)', 'desc')
        ->findAll();

                foreach($start as $starts){
                //     if($frequensi == 'A'){
                       
                //         if($starts->noa < 5 ){
                            $def[$a]['area_id'] =  $data->area_id;
                            $def[$a]['office_id'] =  $data->office_id;
                            $def[$a]['office_code'] =  $data->office_code;
                            $def[$a]['name'] =  $starts->name;
                            $def[$a]['office_name'] =  $data->office_name;
                            $def[$a]['identity_number'] =  $starts->identity_number;
                            $def[$a]['cif_number'] =  $starts->cif_number;
                            $def[$a]['phone_number'] =  $starts->phone_number;
                            $def[$a]['noa'] =  $starts->noa;
                            $def[$a]['up'] =  $starts->up;
                            $def[$a]['month'] =  $starts->month;
                            $def[$a]['year'] =  $starts->year;
                            $def[$a]['dateStart'] =  $dateStart;
                            $def[$a]['dateEnd'] =  $dateEnd;
                            $def[$a]['frequensi'] =  $frequensi;
                            $a++;
                 
                }
            
                }
        }
            
            return $this->sendResponse($def,201,[
                'totalRecord' => $a+1,
            ]);

        
    }

    function detail_frequensi($office_id,$ktp, $month, $year){
         if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecordAktif = $this->pawnTransactions
        //    ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)->countAllResults();

            
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            $pawn = new PawnTransactions();

           $pawn->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
            ->where('pawn_transactions.office_id ', $office_id)
			->where('EXTRACT(MONTH FROM contract_date) ', $month)
            ->where('EXTRACT(YEAR FROM contract_date) ', $year)
            ->where('customers.identity_number', $ktp)
            ->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->orderBy('pawn_transactions.sge', 'asc');
		

            $data = $pawn->findAll();
            
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
    }


     public function dpd($area, $branch, $units, $category, $dateStart, $dateEnd, $limit)
	{
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }

         $def = [];
            $c = 0;
            $totalRecordAktif = 0;
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
			// ->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;
            $unit = '';
            
            $areas = new \App\Models\Units();
             $unit = $areas->select('*')->findAll();
            if($area != '0'){

            $unit = $areas->select('*')->where('area_id', $area)->findAll();
            }
            if($branch != '0'){
            
            $unit = $areas->select('*')->where('branch_id', $branch)->findAll();
            }
            if($units != '0'){
           
            $unit = $areas->select('*')->where('office_id', $units)->findAll();
            }

        //selisih bulan
        $dateS = date_create($dateStart);
        $dateE = date_create($dateEnd);

        $selisih = date_diff($dateS, $dateE);

        // echo $selisih->m.' bulan';

        $month = date('Y-m-t', strtotime($dateEnd));

        for($a = 0; $a <= $selisih->m; $a++){
            $b = $a+1;
            $month_1 = date('Y-m-t', strtotime('-'.$b.' month', strtotime($dateEnd)));
            if($a == 0){
                  $month = date('Y-m-d', strtotime('-'.$a.' month', strtotime($dateEnd)));          
            }else{
                $month = date('Y-m-t', strtotime('-'.$a.' month', strtotime($dateEnd)));
            }
            

            // echo $month; exit;
            foreach($unit as $data){
                $dpd_1 = $this->get_dpd($data->office_id, $month_1);
                
                $os = $this->get_os($data->office_id, $month);

                $dpd = $this->get_dpd($data->office_id, $month);
                        // $outstanding = $this->get_os($data->office_id, $monthStart);

                    if($dpd_1['os'] != 0){
                        $persentase = ($dpd['os'] - $dpd_1['os']) / $dpd_1['os'] * 100;
                        // echo $persentase; 
                    }else{
                        $persentase = 0;
                    }
                    
                     if($os['os'] != 0){
                        $persentase_os = $dpd['os'] / $os['os'] * 100 ;
                        // echo $persentase; 
                    }else{
                        $persentase = 0;
                    }
                    
                        if($persentase_os > $limit){
                            $totalRecordAktif ++;
                            $def[$c]['office_id'] =  $data->office_id;
                            $def[$c]['unit'] =  $data->office_name;
                            $def[$c]['noa_os'] =  $os['noa'];
                            $def[$c]['outstanding'] =  $os['os'];
                            $def[$c]['noa'] =  $dpd['noa'];
                            $def[$c]['os'] =  $dpd['os'];
                            $def[$c]['noa_1'] =  $dpd_1['noa'];
                            $def[$c]['os_1'] =  $dpd_1['os'];
                            $def[$c]['persentase_os'] =  round($persentase_os, 1);
                            $def[$c]['persentase'] =  round($persentase,2);
                            $def[$c]['month'] =  date('m', strtotime($month));
                            $def[$c]['year'] =  date('Y', strtotime($month));
                            $def[$c]['date'] = $month;
                            $c++;

                            
                        }
                        // print_r($def);

            }
        }
        
       
            
            return $this->sendResponse($def,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
 
	}

    public function get_dpd($office_id, $date)
	{
		$akumulasiActive = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
		// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
			->first();

           

			$akumulasiRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os')
		// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $office_id)
			 ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date >', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
			->first();
        if($akumulasiRepayment->noa == null){
            $akumulasiRepayment->noa = 0;
        }
        if($akumulasiRepayment->os == null){
            $akumulasiRepayment->os = 0;
        }
        

			

			$data = [
				'noa' => $akumulasiActive->noa + $akumulasiRepayment->noa,
				'os' => $akumulasiActive->os + $akumulasiRepayment->os
			];
			return $data;
	}

    public function detail_dpd($office_id, $date)
	{
  
        //   $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecordAktif = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $office_id)
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)->countAllResults();

        $totalRecordRepay = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $office_id)
            ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date >', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)->countAllResults();

        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif + $totalRecordRepay;

       

        // $date = '2022-09-01';
        // $units = '60c6ca91e64d1e242863095a';

        // var_dump($date);
        // var_dump($units); exit;
        
		$aktif = $this->pawnTransactions->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
			->where('pawn_transactions.office_id', $office_id)
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', false)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            //repayment Regular
            $repay = $this->pawnTransactions->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
			->where('pawn_transactions.office_id', $office_id)
            ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date >', $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
                    ->where('pawn_transactions.payment_status', true)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            
                  $data = array_merge($aktif,$repay);
// var_dump($result);exit;
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif + $totalRecordRepay,
            ]);
	}

    public function moker($area, $branch, $units, $category, $dateStart, $dateEnd)
	{
        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new JournalEntries();

        $totalRecordAktif =  $this->JournalEntries
            ->where('journals.publish_date >=', $dateStart)
                ->where('journals.publish_date <=', $dateEnd)
                ->where('journal_entries.transaction_type', 1)
                ->like('journal_entries.description','Penerimaan Kas dari Modal%')->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            if($area != '0'){
            $pawn->where('area_id', $area);
            }
            if($branch != '0'){
            $pawn->where('branch_id', $branch);
            }
            if($units != '0'){
            $pawn->where('journal_entries.office_id', $units);
            }
           $pawn->select("journal_entries.area_name, journal_entries.office_name, journal_entries.office_id,  EXTRACT(MONTH FROM publish_date) as month,EXTRACT(YEAR FROM publish_date) as year, count(journal_entries.amount) as jumlah,  sum(journal_entries.amount) as moker ")
                ->join('journals', 'journals.id = journal_entries.journal_id')
                ->where('journals.publish_date >=', $dateStart)
                ->where('journals.publish_date <=', $dateEnd)
                ->where('journal_entries.transaction_type', 1)
                ->where('journal_entries.deleted_at ', null)
                ->like('journal_entries.description','Penerimaan Kas dari Modal%')
                ->groupBy('journal_entries.area_name')
                ->groupBy('journal_entries.office_name')
                ->groupBy('journal_entries.office_id')
                ->groupBy('EXTRACT(MONTH FROM publish_date)')
                ->groupBy('EXTRACT(YEAR FROM publish_date)');
			
            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
            
	}

    public function detailMoker($units, $month, $year)
	{
        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new JournalEntries();

        $totalRecordAktif =  $this->JournalEntries
             ->where('journal_entries.office_id', $units)
                ->where('EXTRACT(MONTH FROM publish_date)', $month)
                ->where('EXTRACT(YEAR FROM publish_date)', $year)
                ->where('journal_entries.transaction_type', 1)
                ->like('journal_entries.description','Penerimaan Kas dari Modal%')->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

           $pawn->select("journal_entries.area_name, journal_entries.office_name, journals.publish_date, journal_entries.description, journal_entries.amount ")
                ->join('journals', 'journals.id = journal_entries.journal_id')
                ->where('journal_entries.office_id', $units)
                ->where('EXTRACT(MONTH FROM publish_date)', $month)
                ->where('EXTRACT(YEAR FROM publish_date)', $year)
                ->where('journal_entries.transaction_type', 1)
                ->where('journal_entries.deleted_at ', null)
                ->like('journal_entries.description','Penerimaan Kas dari Modal%')
                ->orderBy('journals.publish_date', 'ASC');
			
            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
            
	}

    function saldokas($area, $branch, $units, $category, $dateStart, $dateEnd,$status)
    {
        // echo $status;
        $saldoLimit = "$status.000";
        // var_dump($saldoLimit);exit;
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->DailyCash
                    // ->where('daily_cashes.office_id', $data->office_id)
                    ->where('daily_cashes.date_open >=', $dateStart)
                    ->where('daily_cashes.date_open <=', $dateEnd)
                    ->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;
            $unit = '';
            
            $areas = new \App\Models\Units();
             $unit = $areas->select('*')->findAll();
            if($area != '0'){
            // $pawn->where('area_id', $area);
            // $areasAll = $area->select('area_id')->groupBy('area_id')->findAll();
        
            $unit = $areas->select('*')->where('area_id', $area)->findAll();
            }
            if($branch != '0'){
            // $pawn->where('branch_id', $branch);
            
            $unit = $areas->select('*')->where('branch_id', $branch)->findAll();
            }
            if($units != '0'){
            // $pawn->where('office_id', $units);
           
            $unit = $areas->select('*')->where('office_id', $units)->findAll();
            }
            // $units  = $area->findAll();
            // var_dump($unit); exit;
            $def = [];
            $a = 0;
            $totalRecordAktif = 0;
            $dateStartrepay = '';

            $percen = 0;
        if($dateStart){
            // $pawn->where('contract_date >=', $dateStart);
            foreach($unit as $data){
                $start = $this->DailyCash->select(" office_name, office_code, date_open, remaining_balance ")
                    ->where('daily_cashes.office_id', $data->office_id)
                    ->where('daily_cashes.date_open >=', $dateStart)
                    ->where('daily_cashes.date_open <=', $dateEnd)
                    ->where('daily_cashes.remaining_balance >=', $saldoLimit)
                    ->orderBy('daily_cashes.date_open', 'desc')
                    ->findAll();
            
                foreach($start as $starts){
                    
                    $pagukas = new \App\Models\Pagukas();
                    $pagu = $pagukas
                    ->where('monitoring_pagukas.office_id', $data->office_id)->first();
                    //cek pagukas
                    $akhir =number_format($starts->remaining_balance, 0, '.', '');
                    if(!$pagu) {
                        $saldo = 0;
                        $persentase = 0;

                    }else{
                        $saldo = $pagu->saldo;
                        $persentase = $akhir  * 100 / $saldo;
                    }

                    //percentase
                    

                   
                                             
                   

                    //cek status kas
                    // $akhir =number_format($starts->remaining_balance, 0, '.', '');

                    if($akhir > $saldo){
                        $status = 1;                       
                    }else{
                        $status = 0; 
                    }
                    // if($statuss != 'all'){
                    //     if($status == $statuss){
                            $def[$a]['area_id'] =  $data->area_id;
                            $def[$a]['office_name'] =  $data->office_name;
                            $def[$a]['office_code'] =  $data->office_code;
                            $def[$a]['date_open'] =  $starts->date_open;
                            $def[$a]['remaining_balance'] =  number_format($starts->remaining_balance, 0, '.', '');
                            $def[$a]['percentase'] = round($persentase,1);
                            $def[$a]['saldo'] =  $saldo;
                            $def[$a]['status'] =  $status;
                            $def[$a]['dateStart'] =  $dateStart;
                            $def[$a]['dateEnd'] =  $dateEnd;
                            // $def[$a]['limit'] =  $status;
                            $a++;
                   

                    $percen = $akhir;
                }
            
                }
        }
            
            return $this->sendResponse($def,201,[
                'totalRecord' => $a+1,
            ]);

        
    }

    public function trxBatal($area, $branch, $units, $category, $dateStart, $dateEnd)
	{
        $monthStart = date('m', strtotime($dateStart));
        $monthEnd = date('m', strtotime($dateEnd));
        $yearStart = date('Y', strtotime($dateStart));
        $yearEnd = date('Y', strtotime($dateEnd));

        // echo $monthStart; echo $yearStart; echo $monthEnd; echo $yearEnd; exit;
        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
         ->groupStart()
            ->where('pawn_transactions.transaction_type', 4)
            ->orGroupStart()
			    ->Where('pawn_transactions.deleted_at !=', null)
            ->groupEnd()
            
        ->groupEnd()
            ->where('EXTRACT(YEAR FROM contract_date) >=', $yearStart)
            ->where('EXTRACT(YEAR FROM contract_date) <=', $yearEnd)
            ->where('EXTRACT(MONTH FROM contract_date) >=', $monthStart)
            ->where('EXTRACT(MONTH FROM contract_date) <=', $monthEnd)

            ->groupBy('EXTRACT(MONTH FROM contract_date)')
             ->groupBy('EXTRACT(YEAR FROM contract_date)')
             ->groupBy('area_id')
            ->groupBy('office_name')
            ->groupBy('office_id')
            ->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            if($area != '0'){
            $pawn->where('pawn_transactions.area_id', $area);
            }
            if($branch != '0'){
            $pawn->where('pawn_transactions.branch_id', $branch);
            }
            if($units != '0'){
            $pawn->where('pawn_transactions.office_id', $units);
            }
          
            $pawn->select(" area_id, office_id, office_name, EXTRACT(MONTH FROM contract_date) as month, EXTRACT(YEAR FROM contract_date) as year, count(id) as total, sum(loan_amount) as up")
			->where('EXTRACT(YEAR FROM contract_date) >=', $yearStart)
            ->where('EXTRACT(YEAR FROM contract_date) <=', $yearEnd)
            ->where('EXTRACT(MONTH FROM contract_date) >=', $monthStart)
            ->where('EXTRACT(MONTH FROM contract_date) <=', $monthEnd)
			->groupStart()
            ->where('pawn_transactions.transaction_type', 4)
            ->orGroupStart()
			    ->Where('pawn_transactions.deleted_at !=', null)
            ->groupEnd()
            
            ->groupEnd()
			->groupBy('EXTRACT(MONTH FROM contract_date)')
            ->groupBy('EXTRACT(YEAR FROM contract_date)')
            ->groupBy('area_id')
            ->groupBy('office_name')
            ->groupBy('office_id')
            // ->orderBy('office_name', 'ASC')
            ->orderBy('EXTRACT(MONTH FROM contract_date) ASC');

            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);

            // ->where('EXTRACT(YEAR FROM contract_date) >=', $yearStart)
            // ->where('EXTRACT(YEAR FROM contract_date) <=', $yearEnd)
            // ->where('EXTRACT(MONTH FROM contract_date) >=', $monthStart)
            // ->where('EXTRACT(MONTH FROM contract_date) <=', $monthEnd)
			// ->where('pawn_transactions.status !=', 5)
			// ->where('pawn_transactions.status !=', 4)
			// ->where('pawn_transactions.transaction_type !=', 4)
			// ->where('pawn_transactions.product_name !=','Gadai Cicilan')
			// ->where('pawn_transactions.deleted_at', null)
            // // ->where('maximum_loan_percentage >' , $limit)
			// ->groupBy('EXTRACT(MONTH FROM contract_date)')
            // ->groupBy('EXTRACT(YEAR FROM contract_date)')
            // ->groupBy('area_id')
            // ->groupBy('office_name')
            // ->groupBy('office_id')
            // ->groupBy('limit')
            // ->orderBy('office_name', 'ASC')
            // ->orderBy('EXTRACT(MONTH FROM contract_date) ASC');
            
	}


    function detailTrxBatal($office_id, $month, $year){
         if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecordAktif = $this->pawnTransactions
        ->where('pawn_transactions.office_id', $office_id)           
            ->where('EXTRACT(MONTH FROM contract_date) ', $month)
            ->where('EXTRACT(YEAR FROM contract_date) ', $year)
			->where('pawn_transactions.transaction_type', 4)
			->orWhere('pawn_transactions.deleted_at !=', null)
            ->countAllResults();
            
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            $pawn = new PawnTransactions();

             $pawn->select("pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
            ->where('pawn_transactions.office_id', $office_id)           
            ->where('EXTRACT(MONTH FROM contract_date) ', $month)
            ->where('EXTRACT(YEAR FROM contract_date) ', $year)
			->groupStart()
                ->where('pawn_transactions.transaction_type', 4)
                ->orGroupStart()
			        ->Where('pawn_transactions.deleted_at !=', null)
                ->groupEnd()           
            ->groupEnd()
            ->orderBy('pawn_transactions.contract_date', 'asc')
            ->orderBy('pawn_transactions.office_name', 'asc');
		
             $data = $pawn->findAll($start, $length);
            
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
    }


   function approval($area, $branch, $units, $category, $dateStart, $dateEnd, $approval, $deviasi, $product )
    {

        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $monthStart = date('m', strtotime($dateStart));
        $monthEnd = date('m', strtotime($dateEnd));
        $yearStart = date('Y', strtotime($dateStart));
        $yearEnd = date('Y', strtotime($dateEnd));

        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
            ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')
                // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
                ->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.EXTRACT(MONTH from contract_date) >=', $monthStart)
                ->where('pawn_transactions.EXTRACT(MONTH from contract_date) <=', $monthEnd)
                ->where('pawn_transactions.EXTRACT(MONTH from contract_date) >=', $yearStart)
                ->where('pawn_transactions.EXTRACT(MONTH from contract_date) <=', $yearEnd)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
                ->groupBy('pawn_transactions.area_id')
                ->groupBy('pawn_transactions.office_name')
                ->groupBy('EXTRACT(MONTH from contract_date)')
                ->groupBy('EXTRACT(YEAR from contract_date)')->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;
            $unit = '';

            $def = [];
            $a = 0;
            $totalRecordAktif = 0;
            $dateStartrepay = '';
        if($dateStart){
           
                $pawn->select("'$product' as product, '$deviasi' as deviasi, '$approval' as approval, pawn_transactions.area_id, pawn_transactions.office_name,pawn_transactions.office_id, EXTRACT(MONTH from contract_date) as month, EXTRACT(YEAR from contract_date) as year,  count(loan_amount) as jumlah")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('pawn_transactions.contract_date >=', $dateStart)
                ->where('pawn_transactions.contract_date <=', $dateEnd)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
                ->groupBy('pawn_transactions.area_id')
                ->groupBy('pawn_transactions.office_name')
                ->groupBy('pawn_transactions.office_id')
                // ->groupBy('transaction_deviations.deviation_type')
                // ->groupBy('transaction_deviations.office_type')
                ->groupBy('EXTRACT(MONTH from contract_date)')
                ->groupBy('EXTRACT(YEAR from contract_date)');

                if($area != '0'){
                $pawn->where('pawn_transactions.area_id', $area);
                }
                if($branch != '0'){
                $pawn->where('pawn_transactions.branch_id', $branch);
                }
                if($units != '0'){
                $pawn->where('pawn_transactions.office_id', $units);
                }

                if($deviasi != 'all'){
                $pawn->where('transaction_deviations.deviation_type', $deviasi);
                }
                if($approval != 'all'){
                $pawn->where('transaction_deviations.office_type', $approval);
                }
                if($product != 'all'){
                    if($product == '0'){
                        $product = 'Gadai Reguler';
                    }
                    if($product == '1'){
                        $product = 'Gadai Reguler GHTS';
                    }
                    if($product == '2'){
                        $product = 'Gadai Opsi Bulanan';
                    }
                    if($product == '3'){
                        $product = 'Gadai Smartphone';
                    }
                    if($product == '4'){
                        $product = 'Gadai Cicilan';
                    }
                $pawn->where('pawn_transactions.product_name', $product);
                }

                $pawn->orderBy('EXTRACT(MONTH from contract_date)')
                ->orderBy('EXTRACT(YEAR from contract_date)');


            $data = $pawn->findAll();
        }
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $a+1,
            ]);

        
    }

    function detailApproval($units, $month, $year, $approval, $deviasi, $product )
    {

        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }

        $pawn = new PawnTransactions();

        $totalRecordAktif =  $this->pawnTransactions
            ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.EXTRACT(MONTH from contract_date)', $month)
                ->where('pawn_transactions.EXTRACT(YEAR from contract_date)', $year)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
                ->countAllResults();
        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;
            $unit = '';

            $def = [];
            $a = 0;
            $totalRecordAktif = 0;
            $dateStartrepay = '';
           
                $pawn->select("pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,customers.cif_number,customers.name ,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name,transaction_deviations.deviation_type,transaction_deviations.office_type, ROUND(maximum_loan_percentage) as ltv, stle,notes,
					(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
                ->join('customers','customers.id = pawn_transactions.customer_id')
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                // ->where('pawn_transactions.office_id', $units)
                ->where('EXTRACT(MONTH from contract_date)', $month)
                ->where('EXTRACT(YEAR from contract_date) ', $year)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
                ->orderBy('pawn_transactions.sge', 'asc');

                if($product != 'all'){
                    if($product == 0){
                        $product = 'Gadai Reguler';
                    }
                    if($product == 1){
                        $product = 'Gadai Reguler GHTS';
                    }
                    if($product == 2){
                        $product = 'Gadai Opsi Bulanan';
                    }
                    if($product == 3){
                        $product = 'Gadai Smartphone';
                    }
                    if($product == 4){
                        $product = 'Gadai Cicilan';
                    }
                $pawn->where('pawn_transactions.product_name', $product);
                }

                if($deviasi != 'all'){
                $pawn->where('transaction_deviations.deviation_type', $deviasi);
                }
                if($approval != 'all'){
                $pawn->where('transaction_deviations.office_type', $approval);
                }
                if($units){
                $pawn->where('pawn_transactions.office_id', $units);
                }

                


            $data = $pawn->findAll();
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $a,
            ]);

        
    }

    public function oneobligor($area, $branch, $units, $dateStart, $dateEnd, $tiering)
	{
        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $pawn->select('customers.name as customer_name, customers.cif_number, customers.identity_number, phone_number, count(loan_amount) as noa,sum(loan_amount) as up')
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
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
            // ->having('sum(loan_amount) >= 250000000')
            ->orderBy('area_id', 'asc')
            ->orderBy('office_name', 'asc')
            ->orderBy('sum(loan_amount)', 'desc')->countAllResults();
            
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            if($area){
            $pawn->where('area_id', $area);
            }
            if($branch){
            $pawn->where('branch_id', $branch);
            }
            if($units){
            $pawn->where('office_id', $units);
            }

           $pawn->select('area_id, office_name,  customers.name as customer_name, customers.cif_number, customers.identity_number, 
           (select phone_number from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as phone_number, 
           (select residence_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as residence_address, 
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
            ->groupBy('residence_address')
            // ->having('sum(loan_amount) >= 250000000')
            ->orderBy('area_id', 'asc')
            ->orderBy('office_name', 'asc')
            ->orderBy('sum(loan_amount)', 'desc');
            // ->get();

            if($tiering){
                if($tiering == 'A'){
                    $pawn->having('sum(loan_amount) <=' , 20000000);
                }
                elseif($tiering == 'B'){
                    $pawn->having('sum(loan_amount) <=' , 50000000);
                    $pawn->having('sum(loan_amount) >' , 20000000);
                }
                elseif($tiering == 'C'){
                    $pawn->having('sum(loan_amount) <=' , 100000000);
                    $pawn->having('sum(loan_amount) >' , 50000000);
                }
                elseif($tiering == 'D'){
                    $pawn->having('sum(loan_amount) <=' , 150000000);
                    $pawn->having('sum(loan_amount) >' , 100000000);
                }
                elseif($tiering == 'E'){
                    $pawn->having('sum(loan_amount) <=' , 150000000);
                    $pawn->having('sum(loan_amount) >' , 150000000);
                }
                elseif($tiering == 'F'){
                    $pawn->having('sum(loan_amount) >' , 250000000);
                }
                else{
                    $pawn->having('sum(loan_amount) >' , 250000000);
                }
            }
            // else{
            //     $pawn->having('sum(loan_amount) >' , 250000000);
            // }

            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}



    public function detailOneobligor($ktp, $status)
	{
  
         if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecordAktif = $this->pawnTransactions
        //    ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)->countAllResults();

            
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            $pawn = new PawnTransactions();

           $pawn->select(" pawn_transactions.repayment_date, pawn_transactions.parent_sge, pawn_transactions.payment_status,pawn_transactions.office_code,pawn_transactions.office_name,pawn_transactions.product_name,sge,contract_date,due_date,auction_date,estimated_value,loan_amount,admin_fee,monthly_fee, interest_rate as rate, insurance_item_name, ROUND(maximum_loan_percentage) as ltv, stle,notes,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description")
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
            ->where('customers.identity_number', $ktp)
            ->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null);
            // ->where('payment_status', FALSE)
            
            if($status != 'all'){
                $pawn->where('payment_status', $status);
            }

            $pawn->orderBy('pawn_transactions.sge', 'asc')
                ->orderBy('pawn_transactions.contract_date', 'asc');
            $data = $pawn->findAll();
            
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
	}

    public function oneobligorGhanet($area, $branch, $units, $dateStart, $dateEnd, $tiering)
	{
        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new Regular();

        $totalRecordAktif =  $pawn->select('customers.name as customer_name, customers.no_cif, customers.nik , customers.mobile as  phone_number,
           count(amount) as noa,sum(amount) as up')
            ->join('customers', 'customers.id=units_regularpawns.id_customer')
            ->join('units', 'units.id=units_regularpawns.id_unit')
            ->where('units_regularpawns.status_transaction', 'L')
            ->groupBy('customers.no_cif')
            ->groupBy('customers.name')
            ->groupBy('customers.nik')
            ->groupBy('customers.mobile')
            // ->having('sum(loan_amount) >= 250000000')
            ->orderBy('area_id', 'asc')
            ->orderBy('units.name', 'asc')
            ->orderBy('sum(amount)', 'desc')->countAllResults();
            
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            // $pawn = new Regular();

            if($area){
            $pawn->where('units.area_id', $area);
            }
            if($branch){
            $pawn->where('units.branch_id', $branch);
            }
            if($units){
            $pawn->where('units.office_id', $units);
            }

           $pawn->select('  customers.city,  customers.name as customer_name, customers.no_cif, customers.nik , customers.mobile as  phone_number,
           count(amount) as noa,sum(amount) as up')
            ->join('customers', 'customers.id=units_regularpawns.id_customer')
            ->join('units', 'units.id=units_regularpawns.id_unit')
            ->where('units_regularpawns.status_transaction', 'L')
            ->groupBy('customers.no_cif')
            ->groupBy('customers.name')
            ->groupBy('customers.nik')
            ->groupBy('customers.mobile')
            ->groupBy('customers.city')
            // ->having('sum(loan_amount) >= 250000000')
            ->orderBy('area_id', 'asc')
            ->orderBy('units.name', 'asc')
            ->orderBy('sum(amount)', 'desc');
      

            $data = $pawn->findAll($start, $length);
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}

    public function detailGhanet($ktp)
	{
  
        $totalRecordAktif = $this->pawnTransactions
        //    ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)->countAllResults();

            
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecordAktif;

            $pawn = new Regular();

           $pawn->select("customers.name,units_regularpawns.nic,units_regularpawns.status_transaction,units.code,units.name as unit,units_regularpawns.type_bmh,no_sbk,date_sbk,deadline,date_auction,estimation,amount,admin, round(capital_lease*100, 2) as rate, type_item, description_1,description_2,description_3,description_4,
           (select date_repayment from units_repayments where units_repayments.no_sbk = units_regularpawns.no_sbk and units_repayments.id_unit = units_regularpawns.id_unit and units_repayments.permit = units_regularpawns.permit limit 1 ) as date_repayment
           ")
            ->join('customers', 'customers.id=units_regularpawns.id_customer')
            ->join('units', 'units.id=units_regularpawns.id_unit')
            ->where('customers.nik', $ktp)
            ->where('units_regularpawns.status_transaction', 'L')
            ->orderBy('units_regularpawns.date_sbk', 'asc');
            

            $data = $pawn->findAll();
            // print_r($data); exit;
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
	}

    
}
