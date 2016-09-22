<?php

namespace Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler;

use Isometriks\Bundle\LegacyFormBundle\Form\Extension\DependencyInjectionExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Craig Blanchette <craig.blanchette@gmail.com>
 */
final class FormExtensionCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $originalDefinition = $container->getDefinition('form.extension');
        $typeExtensionServiceIds = $originalDefinition->getArgument(2);

        $newDefinition = new Definition(
            DependencyInjectionExtension::class,
            [
                $originalDefinition,
                new Reference('service_container'),
                $typeExtensionServiceIds,
            ]
        );

        $container->setDefinition('form.extension', $newDefinition);
    }
}
