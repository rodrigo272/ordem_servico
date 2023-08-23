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
        <div class="col-md-6">
            <div class="block-body">

                <!-- No form_open, No 1 parametro '/', esta determinando para onde os dados vao ir -->
                <?php echo form_open("usuarios/excluir/$usuario->id"); ?>

                <div class="alert alert-warning" role="alert">
                    Tem certeza da exclusão do registro?
                </div>

                <div class="form-group mt-5 mb-2">
                    <input id="envio" type="submit" value="Sim, pode excluir" class="btn btn-danger mr-2 btn-sm">
                    <a href="<?php echo site_url("usuarios/exibir/$usuario->id")?>"
                        class="btn btn-secondary ml-2 btn-sm">Cancelar</a>
                </div>
                <?php echo form_close(); ?>
            </div>

        </div>

    </div>
</div>

<?php echo $this->endSection();?>

<!-- area para scripts da view -->

<?php echo $this->section('scripts'); ?>


<?php echo $this->endSection();?>