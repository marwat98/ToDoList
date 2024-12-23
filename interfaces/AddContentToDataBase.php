<?php

interface AddContentToDataBase{
    public function addNote(string $note,string $date):bool|mysqli_result;
}
?>