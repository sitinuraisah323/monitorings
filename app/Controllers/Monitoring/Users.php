<?php 
namespace App\Controllers\Monitoring;
use App\Middleware\Authenticated;

class Users extends Authenticated
{
	public function index()
	{
		return view('administrator/users/index');
	}
}
