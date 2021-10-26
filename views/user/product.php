<?php !session_start() && session_start(); ?>
<?php
$int = intval($stars);
$decimal = explode(".", $stars)[1] == 0 ? false : true;
function porcentagem_nx ( $parcial, $total ) {
    if($total == 0) return 0;
    return ( $parcial * 100 ) / $total;
}
?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<style>
    body {
        background-color: #f3f4f5 !important;
    }
</style>
<link rel="stylesheet" href="./../../assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>

<div class="contentPageProduct">

    <div class="caminho" href="<?= BASE_URL . "/" ?>">
        <i class="fas fa-directions"></i>
        <a href="<?= BASE_URL . "/category" . "/" . $category['id'] . "/" . $category['nome'] ?>"><?= $category['nome'] ?></a>
        <span>/</span>
        <p><?= $slug; ?></p>
    </div>


    <div class="photoAndPrice">
        <div class="photos">
            <div class="leftPhotos">
                <?php foreach ($allPhotos as $image) : ?>
                    <img src="/Elegance/<?= $image['photo'] ?>" alt="">
                <?php endforeach; ?>
            </div>
            <div class="mainPhoto">
                <img src="/Elegance/<?= $data['photoProduct'] ?>" alt="" id="mainPhoto">

            </div>
        </div>
        <div class="priceAndFav">

            <div class="price">
                <p class="totalSales">Novo | <?= $totalRating ?> vendidos</p>
                <div class="nameAndAddToFav">
                    <p class="nome"><?= $data['nome'] ?></p>
                    <div class="icon">
                        <i class="far fa-heart"></i>
                    </div>
                </div>
            </div>

            <div class="controlStars">
                <?php if ($stars == "0.0") : ?>
                    <div class="notAvaliable">
                        <?php for ($index = 0; $index < 5; $index++) : ?>
                            <i class="fas fa-star"></i>
                        <?php endfor; ?>
                        <span>(não avaliado)</span>
                    </div>
                <?php else : ?>
                    <div class="haveAvaliation">
                        <?php for ($index = 0; $index < $int; $index++) : ?>
                            <i class="fas fa-star" data-id="active"></i>
                        <?php endfor; ?>
                        <?php if ($decimal) : ?>
                            <i class="fas fa-star-half-alt" data-id="active"></i>
                        <?php endif; ?>
                        <?php if ($int <= 4 && !$decimal) : ?>
                            <?php for($index = $int; $index < 5; $index++):?>
                                <i class="far fa-star"></i>
                            <?php endfor; ?>
                        <?php endif; ?>
                        <?php if ($int <= 4 && $decimal) : ?>
                            <?php for($index = ceil($stars); $index < 5; $index++):?>
                                <i class="far fa-star"></i>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>


            <?php if ($data['InitialDiscount'] > 0) : ?>
                <p class="previous-price">R$ <?= $data['InitialPrice'] ?></p>
                <?php
                $percent = (floatval($data['InitialPrice']) / 100) * $data['InitialDiscount'];

                $totalFinal = floatval($data['InitialPrice']) - $percent;
                $FinalPrice = number_format(floatval($totalFinal), 2);
                ?>
                <p class="priceItem">R$ <?= $FinalPrice ?>
                    <small></small>
                    <span class="haveDiscount"><?= $data['InitialDiscount'] ?>% OFF</span>
                </p>
            <?php else : ?>
                <p class="priceItem">R$ <?= number_format(floatval($data['InitialPrice']), 2); ?>

                </p>
            <?php endif; ?>

            <div class="calcEntrega">
                <svg xmlns="http://www.w3.org/2000/svg" class="ui-pdp-icon ui-pdp-icon--shipping ui-pdp-icon--truck ui-pdp-color--BLACK" width="27" height="25" viewBox="0 0 18 15">
                    <path fill-rule="nonzero" d="M7.763 12.207a2.398 2.398 0 0 1-4.726 0H1.8a1.8 1.8 0 0 1-1.8-1.8V2.195a1.8 1.8 0 0 1 1.8-1.8h8.445a1.8 1.8 0 0 1 1.8 1.8v.568l3.322.035L18 6.821v5.386h-2.394a2.398 2.398 0 0 1-4.727 0H7.763zm-.1-1.2h3.182V2.195a.6.6 0 0 0-.6-.6H1.8a.6.6 0 0 0-.6.6v8.212a.6.6 0 0 0 .6.6h1.337a2.399 2.399 0 0 1 4.526 0zm7.843 0H16.8V7.179l-2.086-3.187-2.669-.029v5.76a2.399 2.399 0 0 1 3.461 1.284zm-2.263 1.99a1.198 1.198 0 1 0 0-2.395 1.198 1.198 0 0 0 0 2.396zm-7.843 0a1.198 1.198 0 1 0 0-2.395 1.198 1.198 0 0 0 0 2.396z"></path>
                </svg>
                <p>
                    <span>Envio para todo o pais</span>
                    <a href="">Calcular prazo de entrega</a>
                </p>
            </div>

            <div class="haveEstoque">
                <p>Estoque disponível <i class="fas fa-check"></i></p>
            </div>

            <div class="qtd">
                <label for="qtd">Quantidade <span> ( <?= $data['estq'] ?> disponíveis ) </span></label>
                <select name="" id="">
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>

            <a href="<?= BASE_URL . "/shopNow" . "/" . $data['id_product'] ?>">
                <button class="buyNow">Comprar agora</button>
            </a>
            <div class="addToCardContent">
                <?php if (!$isInTheCard) : ?>
                    <button class="addToCart" id="<?= $data['id_product']; ?>">Adicionar ao carrinho</button>
                <?php endif; ?>

                <?php if ($isInTheCard) : ?>
                    <button class="removeToCart" id="<?= $data['id_product']; ?>">Remover do carrinho
                        <i class="fas fa-trash-restore"></i>
                    </button>
                <?php endif; ?>
                <div class="addToCartDiv"></div>
                <div class="btnRemove"></div>
                <div class="statusAddToCart"></div>


            </div>


            <div class="devolution">
                <svg class="ui-pdp-icon ui-pdp-icon--return ui-pdp-color--GRAY" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 14 12">
                    <path d="M2.474 7.2h7.225a2.7 2.7 0 1 0 0-5.4H7V.6h2.7a3.9 3.9 0 1 1 0 7.8H2.473l2.45 2.389-.839.859L.14 7.8l3.945-3.848.838.859L2.473 7.2z"></path>
                </svg>
                <p> Devolução Gratuita. <span>Você tem 30 dias a partir da data de recebimento</span></p>
            </div>
        </div>
    </div>
    <div class="moreInfo">
        <div class="left">
            <div class="descripton">
                <p>Descrição</p>
                <span id="descProduct">
                    <span class="desc60">
                        <?= substr($data['descProduct'], 0, 60) ?>
                        <?php if (strlen($data['descProduct']) > 60) echo "<button> <span>...</span> <span id='showAllContent'>Ver mais</span></button>"; ?>
                    </span>
                    <span class="fullDesc">
                        <?= nl2br($data['descProduct']); ?>
                        <span id='hide'>Esconder <i class="fas fa-chevron-up"></i></span></button>
                    </span>
                </span>
            </div>
        </div>
        <div class="right">
            <p>Meios de pagamentos</p>

            <div class="paymentÌtem">
                <span>Pagamento online com PayPal</span>
                <img src="<?= BASE_URL . "/assets/images/paypal.jfif" ?>" alt="" width="90px">
            </div>
        </div>
    </div>


    <div class="avaliable">
        <p>Opiniões sobre o produto</p>
        <div class="media">
            <div class="firstColumn">
                <p class="mediap"><?= $stars ?></p>
                <div class="qtdStart">
                    <div class="controlStars">
                        <?php if ($stars == "0.0") : ?>
                            <div class="notAvaliable">
                                <div>

                                <?php for ($index = 0; $index < 5; $index++) : ?>
                                    <i class="fas fa-star"></i>
                                <?php endfor; ?>
                                </div>
                                <span>(não avaliado)</span>
                            </div>
                            <?php else : ?>
                                <div class="haveAvaliation">
                                <?php for ($index = 0; $index < $int; $index++) : ?>
                                <i class="fas fa-star" data-id="active"></i>
                            <?php endfor; ?>
                            <?php if ($decimal) : ?>
                                <i class="fas fa-star-half-alt" data-id="active"></i>
                            <?php endif; ?>
                            <?php if ($int <= 4 && !$decimal) : ?>
                                <?php for($index = $int; $index < 5; $index++):?>
                                    <i class="far fa-star"></i>
                                <?php endfor; ?>
                            <?php endif; ?>
                            <?php if ($int <= 4 && $decimal) : ?>
                                <?php for($index = ceil($stars); $index < 5; $index++):?>
                                    <i class="far fa-star"></i>
                                <?php endfor; ?>
                            <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="totalMedia">Media entre <?= $totalRating ?> avaliação</p>
            </div>
            <div class="secondColumn">
                <?php

                    $nought = 0;
                    $one = 0;
                    $two = 0;
                    $tree = 0;
                    $for = 0;
                    $five = 0;

                    foreach($allNotes as $note){
                        if($note == 1) $one++;
                        if($note == 2) $two++;
                        if($note == 3) $tree++;
                        if($note == 4) $for++;
                        if($note == 5) $five++;
                        if($note == 0) $nought++;
                    }
                ?>
                <div class="item fiveStar">
                    <p>5 Estrelas</p>
                    <div class="total">
                        <div class="progress" style="width: <?= porcentagem_nx($five, $totalRating)?>%;"></div>
                        <span class="totalVote"> ( <?= $five ?> )</span>
                    </div>
                </div>
                <div class="item foreStar">
                    <p>4 Estrelas</p>
                    <div class="total">
                        <div class="progress" style="width: <?= porcentagem_nx($for, $totalRating)?>%;"></div>
                        <span class="totalVote">  ( <?= $for ?> ) </span>
                    </div>
                </div>
                <div class="item treeStar">
                    <p>3 Estrelas</p>
                    <div class="total">
                        <div class="progress" style="width: <?= porcentagem_nx($tree, $totalRating)?>%;"></div>
                        <span class="totalVote">  ( <?= $tree ?> ) </span>
                    </div>
                </div>
                <div class="item twoStar">
                    <p>2 Estrelas</p>
                    <div class="total">
                        <div class="progress" style="width: <?= porcentagem_nx($two, $totalRating)?>%;"></div>
                        <span class="totalVote">  ( <?= $two ?> )</span>
                    </div>
                </div>
                <div class="item oneStar">
                    <p>1 Estrela</p>
                    <div class="total">
                        <div class="progress" style="width: <?= porcentagem_nx($one, $totalRating)?>%;"></div>
                        <span class="totalVote">  ( <?= $one ?> ) </span>
                    </div>
                </div>
                <div class="item oneStar">
                    <p>0 Estrela</p>
                    <div class="total">
                        <div class="progress" style="width: <?= porcentagem_nx($nought, $totalRating)?>%;"></div>
                        <span class="totalVote">  ( <?= $nought ?> )</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="questions">
        <p class="titleQuestions">Perguntas e respostas</p>

        <div class="makeQuest">
            <input type="text" name="" id="question" maxlength="300" placeholder="Faça sua pergunta sobre esse produto...">
            <button <?php if(!isset($_SESSION['jwtTokenUser'])) echo 'disabled title="Precisa entar logado para escrever uma pergunta"'?> id="makeQuestion" data-id="<?= $data['id_product'] ?>">Perguntar</button>
        </div>

        <div class="exampleQuestion">
            <?php if($lastComments == []): ?>
                <div class="noComments">
                    <img src="./../../assets/images/noComments.jpg" alt="">
                    <p>Nenhuma pergunta feita sobre esse produto</p>
                    <label for="question">Fazer um pergunta </label>
                </div>

            <?php else: ?>
                <p class="statusQuestion">Ultimas feitas</p>

                <?php foreach($lastComments as $comment):?>
                    <div class="contentQuestion">
                        <p class="question"><?= $comment['comment'] ?></p>
                        <?php if($comment['answer'] !== ""):?>
                            <p class="resp">
                                <svg class="ui-pdp-icon ui-pdp-questions__questions-list__answer-container__icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                    <path fill="#000" fill-opacity=".25" fill-rule="evenodd" d="M0 0h1v11h11v1H0z"></path>
                                </svg>
                                <span><?= $comment['answer'] ?><span class="data">29/06/2021</span></span>
                            </p>
                        <?php endif;?>
                    </div>
                <?php endforeach;?>

            <div class="allQuestions">Ver todas as perguntas <i class="fa fa-arrow-right"></i></div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="msgToCart">
    <p>Produto adicionado ao carrinho!</p>
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


<!-- MODALS -->

<section class="needMakeLogin">
    <div class="content">
        <img src="<?= BASE_URL . "/assets/images/robot-question.jpg" ?>" width="100px">
        <span>Opps!</span>
        <p>Você precisa estar logado para continuar</p>
        <a href="">Log-in <i class="fa fa-arrow-right"></i></a>
    </div>
</section>
<?php $this->end(); ?>
<?php $this->unshift('scrs'); ?>
<script src="<?= BASE_URL . "/assets/js/ProductController.js" ?>"></script>
<?php $this->end(); ?>