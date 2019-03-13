<?php

namespace JournalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class data_t_scopusType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('scopusSourceID')->add('title')->add('citeScore')->add('citationCount')->add('sJR')->add('rANK')->add('publisher')->add('openAccess')->add('scopusSubSubjectArea')->add('quartile')->add('printISSN')->add('eISSN');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JournalBundle\Entity\data_t_scopus'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'journalbundle_data_t_scopus';
    }


}
