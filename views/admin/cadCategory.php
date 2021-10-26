<?php @!session_start() && session_start(); ?>
<?php $count = 0; ?>
<?php $this->layout('../_adminTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="./../assets/css/style.css">
<style>
    body {
        background-color: #F2F7FF;
    }
</style>
<?php $this->end() ?>

<?php $this->unshift('mainContent'); ?>
<section class="cadCategory">
    <div class="headerCad">
        <p class="titleSection">Controle de categorias</p>
    </div>
    <div class="contentCategories">
        <div class="top">
            <div class="totalyItems" id="count">
                <?php if($qtdCategories > 0): ?>
                    Total de itens <?= $qtdCategories ?>
                <?php endif; ?>
            </div>
            <button data-js="cadCategory">Cadastrar categoria &nbsp; <i class="fas fa-plus"></i></button>
        </div>
        <div class="contentAllCategories" id="contentAllCategories"></div>
        <?php if ($categories == []) : ?>
            <div class="mainContent" id="dontExistsCategory">
                <!-- VERIFICAR SE EXISTEM CATEGORIAS CADASTRADAS -->
                <div class="dont-have-category">
                    <img src="./../assets/images/robot-question.jpg" alt="">
                    <p>Você não possui categorias cadastradas</p>
                    <button data-js="cadCategory">cadastrar categoria</button>
                </div>
            </div>
        <?php else : ?>
            <!-- LISTAR CATEGORIAS -->
            <div class="contentAllCategories" id="categoriesPhp">
                <?php foreach ($categories as $value):?>
                    <?php $count++; ?>
                    <div class="categoryItem">
                        <div class="infos">
                            <div class="photoCategory">
                                <img src="/Elegance/<?= $value['photoCategory']?>" alt="" width="50px">
                            </div>
                            <div class="name">
                                <p class=""><?= $value['nome']?></p>
                            </div>
                        </div>
        
                        <div class="acoes">
                            <div class="remove" data-removeItem="<?= $value['id']?>" >
                                <i class="fas fa-trash-restore-alt"></i>
                            </div>
                            <div class="edit" data-updateItem="<?= $value['id']?>">
                                <i class="fas fa-wrench"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

    <div class="modalCategory" data-js="closeModalCategory">
        <div class="contentModal">
            <div class="headerContentModal">
                <p>Cadastro de categorias</p>
                <button data-js="closeModalCategory" class="closeModal"> <i class="fa fa-times" data-js="closeModalCategory"></i> </button>
            </div>

            <div class="stagesCadCategory">
                <div class="progress-bar">
                    <div class="progress"></div>
                </div>
                <div class="itemStage setPhotoCategory activeItem" data-stage="1">
                    <p>1</p>
                </div>
                <div class="itemStage setPhotoCategory " data-stage="2">
                    <p>2</p>
                </div>
                <div class="itemStage setPhotoCategory " data-stage="3">
                    <p>3</p>
                </div>
            </div>

            <div class="contentStages" data-contentStage="1">
                <div class="images">

                    <label for="image" class="labelImage">
                        <i class="fa fa-plus"></i>
                    </label>
                    <div class="preview">
                        <div class="ok">
                            <i class="fas fa-check"></i>
                        </div>

                        <img src="" alt="" class="imgPreview" width="140px" height="126px">
                    </div>
                </div>
                <input type="file" name="image" id="image" accept="image/jpg,image/png,image/jpeg">

                <p>Selecione uma imagem para essa categoria</p>
                <button id="btnNext" class="btnNext" disabled>Proximo</button>
            </div>
            <div class="contentStages" data-contentStage="2">
                <p class="bold">Estamos quase lá!</p>
                <p>Informe o nome da categoria</p>
                <form action="/Elegance/" enctype="multipart/form-data">
                    <p class="errorText"> <i class="fa fa-info-circle"></i> Nome já informado</p>
                    <input type="text" name="categoryName" id="categoryName" required maxlength="50">

                    <button type="submit" id="BtnCadCategory" disabled>Cadastrar categoria</button>
                </form>

                <div class="loader"></div>


            </div>

            <div class="contentStages" data-contentStage="3">
                <img src="./../assets/images/ok.png" alt="" width="110px">
                <p class="bold">Prontinho!</p>
                <p>Categoria cadastrada com sucesso!</p>
                <button data-js="closeModalCategory">Fechar <i class="fa fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</section>
<?php $this->end(); ?>
<?php $this->unshift('scrs'); ?>
<script src="./../assets/js/cadCategoryController.js"></script>
<?php $this->end(); ?>