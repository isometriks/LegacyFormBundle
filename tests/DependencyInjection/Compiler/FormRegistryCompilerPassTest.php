<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\DependencyInjection\Compiler;

use Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler\FormRegistryCompilerPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class FormRegistryCompilerPassTest extends AbstractCompilerPassTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FormRegistryCompilerPass());
    }
}
