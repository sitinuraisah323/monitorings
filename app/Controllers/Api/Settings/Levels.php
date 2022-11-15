<?php namespace App\Controllers\Api\Settings;
use App\Controllers\Api\BaseApiController;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Levels extends BaseApiController
{
    public $modelName = '\App\Models\Levels';

       /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]

    public $fillSearch = [
        'level'              => 'level',
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
        'level' => [
            'label'  => 'level',
            'rules'  => 'required',
        ],
        'description' => [
            'label'  => 'description',
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
        'level' => [
            'label'  => 'level',
            'rules'  => 'required',
        ],
        'description' => [
            'label'  => 'description',
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
        'level'              => 'level',
        'description' => 'description'
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
        'level'              => 'level',
        'description' => 'description'
    ];

//    product
    public $content = 'Setting Level';
    //--------------------------------------------------------------------

}
