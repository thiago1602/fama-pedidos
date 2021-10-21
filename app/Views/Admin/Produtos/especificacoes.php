<?php echo $this->extend('Admin/layout/principal');?>


<?php echo $this->section('titulo')?> <?php echo $titulo;?> <?php echo $this->endSection()?>


<?php echo $this->section('estilos')?>



<?php echo $this->endSection()?>





<?php echo $this->section('conteudo')?>


                <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>


            </div>
            <div class="card-body">

                <?php  if(session()->has('errors_model')): ?>


                <ul>
                    <?php foreach (session('errors_model') as $error): ?>


                    <li class="text-danger">
                        <?php echo $error ?>

                    </li>
                            <?php endforeach; ?>
                </ul>

                <?php  endif; ?>


<hr class="mt-5 mb-3">

<div class="form-row">

    <div class="col-md-8">

        <?php if (!empty($produtoEspecificacoes)): ?>

        <p></p>
        <div class="alert alert-warning" role="alert">
  <h4 class="alert-heading">Well done!</h4>
  <p>Esse produto não possui especificações até o momento. Portanto ele <strong> não sera exibido </strong> como opção na área pública.</p>
  <hr>
  <p class="mb-0">Aproveite agora para cadastrar uma especificação do produto <strong> <?php echo esc($produto->nome);?></strong>.</p>
</div>

        <?php else: ?>

        <h4 class="card-title">Especificações do Produto</h4>
        <p class="card-description">
            <code>Aproveite para gerenciar as Especificações </code>
        </p>

        <div class="table-responsive">
            <table class="table table-hover">

                <thead>
                <tr>
                    <th>Preço</th>
                    <th>Customizavel</th>
                    <th class="text-center">Remover</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($produtoEspecificacoes as $especificacao): ?>

                <tr>
                    <td> R$&nbsp;<?php echo esc(number_format($especificacao->preco, 2)); ?></td>

                    <td><?php echo ($especificacao->customizavel ? '<label class="badge badge-primary">Sim</label>' : '<label class="badge badge-warning">Não</label>') ?></td>

                    <td class="text-center">

                        <button type="submit" class="btn badge badge-danger">&nbsp;X&nbsp;</button>

                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

            </table>


            <div class="mt-3">

            <?php echo $pager->links() ?>
</div>
        </div>

    </div>

</div>

<?php echo $this->endSection()?>



<?php echo $this->section('scripts')?>

<script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js');?>"></script>
<script src="<?php echo site_url('admin/vendors/mask/app.js');?>"></script>


<?php echo $this->endSection()?>