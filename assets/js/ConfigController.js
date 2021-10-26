class ConfigController{

    constructor() {
        this.form = document.querySelector('#updateConfig');

        this.initEvents();
    }


    initEvents() {

        this.form.addEventListener('submit', (e) => {
            e.preventDefault();

            
            const url = `/Elegance/api/updateConfig`;
            const formData = new FormData();

            console.log(this.form.service.value);
            formData.append('cepOrigem', this.form.cep.value);
            formData.append('serviceCorr', this.form.service.value);
            formData.append('kg', this.form.kg.value);
            formData.append('embalagem', this.form.embalagem.value);

            const updateConfig = this.updateConfigs(formData, url);

            updateConfig.then(response => {

                console.log(response);

            })
        }); 

    }


    async updateConfigs(formData,url) {

        const response = await fetch(url, {method : 'POST', body : formData});
        const json = await response.json();

        return json;

    }
}


new ConfigController();