<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
		'cellar_id',
        'fecha',
        'tipoMovimiento',
        'concepto',
		'total'
    ];

    public function movementProduct()
	{
		return $this->belongsToMany(Product::class)
					->withPivot('cantidad', 'costo_unitario', 'costo_total')
					->withTimestamps();
	}

	
	public function cellar()
    {
        return $this->belongsTo(Cellar::class);
    }
}
