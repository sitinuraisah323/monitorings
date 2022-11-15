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
class Levels extends Model
{
    public $table = 'levels';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','level','description','status'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}