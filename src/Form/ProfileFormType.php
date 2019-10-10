<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName',TextType::class)
            ->add('country',TextType::class)
            ->add('institution',TextType::class)
            ->add('departement',TextType::class)
            ->add('speciality',TextType::class)
            ->remove('username')
        ;
    }

    public function getParent()
    {
        return \FOS\UserBundle\Form\Type\ProfileFormType::class;
    }
}