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
class Units extends Model
{
    public $table = 'units';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_area','name','date_open','status', 'date_create', 'date_update', 'user_create', 'user_update', 'id_cabang', 'region_id', 'branch_id', 'office_id', 'office_code', 'office_name'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function getUnit_byCabang($branch){
        return $this->where('id_cabang', $branch)->findAll();
    }
}