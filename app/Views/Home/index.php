<?php echo $this->extend('Layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
<?php echo $titulo; ?>
<?php echo $this->endSection();?>

<!-- area para estilos da view -->

<?php echo $this->section('estilos'); ?>

<?php echo $this->endSection();?>

<!-- area para conteudo da view -->

<?php echo $this->section('conteudo'); ?>

<?php echo $this->endSection();?>

<!-- area para scripts da view -->

<?php echo $this->section('scripts'); ?>

<?php echo $this->endSection();?>