<?php
namespace Interfaces;
interface RegisterUserInterface{
    public function createAcount(string $login, string $email, string $password,string $template):void;
}
?>