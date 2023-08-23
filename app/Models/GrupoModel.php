<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{
    
    protected $table            = 'grupos';
    protected $returnType       = 'App\Entities\Grupo';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'nome',
        'descricao',
        'exibir'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules      = [
    'nome'         => 'required|min_length[3]|max_length[40]|is_unique[grupos.nome,id,{id}]',
	'descricao'    => 'required|min_length[3]|max_length[130]', // Não pode ter espaços
	
    ];
    protected $validationMessages   = [
        'nome' => [
            'required' => 'O campo nome é obrigatório',
            'min_length' => 'O campo nome precisa ter pelo menos 3 caracteres!',
        ],
        'descricao' => [
            'required' => 'O campo descrição é obrigatório',
           
        ]
       
       
    ];
}
