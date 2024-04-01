<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionInvoice extends Model
{
    use HasFactory;

    protected $table = 'transaction_payment';

    protected $fillable = [
        'id', 'code', 'methode', 'description', 'amount', 'fee', 'date', 'category', 'booking_id',
        'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function booking()
    {
        return $this->belongsTo(TransactionBooking::class, 'booking_id', 'id');
    }

    public function payment()
    {
        return $this->hasMany(TransactionPayment::class, 'invoice_number', 'code');
    }
}
