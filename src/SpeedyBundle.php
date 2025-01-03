<?php

namespace Izopi4a\SpeedyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SpeedyBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}