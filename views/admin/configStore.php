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
    <div class="alertConfigs">
        <p><i class="fas fa-info-circle"></i> O preenchimento dos dados é extemamente importante para todo o funcionamento do website</p>
    </div>

    <section class="allConfigsFromWebSite">
        <form action="" method="post" id="updateConfig">
            <p class="titleToSectionQuestions">Correios</p>

            <div class="controls">
                <div class="formControl">
                    <label for="cep">Cep de saida de mercadoria</label>
                    <input type="text" name="cep" id="cep" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="8">
                </div>
                <div class="formControl">
                    <label for="service">Tipo de serviço</label>
                    <select name="service" id="service">
                        <option value="SEDEX">SEDEX</option>
                        <option value="PAC">PAC</option>
                    </select>
                </div>
                <div class="formControl">
                    <label for="kg">Peso estimado (Kg)</label>
                    <input type="text" name="kg" id="kg" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="8" value="0.500">
                </div>
                <div class="formControl">
                    <label for="embalagem">Embalagem</label>
                    <select name="embalagem" id="embalagem">
                        <option value="correios">Embalagem dos correios</option>
                        <option value="outer">Outra embalagem</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="save">Salvar configurações</button>
        </form>
    </section>
<?php $this->end();?>
<?php $this->unshift('scrs');?>
    <script src="./../assets/js/ConfigController.js"></script>
<?php $this->end();?>