<?php
namespace Interfaces;
interface DataBaseInterface{
    public function dataBaseContent(string $sqlSelect, string $template):array;
}