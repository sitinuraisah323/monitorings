<?php 
namespace App\Controllers;

use App\Middleware\Authenticated;
use App\Models\Area;
use App\Models\MonitoringOsView;
use App\Models\Notifications as ModelsNotifications;
use App\Models\pawn_transactionsModel;
use Prophecy\Doubler\ClassPatch\DisableConstructorPatch;
use CodeIgniter\Database\Postgre\Connection;


// use  CodeIgniter\Database\BaseConnection();
class Fraud extends Authenticated
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
	   //  var_dump(session('privilleges'));
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewOs();
		return view('fraud/index', $data);
	}

	public function detail($office_id, $date)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['date'] = $date;
		return view('fraud/detail', $data);
	}

	public function detail_dpd($office_id, $date)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['date'] = $date;
		return view('fraud/dpd', $data);
	}

    public function ticketsize($office_id, $dateStart, $dateEnd)
	{
       $area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['dateStart'] = $dateStart;
		$data['dateEnd'] = $dateEnd;

		return view('fraud/ticketsize', $data);
	}

	public function detail_frequensi($office_id, $ktp,$dateStart, $dateEnd)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['ktp'] = $ktp;
		$data['dateStart'] = $dateStart;
		$data['dateEnd'] = $dateEnd;
		return view('fraud/frequensi', $data);
	}

	// public function back(){
    //     return view('Administrator/notifications/index');
    // }

	public function detailTrxBatal($office_id, $month, $year)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['month'] = $month;
		$data['year'] = $year;
		return view('fraud/trxBatal', $data);

	}

	public function detailFraud($office_id, $month, $year, $limit)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['month'] = $month;
		$data['year'] = $year;
		$data['limit'] = $limit;
		return view('fraud/fraud', $data);

	}

	public function detailTicketsize($office_id, $month, $year)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['month'] = $month;
		$data['year'] = $year;
		return view('fraud/ticketsize', $data);

	}

	public function detailMoker($office_id, $month, $year)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['month'] = $month;
		$data['year'] = $year;
		return view('fraud/moker', $data);

	}

	public function detailApproval($office_id, $month, $year, $approval, $deviasi, $product)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['office_id'] = $office_id;
		$data['month'] = $month;
		$data['year'] = $year;
		$data['approval'] = $approval;
		$data['deviasi'] = $deviasi;
		$data['product'] = $product;
		
		return view('fraud/approval', $data);

	}

	public function detailOneobligor($ktp, $sistem)
	{
		$area = new Area();
		$view = new MonitoringOsView();
		$data['areas'] = $area->getArea();
		$data['view'] = $view->getViewPencairan();
		$data['ktp'] = $ktp;
		$data['sistem'] = $sistem;
		return view('fraud/oneobligor', $data);
	}
	
}

	
	