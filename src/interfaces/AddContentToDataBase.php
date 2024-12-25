<?php
namespace interfaces;
interface AddContentToDataBase{
    public function addNote(string $note, string $date):bool;
}
?>