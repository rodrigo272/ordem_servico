<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Grupo;

class Grupos extends BaseController
{

    private $grupoModel;

    public function __construct(){

        $this->grupoModel = new \App\Models\grupoModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando os Grupos do sistema', 
        ];

        return  view('Grupos/index',$data);
    }

    public function criar(){

        $grupo = new Grupo();

       
        $data = [
            'titulo' => "Criando o novo Grupo de Acesso",
            'grupo' => $grupo,
        ];

        return view('Grupos/criar', $data);

    }

    public function cadastrar(){

        if(!$this->request->isAJAX()){

            return redirect()->back();

        }

        //Envio o hash do token do form
        $retorno['token'] = csrf_hash();
        //Recupero o post da requisição
        $post = $this->request->getPost();

        //Crio novo objeto da entidade Grupo
        $grupo = new Grupo($post);

       
        
        if($this->grupoModel->save($grupo)){

            $btnCriar = anchor("Grupos/criar", 'Cadastrar novo grupo', ['class' => 'btn btn-danger mt-3']);

            session()->setFlashdata('sucesso',"Dados salvos com sucesso!<br> $btnCriar");

            // Retornamos o ultimo ID inserido na tabela de Grupo
            //o Id do Grupo recem-criado    
            $retorno['id'] = $this->grupoModel->getInsertID();

            return $this->response->setJSON($retorno);

        }

        $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->grupoModel->errors();
        
        return $this->response->setJSON($retorno);
        
   }

    public function recuperaGrupos(){

        if(!$this->request->isAJAX()){

            return redirect()->back();

        }

        $atributos = [
            'id',
            'nome',
            'descricao',
            'exibir',
            'deletado_em',
        ];

        $grupos = $this->grupoModel->select($atributos)
                         //->withDeleted(true)
                         ->orderBy('id','DESC')   
                         ->findAll();

        $data = [];

        
        foreach($grupos as $grupo){

            $data[] = [
                'nome'  => anchor("grupos/exibir/$grupo->id", esc($grupo->nome), 'title="Exibir Grupo '.esc($grupo->nome).' "'),
                'descricao' => esc($grupo->descricao),
                'exibir' => ($grupo->exibir == true ? '<i class="fa fa-eye text-secondary"></i>&nbsp;Exibir grupo' : '<i class="fa fa-eye-slash text-danger"></i>&nbsp;Não Exibir grupo'),
                
            ];
        }

        $retorno = [
            'data' => $data,
        ];

        return $this->response->setJSON($retorno);
    }

    public function exibir(int $id = null){

        $grupo = $this->buscaGrupo($id);

       

        $data = [
            'titulo' => "Detalhando o Grupo " .esc($grupo->nome),
            'grupo' => $grupo,
        ];

        return view('Grupos/exibir', $data);

    }

    public function buscaGrupo(int $id = null){

        if(!$id || !$grupo = $this->grupoModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o grupo de acesso $id");
        }

        return $grupo;
    }

    public function editar(int $id = null){

        $grupo = $this->buscaGrupo($id);

        if($grupo->id < 3){
            return redirect()->back()->with('atencao', 'O grupo '.esc($grupo->nome). ' não pode ser editado');
        }

       

        $data = [
            'titulo' => "Editando o Grupo " .esc($grupo->nome),
            'grupo' => $grupo,
        ];

        return view('Grupos/editar', $data);

    }

    public function atualizar(){

        if(!$this->request->isAJAX()){

            return redirect()->back();

        }

        //Envio o hash do token do form
        $retorno['token'] = csrf_hash();
        //Recupero o post da requisição
        $post = $this->request->getPost();

        //Validamos a existencia do Grupo
        $grupo = $this->buscaGrupo($post['id']);

        
        if($grupo->id < 3){
            return redirect()->back()->with('atencao', 'O grupo <b> '.esc($grupo->nome). ' não pode ser editado');

           /* $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['grupo' => 'O grupo <b>'.esc($grupo->nome). ' não pode ser editado'];
            return $this->response->setJSON($retorno);*/
        }
      
        //Preenchemos os atributos do Grupo com o metodo post
        $grupo->fill($post);

       if($grupo->hasChanged() == false){

            $retorno['info'] = 'Não há dados para serem atualizados';
             //Retorno para o ajax request
            return $this->response->setJSON($retorno);
        }
        
        if($this->grupoModel->protect(false)->save($grupo)){

            session()->setFlashdata('sucesso','Dados salvos com sucesso');

            return $this->response->setJSON($retorno);

        }

        $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->grupoModel->errors();
        
        return $this->response->setJSON($retorno);
        

        

    }
}
