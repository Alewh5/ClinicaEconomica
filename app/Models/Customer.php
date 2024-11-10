<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'tipoDocumento',
		'numeroDocumento',
		'NombreRazonSocial',
		'direccion',
		'telefono',
		'email',
		'departamento',
		'municipio'
    ];
	
	public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}