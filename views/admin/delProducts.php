<?php !session_start() && session_start(); ?>

<?php $this->layout('../_adminTheme'); ?>

<?php $this->unshift('head') ?>
    <title> <?= $this->e($title) ?> </title>
    <link rel="stylesheet" href="./../assets/css/style.css">
    <style>
        body{
            background-color: #F2F7FF;
        }
    </style>
<?php $this->end() ?>

<?php  $this->unshift('mainContent');?>
    <section class="delProducts">
        <p class="titleSectionDel">Deletar Produtos</p>
        <div class="search">
            <input type="text" placeholder="Procure por produtos">
            <i class="fa fa-search"></i>
        </div>
        <div class="productsContentToDelete">
            
            <?php foreach ($products as $value): ?>
                <div class="card">
                    <div class="photo">
                        <img src="/Elegance/<?= $value['photoProduct']?>" alt="">
                    </div>
                    <div class="contentCardDelete">
                        <p class="price">R$ <?= number_format($value['InitialPrice'],2); ?></p>
                        <p><?= $value['nome']?></p>
                        <button id="<?= $value['id_product']?>" data-id="<?= $value['id_product']?>" data-delete="deleteItem"> 
                            <i class="fas fa-trash-restore-alt" data-id="<?= $value['id_product']?> data-delete="deleteItem"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="loading">
            <div>
                <img src="./../assets/images/loader.gif" alt="" width="30px">
            </div>
        </div>

        <div class="pagination">
            <a href="?page=1"><i class="fas fa-angle-double-left"></i></a>
           
            <div class="createPagination">
                
            </div>
                
            <a href="?page=<?= $maxLenght ?>"><i class="fas fa-angle-double-right"></i></a>
        </div>
    </section>
<?php $this->end();?>
<?php $this->unshift('scrs');?>
    <script src="./../assets/js/AdminDelController.js"></script>
<?php $this->end();?>