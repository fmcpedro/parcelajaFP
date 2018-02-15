<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagencyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fagencyname')
                ->add('ffiscalname')
                ->add('ftaxidnumber')
                ->add('faddress')
                ->add('fpostalcode1')
                ->add('fpostalcode2')
                ->add('flocation')
                ->add('femail1')
                ->add('femail2')
                ->add('fcontactperson')
                ->add('ftelephone')
                ->add('fmobilephone')
                ->add('fwebsite')
                ->add('fbank')
                ->add('fiban')
                ->add('fbicswift')
                ->add('frnavt')
                ->add('fpaymethodid')
                ->add('flogo')
                ->add('fstate')
                ->add('subgroup')
                ->add('broker');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tagency'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tagency';
    }


}
