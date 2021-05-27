<?php
// src/Validator/Constraints/ContainsAlphanumeric.php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class ContainsAlphanumeric extends Constraint
{
    public $message = 'Advertencia "{{ string }}" solo es permitido letras y números.';
}