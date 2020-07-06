<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    /**
     * Retourne un tableau contenant la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    protected function getConfiguration($label, $placeholder, $options = []) {
        return array_merge_recursive([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]], $options);
    }

    /**
     * Retourne un tableau contenant la configuration d'un champ constituée uniquement du label donné en argument
     *
     * @param string $label
     * @return array
     */
    protected function getConfigurationLabel($label) {
        return ['label' => $label];
    }
}