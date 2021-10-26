
class cadCategory {
    constructor() {
        this.buttonsToOpenModalRegisterCategory = document.querySelectorAll('[data-js="cadCategory"]');
        this.modalToRegisterCategory = document.querySelector('.modalCategory');
        this.imageCategory = document.querySelector('#image');
        this.preview = document.querySelector('.preview');
        this.addImage = document.querySelector('.labelImage'); 
        this.btnNext = document.querySelector('#btnNext');
        this.stage1 = document.querySelector('[data-contentStage="1"]');
        this.stage2 = document.querySelector('[data-contentStage="2"]');
        this.stage3 = document.querySelector('[data-contentStage="3"]');
        this.infoStage = document.querySelector('[data-stage="2"]');
        this.infoStage3 = document.querySelector('[data-stage="3"]');
        this.progress = document.querySelector('.progress');
        this.BtnCadCategory = document.querySelector('#BtnCadCategory');
        this.inputCategory = document.querySelector('#categoryName');
        this.errorText = document.querySelector('.errorText');
        this.contentAllCategories = document.querySelector('#contentAllCategories');
        this.loader = document.querySelector('.loader');
        this.dontExistsCategory = document.querySelector('#dontExistsCategory');
        this.categoriesPhp = document.querySelector('#categoriesPhp');
        this.removeCategory = document.querySelectorAll('[data-removeItem]');

        this.initEvents();
    }


    initEvents(){
        this.buttonsToOpenModalRegisterCategory.forEach(element => {
            element.addEventListener('click', () => {
                this.modalToRegisterCategory.style.display = "flex";
            })
        });
        this.modalToRegisterCategory.addEventListener(('click') ,e => {
            if(e.target.dataset.js == "closeModalCategory") {
                    
                this.stage1.style.display = "block";
                this.stage2.style.display = "none";
                this.stage3.style.display = "none";
                this.preview.style.display = "none";
                this.progress.style.width = "30%";
                this.addImage.innerHTML = ' <i class="fa fa-plus"></i>';
                this.infoStage.classList.remove('activeItem');
                this.infoStage3.classList.remove('activeItem');
                this.modalToRegisterCategory.style.display = "none";
                this.btnNext.setAttribute('disabled', 'true');   
                if(this.inputCategory.classList.contains('error')){
                    this.inputCategory.classList.remove('error');
                    this.errorText.style.display = "none";
                }
            }
        })
        this.imageCategory.addEventListener('change', (e) => {
            this.addImage.innerHTML = '<i class="fas fa-sync-alt"></i>';
            this.btnNext.removeAttribute('disabled');

            const file = e.target.files[0]; 
            const fileReader = new FileReader();

            fileReader.onloadend = () => {
                document.querySelector('.imgPreview').src = fileReader.result;
            }

            fileReader.readAsDataURL(file);
        
            this.preview.style.display = "block";
        });

        this.btnNext.addEventListener('click', () => {
            this.stage1.style.display = "none";
            this.stage2.style.display = "block";
            this.progress.style.width = "75%";
            this.infoStage.classList.add('activeItem');
        })


        this.inputCategory.addEventListener('keyup', (e) => {
            if(e.target.value[0] !== " " && e.target.value !== ""){
                this.BtnCadCategory.removeAttribute('disabled')
                return;
            }
            this.BtnCadCategory.setAttribute('disabled', 'true');   
        })


        this.BtnCadCategory.addEventListener('click', (e) => {
            e.preventDefault();
            this.loader.innerHTML = `<img src="./../assets/images/loader.gif" width="120px">`;
            const name = this.inputCategory.value;
            const image = this.imageCategory.files[0];

            const formData = new FormData();
            formData.append('name', name);
            formData.append('image', image);

            const url = `/Elegance/api/cadCategory`;
            
            fetch(url, {method: 'POST', body: formData}).then(response => response.json())
            .then(response => {

                console.log(response);
                this.loader.innerHTML = ``;
                if(!response.NameIsPossible){
                    this.inputCategory.classList.add('error');
                    this.errorText.style.display = "block";
                    return;
                }


                if(response.ok) {
                    this.stage2.style.display = "none";
                    this.stage3.style.display = "block";
                    this.infoStage3.classList.add('activeItem');
                    this.progress.style.width = "100%";
                    this.updateDivCategories();
                    return;
                }

                console.log(response);
            })
        });

        this.removeCategory.forEach(element => {
            element.addEventListener('click', e => {
                this.removeCategoryFn(element);
            })
        })
    }
    removeCategoryFn(element) {
        const idProductToBeRemoved = element.dataset.removeitem
        const verification = confirm('Deseja deletar essa categoria?');

        if(verification){
            const urlToRemoveCategory = `/Elegance/api/delCategory`;

            const data = new FormData();
            data.append('id', idProductToBeRemoved);

            fetch(urlToRemoveCategory, {method: 'POST', body: data}).then(response => response.json())
            .then(response => {
                if(response.ok) {
                    this.updateDivCategories();
                }
                
                console.log(response);
            });
        }
    }
    updateDivCategories() {
        const urlToGetCategories = `/Elegance/api/getAllCategories`;
        this.contentAllCategories.innerHTML = ``;
        fetch(urlToGetCategories, {method: 'POST'}).then(response => response.json())
        .then(response => {
            if(response.ok){
                if(this.dontExistsCategory){
                    this.dontExistsCategory.style.display = "none";    
                }
                if(this.categoriesPhp){
                    this.categoriesPhp.style.display = "none";
                    this.categoriesPhp.innerHTML = "";
                }
                
                let count =  0;
                response.categories.forEach(element => {
                    count++;
                    this.contentAllCategories.innerHTML += `
                        <div class="categoryItem">
                            <div class="infos">
                                <div class="photoCategory">
                                    <img src="/Elegance/${element.photoCategory}" alt="" width="50px">
                                </div>
                                <div class="name">
                                    <p class="">${element.nome}</p>
                                </div>
                            </div>
            
                            <div class="acoes">
                                <div class="remove" data-removeItem="${element.id}" >
                                    <i class="fas fa-trash-restore-alt"></i>
                                </div>
                                <div class="edit" data-updateItem="${element.id}">
                                    <i class="fas fa-wrench"></i>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                document.querySelector('#count').innerHTML = `Total de itens: ${count}`;
                this.removeCategory = document.querySelectorAll('[data-removeItem]');
                this.removeCategory.forEach(element => {
                    element.addEventListener('click', () => {
                        this.removeCategoryFn(element);
                    })
                })
                return;
            }
            document.querySelector('#count').innerHTML = "";
            this.contentAllCategories.innerHTML = `
                <div class="mainContent" id="dontExistsCategory">
                    <div class="dont-have-category">
                        <img src="./../assets/images/robot-question.jpg" alt="">
                        <p>Você não possui categorias cadastradas</p>
                        <button data-js="cadCategory">cadastrar categoria</button>
                    </div>
                </div>
            `;
            document.querySelectorAll('[data-js="cadCategory"]').forEach(element => {
                element.addEventListener('click', () => {
                    this.modalToRegisterCategory.style.display = "flex";
                })
            });
        })
    }
}

new cadCategory