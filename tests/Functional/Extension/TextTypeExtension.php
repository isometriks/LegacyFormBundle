<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\Functional\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextTypeExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('custom_option', 'custom_value');
    }

    public function getExtendedType()
    {
        return 'custom_text';
    }
}
