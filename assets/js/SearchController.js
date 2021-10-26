class SearchController {
    constructor() {

        this.showAllSex = document.querySelector('[data-js="showSexItens"]')
        this.SexIcon = document.querySelector('[data-js="showSexIconHideOrShow"]');
        this.itensToShowSex = document.querySelector('[data-js="itensToShowSex"]');
        this.showCategories = document.querySelector('[data-js="showCategoryItens"]');
        this.CategoriesIcon = document.querySelector('[data-js="showCategoryIcon"]');
        this.showCategoriesItens = document.querySelector('[data-js="itensToShowCategory"]');
        this.goTo = document.querySelectorAll('[data-js="goTO"]');
        this.changeSex = document.querySelector('#changeSex');
        this.initialProducts = document.querySelector('.initialProducts');
        this.allInitialProducts = document.querySelectorAll('.productFiltered');
        this.params = [];
        this.initEvents();
    }


    initEvents() {
    
        this.goTo.forEach(element => {
            element.addEventListener('click', (e) => {

                e.preventDefault();
                const idCategory = e.target.dataset.categoryid;
                const allProducts = document.querySelectorAll('.productFiltered');
                const getAllsCategoryId = [];


                this.allInitialProducts.forEach(element => element.style.display = "none");

                allProducts.forEach(element => {
                    getAllsCategoryId.push(element.dataset.category);
                });

                const filteredProducts = getAllsCategoryId.filter(item => item == idCategory);

                if(filteredProducts.length > 0) {
                    
                    document.querySelector('.showMsgErrorJs').style.display = "none";
                    const products = [];

                    filteredProducts.forEach(e => {
                        const productFiltered = document.querySelectorAll(`[data-category="${e}"]`);

                        productFiltered.forEach(e => {
                            products.push(e);
                        });
                    });


                    products.forEach(element => {
                        element.style.display = "block";
                    })

                    return;
                }
               
                
                if(!document.querySelector('.showMsgError')){
                    document.querySelector('.showMsgErrorJs').style.display = "flex";
                }

                
                
            });
        })

        this.changeSex.addEventListener('change', (e) => {
            const itemSelected = this.changeSex.options[this.changeSex.selectedIndex];
            
            const url = `/Elegance/filters?sex=${itemSelected.value}`;

            window.location.href = url;

            console.log(url);
        })
    }
}


new SearchController();
 