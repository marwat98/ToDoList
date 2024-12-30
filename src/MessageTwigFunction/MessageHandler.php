<?php
namespace MessageTwigFunction;

class MessageHandler{
    private $twig;

    public function __construct($twig){
        $this->twig = $twig;
    }
    public function  showMessage(string $template,string $message,bool $errorException):mixed{

        return $this->twig->display($template,['message' => $message]);

        if($errorException == false){
            return throw new \Exception($message);
        }
    }
}
?>