<?php

declare(strict_types=1);

use Core\Interfaces\Cookie;
use Core\Interfaces\CookieConfig;
use Core\Testing\MegaFactory;
use Core\Testing\Server;
use Core\Interfaces\SCFactory;
use Psr\SimpleCache\CacheInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class MegaFactoryTest extends PHPUnit\Framework\TestCase
{

    private MegaFactory $megaFactory;

    protected function setUp(): void
    {
        $td = getcwd() . DIRECTORY_SEPARATOR . 'tests';
        $this->megaFactory = new MegaFactory($td);
    }

    public function testRequest()
    {
        $server = $this->megaFactory->getServer();
        $this->assertTrue($server instanceof Server);
        $serverRequest = $server->getServerRequest('http://example.com', 'GET');
        $this->assertTrue($serverRequest instanceof ServerRequestInterface);
        $serverRequestFactory = $server->getServerRequestFactory();
        $this->assertTrue($serverRequestFactory instanceof ServerRequestFactoryInterface);
        $responseFactory = $server->getResponseFactory();
        $this->assertTrue($responseFactory instanceof ResponseFactoryInterface);
    }

    public function testLog()
    {
        $log = $this->megaFactory->getLogger(false, 'test.log');
        $log->alert('test message');
        $log->error('error message');
        $content = file_get_contents($this->megaFactory->getLogDir() . DIRECTORY_SEPARATOR . 'test.log');
        $assertion = str_contains($content, 'test message');
        $this->assertTrue($assertion);
    }

    public function testCache()
    {
        $cacheMem = $this->megaFactory->getCache()->getNullCache();
        $this->assertTrue($cacheMem instanceof CacheInterface);
        $cacheFactory = $this->megaFactory->getCache()->getCacheFactory();
        $this->assertTrue($cacheFactory instanceof SCFactory);
        $cacheFile = $this->megaFactory->getCache()->getFileCache();
        $cacheFile->set('test', 12345);
        $this->assertEquals(12345, $cacheFile->get('test'));
    }

    public function testCookies()
    {
        $cookieConfig = $this->megaFactory->getCookies()->getCookieConfig();
        $this->assertTrue($cookieConfig instanceof CookieConfig);
        $cookiesArray = $this->megaFactory->getCookies()->getCookiesArray();
        $this->assertTrue($cookiesArray instanceof Cookie);
        $cookiesCache = $this->megaFactory->getCookies()->getCookiesCache('123');
        $this->assertTrue($cookiesCache instanceof Cookie);
        $cookiesCache->set('test', '777');
        $this->assertEquals('777', $cookiesCache->get('test'));
    }

    public function testSession()
    {
        $session = $this->megaFactory->getCookies()->getSessionCache('123');
        $session->set('message', '246');
        $this->assertEquals('246', $session->get('message'));
    }

}
