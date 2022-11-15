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
class Cabang extends Model
{
    public $table = 'cabang';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_area','cabang','branch_id','area_id','status', 'date_create', 'date_update', 'user_create', 'user_update'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}