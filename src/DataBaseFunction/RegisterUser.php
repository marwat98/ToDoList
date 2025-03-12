<?php
namespace DataBaseFunction;
use DataBaseConnection\DataBase;
use Interfaces\RegisterUserInterface;
use MessageTwigFunction\MessageHandler;
require_once ('C:\xampp\htdocs\ToDoList\config.php');

class RegisterUser implements RegisterUserInterface{
    private $db;
    private $message;

    public function __construct(DataBase $db, MessageHandler $message){
        $this->db = $db;
        $this->message = $message;
    }
    public function createAcount(string $login, string $email, string $password,string $template):void{
        //connection with data base
        $conn = $this->db->connection();
        if($conn->connect_errno){
            $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
            return;
        }
        // register user to data base
        $passwordHash = password_hash($password,PASSWORD_ARGON2ID);
        $stmt = $conn->prepare("INSERT INTO users (login, email, password) VALUES (?, ?, ?)");

        if (!$stmt) {
            $this->message->showMessage($template, "Błąd przygotowania zapytania", false);
            return;
        }
        $stmt->bind_param('sss',$login,$email,$passwordHash);
        $result = $stmt->execute();

        if ($result) {
            $this->message->showMessage($template, "Pomyślnie zarejestrowano użytkownika: " . $login, true);
                
        } else {
            $this->message->showMessage($template, "Rejestracja się nie powiodła", false);
        }

        $stmt->close(); 
        $this->db->closeConnection();
    }

}
?>