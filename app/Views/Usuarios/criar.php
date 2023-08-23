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
                    <!-- Exibira os retornos do back-end -->
                    <div id="response">

                    </div>
                    <!-- No form_open, No 1 parametro '/', esta determinando para onde os dados vao ir -->
                    <?php echo form_open('/',['id' => 'form'],['id' => "$usuario->id"]); ?>

                    <?php echo $this->include('Usuarios/_form'); ?>
                    <div class="form-group mt-5 mb-2">
                        <input id="envio" type="submit" value="Salvar" class="btn btn-danger mr-2 btn-sm">
                        <a href="<?php echo site_url("usuarios")?>" class="btn btn-secondary ml-2 btn-sm">Voltar</a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                
            </div>
            
        </div>
    </div>
    
<?php echo $this->endSection();?>

<!-- area para scripts da view -->

<?php echo $this->section('scripts'); ?>

<script>
    $(document).ready(function(){
 
        $("#form").on('submit',function(e){
        e.preventDefault();

            $.ajax({
                type: "POST",
                url:'<?php echo site_url('usuarios/cadastrar'); ?>',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $("#response").html('');
                    $("#envio").val('Aguarde');
                    
                },
                success: function(response){
                    $("#envio").removeAttr("disabled");
                    $("#envio").val('Salvar');
                    $('[name=csrf_test_name]').val(response.token);

                    if(!response.erro){

                        

                        if(response.info){

                            $("#response").html('<div class="alert alert-info" role="alert">'+ response.info +'</div>');
                           
                        }else{
                            //Tudo certo
                            window.location.href = "<?php echo site_url("usuarios/exibir/");?>" + response.id;
                        }

                    }else{
                        //Existem erro de validação
                        $("#response").html('<div class="alert alert-danger" role="alert">'+ response.erro +'</div>');
                    }

                    if(response.erros_model){

                        
                        $.each(response.erros_model, function(key,value){

                            $("#response").append('<ul class="list-unstyled"><li class="text-danger">'+ value +'</li></ul>');
                            
                        });
                    }
                },
                error: function(){
                    alert('Verificar o erro');
                    $("#envio").removeAttr("disabled");
                    $("#envio").val('Salvar');
                }
                
             });
        

             
   

 
        });

        $("#form").submit(function(){

            $(this).find(":submit").attr('disabled','disabled');

        });
    });
</script>

<?php echo $this->endSection();?>

  