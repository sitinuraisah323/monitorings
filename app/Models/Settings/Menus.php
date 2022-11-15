<?php
namespace App\Models\Settings;


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
    public $table = 'oauth_menus';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','segment','id_parent','name','url','status'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}