<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
	use HasFactory;

	protected $fillable = [
		'sale_id',
		'invoice_id',
		'motivo',
		'fecha',
		'total'
	];

	public function productRefund()
	{
		return $this->belongsToMany(Product::class)
			->withPivot('cantidad', 'precio_total')
			->withTimestamps();
	}

	public function sale()
	{
		return $this->belongsTo(Sale::class, 'sale_id');
	}

	public function invoice()
	{
		return $this->belongsTo(Invoice::class, 'invoice_id');
	}
}
