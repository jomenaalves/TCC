<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="assets/css/style.css" />
<style>
    .noTextDe{
        text-decoration: none;
        color: #212121;
    }
    .noTextDe:hover{
        text-decoration: underline;
    }
</style>
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>
    <section class="ShoppingCart">
        <div class="contentShoppingCart">
            <?php if($productsInCart !== []): ?>
                <p class="titleSection">
                    Carrinho de compras <i class="fas fa-shopping-cart"></i>
                </p>
                <br>        
                <table>
                    <thead class="headerShoppingCart">
                        <tr>
                            <td>Produto</td>
                            <td>Quantidade</td>
                            <td>Preço unitário</td>
                            <td>valor total</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($productsInCart as $item):?>
                        <tr class="ItemInTheCart" id="<?= $item['id_product']?>">
                            <td>
                                <div class="productCart">
                                    <img data-image="<?= $item['id_product']?>" src="/Elegance/<?= $item['photoProduct']?>" alt="" width="75px">
                                    <p><a class="noTextDe"href="<?= BASE_URL . "/produto" . "/" . $item['id_product']. "/" . strtolower(str_replace(" ", "-", $item['nome'])); ?>"><?= $item['nome']?></a></p>
                                </div>
                            </td>
                            <td>
                                <div class="qtdContainer">
                                
                                    <div class="remoceQtd" data-id="<?= $item['id_product']?>">
                                        <i class="fa fa-chevron-down"data-id="<?= $item['id_product']?>"></i>
                                    </div>
                                    <p class="qtd" data-qtd="<?= $item['id_product']?>">1</p>
                                    <div class="addQtd" data-id="<?= $item['id_product']?>">
                                        <i class="fa fa-chevron-up"data-id="<?= $item['id_product']?>"></i>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="priceProduct">
                                    <span class="prefix">R$</span>
                                
                                    <?php if($item['InitialDiscount'] > 0): ?>
                                            
                                    <?php 
                                        $percent = (floatval($item['InitialPrice']) / 100) * $item['InitialDiscount'];
                                        
                                        $totalFinal = floatval($item['InitialPrice']) - $percent;
                                        $FinalPrice = number_format(floatval($totalFinal),2);
                                    ?>
                                    <span class="price" data-price="<?= $item['id_product']?>"><?= $FinalPrice?></span>
                                    <?php else: ?>
                                        <span class="price" data-price="<?= $item['id_product']?>"><?=  number_format(floatval($item['InitialPrice']),2); ?>
                                            
                                        </span>
                                    <?php endif; ?>    
                                </p>
                            </td>
                            <td>
                                <p class="subTotal">
                                    <span class="prefix">R$</span>
                                    <?php if(isset($FinalPrice)) :?>
                                        <span data-update="<?= $item['id_product']?>"><?= $FinalPrice ?></span>
                                    <?php else:?>
                                        <span data-update="<?= $item['id_product']?>"><?=  number_format(floatval($item['InitialPrice']),2); ?></span>
                                    <?php endif;?>
                                </p>
                            </td>
                            <td class="removeItemFromCart">
                                <i class="fas fa-trash-restore-alt removeBtn" id="<?= $item['id']?>"></i>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            
            
                <div class="total">
                    <p>TOTAL: <span class="totalSpan"> R$ <?= $totalCart ?></span>  </p>
                </div>
                <div class="buttonsCart">
                    <div class="secure">
                        <div class="item">
                            <i class="fas fa-shipping-fast"></i>
                            <div class="contentCard">
                                <p>RÁPIDA ENTREGA</p>
                                <span>Receba rapidamente o quê <br>você comprou</span>
                            </div>
                        </div>
                        <div class="item">
                            <i class="fas fa-undo"></i>
                            <div class="contentCard">
                                <p>DINHEIRO DE VOLTA</p>
                                <span>Não gostou do que comprou? <br> Devolva!</span>
                            </div>
                        </div>
                        <div class="item">
                            <i class="fas fa-lock"></i>
                            <div class="contentCard">
                                <p>VOCÊ ESTÁ SEGURO</p>
                                <span>Seu produto e seu dinheiro <br> estão seguros conosco</span>
                            </div>
                        </div>
                    </div>
                    <div class="buttons">
                        <button id="checkout">
                            finalizar compra
                        </button>
                        <a href="<?= BASE_URL . "/"?>" id="backToHome">
                            continuar comprando
                        </a>
                    </div>
                </div>
            <?php endif;?>
            <?php if($productsInCart == []):?>
                <div class="emptyCart">
                    <img src="<?= BASE_URL . "/assets/images/emptyCart.png"?>" alt="" width="200px">
                    <p class="titleEmpty">Seu carrinho de compras está vazio</p>
                    <span class="subEmpty">Você ainda não colocou nenhum produto no seu carrinho.</span>
                    <span>Comece exploxar agora mesmo!</span>
                    <a href="<?= BASE_URL . "/"?>"><button>Explorar</button></a>
                </div>
            <?php endif;?>
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

<?php $this->end();?>
<?php $this->unshift('scrs')?>

    <script src="./assets/js/Utils.js"></script>
    <script src="./assets/js/CartController.js"></script>
<?php $this->end();?>