<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, ['label' => 'Nom', 'required' => true])
            ->add('prenom', null, ['label' => 'Prénom', 'required' => true])
            ->add('login', null, ['label' => 'Login', 'required' => true])
            ->add('mdp', RepeatedType::class, [
                'first_options' => ['label' => "Mot de passe"],
                'second_options' => ['label' => "Répétez le mot de passe"],
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux champs doivent correspondre',
                'required' => true,
                'options' => ['attr' => ['class' => 'password-field']]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
