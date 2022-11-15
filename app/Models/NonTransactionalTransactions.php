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

class NonTransactionalTransactions extends Model
 {
    public $table = 'non_transactional_transactions';

    public $DBGroup = 'accounting';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = [ 'id', 'description','document_number','non_transactional_id','number','amount','office_id','office_name','branch_id','area_id','region_id','publish_time','status','attachment','created_by_id','updated_by_id','deleted_by_id','deleted_at','created_at','updated_at' ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function getPengeluaranCabang($branch){
        $month = date('m');
        $year = date('Y');
        // return $this->select('id, area, area_id')->findAll();
     return $this->table('non_transactional_transactions')->select("office_name, date_trunc('day',created_at)::date as created_at, sum(amount) as amount, 
                (select transaction_type from non_transactionals where non_transactionals.transaction_type = 1 limit 1) as address,
                ")
                ->join('non_transactionals', 'non_transactionals.id=non_transactional_transactions.non_transactional_id')
                // ->join('non_transactional_items', 'non_transactional_items.non_transactional_id=non_transactionals.id')
                // ->join('accounts', 'accounts.id=non_transactional_items.account_id')
                ->where('non_transactional_transactions.branch_id', $branch)
                ->where("EXTRACT(MONTH FROM non_transactional_transactions.created_at)", $month )
                ->where("EXTRACT(YEAR FROM non_transactional_transactions.created_at)", $year )
                // ->where('non_transactionals.transaction_type', 1)
                // ->where('non_transactional_items.region_id', 'non_transactional_transactions.region_id')
                ->groupBy('office_name')
                ->groupBy("date_trunc('day',created_at)::date")
                ->get();
    }
}