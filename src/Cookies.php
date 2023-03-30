<?php

namespace Core\Testing;

use Psr\SimpleCache\CacheInterface;
use Core\Cookies\CookiesArray;
use Core\Session\SessionArray;
use Core\Interfaces\Cookie;
use Core\Cookies\CookiesCache;
use Core\Interfaces\CookieConfig;
use Core\Cookies\CookieConfigDefault;
use Core\Interfaces\Session;
use Core\Session\SessionCache;

class Cookies
{

    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getSessionArray(bool $autostart = false): Session
    {
        return new SessionArray($autostart);
    }

    public function getSessionCache(string $sessionId, bool $autostart = false): Session
    {
        return new SessionCache($sessionId, $this->cache, null, $autostart);
    }

    public function getCookiesArray(?CookieConfig $config = null): Cookie
    {
        if (empty($config)) {
            $config = $this->getCookieConfig();
        }
        return new CookiesArray($config);
    }

    public function getCookiesCache(string $browserId, ?CookieConfig $config = null): Cookie
    {
        if (empty($config)) {
            $config = $this->getCookieConfig();
        }
        return new CookiesCache($config, $this->cache, $browserId);
    }

    public function getCookieConfig(array $params = []): CookieConfigDefault
    {
        return new CookieConfigDefault($params);
    }

}
