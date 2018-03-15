<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TpurchaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                //->add('fuserid')
                //->add('fagencyid')
                ->add('agency')
                //->add('fsupplierid')
                //->add('fhascitizenid')
                ->add('fpayid')
                ->add('fcontractnumber')
                //->add('fproddescript')
                //->add('fcalcamount')
                //->add('ffee')
                ->add('fextracharge')
                ->add('fmonthdata')
                ->add('ftotpurchasevalue')
                ->add('fmonthpurchasevalue')
                ->add('fclientdata')
                //->add('fdocsstate')
                ->add('fpurchasedate')
                //->add('fcsimg')
                ->add('fstatus', ChoiceType::class, array(
                    'choices' => array(
                        
                        'Activo' => '1',
                        'Inactivo' => '2',
        )))
                //->add('fdocid')
                //->add('fdocfile')
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tpurchase'
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
