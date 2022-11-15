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
class LevelsPrivileges extends Model
{
    public $table = 'levels_privileges';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','level_id','menu_id','access','status'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}