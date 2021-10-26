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
                <a href="<?= BASE_URL . "/user/perfil"?>"> <i class="fas fa-map-marker-alt"></i> <p>Endereços</p></a>
                <a href="<?= BASE_URL . "/user/pedidos"?>"> <i class="fas fa-box"></i> <p>Pedidos</p></a>
                <a href="<?= BASE_URL . "/user/avaliacoes"?>"> <i class="fas fa-star"></i> <p>Avaliações</p></a>
                <a href="<?= BASE_URL . "/user/carteira"?>"> <i class="fas fa-wallet"></i> <p>Carteira</p></a>
                <a href="<?= BASE_URL . "/exit"?>"> <i class="fas fa-sign-out-alt"></i> <p>Sair</p></a>
            </ul>
        </nav>
        <main class="mainPerfil">
            <div class="mainRequests">
                <?php if($productsPcs !== []):?>
                    <p class="title">Seus pedidos</p>
                    <table>
                        <thead>
                            <tr>
                                <td>Nome do produto</td>
                                <td>Comprado em</td>
                                <td>Preço pago</td>
                                <td>Status da entrega</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($productsPcs as $product):?>
                                <tr>
                                    <td><?= mb_strimwidth($product['nome'], 0, 45, "...")?></td>
                                    <td><?= implode("/", array_reverse(explode("-", explode(" ", $product['create_at'])[0])));?> ás <?= explode(" ", $product['create_at'])[1]?></td>
                                    <td>R$ <?= number_format($product['pricePaid'], 2)?></td>
                                    <td>
                                        <?php 
                                            if($product['statusProduct'] == 0){
                                                echo "<div class='status1'> PREPARANDO PACOTE </div>";
                                            }elseif($product['statusProduct'] == 1) {
                                                echo "<div class='status2'> Saiu para entrega </div>";
                                            }else{
                                                echo "<div class='status3'> Produto entregue </div>";
                                            }
                                            
                                            $paymentId = $product['paymentId'];
                                        ?>
                                        <?php if($product['statusProduct'] == 0) echo "<div class='deleteProduct' id='$paymentId' title='Cancelar entrega do produto e receber seu dinheiro de volta'> <i class='fas fa-times'></i> </div>"?>
                                    </td>

                                </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                <?php else:?>
                    <div class="dontHavePurchase">
                        <img src="./../assets/images/boxEmpty.png" alt="" width="80px">
                        <p>Você não possui nenhuma compra feita</p>
                        <a href="<?= BASE_URL . "/"?>">ir as compras</a>
                    </div>
                <?php endif;?>
            </div>
        </main>
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
    <script>

        const allDeleteButtons = document.querySelectorAll('.deleteProduct');

        if(allDeleteButtons !== []) {

            allDeleteButtons.forEach(item => {
                item.addEventListener('click', (e) => {
                    const confirmDelete = confirm('Deseja cancelar a compra desse produto?');

                    if(confirmDelete) {
                        
                        const url = "/Elegance/api/deletePurchase";
                        const formData = new FormData();

                        formData.append('idPayment', item.id);

                        fetch(url, {method : 'POST', body : formData})
                            .then(response => response.json())
                            .then(response => {
                                if(response) {
                                    window.location.reload();
                                }else{
                                    alert('Falha ao cancelar entrega do produto! tente novamente mais tarde')
                                }

                            });
                        
                    }
                })
            })

        }

    </script>
<?php $this->end();?>
