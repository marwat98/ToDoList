<?php
namespace DataBaseFunction;
use DataBaseConnection\DataBase;
use Interfaces\RegisterUserInterface;
use MessageTwigFunction\MessageHandler;
require_once ('C:\xampp\htdocs\ToDoList\config.php');

class RegisterUser extends RegisterUserInterface{
    private $db;
    private $message;

    public function __construct(DataBase $db, MessageHandler $message){
        $this->db = $db;
        $this->message = $message;
    }
    public function createAcount(string $username, string $email, string $firstPassword, string $secondPassword,string $template):void{
        $conn = $this->db->connection();
        if($conn->connect_errno){
            $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
        }
        $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ? ");
        if($checkEmail->num_rows > 0){
            $this->message->showMessage($template, "Email już istnieje", false);
        }
        $checkEmail->bind_param("s" ,$email);
    }

}
?>