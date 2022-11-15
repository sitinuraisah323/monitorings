<?php 
namespace App\Controllers\Settings;

use App\Middleware\Authenticated;

class Privileges extends Authenticated
{
	public function index()
	{
		return view('administrator/privileges/index');
	}

	public function config($id)
	{
		$menus = (new \App\Models\Menus)->findAll();
		return view('administrator/privileges/config',[
			'menus'	=> $menus,
			'idLevel'	=> $id
		]);
	}
}
