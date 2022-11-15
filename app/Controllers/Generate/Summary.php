<?php 
namespace App\Controllers\Generate;

use App\Controllers\Api\BaseApiController;
use App\Middleware\Authenticated;
use App\Models\Area;
use App\Models\Cabang;
use App\Models\MonitoringDefrosting;
use App\Models\MonitoringDpd;
use App\Models\MonitoringOs;
use App\Models\MonitoringRepayment;
use App\Models\PawnTransactions;
use App\Models\Units;
use Prophecy\Doubler\ClassPatch\DisableConstructorPatch;
use CodeIgniter\Database\Postgre\Connection;
use App\Config\Database;
use App\Models\MonitoringOsView;
use App\Models\JournalEntries;

use TCPDF;

class Summary extends Authenticated
{

	//  private $db1;
  
    // private $pa;

    public function __construct()
    {
        $db =  \Config\Database::connect(); // default database group
        $this->dbtests      = \Config\Database::connect('tests');
		$this->dbaccounting = \Config\Database::connect('accounting');
		$this->units = new \App\Models\Units();
		$this->cabang = new \App\Models\Cabang();
		$this->area = new \App\Models\Area();
		$this->pawnTransactions = new \App\Models\PawnTransactions();
		$this->saldo = new \App\Models\DailyCash();
		$this->outstanding = new \App\Models\MonitoringOs();
		$this->defrosting = new \App\Models\MonitoringDefrosting();
		$this->repayment = new \App\Models\MonitoringRepayment();
		$this->dpd = new \App\Models\MonitoringDpd();
	
		

    }

	public function index($month)
	{
	
		$date = date('Y-m-t', strtotime($month));
		// $date = date('Y-m-d');
		// echo $date; exit;
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';

		$data = $this->report($date); 
		// $deviasi = $this->reportDeviasi($date);
		// dd($data);

		$grouped = $this->grouped($data);
		// $deviasiAll = $this->grouped($deviasi);


		$pdf->AddPage('L', 'A3');
		$view = view('summary/generate.php',['outstanding'=>$grouped,'date'=> $date]);
		
		// $view = 'Yess';
		$pdf->writeHTML($view);

		$pdf->Output('Summary_AWS.pdf', 'D');

	}

	public function grouped($os)
	{
		// echo "<pre/>";
		// print_r($os);exit;
		//var_dump($os);exit;
		$result = [];
		foreach($os as $index =>  $data){
			$result[$data->area][$index] = $data;
		}
		return $result;

	}

	function report($date){

		
		// $date = '2022-10-12';
		$date_1 = date('Y-m-d', strtotime('-1 days', strtotime($date)));

		// var_dump($date_1); exit;
			// $units = $this->units->select('office_id, office_name')->findAll();

		if(session()->get( 'user' )->level == 'unit' || session()->get( 'user' )->level == 'kasir' ){
		$units = $this->units->select('units.office_id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->where('units.office_id', session()->get( 'user' )->office_id)
			->findAll();
		}else if(session()->get( 'user' )->level == 'cabang'){
			$units = $this->units->select('units.office_id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->where('units.branch_id', session()->get( 'user' )->branch_id)
			->findAll();
		}else if(session()->get( 'user' )->level == 'area'){
			$units = $this->units->select('units.office_id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->where('units.area_id', session()->get( 'user' )->area_id)
			->findAll();
		}else{
			$units = $this->units->select('units.office_id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->findAll();
		}

		$data = [];
		$a = 0;
		foreach($units as $unit){

			$getLtv = $this->getLtv($unit->office_id, $date);

			// echo $getOstYesterday['noa']; exit;

			$unit->ltv = (object) array(
				'min'	=> $getLtv['min'],
				'max'		=> $getLtv['max'],
				
			);


			$getOutstanding =  $this->outstanding($unit->office_id, $date);
			
			$unit->outstanding = (object) array(
				'min'		=> $getOutstanding['min'],
				'max'		=> $getOutstanding['max']
			);

			$getDpd =  $this->dpd($unit->office_id, $date);
			
			$unit->dpd = (object) array(
				'min'		=> $getDpd['min'],
				'max'		=> $getDpd['max']
			);

			$getTicketsize =  $this->ticketsize($unit->office_id, $date);
			
				$unit->ticketsize = (object) array(
					'min'		=> $getTicketsize['min'],
					'max'		=> $getTicketsize['max'],
				);

			$getMoker =  $this->moker($unit->office_id, $date);
			
				$unit->moker = (object) array(
					'min'		=> $getMoker['min'],
					'max'		=> $getMoker['max'],
				);

			$getBatal =  $this->batal($unit->office_id, $date);
			
				$unit->batal = (object) array(
					'min'		=> 0,
					'max'		=> $getBatal['total'],
				);
			
			$getFrequensi =  $this->frequensi($unit->office_id, $date);
			
				if($getFrequensi['total'] < 5){
					$unit->frequensi = (object) array(
						'min'		=> $getFrequensi['total'],
						'max'		=> 0,
					);
				}else{
					$unit->frequensi = (object) array(
						'min'		=> 0,
						'max'		=> $getFrequensi['total'],
					);
				}

			$getOneobligor =  $this->oneobligor($unit->office_id, $date);
			
				if($getOneobligor['total'] == 0){
					$unit->oneobligor = (object) array(
						'min'		=> $getOneobligor['total'],
						'max'		=> 0,
					);
				}else{
					$unit->oneobligor = (object) array(
						'min'		=> 0,
						'max'		=> $getOneobligor['total'],
					);
				}

				

		$getCabang =  $this->cabang($unit->office_id, $date);
			if($getCabang){
				$unit->cabang = (object) array(
					'ltv'		=> $getCabang['ltv'],
					'sewa'		=> $getCabang['sewa'],
					'admin'		=> $getCabang['admin'],
					'oneobligor'=> $getCabang['oneobligor'],
					'limit'		=> $getCabang['limit'],
					
				);
			}else{
				$unit->cabang = (object) array(
					'ltv'		=> 0,
					'sewa'		=> 0,
					'admin'		=> 0,
					'oneobligor'=> 0,
					'limit'		=> 0,
					
				);
			}
			$getArea =  $this->areas($unit->office_id, $date);
			
			if($getArea){
				$unit->areas = (object) array(
					'ltv'		=> $getArea['ltv'],
					'sewa'		=> $getArea['sewa'],
					'admin'		=> $getArea['admin'],
					'oneobligor'=> $getArea['oneobligor'],
					'limit'		=> $getArea['limit'],
					
				);
			}else{
				$unit->areas = (object) array(
					'ltv'		=> 0,
					'sewa'		=> 0,
					'admin'		=> 0,
					'oneobligor'=> 0,
					'limit'		=> 0,
					
				);
			}

			$getRegional =  $this->regional($unit->office_id, $date);
			
			if($getRegional){
				$unit->regional = (object) array(
					'ltv'		=> $getRegional['ltv'],
					'sewa'		=> $getRegional['sewa'],
					'admin'		=> $getRegional['admin'],
					'oneobligor'=> $getRegional['oneobligor'],
					'limit'		=> $getRegional['limit'],
					
				);
			}else{
				$unit->regional = (object) array(
					'ltv'		=> 0,
					'sewa'		=> 0,
					'admin'		=> 0,
					'oneobligor'=> 0,
					'limit'		=> 0,
					
				);
			}

			$getPusat =  $this->pusat($unit->office_id, $date);
			
			if($getPusat){
				$unit->pusat = (object) array(
					'ltv'		=> $getPusat['ltv'],
					'sewa'		=> $getPusat['sewa'],
					'admin'		=> $getPusat['admin'],
					'oneobligor'=> $getPusat['oneobligor'],
					'limit'		=> $getPusat['limit'],
					
				);
			}else{
				$unit->pusat = (object) array(
					'ltv'		=> 0,
					'sewa'		=> 0,
					'admin'		=> 0,
					'oneobligor'=> 0,
					'limit'		=> 0,
					
				);
			}
		}
				

		return $units;
}

	

	public function getLtv($units, $date)
	{
		$data=[];
        $monthStart = date('m', strtotime($date));
        $yearStart = date('Y', strtotime($date));
    
        $pawn = new PawnTransactions();

           $pawn->select(" count(id) as total")
            ->where('EXTRACT(YEAR FROM contract_date) ', $yearStart)
            ->where('EXTRACT(MONTH FROM contract_date) ', $monthStart)
			->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.product_name !=','Gadai Cicilan')
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.maximum_loan_percentage <=' , 92 );

			
			$min = $pawn->first();
            // $min = $pawn->first();
			$data['min'] = $min->total;

			// $pawn = new PawnTransactions();

           $pawn->select("count(id) as total")
            ->where('EXTRACT(YEAR FROM contract_date) ', $yearStart)
            ->where('EXTRACT(MONTH FROM contract_date) ', $monthStart)
			->where('pawn_transactions.office_id', $units)
			->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.product_name !=','Gadai Cicilan')
			->where('pawn_transactions.deleted_at', null)
            ->where('pawn_transactions.maximum_loan_percentage >' , 92 );

            $max = $pawn->first();
            
			$data['max'] = $max->total;
			
            return $data;
	}

	public function outstanding($units, $date)
	{
		$data= [];

		$month_1 = date('Y-m-t', strtotime('-1 month', strtotime($date)));

		$osMonth = $this->getOs($units, $date);
		$osMonth_1 = $this->getOs($units, $month_1);

		if($osMonth_1['os'] !=0){
			// $data = 2950000 / 3912485000 * 100;
			// echo $data; exit;

			$persentase = (float) ($osMonth['os'] - $osMonth_1['os']) * 100 / $osMonth_1['os'] ;
		}else{
			$persentase = 0;
		}

		if($persentase > 5){
			$data['min'] = 0;
			$data['max'] = round($persentase, 2);
		}else{
			$data['min'] = round($persentase, 2);
			$data['max'] = 0;
		}
		// var_dump($data);exit;
		return $data;
        
	}

    public function getOs($office_id, $date)
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

	public function dpd($units, $date)
	{
		$data= [];

		$month_1 = date('Y-m-t', strtotime('-1 month', strtotime($date)));

		$dpd = $this->getDpd($units, $date);
		$outstanding = $this->getOs($units, $date);

		if($outstanding['os'] !=0){
			// $data = 2950000 / 3912485000 * 100;
			// echo $data; exit;

			$persentase_os = $dpd['os'] / $outstanding['os'] * 100 ;
		}else{
			$persentase_os = 0;
		}

		if($persentase_os > 5){
			$data['min'] = 0;
			$data['max'] = round($persentase_os, 2);
		}else{
			$data['min'] = round($persentase_os, 2);
			$data['max'] = 0;
		}
		// var_dump($data);exit;
		return $data;
        
	}

    public function getDpd($office_id, $date)
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


	function ticketsize($units, $date)
    {

		$month_1 = date('m', strtotime('-1 month', strtotime($date)));

		// $monthStart_1 = date('m', strtotime($date));
        $monthStart = date('m', strtotime($date));
        $yearStart = date('Y', strtotime($date));
    
        $pawn = new PawnTransactions();

            $ticketsize_1 = $pawn->select(" sum(loan_amount)/count(loan_amount)  as ticketsize ")
            ->where('EXTRACT(YEAR FROM contract_date) ', $yearStart)
            ->where('EXTRACT(MONTH FROM contract_date) ', $month_1)
			->where('pawn_transactions.office_id', $units)			
			->where('pawn_transactions.status !=', 5)
            ->where('pawn_transactions.status !=', 4)
            ->where('pawn_transactions.transaction_type !=', 4)
            ->where('pawn_transactions.deleted_at', null)->first();

            $data['min'] = $ticketsize_1->ticketsize;

			$ticketsize = $pawn->select(" sum(loan_amount)/count(loan_amount)  as ticketsize ")
            ->where('EXTRACT(YEAR FROM contract_date) ', $yearStart)
            ->where('EXTRACT(MONTH FROM contract_date) ', $monthStart)
			->where('pawn_transactions.office_id', $units)			
			->where('pawn_transactions.status !=', 5)
            ->where('pawn_transactions.status !=', 4)
            ->where('pawn_transactions.transaction_type !=', 4)
            ->where('pawn_transactions.deleted_at', null)->first();

            $data['max'] = $ticketsize->ticketsize;
            
            return $data;        
        
    }

	public function moker($units, $date)
	{	

		$month_1 = date('Y-m-t', strtotime('-1 month', strtotime($date)));
		$date_1 = date('Y-m-01', strtotime('-1 month',strtotime($date)));

		// echo $month_1.'-'; echo $date_1.'-';
		$date1 = date('Y-m-01', strtotime($date));
        $pawn = new JournalEntries();
   
           $moker = $pawn->select(" sum(journal_entries.amount) as moker ")
                ->join('journals', 'journals.id = journal_entries.journal_id')
                ->where('journals.publish_date >=', $date1)
                ->where('journals.publish_date <=', $date)
				->where('journal_entries.office_id', $units)
                ->where('journal_entries.transaction_type', 1)
                ->where('journal_entries.deleted_at ', null)
                ->like('journal_entries.description','Penerimaan Kas dari Modal%')->first();
			if($moker != null){
				 $data['max'] = $moker->moker;
			}else{
				 $data['max'] = 0;
			}
           

			$moker_1 = $pawn->select(" sum(journal_entries.amount) as moker ")
                ->join('journals', 'journals.id = journal_entries.journal_id')
                ->where('journals.publish_date >=', $date_1)
                ->where('journals.publish_date <=', $month_1)
				->where('journal_entries.office_id', $units)
                ->where('journal_entries.transaction_type', 1)
                ->where('journal_entries.deleted_at ', null)
                ->like('journal_entries.description','Penerimaan Kas dari Modal%')->first();
			if( $moker_1 != null){
				 $data['min'] = $moker_1->moker;
			}else{
				 $data['min'] = 0;
			}
           
            
			// print_r($data); exit;
            return $data;  
	}

	public function batal($units, $date)
	{
        $monthStart = date('m', strtotime($date));
        $yearStart = date('Y', strtotime($date));

        $pawn = new PawnTransactions();

           $batal = $pawn->select(" count(id) as total, sum(loan_amount) as up")
			->where('EXTRACT(YEAR FROM contract_date) >=', $yearStart)
            ->where('EXTRACT(MONTH FROM contract_date) >=', $monthStart)
			->where('pawn_transactions.office_id', $units)
			->groupStart()
            ->where('pawn_transactions.transaction_type', 4)
            ->orGroupStart()
			    ->Where('pawn_transactions.deleted_at !=', null)
            ->groupEnd()
            
            ->groupEnd()->first();

            $data['total'] = $batal->total;
            
            return $data; 
	}
	
	function frequensi($units, $date)
    {

        $monthStart = date('m', strtotime($date));
        $yearStart = date('Y', strtotime($date));
    
        $pawn = new PawnTransactions();

            $start = $pawn->select('count(loan_amount) as noa, sum(loan_amount) as up')
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
            ->where('pawn_transactions.office_id', $units)
            ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            ->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
            ->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->having('count(loan_amount) >= ', 5)
		->groupBy('customers.cif_number')
		->groupBy('customers.name')
        ->groupBy('customers.identity_number')
        ->countAllResults();

		$data['total'] = $start;
            
        return $data; 
    }

	public function oneobligor($units, $date)
	{
    
        $pawn = new PawnTransactions();

         $one =  $pawn->select(' area_id, office_code, lower(office_name) as office_name,customers.name as customer_name, customers.cif_number, customers.identity_number, 
           (select phone_number from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as phone_number, 
           count(loan_amount) as noa,sum(loan_amount) as up')
            ->join('customers', 'customers.id=pawn_transactions.customer_id')
            // ->join('customer_contacts', 'customer_contacts.customer_id=pawn_transactions.customer_id')
			->where('pawn_transactions.office_id', $units)
            ->where('pawn_transactions.status !=', 5)
			->where('pawn_transactions.status !=', 4)
			->where('pawn_transactions.transaction_type !=', 4)
			->where('pawn_transactions.deleted_at', null)
            ->where('payment_status', FALSE)
			->having('sum(loan_amount) >' , 250000000)
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
          
            $data['total'] = $one;

			// var_dump($data);

			return $data;
            
	}

	

	function cabang($units, $date)
    {
    
        $monthStart = date('m', strtotime($date));
        $yearStart = date('Y', strtotime($date));

        $pawn = new PawnTransactions();
           
            $ltv =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 0)
                ->where('transaction_deviations.deviation_type', 0)
				->first();
			
				if($ltv->total != null){
					$data['ltv'] = $ltv->total;
				}else{
					$data['ltv'] = 0;
				}

			$pawn = new PawnTransactions();
			$sewa =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 0)
                ->where('transaction_deviations.deviation_type', 1)
				->first();
			
				if($sewa->total != null){
					$data['sewa'] = $sewa->total;
				}else{
					$data['sewa'] = 0;
				}

				$pawn = new PawnTransactions();
				$admin =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 0)
                ->where('transaction_deviations.deviation_type', 2)
				->first();
			
				if($admin->total != null){
					$data['admin'] = $admin->total;
				}else{
					$data['admin'] = 0;
				}

				$pawn = new PawnTransactions();
				$oneobligor =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 0)
                ->where('transaction_deviations.deviation_type', 3)
				->first();
			
				if($oneobligor->total != null){
					$data['oneobligor'] = $oneobligor->total;
				}else{
					$data['oneobligor'] = 0;
				}

				$pawn = new PawnTransactions();
				$limit =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 0)
                ->where('transaction_deviations.deviation_type', 5)
				->first();
			
				if($limit->total != null){
					$data['limit'] = $limit->total;
				}else{
					$data['limit'] = 0;
				}


				// var_dump($data); exit;
			return $data;
                 
    }

	function areas($units, $date)
    {
    
        $monthStart = date('m', strtotime($date));
        $yearStart = date('Y', strtotime($date));

        $pawn = new PawnTransactions();
           
            $ltv =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 1)
                ->where('transaction_deviations.deviation_type', 0)
				->first();
			
				if($ltv->total != null){
					$data['ltv'] = $ltv->total;
				}else{
					$data['ltv'] = 0;
				}
			$pawn = new PawnTransactions();
			$sewa =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 1)
                ->where('transaction_deviations.deviation_type', 1)
				->first();
			
				if($sewa->total != null){
					$data['sewa'] = $sewa->total;
				}else{
					$data['sewa'] = 0;
				}

				$pawn = new PawnTransactions();
				$admin =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 1)
                ->where('transaction_deviations.deviation_type', 2)
				->first();
			
				if($admin->total != null){
					$data['admin'] = $admin->total;
				}else{
					$data['admin'] = 0;
				}

				$pawn = new PawnTransactions();
				$oneobligor =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 1)
                ->where('transaction_deviations.deviation_type', 3)
				->first();
			
				if($oneobligor->total != null){
					$data['oneobligor'] = $oneobligor->total;
				}else{
					$data['oneobligor'] = 0;
				}

				$pawn = new PawnTransactions();
				$limit =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 1)
                ->where('transaction_deviations.deviation_type', 5)
				->first();
			
				if($limit->total != null){
					$data['limit'] = $limit->total;
				}else{
					$data['limit'] = 0;
				}


				// var_dump($data); exit;
			return $data;
                 
    }

	function regional($units, $date)
    {
    
        $monthStart = date('m', strtotime($date));
        $yearStart = date('Y', strtotime($date));

        $pawn = new PawnTransactions();
           
            $ltv =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 2)
                ->where('transaction_deviations.deviation_type', 0)
				->first();
			
				if($ltv->total != null){
					$data['ltv'] = $ltv->total;
				}else{
					$data['ltv'] = 0;
				}
			$pawn = new PawnTransactions();
			$sewa =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 2)
                ->where('transaction_deviations.deviation_type', 1)
				->first();
			
				if($sewa->total != null){
					$data['sewa'] = $sewa->total;
				}else{
					$data['sewa'] = 0;
				}

				$pawn = new PawnTransactions();
				$admin =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 2)
                ->where('transaction_deviations.deviation_type', 2)
				->first();
			
				if($admin->total != null){
					$data['admin'] = $admin->total;
				}else{
					$data['admin'] = 0;
				}

				$pawn = new PawnTransactions();
				$oneobligor =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 2)
                ->where('transaction_deviations.deviation_type', 3)
				->first();
			
				if($oneobligor->total != null){
					$data['oneobligor'] = $oneobligor->total;
				}else{
					$data['oneobligor'] = 0;
				}

				$pawn = new PawnTransactions();
				$limit =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 2)
                ->where('transaction_deviations.deviation_type', 5)
				->first();
			
				if($limit->total != null){
					$data['limit'] = $limit->total;
				}else{
					$data['limit'] = 0;
				}


				// var_dump($data); exit;
			return $data;
                 
    }

	function pusat($units, $date)
    {
    
        $monthStart = date('m', strtotime($date));
        $yearStart = date('Y', strtotime($date));

        $pawn = new PawnTransactions();
           
            $ltv =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 2)
                ->where('transaction_deviations.deviation_type', 0)
				->first();

				if($ltv->total != null){
					$data['ltv'] = $ltv->total;
				}else{
					$data['ltv'] = 0;
				}

			$pawn = new PawnTransactions();
			$sewa =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 3)
                ->where('transaction_deviations.deviation_type', 1)
				->first();
			
				if($sewa->total != null){
					$data['sewa'] = $sewa->total;
				}else{
					$data['sewa'] = 0;
				}

				$pawn = new PawnTransactions();
				$admin =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 3)
                ->where('transaction_deviations.deviation_type', 2)
				->first();
			
				if($admin->total != null){
					$data['admin'] = $admin->total;
				}else{
					$data['admin'] = 0;
				}

				$pawn = new PawnTransactions();
				$oneobligor =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 3)
                ->where('transaction_deviations.deviation_type', 3)
				->first();
			
				if($oneobligor->total != null){
					$data['oneobligor'] = $oneobligor->total;
				}else{
					$data['oneobligor'] = 0;
				}

				$pawn = new PawnTransactions();
				$limit =  $pawn->select("count(transaction_deviations.id) as total")
                ->join('transaction_deviations','transaction_deviations.pawn_transaction_id = pawn_transactions.id')               
                ->where('EXTRACT(MONTH FROM contract_date)', $monthStart)
            	->where('EXTRACT(YEAR FROM contract_date)', $yearStart)
				->where('pawn_transactions.office_id', $units)
                ->where('pawn_transactions.status !=', 5)
                ->where('pawn_transactions.status !=', 4)
                ->where('pawn_transactions.transaction_type !=', 4)
                ->where('pawn_transactions.deleted_at', null)
                ->where('transaction_deviations.deleted_at', null)
				->where('transaction_deviations.office_type', 3)
                ->where('transaction_deviations.deviation_type', 5)
				->first();
			
				if($limit->total != null){
					$data['limit'] = $limit->total;
				}else{
					$data['limit'] = 0;
				}


				// var_dump($data); exit;
			return $data;
                 
    }

}