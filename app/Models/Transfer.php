<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'fecha_traslado',
		'detalles',
		'cellar_origen_id',
		'cellar_destino_id'
    ];
	
	public function transferProduct()
	{
		return $this->belongsToMany(Product::class)
					->withPivot('cantidad')
					->withTimestamps();
	}

    public function cellar_origen()
	{
		return $this->belongsTo(Cellar::class, 'cellar_origen_id');
	}

	public function cellar_destino()
	{
		return $this->belongsTo(Cellar::class, 'cellar_destino_id');
	}

}
