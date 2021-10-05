<?php echo $this->extend('Admin/layout/principal');?>


<?php echo $this->section('titulo')?> <?php echo $titulo;?> <?php echo $this->endSection()?>


<?php echo $this->section('estilos')?>

<!-- Aqui enviamos para o template principal os estilos -->

<link rel="stylesheet" href="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.css');?>"/>


<?php echo $this->endSection()?>





<?php echo $this->section('conteudo')?>


<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $titulo; ?></h4>

                <div class="ui-widget">
                    <input id="query" name="query" placeholder="Pesquise por um usuario" class="form-control bg-light mb-5">
                </div>

                <a href="<?php echo site_url("admin/usuarios/criar");?>" class="btn btn-success float-right mb-5">
                    <i class="mdi mdi-plus btn-icon-prepend"></i>
                    Cadastrar
                </a>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Cpf</th>
                            <th>Ativo</th>
                            <th>Situação</th>
                        </tr>
                        </thead>
                        <tbody>


                        <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url("admin/usuarios/show/$usuario->id"); ?>"><?php echo $usuario->nome;?></a>

                            <td><?php echo $usuario->email?></td>
                            <td><?php echo $usuario->cpf?></td>

                            <td><?php echo ($usuario->ativo && $usuario->deletado_em == null ? '<label class="badge badge-primary">Sim</label>' : '<label class="badge badge-primary">Não</label>'); ?></td>

                            <td>
                                <?php echo ($usuario->deletado_em == null ? '<label class="badge badge-primary">Disponivel</label>' : '<label class="badge badge-primary">Excluido</label>'); ?>

                                <?php if ($usuario->deletado_em != null): ?>

                                    <a href="<?php echo site_url("admin/usuarios/desfaserexclusao/$usuario->id");?>" class="badge badge-dark ml-2">
                                        <i class="mdi mdi-undo btn-icon-prepend"></i>
                                        Desfaser
                                    </a>

                                <?php endif; ?>

                            </td>
                        </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <?php echo $pager->links()?>
                </div>
            </div>
        </div>
    </div>

</div>


<?php echo $this->endSection()?>





<?php echo $this->section('scripts')?>

<!-- Aqui enviamos para o template principal os scripts -->

<script src="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.js');?>"></script>


<script>
    $(function (){

        $( "#query" ).autocomplete({
            source: function (request, response){
                $.ajax({

                    url: "<?php echo site_url('admin/usuarios/procurar'); ?>",
                    dataType: "json",
                    data:{
                      term: request.term
                    },
                    success: function (data){

                        if (data.length < 1){

                            var data = [
                                {
                                    label: 'Usuario não encontrado',
                                    value: -1
                                }
                            ];
                        }
                        response(data); //Aqui temos valor no data
                        },
                    
                }); //fim ajax
            },
    minLength: 1,
            select: function (event, ui){
                if(ui.item.value == -1){

                    $(this).val("");
                    return false;
                }else{
                    window.location.href = '<?php echo site_url('admin/usuarios/show/')?>' + ui.item.id;
                }
            }

        }); //fim autocomplete
    });

</script>

<script>var LHC_API = LHC_API||{};
    LHC_API.args = {mode:'widget',lhc_base_url:'//localhost:8000/livehelperchat-master/lhc_web/index.php/',wheight:450,wwidth:350,pheight:520,pwidth:500,leaveamessage:true,check_messages:false,lang:'por/'};
    (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.setAttribute('crossorigin','anonymous'); po.async = true;
        var date = new Date();po.src = 'http://localhost:8000/livehelperchat-master/lhc_web/design/defaulttheme/js/widgetv2/index.js?'+(""+date.getFullYear() + date.getMonth() + date.getDate());
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    })();
</script>

<?php echo $this->endSection()?>
