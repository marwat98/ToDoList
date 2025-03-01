<?php
namespace Interfaces;
interface RegisterUserInterface{
    public function createAcount(string $username, string $email, string $password,string $template):bool;
}
?>