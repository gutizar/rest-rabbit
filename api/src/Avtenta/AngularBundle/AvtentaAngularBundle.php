<?php

namespace Avtenta\AngularBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Avtenta\AngularBundle\DependencyInjection\Security\Factory\WsseFactory;

class AvtentaAngularBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WsseFactory());
    }
}
