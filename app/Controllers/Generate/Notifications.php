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
use App\Controllers\Administrator\Settings\Pagukas;
use App\Models\MonitoringOsView;
use App\Models\Notifications as ModelsNotifications;

class Notifications extends Authenticated
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
        $this->pagukas = new \App\Models\Pagukas();			
    }

	public function index()
	{
		// $data = new Area();
		// $area = $data->getArea();
		// var_dump($area);exit;
		// var_dump(session('notifications')); exit;
		
		$date = date('Y-m-d');
        $saldo = $this->saldo->where('date_open', $date)->findAll();
		foreach($saldo as $data){
			$pagu = $this->pagukas->where('office_id',$data->office_id)->first();
			if($pagu){
                if($data->remaining_balance > $pagu->saldo){

                    $type = 'Saldo Kas';
                    $message = 'Saldo Kas '.$data->office_name.' Melebihi Maximal ';
                    // var_dump($message); exit;
                    $news = new ModelsNotifications();
                    $news->insert([
                        'office_id'	=> $data->office_id,
                        'office_name' => $data->office_name,
                        'date'	=> $date,
                        'type'	=> $type,
                        'saldo' => $data->remaining_balance,
                        'message' => $message,
                        'read'  => '0',                       
                    ]);
                }
            }            	
		}
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