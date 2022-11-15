<?php 
namespace App\Controllers\Generate;

use App\Controllers\Api\BaseApiController;
use App\Middleware\Authenticated;
use App\Models\Area;
use App\Models\MonitoringDefrosting;
use App\Models\MonitoringDpd;
use App\Models\MonitoringOs;
use App\Models\MonitoringOsView;
use App\Models\MonitoringRepayment;
use App\Models\PawnTransactions;
use App\Models\Units;
use Prophecy\Doubler\ClassPatch\DisableConstructorPatch;
use CodeIgniter\Database\Postgre\Connection;

class Outstanding extends Authenticated
{

	//  private $db1;
  
    // private $pa;

    public function __construct()
    {
        $db =  \Config\Database::connect(); // default database group
        $this->dbtests      = \Config\Database::connect('tests');
		$this->dbaccounting = \Config\Database::connect('accounting');
		$this->units = new \App\Models\Units();
		$this->pawnTransactions = new \App\Models\PawnTransactions();
		$this->saldo = new \App\Models\DailyCash();
		$this->outstanding = new \App\Models\MonitoringOs();
		$this->defrosting = new \App\Models\MonitoringDefrosting();
		$this->repayment = new \App\Models\MonitoringRepayment();
		$this->dpd = new \App\Models\MonitoringDpd();
		

    }
	
	
	public function index()
	{
		// $date = date('Y-m-d');
        // $builder = $this->Outstanding($date);
	    
			$units = $this->units->select('office_id, office_name')->findAll();
			// var_dump($units); exit;
		// $dateStart = date('Y-m-d', strtotime(date('Y-m-01', strtotime($date))));
		// $date1 = date('Y-m-d', strtotime($date));
        $date = '2022-09-02';
		$insert = [];
		$update = [];
		$data = [];
        // var_dump($units); exit;
		foreach($units as $unit){

			// Outstanding units
			$outstanding = $this->Outstanding($unit->office_id, $date);
			
			$smartphone = $this->Smartphone($unit->office_id, $date);
		
			$instalment = $this->Instalment($unit->office_id, $date);
			$opsi = $this->Opsi($unit->office_id, $date);
			$regular = $this->Regular($unit->office_id, $date);

			// var_dump($date); 
			$check = $this->outstanding->where('date', $date)->where('office_id', $unit->office_id)->first();

			// $sum =  $akumulasiActiveNoa + $akumulasiRepaymentNoa;
			// var_dump($outstanding['os']); exit;
			
			
			if($check){
				$news = new MonitoringOs();
				$update = $news->update($check->id, [
                	'date'	=> $date,
					'office_id'	=> $unit->office_id,
					'office_name' => $unit->office_name,
					'noa' =>  $outstanding['noa'], 
					'os'	=>  $outstanding['os'],
					'noa_regular'	=> $regular['noa'],
					'regular'	=>  $regular['os'],
					'noa_instalment'	=> $instalment['noa'],
					'instalment'	=> $instalment['os'],
					'noa_opsi'	=> $opsi['noa'],
					'opsi'	=> $opsi['os'],
					'noa_hp'	=> $smartphone['noa'],
					'hp'	=> $smartphone['os'],
					'noa_yukgadai'	=> 0,
					'yukgadai'	=> 0,
            ]);
			
			}else{	

				$news = new MonitoringOs();
           		 $news->insert([
                'date'	=> $date,
					'office_id'	=> $unit->office_id,
					'office_name' => $unit->office_name,
					'noa' =>  $outstanding['noa'], 
					'os'	=>  $outstanding['os'],
					'noa_regular'	=> $regular['noa'],
					'regular'	=>  $regular['os'],
					'noa_instalment'	=> $instalment['noa'],
					'instalment'	=> $instalment['os'],
					'noa_opsi'	=> $opsi['noa'],
					'opsi'	=> $opsi['os'],
					'noa_hp'	=> $smartphone['noa'],
					'hp'	=> $smartphone['os'],
					'noa_yukgadai'	=> 0,
					'yukgadai'	=> 0,
            	]);

				
			}
			//Pencairan
			$defrosting = $this->defrosting($unit->office_id, $date);
			
			$check = $this->defrosting->where('date', $date)->where('office_id', $unit->office_id)->first();
			
			if($check){
				$news = new MonitoringDefrosting();
				$update = $news->update($check->id, [
                	'date'	=> $date,
					'office_id'	=> $unit->office_id,
					'office_name' => $unit->office_name,
					'noa' =>  $defrosting['noa_defrosting'], 
					'os'	=>  $defrosting['os_defrosting'],
					'noa_regular'	=> $defrosting['noa_regular'],
					'regular'	=>  $defrosting['os_regular'],
					'noa_instalment'	=> $defrosting['noa_instalment'],
					'instalment'	=> $defrosting['os_instalment'],
					'noa_opsi'	=> $defrosting['noa_opsi'],
					'opsi'	=> $defrosting['os_opsi'],
					'noa_hp'	=> $defrosting['noa_smartphone'],
					'hp'	=> $defrosting['os_smartphone'],
					'noa_yukgadai'	=> 0,
					'yukgadai'	=> 0
            ]);
			
			}else{	

				$news = new MonitoringDefrosting();
           		 $news->insert([
                	'date'	=> $date,
					'office_id'	=> $unit->office_id,
					'office_name' => $unit->office_name,
					'noa' =>  $defrosting['noa_defrosting'], 
					'os'	=>  $defrosting['os_defrosting'],
					'noa_regular'	=> $defrosting['noa_regular'],
					'regular'	=>  $defrosting['os_regular'],
					'noa_instalment'	=> $defrosting['noa_instalment'],
					'instalment'	=> $defrosting['os_instalment'],
					'noa_opsi'	=> $defrosting['noa_opsi'],
					'opsi'	=> $defrosting['os_opsi'],
					'noa_hp'	=> $defrosting['noa_smartphone'],
					'hp'	=> $defrosting['os_smartphone'],
					'noa_yukgadai'	=> 0,
					'yukgadai'	=> 0
            	]);

				
			}

			//Pelunasan
			$repayment = $this->repayment($unit->office_id, $date);
			
			$check = $this->repayment->where('date', $date)->where('office_id', $unit->office_id)->first();
			
			if($check){
				$news = new MonitoringRepayment();
				$update = $news->update($check->id, [
                	'date'	=> $date,
					'office_id'	=> $unit->office_id,
					'office_name' => $unit->office_name,
					'noa' =>  $repayment['noa_defrosting'], 
					'os'	=>  $repayment['os_defrosting'],
					'noa_regular'	=> $repayment['noa_regular'],
					'regular'	=>  $repayment['os_regular'],
					'noa_instalment'	=> $repayment['noa_instalment'],
					'instalment'	=> $repayment['os_instalment'],
					'noa_opsi'	=> $repayment['noa_opsi'],
					'opsi'	=> $repayment['os_opsi'],
					'noa_hp'	=> $repayment['noa_smartphone'],
					'hp'	=> $repayment['os_smartphone'],
					'noa_yukgadai'	=> 0,
					'yukgadai'	=> 0
            ]);
			
			}else{	

				$news = new MonitoringRepayment();
           		 $news->insert([
                	'date'	=> $date,
					'office_id'	=> $unit->office_id,
					'office_name' => $unit->office_name,
					'noa' =>  $repayment['noa_defrosting'], 
					'os'	=>  $repayment['os_defrosting'],
					'noa_regular'	=> $repayment['noa_regular'],
					'regular'	=>  $repayment['os_regular'],
					'noa_instalment'	=> $repayment['noa_instalment'],
					'instalment'	=> $repayment['os_instalment'],
					'noa_opsi'	=> $repayment['noa_opsi'],
					'opsi'	=> $repayment['os_opsi'],
					'noa_hp'	=> $repayment['noa_smartphone'],
					'hp'	=> $repayment['os_smartphone'],
					'noa_yukgadai'	=> 0,
					'yukgadai'	=> 0
            	]);

				
			}

			//DPD
			$dpd = $this->dpd($unit->office_id, $date);
			
			$check = $this->dpd->where('date', $date)->where('office_id', $unit->office_id)->first();
			
			if($check){
				$news = new MonitoringDpd();
				$update = $news->update($check->id, [
                	'date'	=> $date,
					'office_id'	=> $unit->office_id,
					'office_name' => $unit->office_name,
					'noa' =>  $dpd['noa_defrosting'], 
					'os'	=>  $dpd['os_defrosting'],
					'noa_regular'	=> $dpd['noa_regular'],
					'regular'	=>  $dpd['os_regular'],
					'noa_instalment'	=> $dpd['noa_instalment'],
					'instalment'	=> $dpd['os_instalment'],
					'noa_opsi'	=> $dpd['noa_opsi'],
					'opsi'	=> $dpd['os_opsi'],
					'noa_hp'	=> $dpd['noa_smartphone'],
					'hp'	=> $dpd['os_smartphone'],
					'noa_yukgadai'	=> 0,
					'yukgadai'	=> 0
            ]);
			
			}else{	

				$news = new MonitoringDpd();
           		 $news->insert([
                	'date'	=> $date,
					'office_id'	=> $unit->office_id,
					'office_name' => $unit->office_name,
					'noa' =>  $dpd['noa_defrosting'], 
					'os'	=>  $dpd['os_defrosting'],
					'noa_regular'	=> $dpd['noa_regular'],
					'regular'	=>  $dpd['os_regular'],
					'noa_instalment'	=> $dpd['noa_instalment'],
					'instalment'	=> $dpd['os_instalment'],
					'noa_opsi'	=> $dpd['noa_opsi'],
					'opsi'	=> $dpd['os_opsi'],
					'noa_hp'	=> $dpd['noa_smartphone'],
					'hp'	=> $dpd['os_smartphone'],
					'noa_yukgadai'	=> 0,
					'yukgadai'	=> 0
            	]);

				
			}

		
			
		}
		return redirect()->back();
	}

	public function Outstanding($office_id, $date)
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

	public function Smartphone($office_id, $date)
	{
		//smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();


			//repayment smartphone
			$akumulasiSmartphoneRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();


			$data = array(
				'noa' => $akumulasiSmartphone->noa + $akumulasiSmartphoneRepayment->noa,
				'os' => $akumulasiSmartphone->os + $akumulasiSmartphoneRepayment->os
			);
			// var_dump($data); exit;
			return $data;
	}

	public function Instalment($office_id, $date)
	{
		//Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();


			//repayment Instalment
			$akumulasiInstalmentRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();

			$data = array(
				'noa' => $akumulasiInstalment->noa + $akumulasiInstalmentRepayment->noa,
				'os' => $akumulasiInstalment->os + $akumulasiInstalmentRepayment->os
			);
			return $data;
	}

	public function Opsi($office_id, $date)
	{
		//Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();


			//repayment Opsi
			$akumulasiOpsiRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();

			$data = array(
				'noa' => $akumulasiOpsi->noa + $akumulasiOpsiRepayment->noa,
				'os' => $akumulasiOpsi->os + $akumulasiOpsiRepayment->os
			);
			return $data;
	}

	public function Regular($office_id, $date)
	{
		//Regular
			$akumulasiRegular = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Reguler')
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();


			//repayment Regular
			$akumulasiRegularRepayment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date <=', $date)
			->where('pawn_transactions.repayment_date >', $date)
            ->where('pawn_transactions.product_name', 'Gadai Reguler')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();

			// var_dump($akumulasiRegular->noa); exit;
			$data = array(
				'noa' => $akumulasiRegular->noa + $akumulasiRegularRepayment->noa,
				'os' => $akumulasiRegular->os + $akumulasiRegularRepayment->os
			);
			// var_dump($data); exit;
			return $data;
	}

	//defrosting
	public function defrosting($office_id, $date)
	{
		$akumulasiActive = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();


		//smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();

		//Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();


		
		//Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();

			
		//Regular
			$akumulasiRegular = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			// ->join('customers', 'customers.id = pawn_transactions.id')
			->where('pawn_transactions.office_id', $office_id)
			// ->group_start()
 		 	->like('pawn_transactions.product_name', 'Gadai Reguler%')
			// ->or_where('pawn_transactions.product_name', 'Gadai Reguler GHTS')
			// ->group_end()
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', false)
			->first();

			// var_dump($akumulasiRegular->noa); exit;
			$data = array(
				'noa_defrosting' => $akumulasiActive->noa > 0 ? $akumulasiActive->noa : 0,
				'os_defrosting' => $akumulasiActive->os > 0 ? $akumulasiActive->os : 0,
				'noa_regular' => $akumulasiRegular->noa > 0 ? $akumulasiRegular->noa : 0,
				'os_regular' => $akumulasiRegular->os > 0 ? $akumulasiRegular->os : 0,
				'noa_opsi' => $akumulasiOpsi->noa > 0 ? $akumulasiOpsi->noa : 0,
				'os_opsi' => $akumulasiOpsi->os > 0 ? $akumulasiOpsi->os : 0,
				'noa_instalment' => $akumulasiInstalment->noa > 0 ? $akumulasiInstalment->noa : 0 ,
				'os_instalment' => $akumulasiInstalment->os > 0 ? $akumulasiInstalment->os : 0,
				'noa_smartphone' => $akumulasiSmartphone->noa > 0 ? $akumulasiSmartphone->noa : 0,
				'os_smartphone' => $akumulasiSmartphone->os > 0 ? $akumulasiSmartphone->os : 0,
				
			);
			// var_dump($data); exit;
			return $data;
	}

	//repayment
	public function repayment($office_id, $date)
	{
		$akumulasiActive = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os')
		// ->join('customers', 'customers.id = pawn_transactions.id')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.repayment_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();


		//smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.repayment_date ', $date)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();

		//Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.repayment_date ', $date)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();


		
		//Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.repayment_date ', $date)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();

			
		//Regular
			$akumulasiRegular = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
            ->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.repayment_date ', $date)
            ->like('pawn_transactions.product_name', 'Gadai Reguler%')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where('pawn_transactions.payment_status', true)
			->first();

			// var_dump($akumulasiRegular->noa); exit;
			$data = array(
				'noa_defrosting' => $akumulasiActive->noa > 0 ? $akumulasiActive->noa : 0,
				'os_defrosting' => $akumulasiActive->os > 0 ? $akumulasiActive->os : 0,
				'noa_regular' => $akumulasiRegular->noa > 0 ? $akumulasiRegular->noa : 0,
				'os_regular' => $akumulasiRegular->os > 0 ? $akumulasiRegular->os : 0,
				'noa_opsi' => $akumulasiOpsi->noa > 0 ? $akumulasiOpsi->noa : 0,
				'os_opsi' => $akumulasiOpsi->os > 0 ? $akumulasiOpsi->os : 0,
				'noa_instalment' => $akumulasiInstalment->noa > 0 ? $akumulasiInstalment->noa : 0 ,
				'os_instalment' => $akumulasiInstalment->os > 0 ? $akumulasiInstalment->os : 0,
				'noa_smartphone' => $akumulasiSmartphone->noa > 0 ? $akumulasiSmartphone->noa : 0,
				'os_smartphone' => $akumulasiSmartphone->os > 0 ? $akumulasiSmartphone->os : 0,
				
			);
			// var_dump($data); exit;
			return $data;
	}

	//repayment
	public function dpd($office_id, $date)
	{
		$akumulasiActive = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os')
			->where('pawn_transactions.office_id', $office_id)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where("pawn_transactions.due_date <", $date)
        	->where('pawn_transactions.payment_status', false)
			->first();


		//smartphone
			$akumulasiSmartphone = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
            ->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Smartphone')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where("pawn_transactions.due_date <", $date)
        	->where('pawn_transactions.payment_status', false)
			->first();

		//Instalment
			$akumulasiInstalment = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
            ->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Cicilan')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where("pawn_transactions.due_date <", $date)
        	->where('pawn_transactions.payment_status', false)
			->first();


		
		//Opsi
			$akumulasiOpsi = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
            ->where('pawn_transactions.office_id', $office_id)
            ->where('pawn_transactions.product_name', 'Gadai Opsi Bulanan')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where("pawn_transactions.due_date <", $date)
        	->where('pawn_transactions.payment_status', false)
			->first();

			
		//Regular
			$akumulasiRegular = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $office_id)
            ->like('pawn_transactions.product_name', 'Gadai Reguler%')
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->where("pawn_transactions.due_date <", $date)
        	->where('pawn_transactions.payment_status', false)
			->first();

			// var_dump($akumulasiRegular->noa); exit;
			$data = array(
				'noa_defrosting' => $akumulasiActive->noa > 0 ? $akumulasiActive->noa : 0,
				'os_defrosting' => $akumulasiActive->os > 0 ? $akumulasiActive->os : 0,
				'noa_regular' => $akumulasiRegular->noa > 0 ? $akumulasiRegular->noa : 0,
				'os_regular' => $akumulasiRegular->os > 0 ? $akumulasiRegular->os : 0,
				'noa_opsi' => $akumulasiOpsi->noa > 0 ? $akumulasiOpsi->noa : 0,
				'os_opsi' => $akumulasiOpsi->os > 0 ? $akumulasiOpsi->os : 0,
				'noa_instalment' => $akumulasiInstalment->noa > 0 ? $akumulasiInstalment->noa : 0 ,
				'os_instalment' => $akumulasiInstalment->os > 0 ? $akumulasiInstalment->os : 0,
				'noa_smartphone' => $akumulasiSmartphone->noa > 0 ? $akumulasiSmartphone->noa : 0,
				'os_smartphone' => $akumulasiSmartphone->os > 0 ? $akumulasiSmartphone->os : 0,
				
			);
			// var_dump($data); exit;
			return $data;
	}

	public function pencairan_bydate($date, $units)
	{
		$data = $this->pawnTransactions->select('count(loan_amount) as noa, sum(loan_amount) as os ')
			->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.contract_date ', $date)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
			->orderBy('pawn_transactions.sge', 'asc')
			->findAll();
var_dump($data);exit;
			return $data;
	}


}