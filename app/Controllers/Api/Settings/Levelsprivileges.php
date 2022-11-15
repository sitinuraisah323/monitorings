<?php namespace App\Controllers\Api\Settings;
use App\Controllers\Api\BaseApiController;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Levelsprivileges extends BaseApiController
{
    public $modelName = '\App\Models\LevelsPrivileges';

       /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]

    public $fillSearch = [
        ''              => '',
    ];

    public $searchValue = 'level';

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillWhere = [
        'level_id'              => 'level_id',
        'menu_id'              => 'menu_id',
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
        'level_id' => [
            'label'  => 'level_id',
            'rules'  => 'required',
        ],
        'menu_id' => [
            'label'  => 'menu_id',
            'rules'  => 'required',
        ],
        'access' => [
            'label'  => 'access',
            'rules'  => 'required',
        ]
    ];

    public $validateUpdate = [
        'id' => [
            'label'  => 'id',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Id harus di isi'
            ]
        ],
        'level_id' => [
            'label'  => 'level_id',
            'rules'  => 'required',
        ],
        'menu_id' => [
            'label'  => 'menu_id',
            'rules'  => 'required',
        ],
        'access' => [
            'label'  => 'access',
            'rules'  => 'required',
        ]
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
        'access'              => 'access',
        'menu_id'              => 'menu_id',
        'level_id' => 'level_id'
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
        'access'              => 'access',
        'menu_id'              => 'menu_id',
        'level_id' => 'level_id'
    ];

    public function insertOrUpdate()
    {
        if(is_null(session()->get('logged_in'))){            
            return $this->sendResponse('No Autheticated',403,'No Autheticated');
            die;
        }
        $levelId = $this->request->getPost('level_id');
        $menuId = $this->request->getPost('menu_id');
        $access = $this->request->getPost('access');
        
        $getMenu = $this->model->where('level_id', $levelId)->where('menu_id', $menuId)->first();
        if($getMenu){
            $this->model->update($getMenu->id, [
                'level_id'  => $levelId,
                'menu_id'   => $menuId,
                'access'    => $access
            ]);
        }else{
            $this->model->insert([
                'level_id'  => $levelId,
                'menu_id'   => $menuId,
                'access'    => $access
            ]);
        }
        return $this->sendResponse([],201,'Succcessfully config menu privilege');
    }

//    product
    public $content = 'Setting Level Privileges';
    //--------------------------------------------------------------------

}
