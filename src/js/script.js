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
const phrases = ["Logowanie.."];
const element = document.getElementById("login");

let sleepTime = 250;
let curPhraseIndex = 0;

let writeLetter = async () =>{
    while(true){
        let curWord = phrases[curPhraseIndex];
        for (let i = 0; i< curWord.length; i++) {
            element.innerText = curWord.substring(0, i + 1);
            await sleep(sleepTime);
        }
        await sleep(sleepTime * 3);

        for (let i = curWord.length; i > 0; i--) {
            element.innerText = curWord.substring(0, i - 1);
            await sleep(sleepTime);
        }
        await sleep(sleepTime * 3);
        }
   };

writeLetter();

