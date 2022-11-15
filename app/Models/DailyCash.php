<?php
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

/**
* Class Users
* @package App\Models
* @author Bagus Aditia Setiawan
* @contact 081214069289
* @copyright saeapplication.com
*/

class DailyCash extends Model
 {
    public $table = 'daily_cashes';

    public $DBGroup = 'accounting';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = [ 'id','status','opening_time','date_open','opening_balance','remaining_balance','cashier_name','office_id','office_name','created_by_id','updated_by_id','deleted_by_id','deleted_at','created_at','updated_at','cashier_status','office_code','cashier_id' ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $useAutoIncrement = false;
}