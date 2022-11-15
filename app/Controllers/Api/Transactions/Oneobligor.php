<?php namespace App\Controllers\Api\Transactions;
use App\Controllers\Api\BaseApiController;
use App\Models\PawnTransactions;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Oneobligor extends BaseApiController
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

 public function oneobligor($area, $branch, $units, $category)
	{
        // $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $pawn = new PawnTransactions();

        $totalRecordAktif =  $pawn->select(' area_id, office_code, lower(office_name) as office_name,customers.name as customer_name, customers.cif_number, customers.identity_number, phone_number, count(loan_amount) as noa,sum(loan_amount) as up')
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

            // if($category){
            //     $pawn->where('category_id', $category);
            // }

           $pawn->select(' area_id, office_code, lower(office_name) as office_name,customers.name as customer_name, customers.cif_number, customers.identity_number, (select phone_number from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as phone_number, count(loan_amount) as noa,sum(loan_amount) as up')
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
		// ->having('sum(loan_amount) >= 250000000')
		->orderBy('area_id', 'asc')
		->orderBy('office_name', 'asc')
		->orderBy('sum(loan_amount)', 'desc');
            // ->get();

            if($category){
                if($category == 'A'){
                    $pawn->having('sum(loan_amount) <=' , 20000000);
                }
                elseif($category == 'B'){
                    $pawn->having('sum(loan_amount) <=' , 50000000);
                    $pawn->having('sum(loan_amount) >' , 20000000);
                }
                elseif($category == 'C'){
                    $pawn->having('sum(loan_amount) <=' , 100000000);
                    $pawn->having('sum(loan_amount) >' , 50000000);
                }
                elseif($category == 'D'){
                    $pawn->having('sum(loan_amount) <=' , 150000000);
                    $pawn->having('sum(loan_amount) >' , 100000000);
                }
                elseif($category == 'E'){
                    $pawn->having('sum(loan_amount) <=' , 150000000);
                    $pawn->having('sum(loan_amount) >' , 150000000);
                }
                elseif($category == 'F'){
                    $pawn->having('sum(loan_amount) >' , 250000000);
                }
                else{
                    $pawn->having('sum(loan_amount) >' , 250000000);
                }
            }else{
                    $pawn->having('sum(loan_amount) >' , 250000000);
                }

            $data = $pawn->findAll($start, $length);
            //repayment Regular
            // $repay = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
			// 	(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
			// 	(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
			// 	(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
			// 	(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
			// 	")
			// ->where('pawn_transactions.office_id', $units)
            // ->where('pawn_transactions.contract_date <=', $date)
            // ->where('pawn_transactions.repayment_date >', $date)
			// ->where('pawn_transactions.status !=', 5)
			// ->where('pawn_transactions.status !=', 4)
			// ->where('pawn_transactions.transaction_type !=', 4)
			// ->where('pawn_transactions.deleted_at', null)
            // ->where('pawn_transactions.payment_status', true)
			// ->orderBy('pawn_transactions.sge', 'asc')
			// ->findAll();

       

        
                //   $data = array_merge($aktif,$repay);
            // var_dump($result);exit;
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}

    public function detail($ktp)
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

           $pawn->select("pawn_transactions.id,pawn_transactions.office_id, pawn_transactions.office_name as unit, pawn_transactions.sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
            ->where('customers.identity_number', $ktp)
            ->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('payment_status', FALSE)
            ->orderBy('pawn_transactions.sge', 'asc');
		

            $data = $pawn->findAll();
            
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif,
            ]);
	}

    
}
