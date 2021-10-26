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
            <div class="mainWallet">
                <div class="headerWallet">
                    <p class="titlePage">Sua Carteira</p>
                    <div class="money">
                        <span>total</span>
                        <p>R$ <?= $money ?></p>
                    </div>
                </div>

                <div class="trans">
                    <p class="titleTranslactions">Histórico de translações</p>

                    <div class="contentHistory">
                        <?php if($translactions !== []):?>
                            <?php foreach($translactions as $item):?>
                                <div class="content <?=  $item['isAdd'] == 1 ? "add" : "out"?>">
                                    <p><?= $item['statusTranslaction'] ?></p>
                                    <p class="<?= $item['isAdd'] == 1 ? "added" : "outed"?>"> <?=  $item['isAdd'] == 1 ? "+" : "-"?> R$ <?=  $item['price']?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else:?>
                            <p class="dontHaveTranslactions">Não possui nenhuma translação feita</p>
                        <?php endif;?>
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
  
<?php $this->end();?>
