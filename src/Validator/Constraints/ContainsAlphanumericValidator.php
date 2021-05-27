<?php
// src/Validator/Constraints/ContainsAlphanumericValidator.php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsAlphanumericValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainsAlphanumeric) {
        throw new UnexpectedTypeException($constraint, ContainsAlphanumeric::class);
        }
        
        // las restricciones personalizadas deben ignorar los valores nulos y vacíos para permitir
         // otras restricciones (NotBlank, NotNull, etc.) se encargan de eso
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // lanza esta excepción si tu validador no puede manejar el tipo pasado para que pueda ser marcado como inválido 
            throw new UnexpectedValueException($value, 'string');

            // separar varios tipos usando tuberías
             // lanza una nueva UnexpectedValueException ($ valor, 'cadena | int');
        }

        if (!preg_match('/^[a-zA-Z0-9 ]+$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
        }
    }
}