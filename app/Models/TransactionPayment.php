<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPayment extends Model
{
    use HasFactory;

    protected $table = 'transaction_confirm_payment';

    protected $fillable = [
        'id', 'invoice_number', 'methode', 'sender', 'from', 'amount', 'paid_date', 'file', 'note', 'category', 'event_id',
        'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
