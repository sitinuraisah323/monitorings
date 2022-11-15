<?php namespace App\Controllers\Api\Settings;
use App\Controllers\Api\BaseApiController;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Categories extends BaseApiController
{
    public $modelName = '\App\Models\Settings\Privileges';

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
            'errors' => [
                'required' => 'level harus di isi'
            ]
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
            'errors' => [
                'required' => 'level harus di isi'
            ]
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
        'description'        => 'description'
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
        'description'               => 'description'
    ];

//    product
    public $content = 'Level';
    //--------------------------------------------------------------------

}
