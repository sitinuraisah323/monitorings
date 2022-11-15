<?php namespace App\Controllers\Api;
use App\Controllers\Api\BaseApiController;
use App\Models\Notifications;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Auth extends BaseApiController
{
    public $modelName = '\App\Models\Users';

       /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]

    public $fillSearch = [
        'username'              => 'username',
    ];

    public $searchValue = 'username';

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillWhere = [
        // 'name'              => 'name',
    ];

//    [
//        'name' => [
//        'label'  => 'Name',
//        'rules'  => 'required',
//        'errors' => [
//        'required' => 'Required Name '
//        ]
//    ],
    public $validateInsert = [
        'id_level' => [
            'label'  => 'id_level',
            'rules'  => 'required|integer',
        ],
        'first_name' => [
            'label'  => 'first_name',
            'rules'  => 'required',
        ],
        'last_name' => [
            'label'  => 'last_name',
            'rules'  => 'required',
        ],
        'username' => [
            'label'  => 'username',
            'rules'  => 'required|is_unique[oauth_users.username]',
        ],
        'email' => [
            'label'  => 'email',
            'rules'  => 'required|is_unique[oauth_users.email]',
        ],
        'password' => [
            'label'  => 'password',
            'rules'  => 'required',
        ],
    ];

    public $validateUpdate = [
        'id' => [
            'label'  => 'id',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Id harus di isi'
            ]
        ],
        'id_level' => [
            'label'  => 'id_level',
            'rules'  => 'required|integer',
        ],
        'first_name' => [
            'label'  => 'first_name',
            'rules'  => 'required',
        ],
        'last_name' => [
            'label'  => 'last_name',
            'rules'  => 'required',
        ],
        'username' => [
            'label'  => 'username',
            'rules'  => 'required',
        ],
        'email' => [
            'label'  => 'email',
            'rules'  => 'required',
        ],
    ];

    public $validateRegister = [
        'first_name' => [
            'label'  => 'Nama Depan',
            'rules'  => 'required',
        ],
        'last_name' => [
            'label'  => 'Nama Terakhir',
            'rules'  => 'required',
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
        ],
        'email' => [
            'label'  => 'Alamat Email',
            'rules'  => 'required',
        ],
        'mobile' => [
            'label'  => 'No Hp',
            'rules'  => 'required',
        ],
        'nik' => [
            'label'  => 'No Ktp',
            'rules'  => 'required',
        ],
    ];


    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillableInsert = [
        'id_level'              => 'id_level',
        'first_name'              => 'first_name',
        'last_name' => 'last_name',
        'email' => 'email',
        'username' => 'username',
    ];

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]


    public $fillableIupdate = [
        'id_level'              => 'id_level',
        'first_name'              => 'first_name',
        'last_name' => 'last_name',
        'username' => 'username',
        'email' => 'email',
    ];

//    product
    public $content = 'Posts Kategori';
    //--------------------------------------------------------------------
    public function login()
    {
        $validateLogin = [
            'username' => [
                'label'  => 'username',
                'rules'  => 'required',
            ],
            'password' => [
                'label'  => 'password',
                'rules'  => 'required',
            ]
        ];
        if(count($validateLogin)){
            $this->validate($validateLogin);
        }
        if(! $this->validator->run()){
            return $this->sendResponse($this->validator->getErrors(),422,'Failed insert '.$this->content);
        }
        $username = $this->request->getPost('username');
        $user = $this->model
            ->select('users.*, levels.level')
			->join('levels','levels.id = users.id_level','left')
			->select('units.name as unit_name, units.office_id')
			->join('units','units.id = users.id_unit','left')
			->select('cabang.cabang as cabang_name, cabang.branch_id')
			->join('cabang','cabang.id = users.id_cabang','left')
			->select('areas.area as area_name, areas.area_id')
			->join('areas','areas.id = users.id_area','left')
            ->where('username', $username)->first();
            // var_dump($user);exit;

        if(!$user){
            // echo 'satu';exit;
            return $this->sendResponse([],422,'Username Or Passord Wrong ');
        }
        $isPasswordVerified = password_verify($this->request->getPost('password'),$user->password);
        if(!$isPasswordVerified) {
            //  echo 'dua';exit;
            return $this->sendResponse([],422,'Username Or Password Wrong ');
        }
        $privileges = (new \App\Models\LevelsPrivileges())
            ->select('levels_privileges.*')
            ->join('menus','menus.id = levels_privileges.id_menu')
            ->where('id_level', $user->id_level)->findAll();

         $notifications = (new \App\Models\Notifications())
            ->where('read', '0')->findAll();
        session()->set(array(
            'user'  => $user,
            'logged_in' => true,
            'privileges'    => $privileges,
            // 'notifications' => $notifications,
        ));
        return $this->sendResponse([
            'user'  => $user
        ],201,'Successfully Login '.$this->content);
    }

    public function logout()
    {
        if(session('user')->id_level == 1) {
            session()->destroy();
            return redirect()->to(base_url('monitoring'));
        }else{
            session()->destroy();
            return redirect()->to(base_url('login'));
        }
    }

    public function insert()
    {
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

                    $data = [];
                    foreach ($this->fillableInsert as $column => $param){
                        if($this->request->getPost($param) != null){
                            $data[$column]  = $this->request->getPost($param);
                        }
                    }

                    if($this->request->getPost('password') != null){
                        $data['password']  = sha1($this->request->getPost('password'));
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

                    if($this->request->getPost('password') != null){
                        $data['password']  = sha1($this->request->getPost('password'));
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

    public function register()
    {
        if($this->model){
            if($post = $this->request->getPost()){
                if(method_exists($this, 'beforeValidate')){
                    $this->beforeValidate();
                }
                if(count($this->validateRegister)){
                    $this->validate($this->validateRegister);
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

                    $emailExist = $this->model->where('email', $this->request->getPost('email'))->first();
                    if ($emailExist) return $this->sendResponse([
                        'email_exist'   => 'email sudah digunakan'
                    ],422,'Failed Updated '.$this->content);
               
                    $userExist = $this->model->where('username', $this->request->getPost('username'))->first();
                    if ($userExist) return $this->sendResponse([
                        'username_exist'   => 'Username sudah digunakan'
                    ],422,'Failed Updated '.$this->content);
               

                    $data = [];
                    foreach ($this->fillableInsert as $column => $param){
                        if($this->request->getPost($param) != null){
                            $data[$column]  = $this->request->getPost($param);
                        }
                    }

                    if($this->request->getPost('password') != null){
                        $data['password']  = sha1($this->request->getPost('password'));
                    }                    
                    $modelCustomer = new \App\Models\Customers();
                    $customer = $modelCustomer->where('nik', $this->request->getPost('nik'))->first();
                    if($customer) {
                        $data['id_customer'] = $customer->id;
                    }else{
                        $modelCustomer->save([
                            'name' => $this->request->getPost('first_name').' '.$this->request->getPost('last_name'),
                            'mobile' => $this->request->getPost('mobile'),
                            'email' => $this->request->getPost('email'),
                            'nik' => $this->request->getPost('nik'),
                        ]);
                        $data['id_customer'] = $modelCustomer->getInsertID();
                    }
                    $data['id_level'] = 3;
                    $this->model->save($data);
                    if(method_exists($this, 'afterInsert')){
                        $this->afterInsert();
                    }
                    if(method_exists($this, 'afterInsertOrUpdate')){
                        $this->afterInsertOrUpdate();
                    }
                    $id = $this->model->getInsertID();
                    if($this->model->db->transStatus()){
                        $this->model->db->transCommit();
                        return $this->sendResponse($this->model->find($id),201,'Successfully insert '.$this->content);
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


}
