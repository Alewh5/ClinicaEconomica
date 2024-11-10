<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'customer_id',
		'codigo',
		'fechaEmision',
		'metodoPago',
		'estadoFactura',
		'subTotal',
		'impuestos',
		'total',
		'deuda',
		'descuento_global',
		'valor_descuentoGlobal',
		'descuento_total',
	];
	
	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function productSale()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('cantidad', 'precio_unitario', 'descuento', 'valor_descuento', 'subtotal', 'impuestos', 'precio_total')
            ->withTimestamps();
    }
	
	public function refunds()
    {
        return $this->hasMany(Refund::class, 'sale_id');
    }
}
