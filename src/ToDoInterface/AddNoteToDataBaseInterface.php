<?php
namespace ToDoInterface;
interface AddNoteToDataBaseInterface{
    public function addNote(string $note, string $template,$data = array(),string $sqlInsert):bool;
}
?>