<?php 
namespace App\Controllers\Monitoring;

use App\Middleware\Authenticated;
use App\Models\Area;
use App\Models\MonitoringOsView;
use App\Models\pawn_transactionsModel;
use Prophecy\Doubler\ClassPatch\DisableConstructorPatch;
use CodeIgniter\Database\Postgre\Connection;


// use  CodeIgniter\Database\BaseConnection();
class Pengeluaran extends Authenticated
{

	//  private $db1;
  
    // private $db2;

    public function __construct()
    {
        $this->db1 = db_connect(); // default database group
        $this->dbtests      = \Config\Database::connect('tests');
		$this->dbaccounting = \Config\Database::connect('accounting');
		$session = \Config\Services::session();
		
        // $this->db2 = db_connect("tests"); // other database group
		// $pawn = new pawn_transactionsModel();
		

		if (!$session) {

            redirect('');
        }
    }
	
	
	public function index()
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPengeluaran();
		return view('administrator/dashboard/pengeluaran', $data);
	}

	
	
	
}

	
	