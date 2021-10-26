class AdminDelController {

    constructor () {
        this.allButtonsToDelete = document.querySelectorAll('[data-delete="deleteItem"]');
        this.allProducts = document.querySelector('.productsContentToDelete');
        this.loader = document.querySelector('.loading');
        this.pagination = document.querySelector('.createPagination');
        this.page = 1;
        this.maxPages = 0;
        
        this.pagination.innerHTML = "";
        this.create();
        this.initEvents();
    }


    initEvents() {

        this.allButtonsToDelete.forEach(element => {
            
            
            this.pagination.innerHTML = "";
            this.deleteProduct(element);
    
        });

    }


    create() {
        
        this.pagination.innerHTML = "";
        const urlToGetNumberOfProducts = `/Elegance/api/numberOfProducts`;

        const url_string = window.location.href; 
        const url = new URL(url_string);
        let page = url.searchParams.get("page");
        page == null ?  page = 1 : page = page

        fetch(urlToGetNumberOfProducts, {method: 'POST'}).then(response => response.json())
        .then(response => {
            
            const numbersToMakePaginate = Math.ceil(response / 12);
            this.maxPages = numbersToMakePaginate;

            let maxLeft = (parseInt(page) - Math.floor(5 / 2));
            let maxRight = (parseInt(page) + Math.floor(5 / 2));

            if(maxLeft < 1 ) {

                maxLeft = 1; 
                maxRight = 5;
            
            }

            if(maxRight > numbersToMakePaginate) {

                maxLeft = page - ( 5  - 1 ); 
                maxRight = numbersToMakePaginate;

                if(maxLeft < 1) maxLeft = 1;

            }
            
            
            this.pagination.innerHTML = "";
            for (let index = maxLeft; index <= maxRight; index++) {
                this.pagination.innerHTML += `    
                    <a href="?page=${index}" class="numbers">${index}</a>
                `
            }
        })

    }
    deleteProduct(element) {
        element.addEventListener('click', (e) => {
            this.allProducts.innerHTML = ``;
            this.pagination.innerHTML = "";

            const urlToDeleteProduct = `/Elegance/api/deleteProduct/${element.dataset.id}`;

            this.loader.style.display = "flex";

            fetch(urlToDeleteProduct, {method: 'POST'}).then(response => response.json())
            .then(response => {

                const url_string = window.location.href; //window.location.href
                const url = new URL(url_string);
                let page = url.searchParams.get("page");
                
                page == null ?  1 : page

                const getLastProducts = `/Elegance/api/getAllProducts/${page}`;

                fetch(getLastProducts, {method: 'POST'}).then(response => response.json())
                .then(response => {

                    if(response.products !== []) {
                        this.allProducts.innerHTML = ``;

                        response.products.forEach(product => {

                            const price = product.InitialPrice.split(",")

                            this.allProducts.innerHTML += `
                        
                                <div class="card">
                                    <div class="photo">
                                        <img src="/Elegance/${product.photoProduct}" alt="">
                                    </div>
                                    <div class="contentCardDelete">
                                        <p class="price"> ${new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' }).format(price)}</small></p>
                                        <p>${product.nome}</p>
                                        <button id="${product.id_product}" data-id="${product.id_product}" data-delete="deleteItem">
                                         <i class="fas fa-trash-restore-alt" data-id="${product.id_product}" data-delete="deleteItem"></i>
                                        </button>
                                    </div>
                                </div>

                            `;

                            document.querySelectorAll('[data-delete="deleteItem"]').forEach(element => {
                                element.addEventListener('click', this.deleteProduct(element));
                            });

                            this.loader.style.display = "none";
                        });
                        
                        this.create();
                    }

                    if(response.products == ""){
                        this.loader.style.display = "none";
                        var Url = window.location.href.split('?');

                        if(this.maxPages == 0){
                            this.maxPages = 1;
                        }
                        document.location = Url[0] + `?page=${ this.maxPages - 1}`; 
    
                    }


                });

            });
        }); 

    }

}


new AdminDelController();