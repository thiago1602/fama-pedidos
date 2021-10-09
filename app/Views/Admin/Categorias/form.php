
<div class="form-row">

    <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo  old('nome',esc($usuario->nome) );?>">
    </div>

</div>


<div class="form-row">

    <div class="form-group col-md-3">
        <label for="password">Senha</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <div class="form-group col-md-3">
        <label for="confirmation_password">Confirmar Senha</label>
        <input type="password" class="form-control" name="password_confirmation" id="confirmation_password">
    </div>

    <div class="form-group col-md-3">

        <label for="email">Perfil de acesso</label>


        <select class="form-control" name="is_admin">
            <?php if($usuario->id): ?>

                <option value="1"  <?php echo set_select('is_admin','1'); ?> <?php echo ($usuario->is_admin ? 'selected' : '');?>>Administrador</option>
                <option value="0" <?php echo set_select('is_admin','0'); ?> <?php echo (!$usuario->is_admin ? 'selected' : '');?>>Cliente</option>

            <?php else: ?>

                <option value="1" <?php echo set_select('is_admin','1'); ?> >Sim</option>
                <option value="0" <?php echo set_select('is_admin','0'); ?> selected="">Nao</option>

            <?php endif; ?>
        </select>

    </div>
    <div class="form-group col-md-3">

        <label for="email">Ativo</label>


        <select class="form-control" name="ativo">
            <?php if($usuario->id): ?>

                <option value="1"  <?php echo set_select('ativo','1'); ?><?php echo ($usuario->ativo ? 'selected' : '');?> >Sim</option>
                <option value="0"  <?php echo set_select('ativo','0'); ?> <?php echo (!$usuario->ativo ? 'selected' : '');?>>Não</option>

            <?php else: ?>

                <option value="1">Sim</option>
                <option value="0" selected="">Nao</option>

            <?php endif; ?>
        </select>

    </div>

</div>

<div class="form-check form-check-flat form-check-primary">

</div>



<button type="submit" class="btn btn-primary mr-2 btn-sm">
    <i class="mdi mdi-checkbox-marked-circle btn-icon-prepend"></i>
    Salvar
</button>
