<?php echo $this->extend('Admin/layout/principal_autenticacao');?>


<?php echo $this->section('titulo')?> <?php echo $titulo;?> <?php echo $this->endSection()?>


<?php echo $this->section('estilos')?>

<!-- Aqui enviamos para o template principal os estilos -->


<?php echo $this->endSection()?>





<?php echo $this->section('conteudo')?>

<div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                    <?php if(session()->has('sucesso')): ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Perfeito!</strong> <?php echo session('sucesso'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php endif; ?>



                    <?php if(session()->has('error')): ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Erro</strong> <?php echo session('error'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php endif; ?>


                    <?php if(session()->has('info')): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Informação</strong> <?php echo session('atencao'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php endif; ?>

                    <?php if(session()->has('atencao')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Atençao</strong> <?php echo session('atencao'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php endif; ?>


                    <div class="brand-logo">
                        <img src="<?php echo site_url('admin/') ?>images/logo.svg" alt="logo">
                    </div>
                    <h4>Olá, seja bem vindo(a)!</h4>
                    <h6 class="font-weight-light mb-3">Por favor realize o login.</h6>
                    <?php echo form_open('login/criar'); ?>
                        <div class="form-group">
                            <input type="email" name="email" value="<?php echo old('email'); ?>" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Digite o seu email">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Digite a sua senha">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >Conectar-se</button>
                        </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <a href="<?php echo site_url('password/esqueci') ?>" class="auth-link text-black">Esqueci minha senha</a>
                        </div>

                        <div class="text-center mt-4 font-weight-light">
                           Ainda não uma conta? <a href="<?php echo site_url('registrar') ?>" class="text-primary">Cadastrar-se</a>
                        </div>

                    <script type="text/javascript">
                        var LHCChatOptions = {};
                        LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
                        (function() {
                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                            var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
                            var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
                            po.src = 'http://localhost:8000/livehelperchat_laravel/index.php/por/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true?r='+referrer+'&l='+location;
                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                        })();
                    </script>
                    <?php form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- page-body-wrapper ends -->

<?php echo $this->endSection()?>



<?php echo $this->section('scripts')?>

<!-- Aqui enviamos para o template principal os scripts -->



<?php echo $this->endSection()?>




