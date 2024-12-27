<?php
namespace ToDoInterface;
interface AddNoteToDataBaseInterface{
    public function addNote(string $note, string $template,string $sqlInsert):bool;
}
?>