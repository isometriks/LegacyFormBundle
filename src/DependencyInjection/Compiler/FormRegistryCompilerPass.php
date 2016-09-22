<?php

namespace Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Craig Blanchette <craig.blanchette@gmail.com>
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class FormRegistryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('isometriks.legacy_form.form_registry')) {
            return;
        }

        $formRegistry = $container->getDefinition('isometriks.legacy_form.form_registry');

        $aliases = $formRegistry->getArgument(1);
        foreach ($container->findTaggedServiceIds('form.type') as $id => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['alias'])) {
                    continue;
                }

                $aliases[$tag['alias']] = $container->getDefinition($id)->getClass();
            }
        }

        $formRegistry->replaceArgument(1, $aliases);

        // Change form extensions to match the alias
        foreach ($container->findTaggedServiceIds('form.type_extension') as $id => $foundTags) {
            $extensionDefinition = $container->getDefinition($id);
            $tags = $extensionDefinition->getTags();

            if (!isset($tags['form.type_extension'])) {
                continue;
            }

            // Alter the tags
            $newTags = $this->processTags($tags, $aliases);

            // Set altered tags
            $extensionDefinition->setTags($newTags);
        }
    }

    private function processTags(array $tags, array $aliases)
    {
        foreach ($tags['form.type_extension'] as $tagIndex => $tag) {
            if (!isset($tag['extended_type'])) {
                continue;
            }

            if (isset($aliases[$tag['extended_type']])) {
                $tag['extended_type'] = $aliases[$tag['extended_type']];
                $tags['form.type_extension'][$tagIndex] = $tag;
            }
        }

        return $tags;
    }
}
