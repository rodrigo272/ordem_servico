<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'nome',
        'email',
        'password_hash',
        'reset',
        'reset_expira',
        'imagem',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules      = [
        'id'           => 'permit_empty|is_natural_no_zero', 
	
	// as existentes
	'nome'         => 'required|min_length[3]|max_length[40]',
	'email'        => 'required|valid_email|max_length[130]|is_unique[usuarios.email,id,{id}]', // Não pode ter espaços
	'password'     => 'required|min_length[6]',
	'password_1' => 'required_with[password]|matches[password]'
    ];
    protected $validationMessages   = [
        'nome' => [
            'required' => 'O campo nome é obrigatório',
            'min_length' => 'O campo nome precisa ter pelo menos 3 caracteres!',
        ],
        'email' => [
            'required' => 'O campo email é obrigatório',
            'is_unique' => 'Já existe esse email cadastrado, favor verificar!'
        ],
        'password_1' => [
            'matches' => 'Essa senha está diferente, da Senha acima informada! ',
            'required_with' => 'Por favor, confirme sua senha',
        ]
       
    ];
    

    // Callbacks
    
    protected $beforeInsert   = ['hashPassword'];
    //protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];

    protected function hashPassword(array $data)
    {

              
        if(isset($data['data']['password'])) {

            
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
            unset($data['data']['password_1']);
        }

        

        return $data;
    }
    
}
