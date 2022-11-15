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
class Users extends Model
{
    public $table = 'users';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_employee','id_unit','id_cabang','id_area','email','username','password'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}