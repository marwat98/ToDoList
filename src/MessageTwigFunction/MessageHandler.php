<?php
namespace MessageTwigFunction;

class MessageHandler{
    private $twig;

    public function __construct($twig){
        $this->twig = $twig;
    }
    // Display message 
    public function showMessage(string $template,string $message):mixed{
        return $this->twig->display($template,['message' => $message]);
    }
}
?>