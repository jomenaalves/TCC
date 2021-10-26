class AvaliableController {
    
    constructor() {

        this.stars = document.querySelectorAll('.productToBeEvaluated .rate .stars');
        this.alreadyRating = document.querySelectorAll('[data-currentRating]');

        this.create();
        this.initEvents();
    }


    create() {

        this.alreadyRating.forEach(element => {
           const totalRating = element.dataset.currentrating;

           const stars = element.children[1].children[1].children;

            for (let index = 0; index < totalRating; index++) {
                stars[index].childNodes[0].classList.add('yellowStar');
            }
           
        });

    }

    initEvents() {

        this.stars.forEach(element => {
            element.addEventListener('mouseover',(e) => {

                const parent = element.closest('[data-id]').parentElement.children
                const qtdStar = element.dataset.id;
                const idFrom = parent;

                Array.from(parent).forEach(element => {
                    const stars = element.children;
  
                    Array.from(stars).forEach(icon => {
                        icon.classList.remove('yellowStar');
                    })
                });

                for (let index = 0; index < qtdStar; index++) {

                    const collection = parent[index].children;
                    Array.from(collection).forEach(element => {
                        element.classList.add('yellowStar');
                    })

                }

            })

            element.addEventListener('mouseleave',() => {
                const parent = element.closest('[data-id]').parentElement.children
                
                Array.from(parent).forEach(element => {
                  const stars = element.children;

                  Array.from(stars).forEach(icon => {
                      icon.classList.remove('yellowStar');
                      this.create();
                  })
                })

            });


            element.addEventListener('click', (e) => {
                const totalStars = element.dataset.id;
                const from = element.parentElement.dataset.idfrom;

                console.log(from);
                const url = `/Elegance/api/updateRating/${totalStars}/${from}`;

                fetch(url, {method: 'POST'}).then(response => response.json())
                    .then(response => {

                        window.location.reload();

                    })
            })
        })
    }
}


new AvaliableController();