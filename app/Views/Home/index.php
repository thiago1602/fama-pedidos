<?php echo $this->extend('layout/principal_web');?>


<?php echo $this->section('titulo')?> <?php echo $titulo;?> <?php echo $this->endSection()?>


<?php echo $this->section('estilos')?>

<!-- Aqui enviamos para o template principal os estilos -->

<?php echo $this->endSection()?>


<?php echo $this->section('conteudo')?>

<!-- Begin Sections-->

<!--    About Us    -->

<!--    Menus   -->
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
    <div class="title-block">
        <h1 class="section-title">Conheça os nossos produtos</h1>
    </div>

    <!--    Menus filter    -->
    <div class="menu_filter text-center">
        <ul class="list-unstyled list-inline d-inline-block">

            <li id="todas" class="item active">
                <a href="javascript:;" class="filter-button" data-filter="todas">Todas</a>
            </li>

            <?php foreach ($categorias as $categoria): ?>

            <li class="item">
                <a href="javascript:;" class="filter-button" data-filter="<?php echo $categoria->slug; ?>"><?php echo esc( $categoria->nome); ?></a>
            </li>

            <?php endforeach; ?>

        </ul>
    </div>

    <!--    Menus items     -->
    <div id="menu_items">


        <div class="row">

            <?php foreach ($produtos as $produto): ?>


            <div class="col-sm-6 filtr-item image filter active <?php echo $produto->categoria_slug; ?>">


                <a href="<?php echo site_url('web/');?>src/assets/img/photos/food-1.jpg" class="block fancybox" data-fancybox-group="fancybox">
                    <div class="content">
                        <div class="filter_item_img">
                            <i class="fa fa-search-plus"></i>
                            <img src="<?php echo site_url("produto/imagem/$produto->imagem");?> " alt="<?php echo esc($produto->nome); ?>" />
                        </div>
                        <div class="info">
                            <div class="name"><?php echo esc($produto->nome);?></div>
                            <span class="filter_item_price">A partir de R$&nbsp; <?php echo esc(number_format($produto->preco,2));?></span>
                        </div>
                    </div>
                </a>
            </div>

            <?php endforeach; ?>

        </div>

    </div>
</div>


<!-- End Sections -->


<?php echo $this->endSection()?>





<?php echo $this->section('scripts')?>

<!-- Aqui enviamos para o template principal os scripts -->



<?php echo $this->endSection()?>




