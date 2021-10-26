<?php
require "./vendor/autoload.php";

use Firebase\JWT\JWT;

if (isset($_SESSION['jwtTokenUser'])) {
    $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->section("head"); ?>
    <style>
        [type="submit"] {
            cursor: pointer;
        }
    </style>
    <!-- Icones do fonte awesome -->
    <script src="https://kit.fontawesome.com/77cd38f0c6.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="assets/imgs/favicon.jpg" />
</head>

<body>

    <!-- PRÉ LOADER -->
    <!-- <div class="entry-loading">
    <p class="title-entry-loading">Elegance.</p>
    <div class="loader">
       <div class="bar"></div>
    </div>
    <div class="copy">Website feito por José Carlos Omena Alves e Ana Flavia Gomes da Silva</div>
</div>  -->

    <!-- HEADER -->
    <section class="sub">
        <div class="contain">
            <div>
                <p>Telefone para contato: <span>+55 (16) 99125-6598 </span></p>
            </div>
            <div>
                <p><i class="far fa-envelope"></i></p>
            </div>
        </div>
    </section>
    <header class="header">
        <div class="contain">
            <div class="logo">
                <a href="<?= BASE_URL . "/" ?>">
                    <p class="title">Elegance.</p>
                </a>
            </div>
            <div class="search">
                <form action="<?= BASE_URL . "/search" ?>" method="get">
                    <input type="text" name="q" id="q" placeholder="O que você procura?" required value="<?php if (isset($_GET['q'])) echo $_GET['q'] ?>">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="items-and-login">
                <div class="shopping-cart">
                    <a href="<?= BASE_URL . "/carrinho-de-compras" ?>">
                        <div class="item">
                            <img src=" <?= BASE_URL ?> /assets/images/shopping-bag.svg" alt="Sacola" width="18px" title="Sacola de compras">

                        </div>
                    </a>
                    <div class="quant">
                        0
                    </div>
                </div>

                <div class="favorites">
                    <div class="item">
                        <img src=" <?= BASE_URL ?> /assets/images/heart.svg" alt="favoritos" width="18px" title="Favoritos">
                    </div>
                </div>

                <?php if (!isset($_SESSION['jwtTokenUser'])) : ?>
                    <div class="login">
                        <a href="<?= BASE_URL . "/auth/login" ?>">Entrar</a> <i class="fas fa-arrow-right"></i></i>
                    </div>

                <?php else : ?>
                    <div class="perfil">
                        <p>Olá <?= explode(" ", $jwtUserLogged->username)[0] ?></p>
                        <div class="arrow"><i class="fas fa-sort-down"></i></div>

                        <div class="submenu">
                            <a href="<?= BASE_URL . "/user/perfil"?>">Perfil</a>
                            <a href="<?= BASE_URL . "/exit"?>">Sair</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header> <!-- END HEADER -->
    <div class="content">
        <?= $this->section("mainContent"); ?>
    </div>
    <?= $this->section("scrs"); ?>
    <script>
        const showSubMenu = document.querySelector('.perfil');
        const subMenu = document.querySelector('.submenu');

        if (showSubMenu) {
            showSubMenu.addEventListener('click', () => {
                subMenu.classList.toggle('toggleNoneToFlex');
            });

        }


        const url = "/Elegance/api/getAllCartItem";

        fetch(url, {
            method: 'GET'
        }).then(response => {
            return response.json();
        }).then(response => {
            if(response.rows > 0) {
                document.querySelector('.quant').innerHTML = response.rows;
            }
        })
    </script>
</body>

</html>