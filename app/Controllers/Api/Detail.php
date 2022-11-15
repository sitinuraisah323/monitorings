<?php namespace App\Controllers\Api\Settings;
use App\Controllers\Api\BaseApiController;

/**
 * Class Users
 * @package App\Controllers\Api
 * @author Bagus Aditia Setiawan
 * @contact 081214069289
 * @copyright saeapplication.com
 */
class Detail extends BaseApiController
{
    public $modelName = '\App\Models\pawnTransactions';

       /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]

    public $fillSearch = [
        'sge'              => 'sge',
    ];

    public $searchValue = 'sge';

    /**
     * @var array
     * column of name table database
     * name of param post
     */
//    [
//        'column'    => 'value'
//    ]
    public $fillWhere = [
        'contract_date'              => 'contract_date',
        'office_id'              => 'office_id',
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
    public $content = 'Detail Transaksi';
    //--------------------------------------------------------------------

}
