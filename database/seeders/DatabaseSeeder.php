<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $company = \App\Models\Company::create([ // CREANDO USUARIO DE COMPAÑIA
            'nit' => 1005663635,
            'nombre' => 'ClinicaEconomica',
            'direccion' => 'Cra 10',
            'telefono' => 3013673743,
            'email' => 'info@company.com',
			'municipio' => 'Ilopango',
			'departamento' => 'San Salvador',
			'codigo_postal' => '503',
        ]);

        $user = \App\Models\User::factory()->create([ // USUARIO ADMINISTRADOR
			'company_id' => $company->id,
            // 'rol' => 'admin', // rol administrador
            'nombre' => 'Mary ',
            'email' => 'walejandroh95@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user = \App\Models\User::factory()->create([ // USUARIO VENDEDOR
			'company_id' => $company->id,
            // 'rol' => 'vendedor', // rol administrador
            'nombre' => 'Harold ',
            'email' => 'haroldalexis1667@gmail.com',
            'password' => bcrypt('Amanecerdel33'),
        ]);
    }
}
