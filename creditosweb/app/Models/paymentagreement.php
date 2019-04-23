<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paymentagreement extends Model
{
    protected $table='payment_agreement';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'client',
        'seller',
        'invoice',
        'number_installments',
        'period',
        'total_quota',
        'total',
        'comments',
        'created_at',
        'state'
    ];

    protected $guarded =[

    ];
}
