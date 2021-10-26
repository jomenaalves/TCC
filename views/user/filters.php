<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>


<p></p>
<div class="contentFilters">
    <div class="filters">
        <p class="titleFilters">Filtre por</p>

        <div class="categoriesItens" data-js="itensToShowCategory">
            <?php foreach($categories as $category):?>
                <a href="" data-categoryId="<?=$category['id']?>" data-js="goTO"><?= $category['nome']?></a>
            <?php endforeach;?>
        </div>
       
    </div>
    <div class="productsFiltered">
        <div class="filteredProducts">
            <div class="firstHeaderColumn">
                
            </div>
            <div class="secondHeaderColumn">
                <select name="" id="changeSex">
                    <option value="masculino" <?php if($_GET['sex'] == "masculino") echo 'selected'?>> Masculino</option>
                    <option value="feminino" <?php if($_GET['sex'] == "feminino") echo 'selected'?>>Feminino</option>
                    <option value="unissex" <?php if($_GET['sex'] == "unissex") echo 'selected'?>>Unissex</option>
                    <option value="meninos" <?php if($_GET['sex'] == "meninos") echo 'selected'?>>Infantil - Meninos</option>
                    <option value="meninas" <?php if($_GET['sex'] == "meninas") echo 'selected'?>>Infantil - Meninas</option>
                    <option value="bebes" <?php if($_GET['sex'] == "bebes") echo 'selected'?>>Bebês</option>
                </select>
            </div>
        </div>

        <div class="initialProducts">
            <?php if($firstFilter !== []): ?>
                <?php foreach($firstFilter as $item):?> 
                <div class="productFiltered" data-category="<?= $item['category'] ?>">
                    <a href="<?= BASE_URL . "/produto" . "/" . $item['id_product'] . "/" . strtolower(str_replace(" ","-",$item['nome'])) ?>">
                        <div class="photo">
                            <img src="/Elegance/<?= $item['photoProduct']?>" alt="">
                        </div>
                        <div class="content">
                                <?php if ($item['InitialDiscount'] > 0) : ?>
                                    <p class="previous-price">R$ <?= $item['InitialPrice'] ?></p>
                                    <?php
                                    $percent = (floatval($item['InitialPrice']) / 100) * $item['InitialDiscount'];

                                    $totalFinal = floatval($item['InitialPrice']) - $percent;
                                    $FinalPrice = number_format(floatval($totalFinal), 2);
                                    ?>
                                    <p class="price">R$ <?= $FinalPrice ?>
                                        <span class="haveDiscount"><?= $item['InitialDiscount'] ?>% OFF</span>
                                    </p>
                                <?php else : ?>
                                    <p class="price">R$ <?= number_format(floatval($item['InitialPrice']), 2); ?></p>
                                <?php endif; ?>
                        </div>
                        <div class="desc">
                            <?= $item['nome'] ?>
                        </div>
                    </a>
                </div>
                <?php endforeach;?>
            <?php else:?>
                
                <div class="showMsgError">
                    <img src="assets/images/boxEmpty.png" alt="" width="85px">
                    <p>Não temos nenhum produto dessa categoria ativo no momento</p>
                </div>

            <?php endif;?>
            <div class="showMsgErrorJs">
                <img src="assets/images/boxEmpty.png" alt="" width="85px">
                <p>Não temos nenhum produto dessa categoria ativo no momento</p>
            </div>
        </div>
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


<?php $this->unshift('scrs') ?>

    <script src="assets/js/SearchController.js"></script>

<?php $this->end();?>

