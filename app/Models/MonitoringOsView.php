<?php
namespace App\Models;


use CodeIgniter\Model;

/**
 * Class Users
 * @package App\Models
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class MonitoringOsView extends Model
{
    public $table = 'monitoring_os_view';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','view_id','user_id','created_at', 'updated_at'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function getViewOs(){
        return $this->select('users.username, monitoring_os_view.updated_at')
        ->join('users', 'users.id = monitoring_os_view.user_id')->where('view_id', 1)->findAll();
    }
    
    function getViewPencairan(){
        return $this->select('users.username, monitoring_os_view.updated_at')
        ->join('users', 'users.id = monitoring_os_view.user_id')->where('view_id', 2)->findAll();
    }
    
    function getViewRepayment(){
        return $this->select('users.username, monitoring_os_view.updated_at')
        ->join('users', 'users.id = monitoring_os_view.user_id')->where('view_id', 3)->findAll();
    }
    function getViewDpd(){
        return $this->select('users.username, monitoring_os_view.updated_at')
        ->join('users', 'users.id = monitoring_os_view.user_id')->where('view_id', 4)->findAll();
    }
    
    function getViewSaldo(){
        return $this->select('users.username, monitoring_os_view.updated_at')
        ->join('users', 'users.id = monitoring_os_view.user_id')->where('view_id', 5)->findAll();
    }

    function getViewPerpanjangan(){
        return $this->select('users.username, monitoring_os_view.updated_at')
        ->join('users', 'users.id = monitoring_os_view.user_id')->where('view_id', 6)->findAll();
    }

    function getViewPengeluaran(){
        return $this->select('users.username, monitoring_os_view.updated_at')
        ->join('users', 'users.id = monitoring_os_view.user_id')->where('view_id', 7)->findAll();
    }

     function getViewOneobligor(){
        return $this->select('users.username, monitoring_os_view.updated_at')
        ->join('users', 'users.id = monitoring_os_view.user_id')->where('view_id', 8)->findAll();
    }
}