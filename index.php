<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ToDoList</title>
</head>
<body>
    <section>
        <div class="container">
            <div class="todolist">
                <h1>ToDoList</h1>
                <ion-icon name="list-circle-outline"></ion-icon>
            </div>
            <div class="todolist_action">
                <input type="text" id="toDo" name="toDo" placeholder="Dodaj tekst">
                <button id="add" name="add">Dodaj</button>
            </div>
            
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
</body>
</html>