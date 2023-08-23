<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioFakeSeeder extends Seeder
{
    public function run()
    {
        $usuarioModel = new \App\Models\UsuarioModel();

        // use the factory to create a Faker\Generator instance
        $faker = \Faker\Factory::create();

        $criarUsuarios = 1000;
        $usuariosPush = [];

        for($i = 0; $i < $criarUsuarios; $i++){
            array_push($usuariosPush,[
                'nome'     =>$faker->unique()->name,
                'email'    =>$faker->unique()->email,
                'password' => '1234',
                'ativo' => $faker->numberBetween(0,1),
            ]);
        }

        $usuarioModel->skipValidation(true)
                     ->protect(false)
                     ->insertBatch($usuariosPush);

        echo $criarUsuarios. 'Usuarios, criados com sucesso';
    }
}
