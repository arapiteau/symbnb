<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfigurationLabel('Prénom'))
            ->add('lastName', TextType::class, $this->getConfigurationLabel('Nom'))
            ->add('email', EmailType::class, $this->getConfigurationLabel('E-mail'))
            ->add('introduction', TextType::class, $this->getConfigurationLabel('Introduction'))
            ->add('description', TextareaType::class, $this->getConfigurationLabel('Description'))
            ->add('picture', UrlType::class, $this->getConfigurationLabel('Avatar'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
