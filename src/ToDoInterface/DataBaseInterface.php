<?php
namespace ToDoInterface;
interface DataBaseInterface{
    public function dataBaseContent(string $sqlSelect, string $template):array;
}