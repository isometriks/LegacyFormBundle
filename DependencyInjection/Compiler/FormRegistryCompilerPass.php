<?php

namespace Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormRegistryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $defaultAliases = array(
            'form' => \Symfony\Component\Form\Extension\Core\Type\FormType::class,
            'text' => \Symfony\Component\Form\Extension\Core\Type\TextType::class,
        );

        foreach ($container->findTaggedServiceIds('form.type') as $id => $tags) {
            foreach ($tags as $tag) {
                if (isset($tag['alias'])) {
                    $typeDefinition = $container->getDefinition($id);
                    $defaultAliases[$tag['alias']] = $typeDefinition->getClass();
                }
            }
        }

        $definition = $container->getDefinition('form.registry');
        $definition->setClass('Isometriks\Bundle\LegacyFormBundle\Form\FormRegistry');
        $definition->addArgument($defaultAliases);
    }
}
