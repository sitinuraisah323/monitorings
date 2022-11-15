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
class Notifications extends Model
{
    public $table = 'monitoring_notifications';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','office_id', 'office_name','date','type', 'saldo', 'message', 'read', 'created_at', 'updated_at'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}