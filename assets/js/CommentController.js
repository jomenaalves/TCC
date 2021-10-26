class CommentController{
    constructor(){
        this.answer = document.querySelectorAll('[data-aswer="answer"]');
        this.delQuestion = document.querySelectorAll('[data-remove="remove"]')
        this.upComment = document.querySelectorAll('[data-edit="edit"]')

        this.initEvents();
    }


    initEvents() {
        
        this.answer.forEach(element => {
            element.addEventListener('click', (e) => {
                this.answerComment(e)
            })
        });

        this.delQuestion.forEach(element => {
            element.addEventListener('click', (e) => {
                this.deleteQuestion(e);
            })
        });

        this.upComment.forEach(element => {
            element.addEventListener('click', (e) => {
                this.updateComment(e);
            })
        });

    }

    async answerComment(e) {
        const answer = prompt('Digite a sua resposta aki');
        if(answer){
           const url = "/Elegance/api/makeAnswer";

           const formData = new FormData();
           formData.append('answer', answer);
           formData.append('id', e.target.id);

           const request = await fetch(url, {method: 'POST', body: formData});
           const response = request.json();

           response.then(response => {
              if(response.success == true){
                  window.location.reload();
              }
           });
        }

    }

    async deleteQuestion(e) {
        const confirms = confirm('Deseja Deletar essa pergunta?');
        if(confirms){
           const url = "/Elegance/api/removeQuestion";

           const formData = new FormData();
           formData.append('id', e.target.dataset.id);

           const request = await fetch(url, {method: 'POST', body: formData});
           const response = request.json();

           response.then(response => {
              if(response.success == true){
                  window.location.reload();
              }
           });
        }

    }


    async updateComment(e){
        const answer = prompt('Digite a sua resposta aki', e.target.dataset.answer);
        if(answer){
           const url = "/Elegance/api/makeAnswer";

           const formData = new FormData();
           formData.append('answer', answer);
           formData.append('id', e.target.dataset.id);

           const request = await fetch(url, {method: 'POST', body: formData});
           const response = request.json();

           response.then(response => {
              if(response.success == true){
                  window.location.reload();
              }
           });
        }
    }

}

new CommentController();