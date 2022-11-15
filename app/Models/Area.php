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
class Area extends Model
{
    public $table = 'areas';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','area','area_id','status', 'date_create', 'date_update', 'user_create', 'user_update', 'id_cabang', 'region_id', 'branch_id', 'office_id', 'office_code', 'office_name'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function getArea(){
        return $this->select('id, area, area_id')->findAll();
    }
}