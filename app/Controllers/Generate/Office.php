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

class Office extends Authenticated
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

	public function index()
	{
		// $data = new Area();
		// $area = $data->getArea();
		// var_dump($area);exit;
		
		$date = date('Y-m-d');
		$units = $this->units->select('code')->findAll();
		foreach($units as $data){
			$unit = $this->get_areaunit($data->code);
			
			// var_dump($unit->office_name); exit;

			$check = $this->units->where('code', $data->code)->first();

			
			if($check){
				$news = new Units();
				$update = $news->update($check->id, [
					'id'	=> $check->id,
					'id_area'	=> $check->id_area,
					'code'	=> $check->code,
					'date_open' =>  $check->date_open,
					'status' =>  $check->status,
					'id_cabang' =>  $check->id_cabang,
					'region_id' =>  $unit->region_id,
					'area_id' =>  $unit->area_id,
					'branch_id' =>  $unit->branch_id,
					'office_id' =>  $unit->office_id,
					'office_code' =>  $unit->office_code,
					'office_name' =>  $unit->office_name
				]);
			
			
			}
            	
		}

		$cabang = $this->cabang->select('id, id_area, cabang')->findAll();
		foreach($cabang as $data){
			// $unit = $this->get_areaunit($data->code);
			
			// var_dump($unit->office_name); exit;

			$check = $this->units->where('id_cabang', $data->id)->first();

			
			if($check){
				$news = new Cabang();
				$update = $news->update($data->id, [
					'id'	=> $data->id,
					'id_area'	=> $data->id_area,
					'cabang'	=> $data->cabang,
					'branch_id' => $check->branch_id,
					'area_id'	=> $check->area_id
				]);
			
			
			}
            	
		}
		
		$area = $this->area->select('id, area')->findAll();
		foreach($area as $data){

			$check = $this->cabang->where('id_area', $data->id)->first();

			
			if($check){
				$news = new Area();
				$update = $news->update($data->id, [
					'id'	=> $data->id,
					'area'	=> $data->area,
					'area_id'	=> $check->area_id
				]);
			
			
			}
            	
		}
	 return redirect()->back();

	}

	public function get_areaunit($code)
	{

		 $data = $this->pawnTransactions->select('office_code, region_id, area_id, branch_id, office_id, office_name ')
		->where('office_code', $code)
		->first();

		return $data;

		// var_dump($data);exit;
	}

	function getCabang($area){
		
        $data = $this->cabang->select('id, cabang')->where('id_area', $area)->findAll();
         return $data;
    
	}
	


}