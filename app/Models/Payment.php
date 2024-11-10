<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
	
	 protected $fillable = [
		'invoice_id',
		'sale_id',
        'fecha',
        'monto',
    ];
	
	public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
