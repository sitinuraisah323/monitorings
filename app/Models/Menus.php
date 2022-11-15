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
class Menus extends Model
{
    public $table = 'menus';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','segment','id_parent','name','status'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}