<?php

namespace Joostvanveen\LaravelLitespeedcache\Tests;

use LitespeedCache;

class FeatureTest extends TestCase
{

    /** @test */
    public function it_can_cache()
    {
        LitespeedCache::setUnitTestMode()
                      ->setEnabled(true)
                      ->setEsiEnabled(false)
                      ->setType('private')
                      ->setLifetime(60)
                      ->setExcludedUrls([])
                      ->setExcludedQueryStrings([])
                      ->cache();

        $headers = $this->getHeaders();
        $this->assertTrue(in_array('X-LiteSpeed-Cache-Control: private, max-age=60', $headers));
    }

    /** @test */
    public function it_uses_config_values()
    {
        $config = include(__DIR__ . '/../config/litespeedcache.php');

        LitespeedCache::setUnitTestMode()->cache();

        $headers = $this->getHeaders();
        $this->assertTrue(in_array('X-LiteSpeed-Cache-Control: ' . $config['defaults']['type'] . ', esi=on, max-age=' . $config['defaults']['lifetime'] . '', $headers));
    }

    /** @test */
    public function it_does_not_cache_if_disabled()
    {
        LitespeedCache::setUnitTestMode()
                      ->setEnabled(false)
                      ->cache();

        $headers = $this->getHeaders();
        $this->assertEmpty($headers);
    }
}
