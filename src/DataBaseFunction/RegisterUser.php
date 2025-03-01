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
    public function createAcount(string $username, string $email, string $password,string $template):bool{
        $conn = $this->db->connection();
        if($conn->connect_errno){
            $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
        }
        $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ? ");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();
        
        if ($checkEmail->num_rows > 0) {
            $this->message->showMessage($template, "Email już istnieje", false);
        }
        $checkEmail->free_result();

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss',$username,$email,$password);

        if (!$stmt) {
            $this->message->showMessage($template, "Błąd przygotowania zapytania", false);
        }
        $result = $stmt->execute();
            if ($result) {
                $this->message->showMessage($template, "Pomyślnie zarejestrowano użytkownika: " . $username, true);
                
            } else {
                $this->message->showMessage($template, "Rejestracja się nie powiodła", false);
            }
            
        return $result;

        $stmt->close(); 
        $this->db->closeConnection();
    }

}
?>