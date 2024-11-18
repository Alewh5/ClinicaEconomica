<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'nit',
        'nombre',
        'direccion',
        'telefono',
        'email',
        'sitio_web',
		'municipio',
		'departamento',
		'codigo_postal',
        'presupuesto'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget_movement::class);
    }
	
	public function cellars()
    {
        return $this->hasMany(Cellar::class);
    }
	
}
