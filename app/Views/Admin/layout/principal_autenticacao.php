<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fama Pedidos| <?php echo $this->renderSection('titulo')?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href=" <?php echo site_url('admin/'); ?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href=" <?php echo site_url('admin/'); ?>vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href=" <?php echo site_url('admin/'); ?>css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo site_url('admin/'); ?>images/favicon.png" />

    <!-- Renderiza os estilos especificos da view que estender o layout-->
    <?php echo $this->renderSection('estilos')?>
</head>

<body>
<div class="container-scroller">


    <!-- Renderiza os estilos especificos da view que estender o layout-->
    <?php echo $this->renderSection('conteudo')?>


</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="<?php echo site_url('admin/'); ?>vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="<?php echo site_url('admin/'); ?>js/off-canvas.js"></script>
<script src="<?php echo site_url('admin/'); ?>js/hoverable-collapse.js"></script>
<script src="<?php echo site_url('admin/'); ?>js/template.js"></script>
<!-- endinject -->
</body>

</html>


