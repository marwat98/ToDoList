<?php
namespace Interfaces;
interface RegisterUserInterface{
    public function createAcount(string $username, string $email, string $firstPassword, string $secondPassword,string $template):void;
}
?>