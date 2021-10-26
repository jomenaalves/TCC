class CartController extends Utils{
    constructor() {
        super();

        this.removeQtd = this.qsA('.remoceQtd');
        this.addQtd = this.qsA('.addQtd');
        this.subtotal = this.qs('#subtotal');
        this.calcFrete = this.qs('#calcFrete');
        this.cep = this.qs('#cepText'); 
        this.infoCep = this.qs('.contentInfoCep');
        this.loaderCep = this.qs('.loaderCep');
        this.errorTextCep = this.qs('.errorText');
        this.total = this.qs('.totalSpan');
        this.removeProduct = this.qsA('.removeBtn');
        this.shopAllProductsInTheCart = this.qs('#checkout');
        this.initEvents();
    }

    initEvents() {

        this.addQtd.forEach(element => {
            this.on('click', element, (e) => {
                this.addQtdInTheBoxAndUpdateTotal(e);
                this.calculateSubTotal();
            })
        });

        this.removeQtd.forEach(element => {
            this.on('click', element,  (e) => {
                this.removeQtdInTheBoxAndUpdateTotal(e)
                this.calculateSubTotal();
            })
        })

        this.removeProduct.forEach(element => {
            element.addEventListener('click', () => {
             
                const response = confirm('Deseja deletar esse produto do carrinho?');

                if(response) {

                    // Deletar produto do carrinho
                    const url = `/Elegance/api/deleteFromCart/${element.id}`;~

                    fetch(url, {method : 'POST'})
                        .then(response => response.json())
                        .then(response => {
                            
                            if(response) {
                                alert('Produto deletado com sucesso!');
                                window.location.reload();

                                return;
                            }

                            alert('Falha ao deletar produto')

                        })

                }


            })
        });

        this.shopAllProductsInTheCart.addEventListener('click',() => {
            
            //get al itens in shopping cart and generate a array

            const allItensInCart = document.querySelectorAll('.ItemInTheCart');
            const arrayItensInCart = [];

            allItensInCart.forEach(item => {
                
                const getQtd = document.querySelector(`[data-qtd="${item.id}"]`);
                const total = document.querySelector(`[data-update="${item.id}"]`);
                const image = document.querySelector(`[data-image="${item.id}"]`);

               
                const itemProduct = {
                    'product' : item.id,
                    'image' : image.src,
                    'qtd' : getQtd.innerHTML,
                    'total' : total.innerHTML,
                    
                };

                arrayItensInCart.push(itemProduct);
            });
            
            // create a section for this products
            
            const formData = new FormData();
            formData.append('products', JSON.stringify(arrayItensInCart));

            const url = `/Elegance/api/createSectionFromCart`;
            fetch(url, {method: 'POST', body: formData})
                .then(response => response.json())
                .then(response => {
                    if(response){
                        window.location.href = "/Elegance/cart/shop";
                    }
                })


        })
        
    }

    addQtdInTheBoxAndUpdateTotal(e) {

        const idProduct = e.target.dataset.id;
        
        const qtdDiv = this.qs(`[data-qtd="${idProduct}"]`);
        let atualQtd = parseInt(qtdDiv.innerHTML);
        const priceDiv = this.qs(`[data-price="${idProduct}"]`);
        const price = priceDiv.innerHTML;
        const updateDivPrice = this.qs(`[data-update="${idProduct}"]`);

        if(atualQtd == 10) {
            atualQtd = 10;
        }else {
            atualQtd++;
        }
        qtdDiv.innerHTML = atualQtd
        updateDivPrice.innerHTML =  (price * atualQtd).toFixed(2)
        this.updateTotal();
    }

    removeQtdInTheBoxAndUpdateTotal(e) {

        const idProduct = e.target.dataset.id;
        
        const qtdDiv = this.qs(`[data-qtd="${idProduct}"]`);
        let atualQtd = parseInt(qtdDiv.innerHTML);
        const priceDiv = this.qs(`[data-price="${idProduct}"]`);
        const price = priceDiv.innerHTML;
        const updateDivPrice = this.qs(`[data-update="${idProduct}"]`);

        if(atualQtd == 1) {
            atualQtd = 1;
        }else {
            atualQtd--;
        }
        qtdDiv.innerHTML = atualQtd
        updateDivPrice.innerHTML =  (price * atualQtd).toFixed(2)
        this.updateTotal();

    }


    calculateSubTotal(){
        const totalProducts = this.qsA('[data-update]');
        const count = [];

        let soma = 0;

        totalProducts.forEach(element => {
            count.push(parseFloat(element.innerHTML).toFixed(2));
        });

        for(let i = 0; i < count.length; i++){
            soma += parseFloat(count[i]);
        }

        
        this.total.innerHTML = `R$ ${soma.toFixed(2)}`
        this.updateTotal();
    }
    updateTotal() {
        const TotalCart = parseFloat(this.total.innerHTML.replace("R$","")).toFixed(2); 
 

        
            if(this.qs('.priceFreteCor')){


                const fretes = this.qs('.priceFreteCor').innerHTML;
            
                const totalCartUpdated = parseFloat(TotalCart) + parseFloat(freteValue);
    
                this.total.innerHTML = `R$ ${(totalCartUpdated).toFixed(2)}`;
               

            }
     
    }
}

new CartController();