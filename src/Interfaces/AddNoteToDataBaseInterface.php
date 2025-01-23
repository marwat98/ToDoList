<?php
namespace Interfaces;
interface AddNoteToDataBaseInterface{
    public function addNote(string $note, string $template,string $sqlInsert):bool;
}
?>