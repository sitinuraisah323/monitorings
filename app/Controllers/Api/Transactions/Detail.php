<?php namespace App\Controllers\Api\Transactions;
use App\Controllers\Api\BaseApiController;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Detail extends BaseApiController
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

 public function outstanding_bydate($units, $date)
	{
         $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecordAktif = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)->countAllResults();

        $totalRecordRepay = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
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
        
		$aktif = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
			->where('pawn_transactions.office_id', $units)
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
            $repay = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
			->where('pawn_transactions.office_id', $units)
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

            $aktifCicilan = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description,
                (select sum(installment_amount) from installment_items where pawn_transactions.id=installment_items.pawn_transaction_id and payment_date <= '$date' limit 1) as angsuran,
				")
            ->where('pawn_transactions.transaction_type ', 5)
			->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            //repayment Regular
            $repayCicilan = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description,
                (select sum(installment_amount) from installment_items where pawn_transactions.id=installment_items.pawn_transaction_id and payment_date <= '$date' limit 1) as angsuran,
				")
            ->where('pawn_transactions.transaction_type ', 5)
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.contract_date <=', $date)
            ->where('pawn_transactions.repayment_date >', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', true)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            
                  $data = array_merge($aktif,$repay,$aktifCicilan,$repayCicilan);
// var_dump($result);exit;
            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecordAktif + $totalRecordRepay,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}

    public function dpd_bydate($units, $date)
	{
         $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecordAktif = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)->countAllResults();

        $totalRecordRepay = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
            ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
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
        
		$aktif = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
			->where('pawn_transactions.office_id', $units)
			->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.status !=', 5)
                    ->where('pawn_transactions.status !=', 4)
                    ->where('pawn_transactions.transaction_type !=', 4)
                    ->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.payment_status', false)
            ->where('pawn_transactions.payment_status', false)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            //repayment Regular
            $repay = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
			->where('pawn_transactions.office_id', $units)
            ->where("pawn_transactions.due_date <", $date)
                    ->where('pawn_transactions.repayment_date', $date)
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
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}

    public function pencairan_bydate($units, $date)
	{
         $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecord = $this->pawnTransactions
            
            ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)->countAllResults();

        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecord;

       

        // $date = '2022-09-01';
        // $units = '60c6ca91e64d1e242863095a';

        // var_dump($date);
        // var_dump($units); exit;
        
		$data = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
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

            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecord,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}

    public function pelunasan_bydate($units, $date)
	{
         $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecord = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.repayment_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)->countAllResults();

        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecord;

       

        // $date = '2022-09-01';
        // $units = '60c6ca91e64d1e242863095a';

        // var_dump($date);
        // var_dump($units); exit;
        
		$data = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
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
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecord,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}

    public function perpanjangan_bydate($units, $date)
	{
         $date = date('Y-m-0'.$date);
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
    
        $totalRecord = $this->pawnTransactions
            ->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date ', $date)           
            ->where('pawn_transactions.parent_sge !=', null)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)->countAllResults();

        
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : $totalRecord;

       

        // $date = '2022-09-01';
        // $units = '60c6ca91e64d1e242863095a';

        // var_dump($date);
        // var_dump($units); exit;
        
		$data = $this->pawnTransactions->select("id,office_id, office_name as unit, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
				(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
				(select cif_number from customers where pawn_transactions.customer_id = customers.id limit 1 ) as cif_number,				
				(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name,
				(select array_to_string(array_agg(description), ' | ')  from transaction_insurance_items where pawn_transactions.id=transaction_insurance_items.pawn_transaction_id group by pawn_transaction_id) as description
				")
			->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date ', $date)
            ->where('pawn_transactions.parent_sge !=', null)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();

            
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecord,
            ]);
            // var_dump($data); exit;
			// return $this->sendResponse($data, 200); 
	}
}
