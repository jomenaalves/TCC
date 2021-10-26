<?php !session_start() && session_start(); ?>

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
<section class="cadProducts">
    <p class="titleSection">Cadastro de Produtos</p>

    <?php if ($categories == []) : ?>
        <div class="alertCategories">
            <div>
                <i class="fas fa-exclamation" id="alert"></i>
            </div>
            <div>
                <p>Você não possui categorias cadastradas</p>
                <div class="flex-column">
                    <a href="">Cadastrar categorias</a>
                    <i class="fa fa-arrow-right"></i>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <form action="" id="cadProducts" method="post" enctype="multipart/form-data">
        <div class="contentCadProducts">
            <div class="firstLine">
                <div class="form-control">
                    <label for="name">Breve descrição (60)</label>
                    <input type="text" maxlength="60" required id="name" name="name">
                </div>
                <div class="form-control">
                    <label for="sex">Sexo</label>
                    <select name="sex" id="sex">
                        <option value="Unissex">Unissex</option>
                        <option value="Masc" selected>Masculino</option>
                        <option value="Fem">Feminino</option>
                        <option value="Girls">Infantil - Meninas</option>
                        <option value="Boys">Infantil - Meninos</option>
                        <option value="Baby">Infantil - Bebês</option>
                    </select>
                </div>
                <div class="form-control">
                    <label for="name">Categoria</label>
                    <select name="category" id="category" required>
                        <!-- ALL CATEGORIES -->
                        <?php foreach ($categories as $key => $value) : ?>
                            <option value="<?= $value['id'] ?>"><?= $value['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-control">
                    <label for="tam">Tamanho</label>
                    <select name="tam" id="tam">
                        <option value="PP">PP</option>
                        <option value="P">P</option>
                        <option value="M" selected>M</option>
                        <option value="G">G</option>
                        <option value="GG">GG</option>

                    </select>
                </div>
                <div class="form-control">
                    <label for="gp">Grupo</label>
                    <select name="group" id="group">
                        <option value="Unique" selected>Peça unica</option>
                        <option value="Lot">Varias Peças</option>
                    </select>
                </div>
            </div>
            <div class="secondLine">

                <div class="form-control">
                    <label for="piece">Quantidade de peças</label>
                    <input type="number" name="piece" id="piece" value="1" required>
                </div>

                <div class="form-control">
                    <label for="estq">Estoque Inicial</label>
                    <input type="number" name="estq" id="estq" value="10" required>
                </div>
                <div class="form-control">
                    <label for="name">Preço inicial</label>
                    <input type="text" required step="any" name="InitialPrice" id="InitialPrice"  maxlength="10" >
                </div>
                <div class="form-control">
                    <label for="name">Desconto em %</label>
                    <input type="number" placeholder="Ex: 10" required value="0" name="InitialDiscount" id="InitialDiscount">
                </div>
            </div>

            <div class="photosProduct">
                <p class="notBeNull"> <i class="fa fa-info-circle"></i> Selecione uma imagem!</p>
                <p>Escolha as fotos para esse produto (maximo de 5 imagens) </p>
                <label for="photo" type="button" id="addPhotos">SELECIONAR IMAGENS <i class="fa fa-plus"></i> </label>
                <input type="file" name="photo" id="photo" multiple accept="image/jpeg,image/png,image/jfif,image/jpg" novalidate>
            </div>
            <div class="allPhotos">
              
            </div>
            <div class="descProduct">
                <p>Descrição do produto</p>
                <textarea name="desc" id="desc" cols="30" rows="10" required></textarea>
            </div>
        </div>

        <img src="" alt="" id="preview">
        <div class="btnAndLoading">
            <button type="submit" id="submitButton">Cadastrar Produto</button>
            <div class="loaderSubmitForm"></div>             
        </div>
    </form>
    <div class="errorForm">
        <p>Limite maximo de imagens excedido</p>
        <button id="closeMsgErrorForm"><i class="fa fa-times"></i> </button>                    
    </div>
    <div class="successForm">
        <p>Produdo cadastrado com sucesso!</p>
        <button id="closeMsgErrorForm"><i class="fa fa-times"></i> </button>            
    </div>
</section>

<?php $this->end(); ?>
<?php $this->unshift('scrs'); ?>
<script src="./../assets/js/AdminController.js"></script>
<script type="text/javascript">
    function formatDecimal(input) {
        var val = '' + (+input.value);
        if (val) {
            val = val.split('\.');
            var out = val[0];
            while (out.length < 2) {
                out = '0' + out;
            }
            if (val[1]) {
                out = out + '.' + val[1]
                if (out.length < 6) out = out + '0';
            } else {
                out = out + '.00';
            }
            input.value = out;
        } else {
            input.value = '000.00';
        }
    }
</script>
<?php $this->end(); ?>