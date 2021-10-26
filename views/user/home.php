<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<style>
    body {
        background-color: #f3f4f5 !important;
    }
</style>
<link rel="stylesheet" href="assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>



<section class="apresentation">

    <div class="content">
        <h1>Produtos Incríveis</h1>
        <p>não deixe para depois o quê você pode comprar agora</p>
        <a href="">Explorar</a>
    </div>

    <svg id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0">
                <stop stop-color="rgba(243, 243, 244, 1)" offset="0%"></stop>
                <stop stop-color="rgba(243, 244, 245, 1)" offset="100%"></stop>
            </linearGradient>
        </defs>
        <path style="transform:translate(0, 0px); opacity:1" fill="#fff" d="M0,0L720,40L1440,0L2160,80L2880,20L3600,20L4320,80L5040,20L5760,20L6480,50L7200,30L7920,60L8640,30L9360,10L10080,30L10800,0L11520,70L12240,0L12960,30L13680,60L14400,60L15120,30L15840,0L16560,70L17280,70L17280,100L16560,100L15840,100L15120,100L14400,100L13680,100L12960,100L12240,100L11520,100L10800,100L10080,100L9360,100L8640,100L7920,100L7200,100L6480,100L5760,100L5040,100L4320,100L3600,100L2880,100L2160,100L1440,100L720,100L0,100Z"></path>
    </svg>
</section>
<section class="information">
    <div class="content">
        <div class="content-info">
            <div class="icon">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <div class="text">
                <p>Rápida Entrega</p>
                <span>Receba rapidamente o quê você comprou</span>
            </div>
        </div>
        <div class="content-info">
            <div class="icon">
                <i class="fas fa-undo"></i>
            </div>
            <div class="text">
                <p>Dinheiro de volta</p>
                <span>Não gostou do que comprou? Devolva!</span>
            </div>
        </div>
        <div class="content-info">
            <div class="icon">
                <i class="fas fa-lock"></i>
            </div>
            <div class="text">
                <p>Você está seguro</p>
                <span>Seu produto e seu dinheiro estão seguros conosco</span>
            </div>
        </div>
</section>

<p class="title-apresentation">Busca por categorias</p>
<section class="gender">
    <div class="conntent">
        <div class="gender-item">
            <a href="<?= BASE_URL . "/filters" ?>?sex=masculino">
                <div class="photo mascPhoto"></div>
                <div class="text">Moda Masculina</div>
            </a>
        </div>
        <div class="gender-item">
            <a href="<?= BASE_URL . "/filters" ?>?sex=feminino">
                <div class="photo femPhoto"></div>
                <div class="text">Moda Feminina</div>
            </a>
        </div>
        <div class="gender-item">
            <a href="<?= BASE_URL . "/filters" ?>?sex=unissex">
                <div class="photo noGender"></div>
                <div class="text">Unissex</div>
            </a>
        </div> 
        
        <div class="gender-item">
            <a href="<?= BASE_URL . "/filters" ?>?sex=meninos">
                <div class="photo kidPhoto"></div>
                <div class="text">Meninos</div>
            </a>
        </div>
        <div class="gender-item">
            <a href="<?= BASE_URL . "/filters" ?>?sex=meninas">
                <div class="photo girlPhoto"></div>
                <div class="text">Meninas</div>
            </a>
        </div>
        <div class="gender-item">
            <a href="<?= BASE_URL . "/filters" ?>?sex=bebes">
                <div class="photo baby"></div>
                <div class="text">BebÊs</div>
            </a>
        </div>
        <div class="nextSection">
            <i class="fa fa-arrow-right"></i>
        </div>
        <div class="prevSection">
            <i class="fa fa-arrow-left"></i>
        </div>
    </div>
    <div class="countQtdCategories">
        <div class="item active"></div>
        <div class="item"></div>
    </div>
</section>

<p class="title-apresentation">Ultimos adicionados</p>
<section class="lastAdd">
    <div class="contentLastAdd">
        <?php foreach ($lastProducts as $item) : ?>
            <a class="item" href="<?= BASE_URL . "/produto" . "/" . $item['id_product'] . "/" . strtolower(str_replace("/", "-", str_replace(" ", "-", $item['nome']))); ?>">
                <div class="photo">
                    <img src="/Elegance/<?= $item['photoProduct'] ?>" alt="">
                </div>
                <div class="content-item">
                    <?php if ($item['InitialDiscount'] > 0) : ?>
                        <p class="previous-price">R$ <?= $item['InitialPrice'] ?></p>
                        <?php
                        $percent = (floatval($item['InitialPrice']) / 100) * $item['InitialDiscount'];

                        $totalFinal = floatval($item['InitialPrice']) - $percent;
                        $FinalPrice = number_format(floatval($totalFinal), 2);
                        ?>
                        <p class="price">R$ <?= $FinalPrice ?>
                            <small></small>
                            <span class="haveDiscount"><?= $item['InitialDiscount'] ?>% OFF</span>
                        </p>
                    <?php else : ?>
                        <p class="price">R$ <?= number_format(floatval($item['InitialPrice']), 2); ?>

                        </p>
                    <?php endif; ?>

                    <p class="desc">
                        <?= $item['nome'] ?>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>

        <div class="nextBtnToLastAdd">
            <i class="fa fa-arrow-right"></i>
        </div>
        <div class="prevBtnToLastAdd">
            <i class="fa fa-arrow-left"></i>
        </div>
    </div>
</section>


<p class="title-apresentation">Os mais vendidos</p>
<section class="top-sellers">

    <?php foreach($bestSellers as $item):?>
        <a href="<?= BASE_URL . "/produto" . "/" . $item['id_product'] . "/" . strtolower(str_replace("/", "-", str_replace(" ", "-", $item['nome']))); ?>" class="item-seller">
            <div class="photo">
                <img src="<?= BASE_URL  ."/". $item['photoProduct']?>" alt="">
            </div>
            <div class="content-item">
                    <?php if ($item['InitialDiscount'] > 0) : ?>
                        <p class="previous-price">R$ <?= $item['InitialPrice'] ?></p>
                        <?php
                        $percent = (floatval($item['InitialPrice']) / 100) * $item['InitialDiscount'];

                        $totalFinal = floatval($item['InitialPrice']) - $percent;
                        $FinalPrice = number_format(floatval($totalFinal), 2);
                        ?>
                        <p class="price">R$ <?= $FinalPrice ?>
                            <small></small>
                            <span class="haveDiscount"><?= $item['InitialDiscount'] ?>% OFF</span>
                        </p>
                    <?php else : ?>
                        <p class="price">R$ <?= number_format(floatval($item['InitialPrice']), 2); ?>

                        </p>
                    <?php endif; ?>

                    <p class="desc">
                        <?= $item['nome'] ?>
                    </p>
                </div>
        </a>
    <?php endforeach; ?>

    <div class="next-button" data-nextButton="next">
        <i class="fa fa-arrow-right"></i>
    </div>
    <div class="prev-button" data-prevButton="prev">
        <i class="fa fa-arrow-left"></i>
    </div>
</section>


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


<?php $this->end() ?>
<?php $this->unshift('scrs') ?>
<script src="assets/js/HomeController.js"></script>


<?php $this->end() ?>