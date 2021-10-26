class AuthAdminController extends Utils{
    constructor() {
        super();
        this.form = document.querySelector('#MakeAuthAdmin');
        this.msgError = document.querySelector('#msgError');
        this.loader = document.querySelector('.loading');
        this.sectionLogin = document.querySelector('.form-to-login');
        this.redirect = document.querySelector('.redAdmin');
        this.attempts = 0;
        this.totalAttempts = 5;
        this.initEvents();
    }

    initEvents() {
        this.form.addEventListener('submit', (event) => {

            event.preventDefault();
            this.loader.innerHTML = `<img src="./../assets/images/loader.gif" alt="">`;

            if( !this.validatesEmail(this.form.email.value) ) {
                alert('Email informado invalido!');
                return; 
            }

            if(!this.verifyFields()) {
                alert('Preencha todos os campos')
                return;
            }

            // Verificar email 
            const url = `/Elegance/api/verifyEmailInDataBase/${this.form.email.value}`;

            fetch(url, { method: 'POST'}).then(response => response.json())
            .then(response => {
                this.loader.innerHTML = ``;
                console.log(response);
                if(response.isAdmin == true) {
                    console.log('aki');
                    this.verifyPassword(this.form.email.value, this.form.passwd.value, this.form.secret.value)
                    return;
                }
                
                this.msgError.innerHTML = `Email informado invalido!`; 
            })
      
        });
    }
    verifyPassword(email,password,secret) {
        this.loader.innerHTML = `<img src="./../assets/images/loader.gif" alt="">`;
        const url = `/Elegance/api/verifyPassAndLogin/${email}/${password}/${secret}`;

        fetch(url, {method: 'POST'}).then(response => response.json())
        .then(response => {
            this.loader.innerHTML = '';
            if(response.isLogged) {
                this.sectionLogin.style.display = "none";
                this.redirect.style.display = "block";

                setTimeout(() => {
                    window.location.href = "/Elegance/admin";
                }, 3000);

            }else{
                console.log('falha ao logar');
            }
        })
    }


    verifyFields() {

        if(this.form.passwd.value == "" || this.form.passwd.value == " ") {
            return false;
        }

        if(this.form.secret.value == "" || this.form.secret.value == " ") {
            return false;
        }

        return true;
    }
}


new AuthAdminController();