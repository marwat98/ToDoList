<?php
namespace AbstractClasses;
use DataBaseConnection\DataBase;
use MessageTwigFunction\MessageHandler;

abstract class  AbstractClassAddEditNote{
    protected $db;
    protected $message;

    public function __construct(DataBase $db, MessageHandler $message){
        $this->db = $db;
        $this->message = $message;
    }
    abstract public function addEditNote(?int $id,string $note,string $categories, int $pieces, string $template,string $sqlInsert):bool;
}


?>