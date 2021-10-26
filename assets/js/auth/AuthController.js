
    class AuthController extends Utils{
        constructor() {
            super();

            this.btnSendForm = document.querySelector('#sendForm');
            this.form = document.querySelector("[name='sendForm']");
            this.allInput = document.querySelectorAll("[data-input='input']");
            this.msgError = document.querySelector('.msgError');
            this.showMsgEmailNotExist = document.querySelector('.invalidEmail');
            this.closeModalEmail = document.querySelector('#closeModal');
            this.loadingSpace = document.querySelector('.loading');
            this.progress = document.querySelector('.progress');
            this.stage2 = document.querySelector('[data-stage="2"]');
            this.stage3 = document.querySelector('[data-stage="3"]');
            this.contentStage1 = document.querySelector('[data-item="1"]');
            this.contentStage2 = document.querySelector('[data-item="2"]');
            this.code = document.querySelector('#code');
            this.contentStage3 = document.querySelector('[data-item="3"]');
            this.loadingVerifyCode = document.querySelector('.loadingSendEmail');
            this.verifyCode = document.querySelector('#verifyCode');
            this.initEvents();
        }


        initEvents() {
            this.btnSendForm.addEventListener('click', (e) => {

                e.preventDefault();

                if(!this.verifyFieldsForm()) {
                    this.removeAllClassError();
                    this.verifyFieldEmptyAndAddClassError();

                    return;
                }

                if(!this.validatesEmail(this.form.email.value)) {
                    this.showMsgEmailNotExist.classList.add('dis-flex');

                    return;
                }

                if(!this.checkPassAndConfirmPass()) {

                    this.msgError.innerHTML = "Senha e confirmar senha não correspondem!";
                    this.form.pass.classList.add('error');
                    this.form.confPass.classList.add('error');
                    return;
                }

                if(this.checkIfEmailIsAlreadyRegisteredInTheSystem()) {

                    this.msgError.innerHTML = "Email já cadastrado!";
                    return;
                }

                this.sendEmail(this.form.email.value);
                this.removeAllClassError();
                this.msgError.innerHTML = "";
            });

            this.closeModalEmail.addEventListener('click', () => {
                this.showMsgEmailNotExist.classList.remove('dis-flex');
            });

            this.verifyCode.addEventListener('click', () => {

                const code = this.code.value;
                const urlToVerifyCode = `/Elegance/api/verifyCode/${code}`;
                this.loadingVerifyCode.innerHTML = `<img src="../assets/images/loader.gif" width="100x"/>`;
                fetch(urlToVerifyCode, {method: 'POST'}).then(response => response.json())
                .then(response => {
                    this.loadingVerifyCode.innerHTML = "";
                    if( response.ok == true ) {

                        this.loadingVerifyCode.innerHTML = `<img src="../assets/images/loader.gif" width="100x"/>`;
                        this.code.classList.contains('error') && this.code.classList.remove('error');

                        const url = "/Elegance/api/registerUser";

                        const formData = new FormData();
                        formData.append('email', this.form.email.value);
                        formData.append('passwd', this.form.pass.value);
                        formData.append('username', this.form.name.value);
                        formData.append('token', btoa(code));

                        fetch(url , {method: 'POST',body : formData,}).then(response => response.json())
                        .then(response => {
                           this.loadingVerifyCode.innerHTML = "";
                            if( response.ok == true ) {

                                this.progress.style.width = "100%";
                                this.stage3.classList.add('active');
                                this.contentStage2.classList.remove('dis-flex');
                                this.contentStage3.classList.add('dis-flex');

                                setTimeout(() => {
                                    window.location.href = "/Elegance/";
                                }, 2500);
                                return;
                            }
                            console.log({error : 'Token Inválido'});
                        })

                        return;
                    }
                    this.code.classList.add('error');
                });
            }); 
        }

        checkIfEmailIsAlreadyRegisteredInTheSystem() {

            const url = `/Elegance/api/checkIfEmailIsAlreadyRegistered/${this.form.email.value}`;

            fetch(url, {method : 'POST'}).then(response => response.json())
            .then( response => {
                
                if( response.ok == true) {
                    return true; 
                }

                return false;
            });
        }
        sendEmail() {

            //showLoading
            this.loadingSpace.innerHTML = `<img src="../assets/images/loader.gif"/>`;


            fetch(`/Elegance/api/verifyAndSendEmail/${this.form.email.value}`,{method: 'POST'})
                .then(response => {
                    return response.json();
                }).then(response => {
                    this.loadingSpace.innerHTML = '';
                    if(response) { 
                        // email mandado com sucesso
                        this.progress.style.width = "75%";
                        this.stage2.classList.add('active');
                        this.contentStage1.classList.add('dis-none');
                        this.contentStage2.classList.add('dis-flex');
                        return;
                    }
                    
                    alert("Aconteceu algum erro. contate os administradores do sistema");
                })
            
        }

        checkPassAndConfirmPass() {

            if(this.form.pass.value === this.form.confPass.value) {
                return true;
            }

            return false;
        }

        removeAllClassError() {

            this.allInput.forEach ( e => {
                if(e.classList.contains('error')) e.classList.remove("error");
            });

        }

        verifyFieldEmptyAndAddClassError() {

            this.allInput.forEach( e => {

                if(e.value == "" || e.value == " ") {

                    e.classList.add('error');
                    this.msgError.innerHTML = "Preencha todos os campos!";

                }

            });

        }


        verifyFieldsForm() {

            if(this.form.name.value == "" || this.form.name.value == " ") {
                return false;
            }

            if(this.form.email.value == "" || this.form.email.value == " ") {
                return false;
            }

            if(this.form.pass.value == "" || this.form.pass.value == " ") {
                return false;
            }

            if(this.form.confPass.value == "" || this.form.confPass.value == " ") {
                return false;
            }

            return true;
        }
    }


    new AuthController();