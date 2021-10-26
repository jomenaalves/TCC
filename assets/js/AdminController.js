class AdminController {
    constructor() {
        this.btnOpenComponents = document.querySelector('[data-js="openComponets"]');
        this.components = document.querySelector('[data-js="components"]');
        this.allButtons = document.querySelectorAll('[data-item]');
        this.formProducts = document.querySelector('#cadProducts');
        this.preview = document.querySelector('#preview');
        this.addPhoto = document.querySelector('#photo');
        this.previewImages = document.querySelector('.allPhotos');
        this.errorForm = document.querySelector('.errorForm');
        this.mainImage = document.querySelectorAll('.photoSelected');
        this.priceFloat = 0.00;
        this.mainImageSelected = "";
        this.initEvents();
    }

    initEvents() {


        this.formProducts.addEventListener('submit', event => {
            event.preventDefault();

            document.querySelector('#submitButton').setAttribute('disabled', 'true');
            document.querySelector('.loaderSubmitForm').innerHTML = `<img src="./../assets/images/loader.gif"/>`;

            if ( parseInt(this.formProducts.InitialPrice.value) < 1) {
                this.formProducts.InitialPrice.classList.add('error');
                this.formProducts.InitialPrice.value = "0,00";

                setTimeout(() => {
                    document.querySelector('#submitButton').removeAttribute('disabled');
                    document.querySelector('.loaderSubmitForm').innerHTML = ``;
                }, 100);


                return;
            }

            if (this.formProducts.InitialDiscount.value < 0) {
                this.formProducts.InitialDiscount.classList.add('error');

                setTimeout(() => {
                    document.querySelector('#submitButton').removeAttribute('disabled');
                    document.querySelector('.loaderSubmitForm').innerHTML = ``;
                }, 100);

                return;
            }

            this.formProducts.InitialDiscount.classList.remove('error');
            this.formProducts.InitialPrice.classList.remove('error');
          
            if (this.mainImageSelected == "") {

                document.querySelector('.notBeNull').style.display = "block";

                setTimeout(() => {
                    document.querySelector('#submitButton').removeAttribute('disabled');
                    document.querySelector('.loaderSubmitForm').innerHTML = ``;
                }, 100);

                return;
            }

            if (this.formProducts.InitialDiscount.value > 100) {
                this.formProducts.InitialDiscount.value = 100
            }

            const formData = new FormData();
            const body = this.appendFormData(formData, [{
                nome: this.formProducts.name.value,
                sex: this.formProducts.sex.value,
                category: this.formProducts.category.value,
                tam: this.formProducts.tam.value,
                group: this.formProducts.group.value,
                piece: this.formProducts.piece.value,
                estq: this.formProducts.estq.value,
                InitialPrice: this.priceFloat,
                InitialDiscount: this.formProducts.InitialDiscount.value,
                image: this.mainImageSelected,
                allImages : this.addPhoto.files,
                desc: this.formProducts.desc.value,
            }]);

            const url = "/Elegance/api/cadProduct";

            fetch(url, { method: 'POST', body: body }).then(response => response.json())
            .then(response => {
                document.querySelector('.notBeNull').style.display = "none";
                document.querySelector('#submitButton').removeAttribute('disabled');
                document.querySelector('.loaderSubmitForm').innerHTML = ``;


                if(response.NameIsPossible == false) {
                    this.formProducts.name.classList.add('error');
                    this.errorForm.style.opacity = 1;
                    this.errorForm.style.display = "flex"
                    this.errorForm.querySelector('p').innerHTML = "Nome informado já cadastrado!";
                    
                    setTimeout(() => {
                        this.errorForm.style.opacity = 0;
                        this.errorForm.style.display = "none"
                    }, 3000);

                    return;
                }

                if(response.success){

                    this.formProducts.name.classList.remove('error');
                    this.formProducts.InitialPrice.classList.remove('error');

                    this.makeUploadAllImages(this.addPhoto.files);
                    
                    document.querySelector('.successForm').style.opacity = 1;
                    document.querySelector('.successForm').style.display = "flex";

                    setTimeout(() => {

                        document.querySelector('.successForm').style.opacity = 0;
                        document.querySelector('.successForm').style.display = "none";
                        
                    }, 3000);

                }
            });
            

        })

        this.addPhoto.addEventListener('change', () => {
            const files = this.addPhoto.files;
            this.previewImages.innerHTML = ``;

            // verificar se o total de imagens é maior doq 5
            if (files.length > 5) {
                this.addPhoto.value = "";
                //mostrar mensagem de erro
                this.errorForm.style.opacity = 1;
                this.errorForm.style.display = "flex"

                setTimeout(() => {
                    this.errorForm.style.opacity = 0;
                    this.errorForm.style.display = "none"
                }, 3000);

                return;
            }

            let identifier = 0;
            Array.from(files).forEach(element => {
                const fileReader = new FileReader();

                fileReader.onloadend = () => {
                    this.previewImages.innerHTML += `
                    <div class="photoSelected" id="${identifier}">
                        <img src="${fileReader.result}" alt="">
                    </div>
                    `;
                    identifier++
                }
                fileReader.readAsDataURL(element);
            });

            setTimeout(() => {
                document.querySelectorAll('.photoSelected')[0].classList.add('mainPhoto');
                this.mainImageSelected = this.addPhoto.files[0];

                document.querySelectorAll('.photoSelected').forEach((element) => {
                    element.addEventListener('click', () => {
                        this.addMainPhoto(element.id);
                    })
                })
            }, 100);
        });

        this.formProducts.InitialPrice.addEventListener('keyup', (event) => {
            // formatar input
            const formatNumber = this.Format(this.formProducts.InitialPrice.value);
            this.formProducts.InitialPrice.value = formatNumber;

            this.priceFloat =  this.formProducts.InitialPrice.value
        })
    }

    makeUploadAllImages(files) {
        console.log(files);
        const url = `/Elegance/api/addPhotosProducts`;

        Array.from(files).forEach(element => {

            const body = new FormData();
            body.append('image', element)
            fetch(url, {method: 'POST', body: body}).then(response => response.json())
            .then(response => {
                console.log(response);
                if(response.success){
                    return true;
                }
                return false
            })

        });
    }
    Format(valor)
    {
        const v = ((valor.replace(/\D/g, '') / 100).toFixed(2) + '').split('.');
    
        const m = v[0].split('').reverse().join('').match(/.{1,3}/g);
    
        for (let i = 0; i < m.length; i++)
            m[i] = m[i].split('').reverse().join('') + '.';
    
        const r = m.reverse().join('');
    
        return r.substring(0, r.lastIndexOf('.')) + '.' + v[1];
    }
    appendFormData(formData, ItemToAppend) {

        for (const [key, value] of Object.entries(ItemToAppend[0])) {
            formData.append(key, value);
        }
        return formData;

    }
    makeUploadImages(images) {

    }
    addMainPhoto(id) {

        document.querySelectorAll('.photoSelected').forEach(element => {
            if (element.classList.contains('mainPhoto')) {
                element.classList.remove('mainPhoto');
            }
        });

        document.querySelectorAll('.photoSelected')[id].classList.add('mainPhoto');

        this.mainImageSelected = this.addPhoto.files[id];
    }

    toggleActiveButtons() {

        console.log('activeButtons');
    }

    setLocalStoragePage(page) {
        switch (page) {
            case 'dashboard':
                localStorage.setItem('page', 'dashboard');
                break;
            case 'cadProducts':
                localStorage.setItem('page', 'cadProducts');
                break;
            case 'delProducts':
                localStorage.setItem('page', 'delProducts');
                break;
            case 'upProducts':
                localStorage.setItem('page', 'upProducts');
                break;
            case 'coments':
                localStorage.setItem('page', 'coments');
                break;
            case 'email':
                localStorage.setItem('page', 'email');
                break;
            default: 'dashboard'
                localStorage.setItem('page', 'dashboard');
                break;
        }
    }

    verifyIfIsEmpty(value) {
        if (value == "" && value == " ") {
            return false;
        }

        return true;
    }
}



new AdminController();

