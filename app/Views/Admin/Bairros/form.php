
<div class="form-row">

    <?php if (!$bairro->id):?>

    <div class="form-group col-md-4">
        <label for="cep">Cep</label>
        <input type="text" class="cep form-control" name="cep" value="<?php echo  old('cep',esc($bairro->cep) );?>">
        <div id="cep"></div>
    </div>

    <?php endif; ?>
    <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo  old('nome',esc($bairro->nome) );?>" readonly="">
    </div>

    <div class="form-group col-md-4">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" name="cidade" id="cidade" value="<?php echo  old('cidade',esc($bairro->cidade) );?>" readonly="">
    </div>

    <?php if (!$bairro->id):?>

        <div class="form-group col-md-4">
            <label for="estado">Estado</label>
            <input type="text" class="form-control" name="estado" id="estado" value="<?php echo  old('estado',esc($bairro->estado) );?>" readonly="">
        </div>

    <?php endif; ?>

    <div class="form-group col-md-4">
        <label for="estado">Valor de entrega</label>
        <input type="text" class="money form-control" name="valor_entrega" id="valor_entrega" value="<?php echo  old ('valor_entrega',esc($bairro->valor_entrega));?>">
    </div>
</div>

    <div class="form-group col-md-3">

        <label for="email">Ativo</label>


        <select class="form-control" name="ativo">
            <?php if($bairro->id): ?>

                <option value="1"  <?php echo set_select('ativo','1'); ?><?php echo ($bairro->ativo ? 'selected' : '');?> >Sim</option>
                <option value="0"  <?php echo set_select('ativo','0'); ?> <?php echo (!$bairro->ativo ? 'selected' : '');?>>Não</option>

            <?php else: ?>

                <option value="1">Sim</option>
                <option value="0" selected="">Nao</option>

            <?php endif; ?>
        </select>

    </div>



<button id="btn-salvar" type="submit" class="btn btn-primary mr-2 btn-sm">
    <i class="mdi mdi-checkbox-marked-circle btn-icon-prepend"></i>
    Salvar
</button>
