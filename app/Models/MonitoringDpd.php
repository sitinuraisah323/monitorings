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
class MonitoringDpd extends Model
{
    public $table = 'monitoring_dpd';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','date','office_id','office_name', 'noa','os', 'noa_regular', 'regular', 'noa_instalment', 'instalment', 'noa_opsi', 'opsi', 'noa_hp', 'hp', 'noa_yukgadai', 'yukgadai'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}