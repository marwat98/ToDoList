<?php
namespace AbstractClasses;
use DataBaseConnection\DataBase;
use MessageTwigFunction\MessageHandler;

/**
 * Abstract class which implements DataBase class and Message Twig
 */
abstract class  DataBaseAndMessageTwig{
    protected $db;
    protected $message;

    public function __construct(DataBase $db, MessageHandler $message){
        $this->db = $db;
        $this->message = $message;
    }

}



?>