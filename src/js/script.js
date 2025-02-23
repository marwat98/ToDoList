const listContainer = document.getElementById('list-container');

listContainer.addEventListener("click", function(e){
    if(e.target.tagName === "LI"){
        e.target.classList.toggle("checked");
    }
});

function addDeleteNoteAjax(event,formID){
    event.preventDefault();

    const button = event.target;
    const formData = new FormData(document.getElementById(formID));
    formData.append(button.name, button.value);

    fetch('src/DataBaseFunction/DataBaseActions.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Błąd AJAX: ${response.status} ${response.statusText}`);
            }
            return response.text();
        })
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => {
            alert('Wystąpił błąd: ' + error.message);
        });
    };
    document.addEventListener('DOMContentLoaded', function() {
        const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        myModal.show();
    });    

    function sleep(ms){
        return new Promise((resolve)=> setTimeout(resolve,ms));
    }
    const fruits = ["🍎", "🍌", "🍊"]; 
    const fruitElement = document.getElementById("fruits");
    let fruitIndex = 0;
    const sleepTime = 500; 

    const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

    let animateFruits = async () => {
        while (true) {
            let currentFruit = fruits[fruitIndex];

            fruitElement.innerText = " " + currentFruit;
            await sleep(sleepTime * 4);

            fruitElement.innerText = "";
            await sleep(sleepTime * 2);

            fruitIndex = (fruitIndex + 1) % fruits.length;
        }
    };


    animateFruits();
