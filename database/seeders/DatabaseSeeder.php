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

        $company = \App\Models\Company::create([
            'nit' => 1005663635,
            'nombre' => 'ClinicaEconomica',
            'direccion' => 'Cra 10',
            'telefono' => 3013673743,
            'email' => 'info@company.com',
			'municipio' => 'Ilopango',
			'departamento' => 'San Salvador',
			'codigo_postal' => '503',
        ]);

        $user = \App\Models\User::factory()->create([
			'company_id' => $company->id,
            'nombre' => 'Mary ',
            'email' => 'walejandroh95@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        
    }
}
