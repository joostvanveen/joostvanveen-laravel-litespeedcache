<?php

namespace Joostvanveen\LaravelLitespeedcache\Tests;

use LitespeedCache;

class FeatureTest extends TestCase
{

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_can_cache()
    {
        LitespeedCache::setUnitTestMode()
             ->setType('private')
             ->setLifetime(60)
             ->cache();

        $headers = $this->getHeaders();
        $this->assertTrue(in_array('X-LiteSpeed-Cache-Control: private, max-age=60', $headers));
    }
}
