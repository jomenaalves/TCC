<?php !session_start() && session_start(); ?>
<?php 
    require "./vendor/autoload.php";

    use Firebase\JWT\JWT;
?>
<?php $this->layout('_themeAuth'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="./../assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>

    <section class="sectionLoginUser">
        <a href="<?= BASE_URL . "/"?>">
            <img src="./../assets/images/logo.png" alt="" id="logo">
        </a>

        <?php if(!isset($_SESSION['jwtTokenUser'])) : ?>
            
            <p class="title-section">Olá, bem vindo de volta!</p>
            <div class="ContentLogin">
                <form action="" method="POST" id="formLoginUser" disabled>
                    
                    <p class="errorFormText"></p>
                    <div class="contentform">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" required>
                    </div>   
                    <div class="contentform">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" required>
                    </div>  
                    <button type="submit" id="submit" >Entrar</button>         
                    <div class="loaderl">
                        <img src="./../assets/images/loader.gif" alt="" width="35px">
                    </div>    
                </form>
                
                <div class="successLogin">
                <img src="./../assets/images/ok.png" alt="" width="70px">
                    <p>Logado com sucesso! aguarde enquanto redirecionamos você</p>
                    <img src="./../assets/images/loader.gif" alt="" width="30px" id="loaderSuccessLogin">
                </div>
                <p class="reCaptha">Protegido por google reCaptha <i class="fas fa-shield-alt"></i></p>

            </div>
        <?php else: ?>
            <?php $jwtUserLogged = JWT::decode($_SESSION['jwtTokenUser'], SECRET_KEY, ['HS256']);?>
            <div class="sectionActive">

                <p class="title">Olá, <?= $jwtUserLogged->username ?>!</p>
                <p class="subtitle">Você já possui uma sessão ativa!</p>
                <a href="">sair <i class="fas fa-sign-out-alt"></i></a>
            </div>
        <?php endif;?>
    </section>
    
<?php $this->end() ?>

<?php $this->unshift('scrs') ?>
    <script src="./../assets/js/Utils.js"></script>   
    <script src="./../assets/js/auth/LoginUserController.js"></script>

<?php $this->end() ?>