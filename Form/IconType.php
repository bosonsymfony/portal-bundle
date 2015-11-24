<?php

namespace UCI\Boson\PortalBundle\Form;

use UCI\Boson\PortalBundle\Classes\OptionsArray;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IconType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('icon','choice',array(
                'choices' => OptionsArray::icons()
            ))
            ->add('tile')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UCI\Boson\PortalBundle\Entity\Icon'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'futbol_PortalBundle_icon';
    }
}
