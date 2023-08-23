<?php echo $this->extend('Layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
<?php echo $titulo; ?>
<?php echo $this->endSection();?>

<!-- area para estilos da view -->

<?php echo $this->section('estilos'); ?>

<?php echo $this->endSection();?>

<!-- area para conteudo da view -->

<?php echo $this->section('conteudo'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="block">
                    <div class="text-center">
                        <?php if($usuario->imagem == null): ?>
                            <img src="<?php echo site_url('recursos/img/usuario_sem_imagem.png');?>" class="card-img-top img-fluid">
                        <?php else: ?>
                            <img src="<?php echo site_url("usuarios/imagem/$usuario->imagem");?>" class="card-img-top" alt="<?php echo esc($usuario->nome); ?>" style="width: 90%">
                        <?php endif; ?>
                        <a href="<?php echo site_url("usuarios/editarimagem/$usuario->id") ?>" class="btn btn-outline-primary btn-sm mt-3">Alterar Imagem</a>
                    </div>
                </div>
                
            </div>
            <div class="col-md-9">
                <h5>Nome: <?php echo esc($usuario->nome);?></h5>
                <p class="card-title">Email: <?php echo esc($usuario->email);?></p>
                <p class="card-title"><?php echo esc($usuario->ativo == true ? 'Usuario Ativo' : 'Usuario Inativo');?></p>
                <p class="card-title">Criado: <?php echo esc($usuario->criado_em->humanize());?></p>
                <p class="card-title">Atualizado: <?php echo esc($usuario->atualizado_em->humanize());?></p>   
                <div class="dropdown show">
                    <a class="btn btn-danger btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo site_url("usuarios/editar/$usuario->id") ?>">Editar Usuario</a>
                        
                        <div class="dropdown-divider"></div>
                        <?php if($usuario->deletado_em == null): ?>
                            <a class="dropdown-item" href="<?php echo site_url("usuarios/excluir/$usuario->id") ?>">Excluir Usuario</a>
                        <?php else: ?>
                            <a class="dropdown-item" href="<?php echo site_url("usuarios/desfazerexclusao/$usuario->id") ?>">Desfazer Exclusao</a>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo site_url("usuarios") ?>" class="btn btn-sm btn-secondary ml-2">Voltar</a> 
                </div>  
                       
            </div>
        </div>
    </div>
    
<?php echo $this->endSection();?>

<!-- area para scripts da view -->

<?php echo $this->section('scripts'); ?>

<?php echo $this->endSection();?>