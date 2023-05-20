<?php

namespace Core\Testing;

use Psr\SimpleCache\CacheInterface;
use Core\Cookies\CookiesArray;
use Core\Session\SessionArray;
use Core\Interfaces\CookieInterface;
use Core\Cookies\CookiesCache;
use Core\Interfaces\CookieConfigInterface;
use Core\Cookies\CookieConfigDefault;
use Core\Interfaces\SessionInterface;
use Core\Session\SessionCache;

class Cookies
{

    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getSessionArray(bool $autostart = false): SessionInterface
    {
        return new SessionArray($autostart);
    }

    public function getSessionCache(string $sessionId, bool $autostart = false): SessionInterface
    {
        return new SessionCache($sessionId, $this->cache, null, $autostart);
    }

    public function getCookiesArray(?CookieConfigInterface $config = null): CookieInterface
    {
        if (empty($config)) {
            $config = $this->getCookieConfig();
        }
        return new CookiesArray($config);
    }

    public function getCookiesCache(string $browserId, ?CookieConfigInterface $config = null): CookieInterface
    {
        if (empty($config)) {
            $config = $this->getCookieConfig();
        }
        return new CookiesCache($config, $this->cache, $browserId);
    }

    public function getCookieConfig(array $params = []): CookieConfigInterface
    {
        return new CookieConfigDefault($params);
    }

}
