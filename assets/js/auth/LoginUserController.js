class LoginUserController extends Utils {
    constructor() {
        super();

        this.formLoginUser = this.$('#formLoginUser');
        this.emailUser = this.$('#email');
        this.passUser = this.$('#password');
        this.btnSubmit = this.$('#submit');
        this.errorFormText = this.$('.errorFormText');
        this.loader = this.$('.loaderl');
        this.successLogin = this.$('.successLogin');
        this.initEvents();
    }

    initEvents() {

        this.on('submit', this.formLoginUser, (e) => {

            e.preventDefault();
            this.btnSubmit.setAttribute('disabled', true);
            this.loader.style.display = "flex";

            const isValidEmail = this.validatesEmail(this.emailUser.value);

            if (!isValidEmail) {

                this.setError(this.emailUser, this.errorFormText, "Email informado invalido!");
                this.loader.style.display = "none";
                this.passUser.classList.remove('error');  
                this.btnSubmit.removeAttribute('disabled');
                return;
            }

            this.removeErrors();
            this.loader.style.display = "flex";


            // make login

            const url = `/Elegance/api/makeLoginUser`;
            const formData = new FormData();

            formData.append('email', this.emailUser.value);
            formData.append('password', this.passUser.value);

            const promisseToMakeLogin = this.makeLogin(formData, url);

            promisseToMakeLogin.then(response => {

                this.loader.style.display = "none";

                this.btnSubmit.removeAttribute('disabled');
                if (!response.success) {

                    this.emailUser.classList.add('error');
                    this.passUser.classList.add('error');  
                    this.errorFormText.style.display = "flex";
                    this.errorFormText.innerHTML = `${response.error}`;

                    return;
                }

                this.formLoginUser.style.display = "none";
                this.successLogin.style.display = "flex";

                setTimeout(() => {
                    window.location.href = "/Elegance/";
                }, 1000);
            });


        });

    }

    removeErrors() {
        this.emailUser.classList.remove('error');
        this.passUser.classList.remove('error');  
        this.errorFormText.style.display = "none";
        this.errorFormText.innerHTML = "";
    }

    setError(input, element, text) {

        input.classList.add('error');
        element.style.display = "block";
        element.innerHTML = `${text}`;
    }

    async makeLogin(formData, url) {

        const response = await fetch(url, { method: 'POST', body: formData });
        const json = await response.json();

        return json;

    }
}


new LoginUserController();