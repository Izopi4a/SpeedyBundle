<?php

namespace Izopi4a\SpeedyBundle;

use Izopi4a\SpeedyBundle\DependencyInjection\SpeedyBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SpeedyBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ?SpeedyBundleExtension
    {
        return new SpeedyBundleExtension();
    }
}