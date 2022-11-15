<?php 
namespace App\Controllers\Settings;

use App\Middleware\Authenticated;

class Levels extends Authenticated
{
	public function index()
	{
		return view('administrator/levels/index');
	}
}
