<?php

namespace Core\Testing;

use Core\Interfaces\SCFactory;
use Core\Cache\SCFactoryGeneric;
use Psr\SimpleCache\CacheInterface;

class Cache
{

    private string $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function getFileCache(): CacheInterface
    {
        $cacheFactory = $this->getCacheFactory();
        return $cacheFactory->getFileCache($this->dir);
    }

    public function getNullCache(): CacheInterface
    {
        $factory = $this->getCacheFactory();
        return $factory->getMemory();
    }

    public function getCacheFactory(): SCFactory
    {
        return new SCFactoryGeneric();
    }

}
