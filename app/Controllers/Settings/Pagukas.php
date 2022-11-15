<?php 
namespace App\Controllers\Settings;

use App\Middleware\Authenticated;
use App\Models\Units;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class Pagukas extends Authenticated
{
	public function index()
	{
		$units = new Units();
		$data['units'] = $units->select('office_id, office_name')->OrderBy('office_name','asc')->findAll();
		return view('administrator/pagukas/index', $data);
	}
}
