<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 11.1.17.
 * Time: 17.29
 */
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CustomPass implements  CompilerPassInterface
{


    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition=$container->getDefinition('fos_user.listener.authentication');
        $definition->setClass('AppBundle\EventListener\AuthenticationListener');
    }
}