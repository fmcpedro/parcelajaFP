<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TagencyType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('fagencyname')
                ->add('ffiscalname')
                ->add('ftaxidnumber')
                ->add('faddress', TextareaType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('taxAddress', TextareaType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
//                ->add('fpostalcode1')
//                ->add('fpostalcode2')
//                ->add('flocation')
                ->add('femail1', TextType::class, array(
                    'required' => true,
                ))
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
                //->add('flogo')
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                ])
                ->add('fstate', ChoiceType::class
                        , array(
                    'choices' => array(
                        'Activo' => true,
                        'Inactivo' => false,
            )))
                ->add('subgroup', null, ['required' => true])
                ->add('broker');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tagency'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_tagency';
    }

}
