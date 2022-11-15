<?php


namespace App\Controllers\Api;


use App\Libraries\OAuth2;
use CodeIgniter\RESTful\ResourceController;
use OAuth2\Request;

/**
 * Class BaseApiController
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */

class BaseApiController extends ResourceController
{
    public $modelName;

    public $format = 'json';

    /**
     * @var string
     */

    public $primaryKey = 'id';
    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillSearch = [];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillWhere = [];


//    [
//        'name' => [
//        'label'  => 'Name',
//        'rules'  => 'required',
//        'errors' => [
//        'required' => 'Required Name '
//        ]
//    ],
    public $validateInsert = [];
//  [
//        'name' => [
//        'label'  => 'Name',
//        'rules'  => 'required',
//        'errors' => [
//        'required' => 'Required Name '
//        ]
//    ],

    public $validateUpdate = [];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillableInsert = [];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $searchValue = 'name';

    public $fillableIupdate = [];

//    product
    public $content;

    public function sendResponse($data = [], $status = 202, $message = '')
    {
        return $this->respond(array(
            'data'  => $data,
            'status'    => $status,
            'message'   => $message
        ));
    }

    public function where()
    {
        if($gets = $this->request->getGet()){
            if(count($this->fillSearch)){
                foreach ($this->fillSearch as $column => $param){
                    $get = $this->request->getGet($param);
                    if($get != null){
                        $this->model->like($column,$get);
                    }
                }
            }

            if(count($this->fillWhere)){
                foreach ($this->fillWhere as $column => $param){
                    $get = $this->request->getGet($param);
                    if($get != null){
                        $this->model->where($column,$get);
                        
                    }
                }
                       

            }

        }
    
        if(method_exists($this,'beforeIndex')){
            $data = $this->beforeIndex();
        }

        if($search = $this->request->getGet('search')){
            $value = $search['value'];
            if($value){
                $this->model->like($this->searchValue, $value);
            }
        }
    }

    public function index()
    {
        // echo 'Yes'; exit;
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
        if($this->model){
            $this->where();
            
            $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
            $length = $this->request->getGet('length') ? $this->request->getGet('length') : 10;

            $data = $this->model->orderBy($this->model->table.'.id','desc')->findAll($length, $start);
            $this->where();
            $totalRecord = $this->model->countAllResults();
            if(method_exists($this,'afterIndex')){
                $data = $this->afterIndex($data);
            }
            return $this->sendResponse($data,201,[
                'totalRecord' => $totalRecord,
            ]);
        }
        return $this->sendResponse('Model Not Found',201,'Model Not Found '.$this->model);

    }

    // public function index_detail($units, $date)
    // {
    //     var_dump($this->request->getGet('date'));exit;
    //     if(is_null(session()->get('logged_in'))){            
    //         return $this->sendResponse('No Autheticated',403,'No Autheticated');
    //         die;
    //     }
    //     if($this->model){
    //         // $this->model->where('office_id',$units);
    //         // $this->model->where('contract_date',$date);
    //         $this->where();
            
    //         $start = $this->request->getGet('start') ? $this->request->getGet('start') : 0;
    //         $length = $this->request->getGet('length') ? $this->request->getGet('length') : 10;

    //         $data = $this->model->orderBy($this->model->table.'.id','desc')->findAll($length, $start);
    //         $this->where();
    //         $totalRecord = $this->model->countAllResults();
    //         if(method_exists($this,'afterIndex')){
    //             $data = $this->afterIndex($data);
    //         }
    //         return $this->sendResponse($data,201,[
    //             'totalRecord' => $totalRecord,
    //         ]);
    //     }
    //     return $this->sendResponse('Model Not Found',201,'Model Not Found '.$this->model);

    // }

    public function insert()
    {
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }

        if($this->model){
            if($post = $this->request->getPost()){
                if(method_exists($this, 'beforeValidate')){
                    $this->beforeValidate();
                }
                if(count($this->validateInsert)){
                    $this->validate($this->validateInsert);
                }
                if(! $this->validator->run()){
                    return $this->sendResponse($this->validator->getErrors(),422,'Failed insert '.$this->content);
                }
                if(count($this->fillableInsert)){
                    $this->model->db->transBegin();
                    if(method_exists($this, 'beforeInsert')){
                        $this->beforeInsert();
                    }
                    if(method_exists($this, 'beforeInsertOrUpdate')){
                        $this->beforeInsertOrUpdate();
                    }

                    $data = [
                        'name' => $this->request->getPost('name')
                    ];
                    foreach ($this->fillableInsert as $column => $param){
                        if($this->request->getPost($param) != null){
                            $data[$column]  = $this->request->getPost($param);
                        }
                    }

                    $this->model->save($data);
                    if(method_exists($this, 'afterInsert')){
                        $this->afterInsert();
                    }
                    if(method_exists($this, 'afterInsertOrUpdate')){
                        $this->afterInsertOrUpdate();
                    }
                    if($this->model->db->transStatus()){
                        $this->model->db->transCommit();
                        return $this->sendResponse($this->model->find($this->model->getInsertID()),201,'Successfully insert '.$this->content);
                    }else{
                        $this->model->db->transRollback();
                        return $this->sendResponse($this->model->db->getLastQuery(),400,'Failed insert '.$this->content);
                    }
                }
            }
            return $this->sendResponse(false, 400, 'Request Should Post');
        }
        return $this->sendResponse('Model Not Found',201,'Model Not Found '.$this->model);
    }

    public function updated()
    {
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
        if($this->model){
            if($this->request->getPost()){
                if(method_exists($this, 'beforeValidate')){
                    $this->beforeValidate();
                }
                if(count($this->validateUpdate)){
                    $this->validate($this->validateUpdate);
                }
                if(! $this->validator->run()){
                    return $this->sendResponse($this->validator->getErrors(),422,'Failed Updated '.$this->content);
                }
                if(count($this->fillableIupdate)){
                    $this->model->db->transBegin();
                    if(method_exists($this, 'beforeUpdate')){
                        $this->beforeUpdate();
                    }
                    if(method_exists($this, 'beforeInsertOrUpdate')){
                        $this->beforeInsertOrUpdate();
                    }

                    $data = [];
                    foreach ($this->fillableIupdate as $column => $param){
                        if($this->request->getPost($param) != null){
                            $data[$column]  = $this->request->getPost($param);
                        }
                    }

                    $this->model->update($this->request->getPost($this->primaryKey),$data);


                    if(method_exists($this, 'afterUpdate')){
                        $this->afterUpdate();
                    }
                    if(method_exists($this, 'afterInsertOrUpdate')){
                        $this->afterInsertOrUpdate();
                    }
                    if($this->model->db->transStatus()){
                        $this->model->db->transCommit();
                        return $this->sendResponse($this->model->find($this->request->getPost('id')),201,'Successfully updated '.$this->content);
                    }else{
                        $this->model->db->transRollback();
                        return $this->sendResponse($this->model->db->getLastQuery(),400,'Failed updated '.$this->content);
                    }
                }
            }
            return $this->sendResponse(false, 400, 'Request Should Post');
        }
        return $this->sendResponse('Model Not Found',201,'Model Not Found '.$this->model);
    }

    public function deleted($id)
    {
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
        if($this->model) {
            $data = $this->model->find($id);
            if ($find = $this->model->delete($id)) {
                if(method_exists($this, 'afterDeleted')){
                    $this->afterDeleted($data);
                }
                return $this->sendResponse($data, 201, 'Successfully get ' . $this->content);
            } else {
                return $this->sendResponse(false, 400, 'Successfully get ' . $this->content);
            }
        }
        return $this->sendResponse('Model Not Found',201,'Model Not Found '.$this->model);
    }


    public function view($id)
    {
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
        if($this->model) {
            if ($find = $this->model->find($id)) {
                if(method_exists($this, 'afterView')){
                    $find = $this->afterView($find);
                }
                return $this->sendResponse($find, 201, 'Successfully get ' . $this->content);
            } else {
                return $this->sendResponse(false, 400, 'Successfully get post' . $this->content);
            }
        }
        return $this->sendResponse('Model Not Found',201,'Model Not Found '.$this->model);

    }

    public function images_url($path)
    {
        if(!is_file($path)){
            return base_url('storage/images/default/noimage.jpg');
        }
        return base_url($path);
    }
    public function avatar_url($path)
    {
        if(!is_file($path)){
            return base_url('storage/images/default/avatar.png');
        }
        return base_url($path);
    }

}