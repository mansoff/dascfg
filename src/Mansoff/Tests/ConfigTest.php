<?php declare(strict_types=1);

namespace Mansoff\Tests;

use Mansoff\Service\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testConfig()
    {
        $data = [
            'foo3' => 'bar4',
            'foo' => 'bar',
            'foo1' => 'bar2',
        ];
        $separator = ':';
        $config = new Config($data, $separator);

        $this->assertEquals(true, $config->has('foo'));
        $this->assertEquals(false, $config->has('bar'));
        $this->assertEquals('bar', $config->get('foo'));
        $this->assertEquals(null, $config->get('bar'));
    }

    public function testMultiDimensionalConfig()
    {
        $data = [
            'foo' => 'bar',
            'level2' => [
                'foo2' => 'bar2',
                'level3' => [
                    'foo3' => 'bar3',
                    'level4' => [
                        'foo4' => 'bar4',
                    ],
                ],
            ],
        ];
        $separator = ':';
        $config = new Config($data, $separator);

        $this->assertEquals(true, $config->has('foo'));
        $this->assertEquals(false, $config->has('bar'));
        $this->assertEquals('bar', $config->get('foo'));
        $this->assertEquals(null, $config->get('bar'));

        $this->assertEquals(true, $config->has('level2'));
        $this->assertEquals(true, $config->has('level2:level3'));
        $this->assertEquals(true, $config->has('level2:level3:level4'));
        $this->assertEquals(true, $config->has('level2:foo2'));
        $this->assertEquals(true, $config->has('level2:level3:foo3'));
        $this->assertEquals(true, $config->has('level2:level3:level4:foo4'));

        $this->assertEquals('bar2', $config->get('level2:foo2'));
        $this->assertEquals('bar3', $config->get('level2:level3:foo3'));
        $this->assertEquals('bar4', $config->get('level2:level3:level4:foo4'));
    }

    public function testGetAll()
    {
        $data = [
            'foo3' => 'bar4',
            'foo' => 'bar',
            'foo1' => 'bar2',
        ];
        $separator = ':';
        $config = new Config($data, $separator);

        $this->assertEquals($data, $config->getAll());
    }

    public function testHasFalseFirstKey()
    {
        $data = [
            'foo3' => 'bar4',
        ];
        $separator = ':';
        $config = new Config($data, $separator);

        $this->assertEquals(false, $config->has('a:b:c'));
    }

    public function testHasFalseSecondKey()
    {
        $data = [
            'foo3' => 'bar4',
        ];
        $separator = ':';
        $config = new Config($data, $separator);

        $this->assertEquals(false, $config->has('foo3:a:b:c'));
    }

    public function testGetFalseFirstKey()
    {
        $data = [
            'foo3' => 'bar4',
        ];
        $separator = ':';
        $config = new Config($data, $separator);

        $this->assertEquals(false, $config->get('a:b:c'));
    }

    public function testGetFalseSecondKey()
    {
        $data = [
            'foo3' => 'bar4',
        ];
        $separator = ':';
        $config = new Config($data, $separator);

        $this->assertEquals(false, $config->get('foo3:a:b:c'));
    }
}