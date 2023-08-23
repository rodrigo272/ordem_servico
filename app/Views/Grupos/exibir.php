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
                <h5>Nome: <?php echo esc($grupo->nome);?></h5>
                    <p class="card-title">Descrição: <?php echo esc($grupo->descricao);?></p>
                    <p class="card-title">Criado: <?php echo esc($grupo->criado_em->humanize());?></p>
                    <p class="card-title">Atualizado: <?php echo esc($grupo->atualizado_em->humanize());?></p>   
                <div class="dropdown show">
                    <?php if($grupo->id > 2): ?>
                        <a class="btn btn-danger btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </a>
                        
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="<?php echo site_url("grupos/editar/$grupo->id") ?>">Editar Grupo</a>
                                
                                <div class="dropdown-divider"></div>
                                <?php if($grupo->deletado_em == null): ?>
                                    <a class="dropdown-item" href="<?php echo site_url("grupos/excluir/$grupo->id") ?>">Excluir Grupo</a>
                                <?php else: ?>
                                    <a class="dropdown-item" href="<?php echo site_url("grupos/desfazerexclusao/$grupo->id") ?>">Desfazer Exclusao</a>
                                <?php endif; ?>
                            </div>
                    <?php endif; ?>
                    <a href="<?php echo site_url("grupos") ?>" class="btn btn-sm btn-secondary ml-2">Voltar</a> 
                </div>  
                       
            </div>
        </div>
    </div>
    
<?php echo $this->endSection();?>

<!-- area para scripts da view -->

<?php echo $this->section('scripts'); ?>

<?php echo $this->endSection();?>