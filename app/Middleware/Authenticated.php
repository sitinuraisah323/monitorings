<?php
namespace App\Middleware;


use App\Controllers\BaseController;

/**
 * Class Authenticated
 * @package App\Middleware
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Authenticated extends BaseController
{
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger); // TODO: Change the autogenerated stub
        if(is_null(session()->get('logged_in'))){
            header('Location: '.base_url('monitoring'));
            die;
        }
        $levelAllowerd = [1,2];
        
        if(!session()->get('user')->id_level){
            header('Location: '.base_url(''));
            die;
        }
        return true;
        // $this->privileges();
    }

    public function privileges()
    {
        if($privileges = session('privileges')){
            foreach($privileges as $privilege){
                if($privilege->url === implode($this->uri->getSegments(),'/')){
                    if($privilege->access === 'DENIED'){
                        // echo 'Access denied';
                        header('Location: '.base_url('administrator/error_403'));
                        die;
                    }
                }
            }
            return true;
        }
    }
}