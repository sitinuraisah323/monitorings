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

class PawnTransactions extends Model
 {
    public $table = 'journals';

    public $DBGroup = 'accounting';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = [ 'id', 'insurance_item_id', 'customer_id', 'company_id', 'sge', 'product_id', 'status', 'transaction_type', 'contract_date', 'due_date', 'auction_date', 'loan_amount', 'admin_fee', 'monthly_fee', 'created_by_id', 'updated_by_id', 'deleted_by_id', 'deleted_at', 'created_at', 'updated_at', 'insurance_item_name', 'maximum_loan', 'maximum_loan_percentage', 'notes', 'office_id', 'prolongation_period', 'prolongation_date', 'office_type', 'branch_id', 'area_id', 'region_id', 'head_id', 'per_15_days_fee', 'parent_id', 'product_name', 'fine_percentage', 'payment_status', 'payment_amount', 'prolongation_order', 'repayment_date', 'parent_sge', 'estimated_value', 'interest_rate', 'is_option', 'office_name', 'sa_code', 'office_code', 'created_by', 'approved_by', 'stle', 'is_follow_up', 'is_follow_up_weekly', 'reason' ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}