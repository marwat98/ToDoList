<?php
require_once('DataBase.php');
require_once('Interfaces/AddContentToDataBase.php');

class AddToDataBase implements AddContentToDataBase{
    public function addNote(): void{
        $db = new DataBase("localhost","root","","toDoList");
        $conn = $db->connection();
    }
}
?>