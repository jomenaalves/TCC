<?php @!session_start() && session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->section("head"); ?>
    <!-- Icones do fonte awesome -->
    <script src="https://kit.fontawesome.com/77cd38f0c6.js" crossorigin="anonymous"></script>
    <link rel="icon" href="https://th.bing.com/th/id/R55669b73c184da6902ca05876cae4d9e?rik=ZUFqFanYB%2fXVkw&riu=http%3a%2f%2fwww.clipartbest.com%2fcliparts%2f4ib%2fLzX%2f4ibLzXgxT.png&ehk=zbAK44hJ9x6rTL3BrYBu%2bK5rioIv50TUo1Hu3VccB%2bw%3d&risl=&pid=ImgRaw" type="image/x-icon" />
</head>

<body>
    <section class="contentDashboard">
        <section class="nav">
            <div class="headerNav">
            
                <img src="./assets/images/logo.png" alt="" width="120px">
                <img src="./../assets/images/logo.png" alt="" width="120px">
                <p>Dashboard</p>
            </div>
            <div class="contentNavDash">
                <p class="titleNav">Menu</p>
                <a href="<?= BASE_URL. "/admin"?>" 
                    class="itemNav <?php if($_SESSION['infoNamePage'] == "/") echo "active";?>"
                    data-item="dashboard"
                >
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <section class="subItem" data-js="components">
                    <a href="">Alertas</a>
                </section>
                <p class="titleNav"> Conteúdos </p>
                <a href="<?= BASE_URL. "/admin/cadastro-de-produtos"?>" 
                   class="itemNav <?php if($_SESSION['infoNamePage'] == "cadProduct") echo "active";?>"
                   data-item="cadProducts"
                >
                    <i class="fas fa-tshirt"></i> Cadastro de Produtos
                </a>
                <a href="<?= BASE_URL. "/admin/cadastro-de-categorias"?>"
                    class="itemNav <?php if($_SESSION['infoNamePage'] == "cadCategory") echo "active";?>" 
                    data-item="delProducts"
                >
                    <i class="fas fa-sitemap"></i> &nbsp; Categorias
                </a>
                <a href="<?= BASE_URL. "/admin/exclusao-de-produtos"?>"
                    class="itemNav <?php if($_SESSION['infoNamePage'] == "delProduct") echo "active";?>" 
                    data-item="delProducts"
                >
                    <i class="fas fa-trash-alt"> </i> &nbsp; Exclusão de Produtos
                </a> 
                <a href="<?= BASE_URL. "/admin/atualizar-produtos"?>" 
                   class="itemNav <?php if($_SESSION['infoNamePage'] == "upProduct") echo "active";?>"
                   data-item="upProducts">
                    <i class="fas fa-wrench"></i> Atualizar Produtos
                </a>
                <p class="titleNav"> Suporte </p>
                <a href="<?= BASE_URL. "/admin/comentarios"?>" class="itemNav <?php if($_SESSION['infoNamePage'] == "comentarios") echo "active";?>" data-item="coments">
                    <i class="fas fa-comment"></i> Comentarios
                </a>
                <p class="titleNav">Configurações</p>
         
                <a href="<?= BASE_URL . "/admin/configs"?>" 
                class="itemNav <?php if($_SESSION['infoNamePage'] == "configs") echo "active";?>">
                    <i class="fas fa-cogs"></i> Configurações
                </a>
                <a href="" class="itemNav">
                    <i class="fas fa-user-shield"></i> Administradores
                </a>
            </div>
        </section>
        <section class="main">
            <?= $this->section("mainContent"); ?>
        </section>

        <?= $this->section("infos"); ?>
        
    </section>
    <?= $this->section("scrs"); ?>
</body>

</html>