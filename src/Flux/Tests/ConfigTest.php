<?php
namespace Flux\Tests;
use Flux\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGet()
    {
        $config = new Config();
        $config['key'] = 1;

        $this->assertSame($config['key'], 1);
        $this->assertSame($config->get('key'), 1);
    }

    public function testUnset()
    {
        $config = new Config();
        $config['key'] = 1;
        unset($config['key']);

        $this->assertArrayNotHasKey('key', $config);
        $this->assertNull($config->get('key'));
    }

    public function testRemove()
    {
        $config = new Config();
        $config->set('key', 1);
        $config->remove('key');

        $this->assertArrayNotHasKey('key', $config);
        $this->assertNull($config->get('key'));
    }

    public function testToString()
    {
        $config = new Config();
        $this->assertSame((string) $config, '{}');

        $config->set('key', 1.01);
        $this->assertContains('"key": 1.01', (string) $config);
    }
}
