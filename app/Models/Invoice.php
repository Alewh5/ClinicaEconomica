<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'provider_id',
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
	
	public function productInvoice()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('cantidad', 'precio_unitario', 'descuento', 'valor_descuento', 'subtotal', 'impuestos', 'precio_total')
            ->withTimestamps();
    }
	
	public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
	
	public function refunds()
    {
        return $this->hasMany(Refund::class, 'invoice_id');
    }
}
