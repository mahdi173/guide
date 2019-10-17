<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName',TextType::class)
            ->add('country',CountryType::class)
            ->add('institution',TextType::class)
            ->add('departement',TextType::class)
            ->add('speciality',TextType::class)
            ->add('termsAccepted', CheckboxType::class, [
                'mapped' => false,
                'constraints' => new IsTrue(),
                'label' => 'Accepte terms and conditions'
            ])
            ->remove('username')
        ;
    }
    public function getParent()
    {
        return \FOS\UserBundle\Form\Type\RegistrationFormType::class;
    }
}
