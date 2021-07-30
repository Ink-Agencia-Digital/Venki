<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pago extends Model
{
    use HasFactory;
    protected $table='pagos'; 
    protected $fillable = [
        'user_id',
        'membresia_id',
        'x_cust_id_cliente',
        'x_id_factura',
        'x_ref_payco',
        'x_amount_base',
        'x_tax',
        'x_response',
        'x_approval_code',
        'x_transaction_id',
        'x_transaction_date',
        'x_cod_response',
        'x_response_reason_text',
        'x_error_code',
        'x_transaction_state',
        'x_customer_ip',
        'x_franchise',
        'x_signature'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function membresias()
    {
        return $this->belongsTo(membresias::class);
    }

}
