<?php
namespace Interfaces;
interface AddEditNoteInterface{
    public function addEditNote(?int $id,string $note,string $categories, int $pieces, string $template,string $sqlInsert):bool;
}
?>