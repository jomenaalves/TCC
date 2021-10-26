<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="./../assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>
  
    <section class="infoProductSelected">
        <div class="firstColumn">
            <div class="photoProductSelected">
                <img src="/Elegance/<?=$infoProduct['photoProduct']?>" alt="">
            </div>
            <div class="nameAndInfos">
                <p id="nameProductBuyed"><?= $infoProduct['nome']?></p>
                <p>Tamanho : <?= $infoProduct['tam'] ?></p>

                <p class="priceNoDiscount">
                    <span>Preço sem desconto</span>
                    R$ <?= $infoProduct['InitialPrice']; ?>
                </p>
            </div>
        </div>

        <div class="finalPrice">
        
            <?php 
                $percent = (floatval($infoProduct['InitialPrice']) / 100) * $infoProduct['InitialDiscount'];
                
                $totalFinal = floatval($infoProduct['InitialPrice']) - $percent;
                $FinalPrice = number_format(floatval($totalFinal),2);
            ?>

            <p class="infoPrice">Preço final</p>
            <?php if($infoProduct['InitialDiscount'] > 0): ?>
                <span class="haveDiscount"><?= $infoProduct['InitialDiscount'] ?>% OFF</span>
            <?php endif;?>
            <p class="priceItem">
                R$ <?= $FinalPrice?>
            </p>
     
       
        </div>
    </section>

    <section class="stepsShowNow">

        <div class="headerSteps">
            <div data-stepHeader="1" class="stepItem stepActive">
                <i class="far fa-id-card"></i>
                <p>Dados Pessoais</p>
            </div>
            <div data-stepHeader="2" class="stepItem">
                <i class="fas fa-credit-card"></i>
                <p>Metodo de pagamento</p>
            </div>
            <div data-stepHeader="3" class="stepItem">
                <i class="fas fa-check"></i>
                <p>Confirmar dados</p>
            </div>
        </div>

        <div class="contentsSteps">
            <div data-infoProductStep="1" class="contentStepItem activeStepItem">
                <div class="alertStepDatas">
                    <i class="fas fa-info-circle"></i>
                    <p>Usamos seus dados pessoais apenas para a garantir a entrega do seu produto</p> 
                </div>

                <div class="address">
                    <p class="titleAddress">Selecione um endereço</p>
                    <?php foreach($address as $addrs):?>
                        <div class="addressItem">
                            <div class="isMain">
                                <input type="checkbox" name="ismMain" id="isMain<?= $addrs['id'];?>">
                                <label for="isMain<?= $addrs['id'];?>">Selecionar como endereço de entrega</label>
                            </div>
                            <div class="anyInfo">
                                <p>Tipo de endereço: <?= $addrs['type_address']; ?></p>
                                <p class="addressToMount">Endereço:  <?= $addrs['address_user']; ?> nº <?= $addrs['number_address'];?></p>
                                <p>Bairro: <?= $addrs['district']; ?></p>
                                <p class="cityToMount">Cidade: <?= $addrs['city'];?>, <?=$addrs['uf']; ?></p>
                                <p>Referencia: <?= $addrs['reference']?></p>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>

                <div class="dataUser">

                    <div class="firstColumnForData">
                        <div class="control">
                            <label for="">Email</label>
                            <input type="email" name="email" id="email" disabled value="<?= $email ?>">
                        </div>
                        <div class="control">
                            <label for="">Nome</label>
                            <input type="text" name="name" id="name" disabled value="<?= $name ?>">
                        </div>
                        <div class="control">
                            <label for="">CPF</label>
                            <input type="text" name="cpf" id="cpf" value="" placeholder="99999999999" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>

                    <div class="secondColumnForData">
                        <div class="control">
                            <label for="sexo">Sexo</label>
                            <select name="sexo" id="sexo">
                            <optgroup>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </optgroup>
                            </select>   
                        </div>
                        <div class="control">
                            <label for="dataNasc">Data de nascimento</label>
                            <input type="date" name="" id="dataNasc"  min="1950-10-01" max="<?= date('Y-m-d');?>">
                        </div>
                    </div>
                </div>

                <div class="buttonsPayment">
                    <p class="msgErrorFirstDisplay"></p>
                    <button class="back">Voltar</button>
                    <button class="next" data-button="btnNext">Proximo</button>
                </div>
            </div>
            <div data-infoProductStep="2" class="contentStepItem">
                <p class="titleStep">Escolha o metodo de pagamento</p>
                <div class="paymentItem">

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
            <div data-infoProductStep="3" class="contentStepItem">
                <div class="verifyYoursData">
                    <img src="<?= BASE_URL . "/assets/images/checklist.png"?>" alt="Verifique seus dados" width="60px">
                    <p class="titleToVerify">Verifique seus dados antes de continuar</p>     
                </div>

                <div class="contentStep3">
                    <p>Destinatário: José Carlos Omena Alves</p>  
                    <p>CPF: 544.296.168-09</p>  
                    <p>Data de nascimento: 01/08/2021</p>
                    <p>Sexo: Masculino</p>
                    <p>Endereço: Rua Shinzu shimizu, nº 140</p>
                    <p>Cidade: Guariba, SP</p>
                </div>

                <div class="buttonsContentStep3">
                    <button data-js="btnBackToStep2">Voltar</button>
                    <button data-js="btnToMakePayment" id="<?=$infoProduct['id_product']?>">Finalizar</button>
                </div>
            </div>
        </div>
        

    </section>
    

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

<div class="modalToPayWithWallet">
    <div class="contentModalPayWithWallet">

        <!-- INSUFFICIENT MONEY -->
        <?php if(number_format($wallet, 2) < $FinalPrice):?>
            <div class="dontHaveMoney">
                <img src="./../assets/images/walletEmpty.png" alt="" width="80px">
                <p>Dinheiro insuficiente</p>

                <span class="required">Dinheiro necessário: R$ <?= number_format($FinalPrice, 2); ?></span>
                <span class="got">Dinheiro atual: R$ <?= number_format($wallet, 2) ?></span>

                <button id="dontHaveMoney">Escolher outro método de pagamento <i class="fa fa-arrow-right"></i> </button>
            </div>
        <?php endif; ?>

        <?php if(number_format($wallet, 2) >= $FinalPrice):?>
            <div class="haveMoney">
                <!-- <p>
                    Pagar com a sua carteira
                </p> -->
                <div class="headerMoney">
                    <span>total</span>
                    <p class="totalMoney">R$ <?= number_format($wallet, 2)?></p>
                </div>

                <div class="productToBuyed">
                    <div>
                        <span>Produto</span>
                        <p><?= mb_strimwidth($infoProduct['nome'], 0, 50, "...")?></p>
                    </div>
                    <div>
                        <span>Valor</span>
                        <p>R$ <?= $FinalPrice?></p>
                    </div>
                </div>

                <div class="totalAfter">
                    <span>Total após o pagamento</span>
                    <p>
                        R$
                        <?php 
                           echo ($wallet - $FinalPrice);
                        ?>
                        
                    </p>
                </div>

                <div class="buttons">
                    <button class="cancelPaymentMethodAndShowDisplay2">Escolher outro meio de pagamento</button>
                    <button class="makePaymentWithWallet" id="<?= $infoProduct['id_product']?>" data-pricePaid="<?=$FinalPrice?>">Efetuar pagamento</button>
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

<?php $this->end();?>
<?php $this->unshift('scrs');?>
    <script src="./../assets/js/ShopNowController.js"></script>
<?php $this->end();?>
