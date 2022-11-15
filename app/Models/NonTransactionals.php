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

class NonTransactionals extends Model
 {
    public $table = 'non_transactionals';

    public $DBGroup = 'accounting';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = [ 'id', 'name','code','description','transaction_type','cash_type','created_by_id','updated_by_id','deleted_by_id','deleted_at','created_at', 'updated_at' ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}