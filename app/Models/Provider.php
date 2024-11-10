<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
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
		'municipio',
		'responsable_iva'
    ];
	
	public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}
