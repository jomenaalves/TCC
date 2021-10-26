
class HomeController
{
    constructor() {
        this.topSellers = document.querySelector('.top-sellers');
        this.category = document.querySelector('.category');
        this.atualPage = 0;
        this.AllCategories = document.querySelectorAll('.category-item');
        this.lastAddContainer = document.querySelector('.contentLastAdd');
        this.nextLastAddContainer = document.querySelector('.nextBtnToLastAdd');
        this.prevLastAddContainer = document.querySelector('.prevBtnToLastAdd');
        this.contentGoToYourSex = document.querySelector('.gender');
        this.nextSex = document.querySelector('.nextSection');
        this.prevSex = document.querySelector('.prevSection');
        this.lastIndexProducts = 4;
        this.firstIndexProducts = 0;
        this.currentSexItem = 0;

        // best Sellers 
        this.currentBestSellersIndex = 4;
        this.firstIndexBestSellers = 0;
        // this.loader();
        this.initEvents();
    }

    initEvents() {  
    
        const prevButton =  document.querySelector('[data-prevButton="prev"]');
        const nextButton = document.querySelector('[data-nextButton="next"]');
        const itemBestSellers = document.querySelectorAll('.item-seller');


        nextButton.addEventListener('click', () => {
            
            // hide de first item
            const currentLastIndex = itemBestSellers[this.firstIndexBestSellers];
            currentLastIndex.style.display = "none";

            this.currentBestSellersIndex++;
            
            // show de last item
            const nextItemInArray = itemBestSellers[this.currentBestSellersIndex];
            nextItemInArray.style.display = "flex";


            this.firstIndexBestSellers++;

           
            this.activeNextOrPrevButtonInBestSellers(); 
        
        });

        prevButton.addEventListener('click', () => {

            // hide de last item
            const currentLastIndex = itemBestSellers[this.currentBestSellersIndex];
            currentLastIndex.style.display = "none";

            this.currentBestSellersIndex--;

            this.firstIndexBestSellers--;

            
            // show de first item
            const nextItemInArray = itemBestSellers[this.firstIndexBestSellers];
            nextItemInArray.style.display = "flex";



            this.activeNextOrPrevButtonInBestSellers()
        
        })

   

        this.lastAddContainer.addEventListener('mouseover', () => {
           
            this.activeNextOrPrevButtonLastAdd()
        
        });

        this.lastAddContainer.addEventListener('mouseleave', () => {
            this.nextLastAddContainer.style.display = "none";
            this.prevLastAddContainer.style.display = "none";
        });

        this.topSellers.addEventListener('mouseover', () => {

        

            this.activeNextOrPrevButtonInBestSellers();
        });

        this.topSellers.addEventListener('mouseleave', () => {
            const prevButton =  document.querySelector('[data-prevButton="prev"]');
            const nextButton = document.querySelector('[data-nextButton="next"]');

            prevButton.style.display = "none";
            nextButton.style.display = "none";
        });


        this.nextLastAddContainer.addEventListener('click', () => {
            const totalItens = this.lastAddContainer.querySelectorAll('.item');

            totalItens[this.firstIndexProducts].style.display = "none";

            this.lastIndexProducts++;
            this.firstIndexProducts++;
            if(this.lastIndexProducts == totalItens.length -1) this.lastIndexProducts = totalItens.length -1;
            

            totalItens[this.lastIndexProducts].style.display = "flex";

            this.activeNextOrPrevButtonLastAdd()
        })

        this.prevLastAddContainer.addEventListener('click', () => {
            
            const totalItens = this.lastAddContainer.querySelectorAll('.item');

            totalItens[this.lastIndexProducts].style.display = "none";           
            this.lastIndexProducts--;
            
            console.log(this.lastIndexProducts, this.firstIndexProducts);
            
            if(this.lastIndexProducts < 4) this.lastIndexProducts = 4;


            this.firstIndexProducts--;
            if(this.firstIndexProducts <= 0) this.firstIndexProducts = 0;

            
            totalItens[this.firstIndexProducts].style.display = "flex";
            
            this.activeNextOrPrevButtonLastAdd()
        })
    
        this.contentGoToYourSex.addEventListener('mouseover', () => {
            
            this.activeNextOrPrevButtonSex();

        });

        this.contentGoToYourSex.addEventListener('mouseleave', () => {
            const nextButton = document.querySelector('.nextSection');
            const prevButton = document.querySelector('.prevSection');

            nextButton.style.display = "none";
            prevButton.style.display = "none";
        });


        this.nextSex.addEventListener('click', () => {
            
            const allGenderItens = document.querySelectorAll('.gender-item');
            const firstItens = [0,1,2];
            const secondItens = [3,4,5];

        
            this.currentSexItem++;
            if(this.currentSexItem >= 1) this.currentSexItem = 1;

            allGenderItens.forEach(element => element.style.display = "none");

            if(this.currentSexItem == 0) {
                firstItens.forEach(i => {
                   allGenderItens[i].style.display = "flex";
                })
            }

            if(this.currentSexItem == 1) {
                secondItens.forEach(i => {
                    allGenderItens[i].style.display = "flex";
                })
            }

            this.updateCurrent();
            this.activeNextOrPrevButtonSex();
        });

        this.prevSex.addEventListener('click', () => {
            
            const allGenderItens = document.querySelectorAll('.gender-item');
            const firstItens = [0,1,2];
            const secondItens = [3,4,5];

        
            this.currentSexItem--;
            if(this.currentSexItem <= 0) this.currentSexItem = 0;

            allGenderItens.forEach(element => element.style.display = "none");

            if(this.currentSexItem == 0) {
                firstItens.forEach(i => {
                   allGenderItens[i].style.display = "flex";
                })
            }

            if(this.currentSexItem == 1) {
                secondItens.forEach(i => {
                    allGenderItens[i].style.display = "flex";
                })
            }

            this.updateCurrent();
            this.activeNextOrPrevButtonSex();
        })
    
    }
    updateCurrent() {
        const allCurrents = document.querySelectorAll('.countQtdCategories .item');

        allCurrents.forEach(element => element.classList.remove('active'));

        if(this.currentSexItem == 0){
            allCurrents[0].classList.add('active');
        }
        if(this.currentSexItem == 1){
            allCurrents[1].classList.add('active');
        }
    }
    activeNextOrPrevButtonSex() {

        const nextButton = document.querySelector('.nextSection');
        const prevButton = document.querySelector('.prevSection');

        if(this.currentSexItem == 0) {
            nextButton.style.display = "flex";
            prevButton.style.display = "none";
        }

        if(this.currentSexItem == 1) {
            nextButton.style.display = "none";
            prevButton.style.display = "flex";
        }
    }
   
    activeNextOrPrevButtonLastAdd() {
        const totalItens = this.lastAddContainer.querySelectorAll('.item');
        
        const lastItem = totalItens[totalItens.length -1];

        let style = "display";
        let prop = style.replace(/([A-Z])/g, '-$1').toLowerCase();
        
        const displayLastItem = window.getComputedStyle(lastItem,null).getPropertyValue(prop);

        if(totalItens.length > 5 && displayLastItem == "none") {
            this.nextLastAddContainer.style.display = "flex";
            this.prevLastAddContainer.style.display = "none";
        }

        if(displayLastItem == "flex"){
            this.nextLastAddContainer.style.display = "none";
        }
      
        if(this.firstIndexProducts > 0){
            this.prevLastAddContainer.style.display = "flex";
        }
    }


    // Best Sellers Controllers

    activeNextOrPrevButtonInBestSellers() {


        const prevButton =  document.querySelector('[data-prevButton="prev"]');
        const nextButton = document.querySelector('[data-nextButton="next"]');

        const allItensInBestSellers = document.querySelectorAll('.item-seller');
        const lastIndexInArrayBestSellers = allItensInBestSellers[allItensInBestSellers.length - 1];

        let style = "display";
        let prop = style.replace(/([A-Z])/g, '-$1').toLowerCase();

        const displayActiveInLastItem = 
            window.getComputedStyle(lastIndexInArrayBestSellers,null).getPropertyValue(prop);
        
        if(displayActiveInLastItem == "none") {
            nextButton.style.display = "flex";
            prevButton.style.display = "none";
            
        }

        if(displayActiveInLastItem == "flex"){
            nextButton.style.display = "none";
            prevButton.style.display = "flex";  
        }
        
        if(this.firstIndexBestSellers > 0){
            prevButton.style.display = "flex";  
        }

    }

}

const controller = new HomeController();