<?php 
namespace App\Controllers\Monitoring;

use App\Controllers\BaseController;

class Login extends BaseController
{
	public function index()
	{
		return view('administrator/login/index');
	}

    public function auth()
    {
        $username = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $session = \Config\Services::session();
        $newdata = [
            'username'      => $username,
            'password'      => $password,
            'logged_in'     => TRUE
        ];
        if($newdata!=null){
            $session->set($newdata);
            return view('administrator/dashboard/index');
        }else{
            //  return redirect()->to(base_url(''));
        }

    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url(''));
    }

}