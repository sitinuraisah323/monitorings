<?php 
namespace App\Controllers\Administrator;


use App\Middleware\Authenticated;

class Goldprice extends Authenticated
{
	public function index()
	{
		return view('administrator/goldprice/index');
	}
}
