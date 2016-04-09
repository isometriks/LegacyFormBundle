<?php

namespace Isometriks\Bundle\LegacyFormBundle;

use Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler\FormRegistryCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Craig Blanchette <craig.blanchette@gmail.com>
 */
class IsometriksLegacyFormBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormRegistryCompilerPass());
    }
}
