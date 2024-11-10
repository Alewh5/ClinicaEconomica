<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descripcion',
        'tipo_producto',
        'precio',
        'iva_compra',
		'iva_venta',
		'marca',
        'categoria',
		'estado'
    ];

    public function cellars()
    {
        return $this->belongsToMany(Cellar::class)
            ->withPivot('cantidad')
            ->withTimestamps();
    }
	
	public function invoiceProduct()
    {
        return $this->belongsToMany(Invoice::class)
            ->withPivot('cantidad', 'precio_unitario', 'descuento', 'valor_descuento', 'subtotal', 'impuestos', 'precio_total')
            ->withTimestamps();
    }
	
	public function refundProduct()
    {
        return $this->belongsToMany(Refund::class)
            ->withPivot('cantidad', 'total')
            ->withTimestamps();
    }

    public function movements()
	{
		return $this->belongsToMany(Movement::class)
					->withPivot('cantidad', 'costo_unitario', 'costo_total')
					->withTimestamps();
	}
	
	public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
}
