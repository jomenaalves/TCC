<?php !session_start() && session_start(); ?>
<?php $this->layout('_themeAuth'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="./../assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>
   <section class="containLogin">
       <div class="imgs">
            <img src="../assets/images/logo.png" alt="">
            <p>Cadastre-se no nosso sistema</p>
       </div>
        <section class="stages">
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            <div class="item setEmailAndPass active" data-stage="1">
                <p>1</p>
            </div>
            <div class="item verifyEmail" data-stage="2">
                <p>2</p>
            </div>
            <div class="item succeful" data-stage="3">
                <p>3</p>
            </div>
        </section>

        <section class="formLogin" data-item="1">
            <form action="#" name="sendForm">
                <p class="msgError"></p>
                <div class="form-control">
                    <label for="name">Nome completo</label>
                    <input type="text" name="name" id="name" data-input="input">
                </div>
                <div class="form-control">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email"  data-input="input">
                </div>
                <div class="form-control">
                    <div class="passAndConfirm">
                        <div class="pass">
                            <label for="password">Senha</label>
                            <input type="password" name="pass" id="password"  data-input="input">
                        </div>
                        <div class="conf">
                            <label for="confPass">Confirmar senha</label>
                            <input  type="password" name="confPass" id="confPass"  data-input="input">
                        </div>
                    </div>
                </div>
                <button type="submit" id="sendForm">Enviar</button>
            </form>
            <div class="loading"></div>
        </section>
        <section class="sendEmail" data-item="2">
            <div class="contentnSendEmail">
                <img src="../assets/images/waiting.gif" alt="imageSend" width="90px">
                <p>Estamos quase lá!</p>
                <span>Digite o codigo de verificação que enviamos em seu email</span>
                <div class="codVerify">
                    <input type="text" name="" id="code" maxlength="5" minlength="5"  onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    <button id="verifyCode">Verificar</button>
                </div>

                <div class="loadingSendEmail"></div>
            </div>
        </section>
        <section class="failOrOkay" data-item="3">
            <div class="contentnfailOrOkay">    
                <div class="image">
                    <img src="../assets/images/ok.png" alt="" width="100px">
                </div>
                <p class="text">Prontinho!</p>
                <span class="status">Aguarde enquanto redirecionamos você para pagina principal</span>

                <div class="loading">
                    <img src="../assets/images/loader.gif" alt="" width="75px">
                </div>
            </div>
        </section>
   </section>



   <div class="invalidEmail">
       <div class="content">
           <img src="../assets/images/robot-question.jpg" alt="">
           <h3>Oh não!!</h3>

           <p class="first">Parece que você digitou um e-mail invalido!</p>
           <p class="second">é nessesario um email valido para prosseguir</p>

           <button id="closeModal">Voltar <i class="fas fa-arrow-right"></i></button>
       </div>
   </div>
<?php $this->end();?>   
<?php $this->unshift("scrs"); ?>
    <script src="../assets/js/Utils.js"></script>
    <script src="../assets/js/auth/AuthController.js"></script>
<?php $this->end();?>