<?php

namespace App\Exceptions;

use \Exception;

class WarriorNotFound extends Exception 
{
    public static function getException() 
    {
        try {
            throw new Exception("Warrior not found.");
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }   
}
