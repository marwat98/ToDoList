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