<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Géneros
        DB::table('genero')->insert([
            ['nombre' => 'Masculino'],
            ['nombre' => 'Femenino'],
        ]);

        // 2. Tipos de Documento
        DB::table('tipos_documentos')->insert([
            ['nombre' => 'Cédula de Ciudadanía'],
            ['nombre' => 'Tarjeta de Identidad'],
        ]);

        // 3. Departamentos
        for ($i = 1; $i <= 5; $i++) {
            DB::table('departamentos')->insert([
                'nombre' => 'Departamento ' . $i,
            ]);
        }

        // 4. Municipios (2 por departamento)
        $departamentos = DB::table('departamentos')->get();
        foreach ($departamentos as $departamento) {
            for ($j = 1; $j <= 2; $j++) {
                DB::table('municipios')->insert([
                    'nombre' => 'Municipio ' . $j . ' de ' . $departamento->nombre,
                    'departamento_id' => $departamento->id,
                ]);
            }
        }

        // 5. Usuario administrador
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('1234567890'),
        ]);

        // 6. Insertar pacientes válidos
        $tipoDoc = DB::table('tipos_documentos')->first();
        $genero = DB::table('genero')->first();
        $departamento = DB::table('departamentos')->first();
        $municipio = DB::table('municipios')->where('departamento_id', $departamento->id)->first();

        for ($i = 1; $i <= 5; $i++) {
            DB::table('paciente')->insert([
                'tipo_documento_id' => $tipoDoc->id,
                'numero_documento' => '1000000' . $i,
                'nombre1' => 'Nombre' . $i,
                'nombre2' => 'Segundo' . $i,
                'apellido1' => 'Apellido' . $i,
                'apellido2' => 'ApellidoDos' . $i,
                'genero_id' => $genero->id,
                'departamento_id' => $departamento->id,
                'municipio_id' => $municipio->id,
                'correo' => 'paciente' . $i . '@correo.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
