<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellar extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'company_id',
		'nombre',
		'ubicacion',
		'detalles',
		'predeterminada'
    ];
	
	public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('cantidad')
            ->withTimestamps();
    }
	
	public function company()
    {
        return $this->belongsTo(Company::class);
    }
	
	public function movements()
    {
        return $this->hasMany(Movement::class);
    }
	
	public function transfers_origen()
    {
        return $this->hasMany(Transfer::class, 'cellar_origen_id');
    }

    public function transfers_destino()
    {
        return $this->hasMany(Transfer::class, 'cellar_destino_id');
    }
}
