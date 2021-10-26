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
            <ul>
            <a href="<?= BASE_URL . "/user/perfil"?>"> <i class="fas fa-map-marker-alt"></i> <p>Endereços</p></a>
                <a href="<?= BASE_URL . "/user/pedidos"?>"> <i class="fas fa-box"></i> <p>Pedidos</p></a>
                <a href="<?= BASE_URL . "/user/avaliacoes"?>"> <i class="fas fa-star"></i> <p>Avaliações</p></a>
                <a href="<?= BASE_URL . "/user/carteira"?>"> <i class="fas fa-wallet"></i> <p>Carteira</p></a>
                <a href="<?= BASE_URL . "/exit"?>"> <i class="fas fa-sign-out-alt"></i> <p>Sair</p></a>
            </ul>
            </ul>
        </nav>
        <main class="mainPerfil">
            <p class="pMain">Endereços</p>

            
            <div class="enderecos">
                <?php if($address !== []):?>

                    <?php foreach($address as $addressItem):?>
                        <div class="addressItem">
                            <div class="headerAddress">
                               <p class="title">
                                    <?= ucfirst($addressItem['type_address'])?>
                               </p>
                               <div class="acoesAddress">
                                    <i class="fas fa-trash-restore-alt" id="<?= $addressItem['id']?>"  data-delete="deleteAddress"></i>
                                    <i class="fas fa-pencil-alt" id="<?= $addressItem['id']?>"></i>
                               </div>
                            </div>
                            <div class="contentAddress">
                                <p>Endereço: <?= $addressItem['address_user']?></p>
                                <p>Tipo de endereço: <?= ucfirst($addressItem['type_address'])?></p>
                                <p>Numero: <?= $addressItem['number_address']?></p>
                                <p>Cidade: <?= $addressItem['city'] ?></p>
                                <p>Uf: <?= $addressItem['uf'] ?></p>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                <div class="addEnd">
                    <i class="fas fa-plus"></i>
                    <p>Novo endereço</p>
                </div>
           
            </div>
           


            <div class="addEndContent">
                <p>Adicionar endereço de entrega</p>
                <p>* campos obrigatórios</p>

                <form action="" class="address">

                    <div class="firstColumnForm">
                      <div class="formControl">
                            <label for="nome">Nome do destinatário*</label>
                            <input type="text" placeholder="Nome do destinatário" required  name="nome" id="nome">
                        </div>
                        <div class="formControl">
                            <label for="endType">Tipo de endereço* </label>
                            <select name="endType" id="endType" required>
                                <optgroup>
                                    <option value="Casa" selected>Casa</option>
                                    <option value="Apartamento">Apartamento</option>
                                    <option value="Comercial">Comercial</option>
                                    <option value="Outro">Outro</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="formControl">
                            <label for="cep">CEP*</label>
                            <input type="tel" placeholder="00000000" required name="cep" id="cep" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="8"> 
                        </div>

                    </div>

                    <div class="secondStage">
                        <div class="formControl">
                            <label for="end">Endereço* </label>
                            <input type="text" placeholder=""  id="end" name="end"> 
                        </div>
                        <div class="formControl">
                            <label for="number">Numero* </label>
                            <input type="text" placeholder=""  id="number" name="number"> 
                        </div>
                        <div class="formControl">
                            <label for="info">Informações de referência* </label>
                            <input type="text" placeholder=""  id="info" name="info"> 
                        </div>
                        <div class="formControl">
                            <label for="bairro">Bairro* </label>
                            <input type="text" placeholder=""  id="bair" name="bair"> 
                        </div>
                        <div class="formControl">
                            <label for="city">Cidade* </label>
                            <input type="text" placeholder="" name="city"  id="city" disabled> 
                        </div>
                        <div class="formControl">
                            <label for="uf">UF* </label>
                            <input type="text" placeholder="" name="uf" id="uf" disabled> 
                        </div>
                    </div>

                    <button>Salvar informações</button>
                </form>
            </div>
        </main>
    </div>

    <div class="modalFillInAllFields">
        <p>Preencha todos os campos!</p>
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
    <script src="./../assets/js/profile/EnderecoController.js"></script>
<?php $this->end();?>
