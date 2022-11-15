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

class JournalEntries extends Model
 {
    public $table = 'journal_entries';

    public $DBGroup = 'accounting';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = [ 'id', 'journal_id','account_id','ref_code','description','transaction_type','amount','deleted_at','created_at','updated_at','office_id','daily_cash_id','document_number','is_cash_entry','is_balance_affected','branch_id','branch_name','area_id','area_name','regional_id','regional_name','office_name' ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}