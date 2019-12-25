<?php

namespace App\Form;

use App\Entity\User;
use Sulu\Bundle\ContactBundle\Entity\Contact;
use Sulu\Bundle\ContactBundle\Entity\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
//    /**
//     * {@inheritdoc}
//     */
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder
//            ->add('fullName',TextType::class)
//            ->add('country',CountryType::class)
//            ->add('institution',TextType::class)
//            ->add('departement',TextType::class)
//            ->add('speciality',TextType::class)
//            ->add('termsAccepted', CheckboxType::class, [
//                'mapped' => false,
//                'constraints' => new IsTrue(),
//                'label' => 'Accepte terms and conditions'
//            ])
//            ->remove('username')
//        ;
//    }
//    public function getParent()
//    {
//        return \FOS\UserBundle\Form\Type\RegistrationFormType::class;
//    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class);

        $builder->add('email', EmailType::class);

        $builder->add('plainPassword', RepeatedType::class, [
            'mapped' => false,
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],
            'first_name' => 'first',
            'second_name' => 'second',
            'required' => true

        ]);

        $builder->add('firstName', TextType::class, [
            'property_path' => 'contact.firstName',
            'required' => false
        ]);


        $builder->add('lastName', TextType::class, [
            'property_path' => 'contact.lastName',
            'required' => false
        ]);

        $builder->add(
            'terms',
            CheckboxType::class,
            [
                'mapped' => false,
                'required' => true,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
                'validation_groups' => ['registration'],
                'empty_data' => function(FormInterface $form) {
                    $user = new User();
                    $user->setContact(new Contact());

                    return $user;
                }
            ]
        );
    }
}
