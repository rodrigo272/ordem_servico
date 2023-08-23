
   <div class="form-group">
       <label class="form-control-label">Nome Completo</label>
       <input type="text" name="nome" placeholder="Seu Nome" class="form-control" value="<?php echo esc($usuario->nome)?>">
   </div>
   <div class="form-group">       
        <label class="form-control-label">Email</label>
        <input type="email" name="email" placeholder="Seu email" class="form-control" value="<?php echo esc($usuario->email)?>">
   </div>
   <div class="form-group">       
        <label class="form-control-label">Senha</label>
        <input type="password" name="password" placeholder="Senha de acesso" class="form-control">
   </div>
   <div class="form-group">       
        <label class="form-control-label">Confirmar a Senha</label>
        <input type="password" name="password_1" placeholder="Senha de acesso" class="form-control">
   </div>

<div class="custom-control custom-checkbox">
    <input type="hidden" name="ativo" value="0">
    <input type="checkbox" class="custom-control-input" name="ativo" value="1" id="ativo" <?php if($usuario->ativo == true): ?> checked <?php endif; ?>>
    <label class="custom-control-label" for="ativo">Usuario Ativo</label>
</div>
   

                     
            
            
                
            
