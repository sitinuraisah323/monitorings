<?php namespace App\Controllers\Api;
use App\Controllers\Api\BaseApiController;
use App\Models\Notifications as ModelsNotifications;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Notifications extends BaseApiController
{
    public $modelName = '\App\Models\Notifications';

       /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]

    public $fillSearch = [
        'office_name'              => 'office_name',
    ];

    public $searchValue = 'office_name';

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
        'name' => [
            'label'  => 'name',
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
        'name' => [
            'label'  => 'name',
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
        'name'              => 'name',
        'url' => 'url'
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
        'name'              => 'name',
        'url' => 'url'
    ];

//    product
    public $content = 'Setting Level';
    //--------------------------------------------------------------------

    public function getUpdateRead($id) {
        $notif = new ModelsNotifications();

        $check = $notif->where('id', $id)->first();

			
			if($check){
				$update = $notif->update($check->id, [
					'id'	=> $check->id,
					'office_id'	=> $check->office_id,
					'office_name'	=> $check->office_name,
					'date' =>  $check->date,
					'type' =>  $check->type,
					'saldo' =>  $check->saldo,
					'message' =>  $check->message,
					'read' =>  '1',
					
				]);
			
			
			}

            return view('administrator/notifications/saldo', $id);
    }

}