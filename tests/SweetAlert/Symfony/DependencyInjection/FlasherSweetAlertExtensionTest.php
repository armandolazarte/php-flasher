<?php

namespace Flasher\Tests\SweetAlert\Symfony\DependencyInjection;

use Flasher\Tests\Prime\TestCase;
use Flasher\SweetAlert\Symfony\DependencyInjection\FlasherSweetAlertExtension;
use Flasher\SweetAlert\Symfony\FlasherSweetAlertSymfonyBundle;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherSymfonyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherSweetAlertExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getContainer();

        $this->assertTrue($container->has('flasher.sweet_alert'));
    }

    public function testCreateInstanceOfSweetAlertAdapter()
    {
        $container = $this->getContainer();

        $flasher = $container->getDefinition('flasher');
        $calls = $flasher->getMethodCalls();

        $this->assertCount(5, $calls);

        $this->assertEquals('addFactory', $calls[0][0]);
        $this->assertEquals('template', $calls[0][1][0]);
        $this->assertEquals('flasher.template', (string) $calls[0][1][1]);

        $this->assertEquals('addFactory', $calls[4][0]);
        $this->assertEquals('sweet_alert', $calls[4][1][0]);
        $this->assertEquals('flasher.sweet_alert', (string) $calls[4][1][1]);
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $container->registerExtension(new FlasherExtension());
        $flasherBundle = new FlasherSymfonyBundle();
        $flasherBundle->build($container);

        $container->registerExtension(new FlasherSweetAlertExtension());
        $adapterBundle = new FlasherSweetAlertSymfonyBundle();
        $adapterBundle->build($container);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->getCompilerPassConfig()->setAfterRemovingPasses(array());

        return $container;
    }

    private function getContainer()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher', array());
        $container->loadFromExtension('flasher_sweet_alert', array());
        $container->compile();

        return $container;
    }
}
