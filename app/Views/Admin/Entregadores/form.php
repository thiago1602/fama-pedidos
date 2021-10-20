
<div class="form-row">

    <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo  old('nome',esc($entregador->nome) );?>">
    </div>


</div>


<div class="form-row">


    <div class="form-group col-md-3">

        <label for="email">Ativo</label>


        <select class="form-control" name="ativo">
            <?php if($entregador->id): ?>

                <option value="1"  <?php echo set_select('ativo','1'); ?><?php echo ($entregador->ativo ? 'selected' : '');?> >Sim</option>
                <option value="0"  <?php echo set_select('ativo','0'); ?> <?php echo (!$entregador->ativo ? 'selected' : '');?>>Não</option>

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
