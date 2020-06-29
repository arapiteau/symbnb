<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration('Prénom', 'Votre prénom'))
            ->add('lastName', TextType::class, $this->getConfiguration('Nom', 'Votre nom'))
            ->add('email', EmailType::class, $this->getConfiguration('E-mail', 'Votre adresse e-mail'))
            ->add('hash', PasswordType::class, $this->getConfiguration('Mot de passe', 'Choisissez votre mot de passe'))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration('Confirmation de mot de passe', 'Confirmez votre mot de passe'))
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction', 'Quelques mots sur vous'))
            ->add('description', TextareaType::class, $this->getConfiguration('Description', 'Présentez-vous plus en détail'))
            ->add('picture', TextType::class, $this->getConfiguration('Avatar', 'Insérez une URL de votre avatar'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
