class ProductController {
    constructor() {
        this.image = document.querySelector('#mainPhoto');
        this.container = document.querySelector('.mainPhoto');
        this.toZoom = document.querySelector('#imageToZoom');
        this.showAllContent = document.querySelector('#showAllContent');
        this.hideContent = document.querySelector('#hide');
        this.btnToAddToCard = document.querySelector('.addToCart');
        this.statusAddToCart = document.querySelector('.statusAddToCart');
        this.needBeLogged = document.querySelector('.needMakeLogin');
        this.btnRemove = document.querySelector('.removeToCart')
        this.divToAddBtnRemove = document.querySelector('.btnRemove');
        this.addToCartDiv = document.querySelector('.addToCartDiv');
        this.makeQuestion = document.querySelector('#makeQuestion');

        this.initEvents();
    }

    initEvents() {
        // TEMP
        this.image.addEventListener('mousemove', (e) => {
            setTimeout(() => {
                const x = e.clientX - e.target.offsetLeft;
                const y = e.clientY - e.target.offsetTop;
    
                this.image.style.transformOrigin = `${x}px ${y}px`;
                this.image.style.transform = `scale(2)`;    
            }, 10);
            
        });
        this.image.addEventListener('mouseleave', (e) => {

            this.image.style.transformOrigin = 'center';
            this.image.style.transform = `scale(1)`;
        });

        if(this.showAllContent) {
            this.showAllContent.addEventListener('click', () => {
                document.querySelector('.desc60').style.display = "none";
                document.querySelector('.fullDesc').style.display = "block"
            }); 
        }
       
        this.hideContent.addEventListener('click', () => {
            document.querySelector('.desc60').style.display = "flex";
            document.querySelector('.fullDesc').style.display = "none"
        });

        this.makeQuestion.addEventListener('click', () => {
            const comment = document.querySelector('#question');

            if(comment.value == "" || comment.value == " ") {
                comment.classList.add('error');
                return;
            }

            comment.classList.remove('error');

            const formData = new FormData();
            formData.append('comment',comment.value);
            formData.append('id', this.makeQuestion.dataset.id);

            const url = `/Elegance/api/registerComment`;

            fetch(url, {method: 'POST', body: formData}).then(response => response.json())
                .then(response => {
                    if(response){
                        window.location.reload();
                    }
                }); 
        });


        if(this.btnToAddToCard){
            this.btnToAddToCard.addEventListener('click', (e) => {

                this.addOrRemoveFromCard(e);

                //UPDATE QTD IN CARD
                const url = "/Elegance/api/getAllCartItem";

                fetch(url, {method: 'GET'}).then(response => {
                    return response.json();
                }).then(response => {
                    this.updateCart(response.rows);
                })

            })
        }
       
        if(this.btnRemove){ 

            this.btnRemove.addEventListener('click', (e) => {
                this.statusAddToCart.innerHTML = `<img src="./../../assets/images/loader.gif" width="20px"/>`;
            
               this.removeFromCart(e.target.id).then(response => {
                    if(response.success){
                        this.addToCartDiv.innerHTML = `
                            <button class="addToCartJs" id="${e.target.id}">
                                Adicionar ao carrinho
                            </button>
                        `;
                        document.querySelector('.removeToCart').style.display = "none";
                        this.divToAddBtnRemove.innerHTML = ""
                        this.statusAddToCart.innerHTML = "";

                        document.querySelector('.addToCartJs').addEventListener('click', (e) => {
                            this.addOrRemoveFromCard(e);
                        })
                        //UPDATE QTD IN CARD
                        const url = "/Elegance/api/getAllCartItem";

                        fetch(url, {method: 'GET'}).then(response => {
                            return response.json();
                        }).then(response => {
                            this.updateCart(response.rows);
                        })
                        return;
                    }
                    
                    console.log(response);
               });
            });

        }
    }
    addOrRemoveFromCard(e) {
        //         DISABLE BUTTON AND SHOW LOADING         //
    
                /* =============================================== */
                if(this.btnToAddToCard){

                    this.btnToAddToCard.setAttribute('disabled',true);
                }
                this.statusAddToCart.innerHTML = `<img src="./../../assets/images/loader.gif" width="20px"/>`;
            
            /* =============================================== */
            
           const checkIfUserIsLogged = this.checkIfUserIsLogged();

           checkIfUserIsLogged.then(response => {

               if(response.isLogged) {

                    // console.log(response);
                    // add to card
                    const addToCart = this.addProductToCart(e.target.id);
                    
                    addToCart.then(response => {

                        if(response.success) {
                            
                            this.statusAddToCart.innerHTML = ``;
                            if(this.btnToAddToCard){

                                this.btnToAddToCard.style.display = "none";
                            }
                            if(document.querySelector('.addToCartJs')) {
                                document.querySelector('.addToCartJs').style.display = "none";
                            }
                            this.divToAddBtnRemove.innerHTML = ` 
                            <button class="removeToCartJs" id="${e.target.id}">
                                Remover do carrinho 
                                <i class="fas fa-trash-restore"></i>
                            </button>`
                            ;

                            document.querySelector('.removeToCartJs').addEventListener('click', (e) => {
                                this.statusAddToCart.innerHTML = `<img src="./../../assets/images/loader.gif" width="20px"/>`;
            
                                this.removeFromCart(e.target.id).then(response => {

                                    if(response.success){
                                        this.addToCartDiv.innerHTML = `
                                            <button class="addToCartJs" id="${e.target.id}">
                                                Adicionar ao carrinho
                                            </button>
                                        `;
                                        this.divToAddBtnRemove.innerHTML = ""
                                        this.statusAddToCart.innerHTML = "";

                                         document.querySelector('.addToCartJs').addEventListener('click', (e) => {
                                           this.addOrRemoveFromCard(e);
                                        })

                                         //UPDATE QTD IN CARD
                                        const url = "/Elegance/api/getAllCartItem";

                                        fetch(url, {method: 'GET'}).then(response => {
                                            return response.json();
                                        }).then(response => {
                                            this.updateCart(response.rows);
                                        })
                                        return;
                                    }
                                    
                                    console.log(response);
                                });
                            });

                            //UPDATE QTD IN CARD
                            const url = "/Elegance/api/getAllCartItem";

                            fetch(url, {method: 'GET'}).then(response => {
                                return response.json();
                            }).then(response => {
                                this.updateCart(response.rows);
                            })
                        
                        }

                    });

                    return;
                }
                console.log(response);
               // show message to make login
                this.needBeLogged.style.display = "flex";
                this.btnToAddToCard.removeAttribute('disabled');
                this.btnToAddToCard.style.width = "100%"
                this.statusAddToCart.innerHTML = ``;
                return;
           });
    }

    async removeFromCart(id) {

        const formData = new FormData();
        formData.append('idProduct', id);

        const response = await fetch('/Elegance/api/removeFromCard', {method : 'POST', body : formData});
        const json = await response.json();     
    
        return json;
    }
    
    
    updateCart(totalItems) {
        document.querySelector('.quant').innerHTML = totalItems
    }


    async addProductToCart(idProduct) { 

        const formData = new FormData();
        formData.append('idProduct', idProduct);

        const response = await fetch("/Elegance/api/addProductToCard", {method : 'POST', body : formData});
        const json = await response.json();

        return json;

    }


    async checkIfUserIsLogged(){

        const response = await fetch("/Elegance/api/checkIfUserIsLogged", {method : 'POST'});
        const json = await response.json();

        return json;
       
    }
}

new ProductController();