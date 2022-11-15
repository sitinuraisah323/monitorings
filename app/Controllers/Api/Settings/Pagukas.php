<?php namespace App\Controllers\Api\Settings;
use App\Controllers\Api\BaseApiController;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Pagukas extends BaseApiController
{
    public $modelName = '\App\Models\Pagukas';

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
        'office_name'              => 'office_name',
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
        'office_id' => [
            'label'  => 'office_id',
            'rules'  => 'required|is_unique[monitoring_pagukas.office_id]',
        ],
        'office_name' => [
            'label'  => 'office_name',
            'rules'  => 'required',
        ],
        'saldo' => [
            'label'  => 'saldo',
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
        'office_id'   => [
            'label'  => 'office_id',
            'rules'  => 'required',
        ],
        'office_name' => [
            'label'  => 'office_name',
            'rules'  => 'required',
        ],
        'saldo'   => [
            'label'  => 'saldo',
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
        'office_id' => 'office_id',
        'office_name' => 'office_name',
        'saldo' => 'saldo'
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
         'office_id' => 'office_id',
         'office_name' => 'office_name',
        'saldo' => 'saldo'
    ];

//    product
    public $content = 'Setting Pagukas';
    //--------------------------------------------------------------------

    

}