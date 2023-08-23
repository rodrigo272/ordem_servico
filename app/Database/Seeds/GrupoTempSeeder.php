<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GrupoTempSeeder extends Seeder
{
    public function run()
    {
        $grupoModel = new \App\Models\GrupoModel();

            $grupos = [
            [    

                'nome' => 'Administrador',
                'descricao' => 'Grupo com acesso total',
                'exibir' => false,

            ],
            [

                'nome' => 'Clientes',
                'descricao' => 'Acesso as suas ordens de serviço individual',
                'exibir' => false,

            ],
            [

                'nome' => 'Atendente',
                'descricao' => 'Acesso ao sistema para atender aos clientes',
                'exibir' => false,

            ],
        ];

        foreach($grupos as $grupo){
            $grupoModel->insert($grupo);
        }
    }
}
