<?php
namespace DataBaseFunction;
require_once ('C:\xampp\htdocs\ToDoList\config.php');

use AbstractClasses\DataBaseAndMessageTwig;
use Interfaces\AddEditNoteInterface;

/**
 * Class responsible for adding and editing notes in the database.
 */
class AddEditToDataBase extends DataBaseAndMessageTwig implements AddEditNoteInterface {
    
    /**
     * Adds or updates a note in the database.
     *
     * @param int|null $id         ID of the note to edit; if null, a new note is added.
     * @param string   $note       Content of the note.
     * @param string   $categories Categories assigned to the note.
     * @param int      $pieces     Quantity related to the note.
     * @param string   $template   Twig template for displaying messages.
     * @param string   $sqlInsert  SQL statement for insert/update.
     *
     * @return bool True if the operation succeeded, false otherwise.
     */
    public function addEditNote(?int $id, string $note, string $categories, int $pieces, string $template, string $sqlInsert): bool {
        
        // Establish a connection with the database
        $conn = $this->db->connection();
        if ($conn->connect_errno) {
            $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
            return false;
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare($sqlInsert);
        if (!$stmt) {
            $this->message->showMessage($template, "Błąd przygotowania zapytania: " . $conn->error);
            $conn->close();
            return false;
        }

        // Define parameter types and values based on whether $id is provided
        $types = ($id !== null) ? "ssii" : "ssi";
        $arguments = ($id !== null) ? [$note, $categories, $pieces, $id] : [$note, $categories, $pieces];

        // Bind parameters and check for errors
        if (!$stmt->bind_param($types, ...$arguments)) {
            $this->message->showMessage($template, "Błąd bindowania parametrów: " . $stmt->error);
            $stmt->close(); 
            $this->db->closeConnection();
            return false;
        }

        // Execute the statement
        $result = $stmt->execute();

        // Show success or failure message
        $this->message->showMessage(
            $template, 
            $result ? "Pomyślnie wykonano operację: " . $note : "Operacja nie powiodła się: " . $stmt->error
        );

        // Close database resources
        $stmt->close();
        $this->db->closeConnection();

        return $result;
    }
}
?>
