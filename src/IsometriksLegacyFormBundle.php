<?php

namespace Isometriks\Bundle\LegacyFormBundle;

use Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler\FormExtensionCompilerPass;
use Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler\FormRegistryCompilerPass;
use Isometriks\Bundle\LegacyFormBundle\DependencyInjection\IsometriksLegacyFormExtension;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Craig Blanchette <craig.blanchette@gmail.com>
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class IsometriksLegacyFormBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormRegistryCompilerPass());
        $container->addCompilerPass(new FormExtensionCompilerPass(), PassConfig::TYPE_OPTIMIZE);
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new IsometriksLegacyFormExtension();
    }
}
