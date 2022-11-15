<?php 
namespace App\Controllers\Administrator;
use App\Middleware\Authenticated;

class Handover extends Authenticated
{
	public function index()
	{
		return view('administrator/handover/index');
	}
}
