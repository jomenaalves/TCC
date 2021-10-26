<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>
   <!-- PRODUTO NÃO ENCONTRADO -->
   <?php if(!isset($_GET['q'])): ?>
 
        <div class="searchProductToShow">
            <p>Pesquise por um produto</p>
            <form action="<?= BASE_URL . "/search"?>" method="get">
                <div class="flexSearch">
                    <input type="text" name="q" id="q" required>
                    <button><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>

    <?php else:?>
        <?php if($allProducts == []):?>
        <div class="productSearchDontExists">
            <p class="titleSeachProducts">Você pesquisou por "<?= mb_strimwidth($q, 0, 20, '...'); ?>"</p>
            <p class="subTitleSeachProducts">Não encontramos nenhum produto com esse nome</p>
            <button>Encontrar produtos <i class="fa fa-arrow-right"></i></button>
        </div>
        <?php else:?>

            <p class="whySearch">Porque você pesquisou por <span> "<?= mb_strimwidth($q, 0, 20, '...'); ?>" </span></p>
            <div class="listProducts">
                <?php foreach($allProducts as $product):?>
                    <a href="<?= BASE_URL . "/produto" . "/" . $product['id_product'] . "/" . strtolower(str_replace("/", "-", str_replace(" ", "-", $product['nome']))); ?>" class="itemSearched">
                        <div class="photo">
                            <img src="/Elegance/<?= $product['photoProduct']?>" alt="">
                        </div>
                        <div class="descriptionProduct">

                            <?php if ($product['InitialDiscount'] > 0) : ?>
                                <p class="previous-price">R$ <?= $product['InitialPrice'] ?></p>
                                <?php
                                $percent = (floatval($product['InitialPrice']) / 100) * $product['InitialDiscount'];

                                $totalFinal = floatval($product['InitialPrice']) - $percent;
                                $FinalPrice = number_format(floatval($totalFinal), 2);
                                ?>
                                <p class="price">R$ <?= $FinalPrice ?>
                                    <small></small>
                                    <span class="haveDiscount"><?= $product['InitialDiscount'] ?>% OFF</span>
                                </p>
                            <?php else : ?>
                                <p class="price">R$ <?= number_format(floatval($product['InitialPrice']), 2); ?>

                                </p>
                            <?php endif; ?>
                            <p class="desc">
                                <?= $product['nome'] ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach;?>
            </div>
    <?php endif;?>


   <?php endif;?>
    
    <footer>
    <div class="content">
        <div class="item">
            <p class="title">Informações</p>
            <div class="contacts">
                <span>Rua 9 de Junho ( Guariba - centro )</span>
                <span>Email: jomenaalves@gmail.com</span>
                <span>Tel: +55 (16) 99125-6598 </span>
            </div>
        </div>
        <div class="item">
            <p class="title">Redes sociais</p>
            <div class="social">
                <a href="">Facebook</a>
                <a href="">Instagram</a>
                <a href="">Youtube</a>
                <a href="">Twitter</a>
            </div>
        </div>
        <div class="item">
            <p class="title">Minha conta</p>

            <a href="">Entre</a>
        </div>
        <div class="item">
            <p class="title">Outros</p>
            <div class="outers">
                <a href="">Soluciar problemas</a>
                <a href="">Tornar-se um revendedor</a>
            </div>
        </div>
    </div>
</footer>
<section class="copyFooter">
    <p>Copyright © 1999-<?= date('Y') ?> elegance.com.br</p>
    <p>Desenvolvido por José Carlos Omena Alves e Ana Flávia Gomes da Silva</p>
</section>
<?php $this->end();?>