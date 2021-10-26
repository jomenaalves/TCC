<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="./../assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>
    

    <div class="contentPerfilUser">
        <nav>
            <p class="titleNav">Minha conta</p>
            <ul>
                <a href="<?= BASE_URL . "/user/perfil"?>"> <i class="fas fa-map-marker-alt"></i> <p>Endereços</p></a>
                <a href="<?= BASE_URL . "/user/pedidos"?>"> <i class="fas fa-box"></i> <p>Pedidos</p></a>
                <a href="<?= BASE_URL . "/user/avaliacoes"?>"> <i class="fas fa-star"></i> <p>Avaliações</p></a>
                <a href="<?= BASE_URL . "/user/carteira"?>"> <i class="fas fa-wallet"></i> <p>Carteira</p></a>
                <a href="<?= BASE_URL . "/exit"?>"> <i class="fas fa-sign-out-alt"></i> <p>Sair</p></a>
            </ul>
        </nav>
        <main class="mainPerfil">
            <div class="MainRatings">
                
                <div class="allProductsPurchased">
                    <p class="titleRatings">Avaliações <i class="fas fa-star"></i></p>
                    <span class="subRatings">Avalie o produto quê você recebeu, isso nos ajuda a cada vez mais melhorarmos  a qualidade dos nossos produtos</span>
                    
                    <div class="contentProducts">
                        <?php foreach($avaliables as $product): ?>
                            <div class="productToBeEvaluated" id="<?= $product['id']?>"  <?php if($product['already_rated'] == 0): ?> data-currentRating="0" <?php else: ?> data-currentRating="<?= $product['totalStars']?>" <?php endif; ?>>
                                <div class="photo">
                                    <img src="<?= BASE_URL . "/" . $product['photoProduct']?>" alt="">
                                </div>
                                <div class="contentEvaluated">
                                    <p class="titleContentEvaluated">Avalie</p>
                                    <div class="rate" data-idFrom="<?= $product['id']?>">
                                        <div class="stars" data-id="1"><i class="fas fa-star"></i></div>
                                        <div class="stars" data-id="2"><i class="fas fa-star"></i></div>
                                        <div class="stars" data-id="3"><i class="fas fa-star"></i></div>
                                        <div class="stars" data-id="4"><i class="fas fa-star"></i></div>
                                        <div class="stars" data-id="5"><i class="fas fa-star"></i></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>

            </div>
        </main>
    </div>

   
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


<?php $this->unshift('scrs');?>
  <script src="./../assets/js/profile/AvaliableController.js"></script>
<?php $this->end();?>
