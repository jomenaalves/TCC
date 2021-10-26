<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>
<section class="succesPayment">
    <img src="assets/images/paymentSuccess.gif" alt="" width="200px">

    <p class="titlePayment">Compra feita com sucesso!</p>
    <span class="subPayment">Você pode acompanhar o progresso do produto no seu perfil!</span>

    <div class="statusCompra">
        <p class="titleContent">Status da compra</p>
        <div class="contentStatus">
            <div>
                <p>Produto</p>
                <p><?= $nameProduct ?></p>
            </div>
            <div class="valuePay">
                <span>Valor pago</span>
                <p> R$ <?= number_format($price, 2) ?></p>
            </div>
        </div>
    </div>

    <a href="<?= BASE_URL . "/"?>">Voltar as compras</a>
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

<?php $this->end(); ?>