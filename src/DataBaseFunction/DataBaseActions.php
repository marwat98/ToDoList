 <?php
use DataBaseFunction\AddToDataBase;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!isset($_POST["note"]) || empty(trim($_POST["note"]))){
        throw new Exception("Don't POST variable to data base");
    } else {
        $note = $_POST['note'];
        $data = date('Y-m-d H:i:s');
            
        $addToDataBase = new AddToDataBase();
        $addToDataBase->addNote($note,$data);
    }
}
?> 