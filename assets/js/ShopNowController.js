class shopNowController {
    constructor() {

        // STEP 1 
        this.btnNextToPaymentMethod = document.querySelector('[data-button="btnNext"]');

        this.haveErrorsInFirstDisplay = { errors: false };
        this.msgErrorFirstDisplay = document.querySelector('.msgErrorFirstDisplay');

        this.allInputsToData = {
            'email': document.querySelector('#email'),
            'nome': document.querySelector('#name'),
            'cpf': document.querySelector('#cpf'),
            'sexo': document.querySelector('#sexo'),
            'dataNasc': document.querySelector('#dataNasc'),
            'address' : document.querySelector('.addressToMount'),
            'city' : document.querySelector('.cityToMount')
        };

        // STEP 2

        this.btnNextFromStep2 = document.querySelector('[data-button="goToLastStep"]');
        this.btnBackToFirtStep = document.querySelector('[data-button="backTo1"]');
        this.paymentMethod = document.querySelectorAll('input[type="radio"][name="payment"]');
        this.paymentMethodFiltered = "";
        // STEP 3

        this.btnBackToStep2 = document.querySelector('[data-js="btnBackToStep2"]');
        this.btnToMakePayment = document.querySelector('[data-js="btnToMakePayment"]');

        // PAYMENT WITH WALLET
        this.modalToPayWithWallet = document.querySelector('.modalToPayWithWallet');
        this.cancelPaymentMethod = document.querySelector('.cancelPaymentMethodAndShowDisplay2');
        this.makePaymentWithWalletBtn = document.querySelector('.makePaymentWithWallet');
        this.btnDontHaveMoney = document.querySelector('#dontHaveMoney');

        this.contentModal = document.querySelector('.contentModalPayWithWallet');

        this.initEvents();
    }


    initEvents() {

        this.btnNextToPaymentMethod.addEventListener('click',
            (e) => this.verifyAllDataAndToggleDiv(e)
        );

        this.btnNextFromStep2.addEventListener('click',
            (e) => this.checkPaymentAndGoToLastStep(e)
        );

        this.btnBackToFirtStep.addEventListener('click', e => this.changeDisplay(1))
        this.btnBackToStep2.addEventListener('click', e => this.changeDisplay(2));


        this.btnToMakePayment.addEventListener('click', (e) => {

            if( this.paymentMethodFiltered == "Paypal" ) {
                // paypal payment
                this.makePayment(e.target.id);
                return;
            }       
            
            if( this.paymentMethodFiltered == "wallet" ) {
                // paypal payment
                this.makePaymentWithWallet(e.target.id);
                return;
            }       

        });


        if(this.btnDontHaveMoney) {
            this.btnDontHaveMoney.addEventListener('click', (e) => {
                this.modalToPayWithWallet.style.display = 'none';
                this.changeDisplay(2);
            })
        }

        if(this.cancelPaymentMethod) {
            this.cancelPaymentMethod.addEventListener('click', (e) => {
                this.modalToPayWithWallet.style.display = 'none';
                this.changeDisplay(2);
            })
        }

        if(this.makePaymentWithWalletBtn){
            this.makePaymentWithWalletBtn.addEventListener('click', (e) => {
                this.makePaymentWithWalletBtn.setAttribute('disabled', 'true');
                const paymentId = "PAYID-" + btoa(`PAGO COM WALLET ${e.target.id} AND ${Date.now()}`);
                const token = btoa(Date.now + e.target.id);
                const payerId = btoa("ID" + Date.now + e.target.id);
    
                const formData = new FormData();
    
                formData.append('paymentId', paymentId);
                formData.append('token', token);
                formData.append('payerId', payerId);
                formData.append('pricePaid', this.makePaymentWithWalletBtn.dataset.pricepaid);
            
                const url = `/Elegance/walletPayment/${e.target.id}`;
    
                fetch(url, {method : 'POST', body : formData})
                    .then(response => response.json())
                    .then(response => {
                        if(response) {

                            const name = document.querySelector('#nameProductBuyed').innerHTML;

                            this.contentModal.innerHTML = `
                            
                                <div class="successBuyedWithWallet">
                                    <img src="./../assets/images/paymentSuccess.gif" width="130px"/>
                                    <p class="firstP">COMPRA FEITA COM SUCESSO!</p>
                                    <p class="secondP">VOCÊ PODE ACOMPANHAR O PROGRESSO DO PRODUTO NO SEU PERFIL!</p>

                                    <div class="statusBuyed">
                                        <p class="titleStatus">Status da compra</p>

                                        <div class="contentStatus">
                                            <div>
                                                <span>NOME</span>
                                                <p>${name.substr(0, 35)}</p>
                                            </div>
                                            <div>
                                                <span>Preço pago</span>
                                                <p>${ this.makePaymentWithWalletBtn.dataset.pricepaid}</p>
                                            </div>
                                        </div>

                                        <a href="/Elegance/">Voltar as compras</a>
                                    </div>
                                </div>

                            `;

                        }else{
                            alert('fudeo');
                        }
                    });
            })
        }
        

    }


    makePayment(id) {

        const url = `/Elegance/paypalPayment/${id}`;

        window.location.href = url

    }

    makePaymentWithWallet() {

        // show Modal to Pay with Wallet
        this.modalToPayWithWallet.style.display = 'flex';


    }

    checkPaymentAndGoToLastStep() {
        
        this.paymentMethod.forEach(element => {
            if(element.checked){
                this.paymentMethodFiltered  = element.id;
                return;
            }
        })

        if(this.paymentMethodFiltered == "") {
            alert('Escolha um metodo de pagamento');
            return;
        }

        this.changeDisplay(3);
        this.mountDisplayTree();
    }

    mountDisplayTree(){

        const contentToMount = document.querySelector('.contentStep3');

        contentToMount.innerHTML = `
            <p>Destinatário: ${this.allInputsToData.nome.value}</p>  
            <p>CPF: ${this.allInputsToData.cpf.value}</p>  
            <p>Data de nascimento: ${this.allInputsToData.dataNasc.value.split('-').reverse().join('/')}</p>
            <p>Sexo: ${this.allInputsToData.sexo.value == "M" ? "Masculino" : "Feminino"}</p>
            <p>${this.allInputsToData.address.innerHTML}</p>
            <p>${this.allInputsToData.city.innerHTML}</p>
        `;

    }

    verifyAllDataAndToggleDiv() {

        // this.btnNextToPaymentMethod.setAttribute('disabled', 'true');

        // CHECK IF ANY FIELD IS EMPTY
        for (const key in this.allInputsToData) {
            if (Object.hasOwnProperty.call(this.allInputsToData, key)) {
                const element = this.allInputsToData[key];

                if (element.value == "") {
                    this.haveErrorsInFirstDisplay.errors = true;
                    break;
                }

                this.haveErrorsInFirstDisplay.errors = false;
            }
        }

        if (this.haveErrorsInFirstDisplay.errors) {
            // SHOW MSG ERROR
            this.msgErrorFirstDisplay.innerHTML = `Preencha todos os campos!`;
            return;
        }

        // VERIFY CPF AND DATA OF BIRTH
        if(!this.validateCPF(this.allInputsToData.cpf.value)) {
            this.allInputsToData.cpf.classList.add('error');
            this.msgErrorFirstDisplay.innerHTML = `Insira um CPF válido`;
            return;
        }

        this.allInputsToData.cpf.classList.remove('error');
        this.msgErrorFirstDisplay.innerHTML = ``;

        const age = this.getAge(this.allInputsToData.dataNasc.value);

        if(age.years < 18) {
            this.allInputsToData.dataNasc.classList.add('error');
            this.msgErrorFirstDisplay.innerHTML = `Precisa ser maior de idade para continuar!`;
            return;
        } 

        this.allInputsToData.dataNasc.classList.remove('error');
        this.msgErrorFirstDisplay.innerHTML = ``;

        // SHOW DISPLAY 2 
        this.changeDisplay(2);
        
    }

    changeDisplay(display) {

        const allDisplay = document.querySelectorAll('[data-infoProductStep]');
        allDisplay.forEach(element => element.classList.remove("activeStepItem"));

        const allDisplayHeader = document.querySelectorAll('.stepItem');
        allDisplayHeader.forEach(element => element.classList.remove("stepActive"));

        const nextDisplay = document.querySelector(`[data-infoProductStep="${display}"]`);
        nextDisplay.classList.add("activeStepItem");

        const displayHeaderActive = document.querySelector(`[data-stepHeader="${display}"]`);
        displayHeaderActive.classList.add("stepActive");
    }

    getAge(birthDate, ageAtDate) {
        var daysInMonth = 30.436875; // Days in a month on average.
        var dob = new Date(birthDate);
        var aad;
        if (!ageAtDate) aad = new Date();
        else aad = new Date(ageAtDate);
        var yearAad = aad.getFullYear();
        var yearDob = dob.getFullYear();
        var years = yearAad - yearDob; // Get age in years.
        dob.setFullYear(yearAad); // Set birthday for this year.
        var aadMillis = aad.getTime();
        var dobMillis = dob.getTime();
        if (aadMillis < dobMillis) {
            --years;
            dob.setFullYear(yearAad - 1); // Set to previous year's birthday
            dobMillis = dob.getTime();
        }
        var days = (aadMillis - dobMillis) / 86400000;  
        var monthsDec = days / daysInMonth; // Months with remainder.
        var months = Math.floor(monthsDec); // Remove fraction from month.
        days = Math.floor(daysInMonth * (monthsDec - months));
        return {years: years, months: months, days: days};
    }
    
    validateCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf == '') return false;
        // Elimina CPFs invalidos conhecidos	
        if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
            return false;
        // Valida 1o digito	
        let add = 0;
        for (let i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        let rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return false;
        // Valida 2o digito	
        add = 0;
        for (let i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
            return false;
        return true;
    }
}


new shopNowController();