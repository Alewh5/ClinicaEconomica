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
            'nombre' => 'Company 1',
            'direccion' => 'Cra 10',
            'telefono' => 3013673743,
            'email' => 'info@company.com',
			'municipio' => 'Sincelejo',
			'departamento' => 'Sucre',
			'codigo_postal' => '700003',
        ]);

        $user = \App\Models\User::factory()->create([
			'company_id' => $company->id,
            'nombre' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);
        
    }
}
