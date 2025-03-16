<?php 
namespace Interfaces;
interface DeleteNoteToDataBaseInterface{
    public function deleteNote(int $id, string $template, string $sqlDelete):bool;
}
?>