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
class Regular extends Model
{
    public $table = 'units_regularpawns';

    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','no_sbk','nic','id_customer','ktp','date_sbk','deadline','amount','date_auction','estimation','admin','capital_lease_old','periode','installment','status_transaction','id_unit','type_item','type_bmh','description_1','description_2','description_3','description_4','permit','status','date_create','date_update','user_create','user_update','capital_lease','id_repayment'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // function getArea(){
    //     return $this->select('id, area, area_id')->findAll();
    // }
}