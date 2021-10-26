<?php $this->layout('../_adminTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
    body {
        background-color: #F2F7FF;
    }
</style>
<?php $this->end() ?>

<?php $this->unshift('mainContent'); ?>

    <div class="headerMainAdmin">
        <div class="anyInfo">
            <div class="card">
                <div class="image eye">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="text">
                    <p>Visitantes</p>
                    <p>25k</p>
                </div>
            </div>
            <div class="card">
                <div class="image sale">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="text">
                    <p>Vendas</p>
                    <p>1.800</p>
                </div>
            </div>
            <div class="card">
                <div class="image count">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text">
                    <p>Contas</p>
                    <p>12.569</p>
                </div>
            </div>
            <div class="card">
                <div class="image wallet">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="text">
                    <p>Ganhos</p>
                    <p>R$ 125.984</p>
                </div>
            </div>
        </div>
    </div>
    <div class="lastProductsSale">

        <div class="headerLast">
            <p>Ultimos Produtos Vendidos</p>
        </div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome do produto</th>
                        <th>Nome do comprador</th>
                        <th>Preço</th>
                        <th>Metodo de pagamento</th>
                        <th>Status da compra</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>12</th>
                        <th>Blusa Capitã Marvel</th>
                        <th>José Carlos Omena Alves</th>
                        <th>R$28.99</th>
                        <th class="center">Cartão</th>
                        <th class="center aprov">Aprovada</th>
                    </tr>
                    <tr>
                        <th>77</th>
                        <th>Bolsa Fem Cor Azu...</th>
                        <th>Ana Flávia Gomes Da silva</th>
                        <th>R$128.99</th>
                        <th class="center">Boleto</th>
                        <th class="center pend">Pendente</th>
                    </tr>
                    <tr>
                        <th>68</th>
                        <th>Relogio Unissex ...</th>
                        <th>Maria José De Xavier</th>
                        <th>R$258.87</th>
                        <th class="center">Boleto</th>
                        <th class="center aprov">Aprovado</th>
                    </tr>
                    <tr>
                        <th>15</th>
                        <th>Blusa Homem de fe...</th>
                        <th>José Carlos Omena Alves</th>
                        <th>R$28.99</th>
                        <th class="center">Cartão</th>
                        <th class="center aprov">Aprovada</th>
                    </tr>
                    <tr>
                        <th>324</th>
                        <th>Vestido Rosa com..</th>
                        <th>Pedro Augusto Monteiro</th>
                        <th>R$214.56</th>
                        <th class="center">Paypal</th>
                        <th class="center rec">Recusado</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php $this->end(); ?>

<?php $this->unshift("infos"); ?>
    <div class="lastMessagesADM">
        <div class="content">
            <div class="headerMessage">
                <p>Mensagens Privadas</p>
                <span>Ver todas <i class="fa fa-arrow-right"></i></span>
            </div>
            <div class="messages">
                <div class="showChatWithLastMessage">
                    <div class="image">
                        <img src="assets/images/homem-1.jpg" alt="">
                    </div>
                    <div class="contentChat">
                        <p class="nameClient">Pedro Alcantara</p>
                        <span class="lastMessage">Olá, quando vocês vão...</span>
                    </div>
                </div>
                <div class="showChatWithLastMessage">
                    <div class="image">
                        <img src="assets/images/mulher-1.jpg" alt="">
                    </div>
                    <div class="contentChat">
                        <p class="nameClient">Luiza Pereira</p>
                        <span class="lastMessage">Gostei muito do pro...</span>
                    </div>
                </div>
                <div class="showChatWithLastMessage">
                    <div class="image">
                        <img src="assets/images/homem-2.jpg" alt="">
                    </div>
                    <div class="contentChat">
                        <p class="nameClient">Luiz Felipe</p>
                        <span class="lastMessage">Precisam de revende...</span>
                    </div>
                </div>
                <div class="showChatWithLastMessage">
                    <div class="image">
                        <img src="assets/images/mulher-2.jfif" alt="">
                    </div>
                    <div class="contentChat">
                        <p class="nameClient">Maria Aparecida</p>
                        <span class="lastMessage">Oii, Apareci! rs</span>
                    </div>
                </div>
                <div class="showChatWithLastMessage">
                    <div class="image">
                        <img src="assets/images/no-photo.jpg" alt="">
                    </div>
                    <div class="contentChat">
                        <p class="nameClient">Usuario Fantasma</p>
                        <span class="lastMessage">Quando vão começar....</span>
                    </div>
                </div><div class="showChatWithLastMessage">
                    <div class="image">
                        <img src="assets/images/no-photo.jpg" alt="">
                    </div>
                    <div class="contentChat">
                        <p class="nameClient">Usuario Fantasma</p>
                        <span class="lastMessage">Quando a promoçao...</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $this->end();?>
<?php $this->unshift('scrs'); ?>
<script src="assets/js/AdminController.js"></script>
<?php $this->end(); ?>