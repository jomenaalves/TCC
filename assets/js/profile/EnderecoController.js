
class EnderecoController {
    constructor() {

        this.form = document.querySelector('.address');
        this.secondStage = document.querySelector('.secondStage');
        this.showFormToAddEnd = document.querySelector('.addEnd');
        this.addEndContent = document.querySelector('.addEndContent');
        this.btnsDelete = document.querySelectorAll('[data-delete="deleteAddress"]');
        this.initEvents();
    }



    initEvents() {

        this.showFormToAddEnd.addEventListener('click',() => {
            this.showFormToAddEnd.style.display = "none"; 
            this.addEndContent.style.display = "block";    
            const address = document.querySelectorAll('.addressItem')
            address.forEach(element => element.style.display = "none");
        });


        this.form.cep.addEventListener('keyup', (e) => {
           const value = e.target.value;

           if(value == "" || value.length < 8) {
               this.form.cep.classList.add('error');
               return
           }
           this.form.cep.classList.remove('error');

            // consult CEP
            const url = `https://viacep.com.br/ws/${value}/json/`;

            fetch(url).then(response => response.json())
            .then(response => {
                if(response.erro) {

                    this.form.cep.classList.add('error');
                    this.secondStage.style.display = "none";
                    return;

                }

                this.secondStage.style.display = "block"
                this.form.city.value =  response.localidade
                this.form.uf.value =  response.uf
                this.form.bair.value = response.bairro;
                console.log(response);
            })
        });


        this.form.addEventListener('submit', (e) => {

            e.preventDefault();

            if(this.addEnd()) {
                document.querySelector('.modalFillInAllFields').innerHTML = "Preencha todos os campos!";
                document.querySelector('.modalFillInAllFields').style.display = "flex";

                setInterval(() => {
                    document.querySelector('.modalFillInAllFields').style.display = "none";
                }, 2000);

                return;
            }


            // ADD ENDEREÇO

            const formData = new FormData();
            formData.append('name', this.form.nome.value);
            formData.append('type', this.form.endType.value);
            formData.append('cep', this.form.cep.value);
            formData.append('end', this.form.end.value);
            formData.append('number', this.form.number.value);
            formData.append('info', this.form.info.value);
            formData.append('bair', this.form.bair.value);
            formData.append('city', this.form.city.value);
            formData.append('uf', this.form.uf.value);
            

            const url = `/Elegance/api/addAddress`;

            fetch(url, {method: 'POST', body: formData}).then(response => response.json())
            .then(response => {
                console.log(response);
                if(response.add) {
                    window.location.reload(); 
                    return;
                }

                if(!response.add) {
                    document.querySelector('.modalFillInAllFields').innerHTML = "Já possui um endereço com esses"
                    document.querySelector('.modalFillInAllFields').style.display = "flex";

                    setInterval(() => {
                        document.querySelector('.modalFillInAllFields').style.display = "none";
                    }, 2000);
                }
            })

        });

        this.btnsDelete.forEach(element => element.addEventListener('click', e =>  this.removeEnd(element)));

    }

    addEnd() {

        const firstColumn = this.form.children[0].children;

        const error = { error : false };

        [...firstColumn].forEach(element => {

            const itens = Array.from(element.children);

            const inputValue = itens[1].value


            if(inputValue == "" || inputValue == " ") {       
                error.error = true;
                return error.error;
            }
            
        });

        if(error.error == false) {

            const secondColumn = this.form.children[1].children;

            [...secondColumn].forEach(element => {

                const itens = Array.from(element.children);

                const inputValue = itens[1].value

                if(inputValue == "" || inputValue == " ") {
                    error.error = true;
                    return error.error;
                }

            });
        } 

        return error.error;
    }

    async removeEnd(item) {
        const confirmReturn = confirm('Deseja deletar esse endereço?');

        if(confirmReturn) {

            const formData = new FormData();
            formData.append('id_product', item.id);
            const request = await fetch('/Elegance/api/removeAddress', {method: 'POST', body : formData});
            const response = request.json();

            response.then(response => {
                if(response) {
                    window.location.reload();
                }else{
                    alert('Falha ao deletar esse endereço, tente novamente mais tarde');
                }
            });

        }
    }
}


new EnderecoController();