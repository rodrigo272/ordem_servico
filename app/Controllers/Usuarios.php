<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Entities\Usuario;

class Usuarios extends BaseController
{
    private $usuarioModel;

    public function __construct(){

        $this->usuarioModel = new \App\Models\UsuarioModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando os Usuarios do sistema', 
        ];

        return  view('Usuarios/index',$data);
    }

    public function recuperaUsuarios(){

        if(!$this->request->isAJAX()){

            return redirect()->back();

        }

        $atributos = [
            'id',
            'nome',
            'email',
            'ativo',
            'imagem',
        ];

        $data = [];

        $usuarios = $this->usuarioModel->select($atributos)
                          //Tirar o comentario abaixo para mostrar os usuarios deletados  
                         //->withDeleted(true)
                         ->orderBy('id','DESC')   
                         ->findAll();
        
        foreach($usuarios as $usuario){

            $nome = esc($usuario->nome);

            if($usuario->imagem != null){

                $imagem = [
                    'src' => site_url("usuarios/imagem/$usuario->imagem"),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => esc($usuario->nome),
                    'width' => '50',
                ];

            }else{
                $imagem = [
                    'src' => site_url("recursos/img/usuario_sem_imagem.png"),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => 'Usuario sem imagem',
                    'width' => '50',
                ];
            }

            $data[] = [
                'nome'  => anchor("usuarios/exibir/$usuario->id", esc($usuario->nome), 'title="Exibir usuário '.$nome.' "'),
                'email' => esc($usuario->email),
                'ativo' => ($usuario->ativo == true ? '<i class="fa fa-unlock-alt text-success"></i>&nbsp;Ativo' : '<i class="fa fa-lock text-warning"></i>&nbsp;Inativo'),
                'imagem' => $usuario->imagem = img($imagem),
            ];
        }

        $retorno = [
            'data' => $data,
        ];

        return $this->response->setJSON($retorno);
    }

    public function exibir(int $id = null){

        $usuario = $this->buscaUsuario($id);

       

        $data = [
            'titulo' => "Detalhando o usuario " .esc($usuario->nome),
            'usuario' => $usuario,
        ];

        return view('Usuarios/exibir', $data);

    }

    public function buscaUsuario(int $id = null){

        if(!$id || !$usuario = $this->usuarioModel->withDeleted(true)->find($id)){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuario $id");
        }

        return $usuario;
    }

    public function editar(int $id = null){

        $usuario = $this->buscaUsuario($id);

       

        $data = [
            'titulo' => "Editando o usuario " .esc($usuario->nome),
            'usuario' => $usuario,
        ];

        return view('Usuarios/editar', $data);

        
    }

    public function atualizar(){

        if(!$this->request->isAJAX()){

            return redirect()->back();

        }

        //Envio o hash do token do form
        $retorno['token'] = csrf_hash();
        //Recupero o post da requisição
        $post = $this->request->getPost();

        //Validamos a existencia do usuario
        $usuario = $this->buscaUsuario($post['id']);

        
        if(empty($post['password'])){
            unset($post['password']);
            unset($post['password_1']);
            
        }

      


        //Preenchemos os atributos do Usuario com o metodo post
        $usuario->fill($post);

       if($usuario->hasChanged() == false){

            $retorno['info'] = 'Não há dados para serem atualizados';
             //Retorno para o ajax request
            return $this->response->setJSON($retorno);
        }
        
        if($this->usuarioModel->protect(false)->save($usuario)){

            session()->setFlashdata('sucesso','Dados salvos com sucesso');

            return $this->response->setJSON($retorno);

        }

        $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->usuarioModel->errors();
        
        return $this->response->setJSON($retorno);
        

        

    }

    public function criar(){

        $usuario = new Usuario(); 

       

        $data = [
            'titulo' => "Cadastro de usuario ",
            'usuario' => $usuario,
           
        ];

        return view('Usuarios/criar', $data);
       
    }

    public function cadastrar(){

        if(!$this->request->isAJAX()){

            return redirect()->back();

        }

        //Envio o hash do token do form
        $retorno['token'] = csrf_hash();
        //Recupero o post da requisição
        $post = $this->request->getPost();

        //Crio novo objeto da entidade Usuario
        $usuario = new Usuario($post);

       
        
        if($this->usuarioModel->protect(false)->save($usuario)){

            $btnCriar = anchor("usuarios/criar", 'Cadastrar novo usuário', ['class' => 'btn btn-danger mt-3']);

            session()->setFlashdata('sucesso',"Dados salvos com sucesso!<br> $btnCriar");

            // Retornamos o ultimo ID inserido na tabela de Usuario
            //o Id do usuario recem-criado    
            $retorno['id'] = $this->usuarioModel->getInsertID();

            return $this->response->setJSON($retorno);

        }

        $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
        $retorno['erros_model'] = $this->usuarioModel->errors();
        
        return $this->response->setJSON($retorno);
        
   }

   public function editarimagem(int $id = null){
        
        $usuario = $this->buscaUsuario($id);

        $data = [
            'titulo' => "Alterando a imagem do usuario " .esc($usuario->nome),
            'usuario' => $usuario,
        ];

        return view('Usuarios/editar_imagem', $data);

    
    }

    public function upload(){

        if(!$this->request->isAJAX()){

            return redirect()->back();

        }

        $retorno['token'] = csrf_hash();

        $validacao = service('validation');

        $regras = [
            'imagem' => 'uploaded[imagem]|max_size[imagem,2048]|ext_in[imagem,png,jpg,jpeg,webp]',
        ];

        $mensagens = [
            'imagem' => [
                'uploaded' => 'Por favor, escolha uma imagem',
                'max_size' => 'O tamanho do arquivo é maior do que 2m',
                'ext_in' => 'Escolha uma extensão que seja: png,jpeg ou webp',
            ],
                
        ];

        $validacao->setRules($regras,$mensagens);

        if($validacao->withRequest($this->request)->run() == false){

            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = $validacao->getErrors();
        
            return $this->response->setJSON($retorno);

            
        }

        
             
        //Recupero o post da requisição
        $post = $this->request->getPost();

        //Validamos a existencia do usuario
        $usuario = $this->buscaUsuario($post['id']);

        //Recuperamos a imagem
        $imagem = $this->request->getFile('imagem');

        list($largura, $altura) = getimagesize($imagem->getPathName());

        if($largura < "300" || $altura < "300"){

            $retorno['erro'] = 'Por favor, verifique os erros abaixo e tente novamente';
            $retorno['erros_model'] = ['dimensao' => 'A imagem não pode ser menor do que 300 x 300 pixels'];
        
            return $this->response->setJSON($retorno);

        }

        $caminhoImagem = $imagem->store('usuarios');

        $caminhoImagem = WRITEPATH . "uploads/$caminhoImagem";

        //Chama o metodo manipula imagem
       
            $this->manipulaImagem($caminhoImagem, $usuario->id);

       

            $imagemAntiga = $usuario->imagem;

            $usuario->imagem = $imagem->getName();

            
            $this->usuarioModel->save($usuario);

            if($imagemAntiga != null){
                $this->removeImagemAntiga($imagemAntiga);
            }

            

            session()->setFlashdata('sucesso','A Imagem foi atualizada com sucesso!');

            return $this->response->setJSON($retorno);
    
        }

        private function removeImagemAntiga(string $imagem){

            $caminhoImagem = WRITEPATH . "uploads/usuarios/$imagem";

            if(is_file($caminhoImagem)){
                unlink($caminhoImagem);
            }
        }

        private function manipulaImagem(string $caminhoImagem, int $usuario_id){

         //Redimensionamos a imagem para 300 x 300
        service('image')
        ->withFile($caminhoImagem)
        ->fit(300,300,'center')
        ->save($caminhoImagem);

        //Adicionar Marca d'agua na imagem

        $anoAtual = date('Y');
    
        \Config\Services::image('imagick')
            ->withFile($caminhoImagem)
            ->text("Ordem $anoAtual - User-ID $usuario_id", [
                'color' => '#fff',
                'opacity' => 0.5,
                'withShadow' => false,
                'hAlign' => 'center',
                'vAlign' => 'bottom',
                'fontSize' => 10 
            ])
            ->save($caminhoImagem);
        }

        public function imagem(string $imagem = null){

            if($imagem != null){
                $this->exibeArquivo('usuarios',$imagem);
            }

        }

        public function excluir(int $id = null){

            $usuario = $this->buscaUsuario($id);

            if($usuario->deletado_em != null){
                return redirect()->back()->with('info' ,"Usuario já foi excluido da base de dados");
            }

            if($this->request->getMethod() === 'post'){

                $this->usuarioModel->delete($id);

                if($usuario->imagem != null){

                    $this->removeImagemAntiga($usuario->imagem);
                }

                $usuario->imagem = null;
                $usuario->ativo = false;

                $this->usuarioModel->protect(false)->save($usuario);

                return redirect()->to(site_url("usuarios"))->with('sucesso',"Usuario $usuario->nome excluido com sucesso");
            }
           
    
            $data = [
                'titulo' => "Excluindo o usuario " .esc($usuario->nome),
                'usuario' => $usuario,
            ];
    
            return view('Usuarios/excluir', $data);
    
        }

    
}
