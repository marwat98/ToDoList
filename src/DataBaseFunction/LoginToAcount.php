<?php
namespace DataBaseFunction;
use DataBaseConnection\DataBase;
use MessageTwigFunction\MessageHandler;
require_once ('C:\xampp\htdocs\ToDoList\config.php');

class LoginToAcount{
    private $db;
    private $message;

    public function __construct(DataBase $db, MessageHandler $message){
        $this->db = $db;
        $this->message = $message;
    }
    public function loginOnAccount(string $username, string $password, string $template){
        
        $conn = $this->db->connection();
        if($conn->connect_errno){
            $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
            return false;
        }
        $checkAcount = $conn->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');

        if (!$checkAcount) {
            $this->message->showMessage($template, "Błąd zapytania SQL", false);
            return false;
        } 

        $checkAcount->bind_param("s", $username);
        $checkAcount->execute();
        $result = $checkAcount->get_result();
        
        if ($result->num_rows > 0) {
            $this->message->showMessage($template, "Konto nie istnieje", false);
            return false;
        } 

        $user = $result->fetch_assoc();
        if(!password_verify($password,$user['password'])){
            $this->message->showMessage($template, "Niepoprawne hasło", false);
            return false;
        }
    }
}

?>