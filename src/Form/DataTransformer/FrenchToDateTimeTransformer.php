<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchToDateTimeTransformer implements DataTransformerInterface
{
    public function transform($date){
        if ($date === null) {
            return null;
        }
        return $date->format('d/m/Y');
    }

    public function reverseTransform($frenchDate){
        // frenchDate = 01/07/2020
        dump($frenchDate);
        if ($frenchDate === null) {
            // Exception
            throw new TransformationFailedException("Vous devez fournir une date.");
        }
        $date = \DateTime::createFromFormat('d/m/Y', $frenchDate);

        if ($date === false) {
            throw new TransformationFailedException("Le format de la date n'est pas celui attendu.");
        }

        return $date;
    }
}