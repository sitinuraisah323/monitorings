<?php 
namespace App\Controllers\Settings;

use App\Middleware\Authenticated;

class Menus extends Authenticated
{
	public function index()
	{
		return view('administrator/menus/index');
	}
}
