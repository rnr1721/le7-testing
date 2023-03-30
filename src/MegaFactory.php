<?php

namespace Core\Testing;

use Core\Logger\LoggerFactoryGeneric;
use Psr\Log\LoggerInterface;
use Core\Testing\Traits\Fs;

class MegaFactory
{

    use Fs;

    private string $cacheDir;
    private string $logDir;

    public function __construct(string $testsDir)
    {
        $ds = DIRECTORY_SEPARATOR;
        $this->cacheDir = $testsDir . $ds . 'cache';
        $this->logDir = $testsDir . $ds . 'logs';
        $this->mkdir($this->cacheDir);
        $this->mkdir($this->logDir);
    }

    public function getLogger(bool $null = true, string $filename = 'test.log'): LoggerInterface
    {
        $lf = new LoggerFactoryGeneric();
        if ($null) {
            return $lf->logNull();
        }
        return $lf->logFile($this->logDir . DIRECTORY_SEPARATOR . $filename);
    }

    public function getServer(): Server
    {
        return new Server();
    }

    public function getCache(): Cache
    {
        return new Cache($this->cacheDir);
    }

    public function getCookies(bool $file = true): Cookies
    {
        if ($file) {
            return new Cookies($this->getCache()->getFileCache());
        }
        return new Cookies($this->getCache()->getNullCache());
    }

    public function removeDirectories(): void
    {
        $this->rmdir($this->cacheDir);
        $this->rmdir($this->logDir);
    }

    public function getLogDir(): string
    {
        return $this->logDir;
    }

    public function getCacheDir(): string
    {
        return $this->cacheDir;
    }

    public function __destruct()
    {
        $this->removeDirectories();
    }

}
