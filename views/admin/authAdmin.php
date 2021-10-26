<?php $this->layout('../_globalTheme'); ?>

<?php $this->unshift('head') ?>
    <title> <?= $this->e($title) ?> </title>
    <link rel="stylesheet" href="./../assets/css/style.css">
    <style>
        body{
            background-color: #fff;
        }
    </style>
<?php $this->end() ?>

<?php  $this->unshift('mainContent');?>
    
    <section class="apresentation-login-admin">
        <div class="logo-image">
            <img src="./../assets/images/logo.png" alt="logo">
            <h1>Área de autentificação de admininstrador</h1>
        </div>
    </section>

    <section class="form-to-login">
        <div class="form">
            <form action="" method="POST" id="MakeAuthAdmin">
            <div id="msgError"></div>
                <div class="form-control">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-control">
                    <label for="password">Senha</label>
                    <input type="password" name="passwd" id="passwd" required>
                </div>
                <div class="form-control">
                    <label for="secret_word">Palavra secreta</label>
                    <input type="text" name="secret" id="secret" required>
                </div>
                <button type="submit">Entrar</button>
                <div class="loading"></div>
            </form>
        </div>
    </section>
    <section class="redAdmin">
        <div class="content">
            <img src="./../assets/images/ok.png" alt="ok" width="80px">
            <p>Aguarde enquanto redirecionamos você.</p>

            <img src="./../assets/images/loader.gif" alt="" width="150px">
        </div>
    </section>  
<?php $this->end();?>
<?php $this->unshift('scrs');?>
    <script src="./../assets/js/Utils.js"></script>
    <script src="./../assets/js/auth/AuthAdminController.js"></script>
<?php $this->end();?>