<?php
    namespace DataBaseFunction;
    require_once ('C:\xampp\htdocs\ToDoList\config.php');
    use AbstractClasses\DataBaseAndMessageTwig;
    use Interfaces\AddEditNoteInterface;

    /**
     * Class responsible for adding and editing notes in the database.
     */
    class AddEditToDataBase extends DataBaseAndMessageTwig implements AddEditNoteInterface{
        /**
         * Adds or edits a note in the database.
         *
         * @param int|null $id          ID of the note to edit; if null, adds a new note.
         * @param string   $note        Content of the note.
         * @param string   $categories  Categories assigned to the note.
         * @param int      $pieces      Number of pieces (or quantity) related to the note.
         * @param string   $template    Twig template for messages.
         * @param string   $sqlInsert   SQL statement for insert/update.
         *
         * @return bool True if the operation succeeded, false otherwise.
         */
        public function addEditNote(?int $id, string $note, string $categories, int $pieces, string $template, string $sqlInsert): bool {

            $conn = $this->db->connection();

            if ($conn->connect_errno) {
                $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
                return false;
            }

            $stmt = $conn->prepare($sqlInsert);

            if (!$stmt) {
                $this->message->showMessage($template, "Błąd przygotowania zapytania", false);
                return false;
            }

            // Determine parameters based on add or edit mode
            if ($id !== null) {
                $stmt->bind_param("ssii", $note, $categories, $pieces, $id);
            } else {
                $stmt->bind_param("ssi", $note, $categories, $pieces);
            }

            $result = $stmt->execute();

            if ($result) {
                $this->message->showMessage($template, "Pomyślnie wykonano operację: " . $note, true);
            } else {
                $this->message->showMessage($template, "Operacja nie powiodła się", false);
            }

            $stmt->close();
            $this->db->closeConnection();

            return $result;
        }
    }
?>