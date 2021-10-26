<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="./../assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>
    <section class="allProducts">

        <div class="contentBox">
            <div class="qtd">
                <p>Compra de <b>
                    <?= $qtd ?></b> 
                    <?php if ($qtd > 1) : echo "items";
                            else : echo "item";
                            endif ?> 
                do carrinho de compras</p>
            </div>
            <div class="totalShopping">
                <div class="totalItens">
                    <p>Quantidade de produtos</p>
                    <span><?= $totalItens ?></span>
                </div>
                <div class="totalAll">
                    <p class="titleTotal">Total</p>
                    <span>R$ <?= number_format($price, 2) ?></span>
                </div>
            </div>
        </div>
    </section>
 
    <div class="buyItens">

        <div class="headerSteps">
            <div data-stepItem="1" class="step stepActive">
                <i class="far fa-id-card"></i>
                <p>Dados Pessoais</p>
            </div>
            <div data-stepItem="2" class="step">
                <i class="fas fa-credit-card"></i>
                <p>Metodo de pagamento</p>
            </div>
            <div data-stepItem="3" class="step">
                <i class="fas fa-check"></i>
                <p>Confirmar dados</p>
            </div>
        </div>
        <div class="contentStepsCart">


            <div class="contentStep activeStepItem" data-stepC="1">

                <div class="dataUsage">
                    <i class="fas fa-info-circle"></i>
                    <p>Usamos seus dados pessoais apenas para garantir a entrega do seu produto</p>
                </div>
                <div class="contentAddress">
                    <p>Tipo de endereço: <?= $address[0]['type_address']?></p>
                    <p class="address" id="addressUser">
                        Endereço: <?= $address[0]['address_user'] ?> nº <?= $address[0]['number_address']  ?>
                    </p>
                    <p>Bairro: <?= $address[0]['district']?></p>
                    <p id="cityUser">Cidada: <?= $address[0]['city']?>, <?= $address[0]['uf']?></p>
                    <p>Referencia: <?= $address[0]['reference']?></p>

                    <div class="addressEntrega">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                </div>
                <div class="AnydataUser">
                    <div class="firstLineForData">
                       <div class="contolDataForm">
                           <label for="email">Email</label>
                           <input type="text" id="email" value="<?= $address[0]['email'] ?>" disabled>
                       </div>
                       <div class="contolDataForm">
                           <label for="name">Nome</label>
                           <input type="text"id="name" value="<?= $address[0]['username'] ?>" disabled>
                       </div>
                       <div class="contolDataForm">
                           <label for="cpf">cpf</label>
                           <input type="text" id="cpf" placeholder="54429616809" value="54429616809" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="11">
                       </div>
                    </div>
                    <div class="secondLineForData">
                        <div class="contolDataForm">
                            <label for="sexo">Sexo</label>
                            <select name="" id="sexo">
                                <optgroup>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                            </select>
                        </div>
                        <div class="contolDataForm">
                            <label for="dataNasc">data de nascimento</label>
                            <input type="date" id="dataNasc" min="1950-10-01" max="<?= date('Y-m-d') ?>" value="2003-08-01" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="11">
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <div class="errorsForm"></div>
                    <a href="<?= BASE_URL . "/"?>" class="back"><button>Voltar</button></a>
                    <button data-goTo="2" class="next">Proximo</button>
                </div>
            </div>

            <div class="contentStep" data-stepC="2">
                <div class="paymentItem">
                <p class="titleStep">Escolha o metodo de pagamento</p>
                    <div>
                        <input type="radio" name="payment" id="Paypal" checked>
                        <label for="Paypal">
                            <img src="<?= BASE_URL . "/assets/images/paypal.jfif"?>" alt="" width="100px">
                            <p>Pagar com paypal</p>
                        </label>
                    </div>

                    <div>
                        <input type="radio" name="payment" id="wallet">
                        <label for="wallet">
                            <i class="fas fa-wallet" style="font-size:30px"></i>
                            <p>Pagar com seu saldo na carteira</p>
                        </label>
                    </div>
                    
                </div>

                <div class="buttonsStep2">
                    <button class="prevStep"  data-button="backTo1">Anterior</button>
                    <button class="nextStep" data-button="goToLastStep">Proximo</button>
                </div>
            </div>

            <div class="contentStep" data-stepC="3">

                <div class="verifyYoursData">
                    <img src="./../assets/images/checklist.png" alt="" width="60px">
                    <p class="titleToVerify">Verifique seus dados antes de continuar</p>
                </div>

                <div class="contentStep3">

                </div>

                
                <div class="buttonsContentStep3">
                    <button data-js="btnBackToStep2">Voltar</button>
                    <button data-js="btnToMakePayment">Finalizar</button>
                </div>
            </div>
        </div>

    </div>



    

<section class="information mt-10">
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

<div class="modalToPayWithWalletInCart">
    <div class="contentModalPayWithWalletinCart">
        <!-- INSUFFICIENT MONEY -->
        <?php if(number_format((float) $wallet, 2,'.','') < number_format($price, 2)):?>
            <div class="dontHaveMoney">
                <img src="./../assets/images/walletEmpty.png" alt="" width="80px">
                <p>Dinheiro insuficiente</p>

                <span class="required">Dinheiro necessário: R$ <?= number_format($price, 2); ?></span>
                <span class="got">Dinheiro atual: R$ <?= number_format((float) $wallet, 2,'.','') ?></span>

                <button id="dontHaveMoney">Escolher outro método de pagamento <i class="fa fa-arrow-right"></i> </button>
            </div>
        <?php endif; ?>

        <?php if(number_format((float) $wallet, 2,'.','') >= $price):?>
            <div class="haveMoney">
                <!-- <p>
                    Pagar com a sua carteira
                </p> -->
                <div class="headerMoney">
                    <span>total</span>
                    <p class="totalMoney">R$ <?= number_format((float) $wallet, 2,'.','')?></p>
                </div>

                <div class="productToBuyed">
                    <div>
                        <span>Informações</span>
                        <p id="nameProduct"><?= $nameProduct ?></p>
                    </div>
                    <div>
                        <span>Valor</span>
                        <p>R$ <?= number_format($price,2,'.','')?></p>
                    </div>
                </div>

                <div class="totalAfter">
                    <span>Total após o pagamento</span>
                    <p>
                        R$
                        <?php 
                        echo number_format(($wallet - $price), 2);
                        ?>
                        
                    </p>
                </div>

                <div class="buttons">
                    <button class="cancelPaymentMethodAndShowDisplay2">Escolher outro meio de pagamento</button>
                    <button class="makePaymentWithWallet" id="<?= $infoProduct['id_product']?>" data-pricePaid="<?= number_format($price, 2)?>">Efetuar pagamento</button>
                </div>
            </div>            
        <?php endif; ?>
    </div>
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

<?php $this->end(); ?>

<?php $this->unshift('scrs'); ?>
    <script src="./../assets/js/ShopCartController.js"></script>
<?php $this->end();?>