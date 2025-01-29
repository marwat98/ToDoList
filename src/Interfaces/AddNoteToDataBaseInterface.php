<?php
namespace Interfaces;
interface AddNoteToDataBaseInterface{
    public function addNote(string $note,string $categories, int $pieces, string $template,string $sqlInsert):bool;
}
?>