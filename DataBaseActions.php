<?php
require_once('AddToDataBase.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!isset($_POST["note"])){
        throw new Exception("Don't POST variable to data base");
    } else {
        $note = $_POST['note'];
        $data = date('Y-m-d H:i:s');
        $addToDataBase = new AddToDataBase();
        $addToDataBase->addNote($note,$data);
        return $addToDataBase;
    }
}
?>