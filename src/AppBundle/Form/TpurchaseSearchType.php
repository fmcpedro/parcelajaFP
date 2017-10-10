<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TpurchaseSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
                $builder
                ->add('agency')
                ->add('fcontractnumber')
//                ->add('fcalcamount')
//                ->add('ftotpurchasevalue')
                ->add('fpurchasedate')
                ->add('fstatus', ChoiceType::class, array(
                    'choices' => array(
                        NULL => '',
                        'Activo' => '1',
                        'Inactivo' => '2',
            )));
                
        
//        
//        $builder->add('fuserid')
//                ->add('fagencyid')
//                ->add('fsupplierid')
//                ->add('fhascitizenid')
//                ->add('fpayid')
//                ->add('fcontractnumber')
//                ->add('fproddescript')
//                ->add('fcalcamount')
//                ->add('ffee')
//                ->add('fextracharge')
//                ->add('fmonthdata')
//                ->add('ftotpurchasevalue')
//                ->add('fmonthpurchasevalue')
//                ->add('fclientdata')
//                ->add('fdocsstate')
//                ->add('fpurchasedate')
//                ->add('fcsimg')
//                ->add('fstatus')
//                ->add('fdocid')
//                ->add('fdocfile');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tpurchase',
            'validation_groups' => false,
            'attr'=>array('novalidate'=>'novalidate')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tpurchase';
    }


}
