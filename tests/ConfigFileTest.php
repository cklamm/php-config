<?php namespace cklamm\Config\Tests;

use cklamm\Config\ConfigFile;
use PHPUnit\Framework\TestCase;

class ConfigFileTest extends TestCase
{
    protected $file;

    public function setUp(): void
    {
        $this->file = new ConfigFile(__DIR__ . '/config.php');
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_config_file($input, $expected)
    {
        $this->assertSame($expected, $this->file->get($input));
    }

    public function dataProvider()
    {
        return [
            ['', 'empty'],
            ['foo', 'bar'],
            ['array', ['a', 'b', 'c']],
            ['undefined', null],

            ['db.driver', 'mysql'],
            ['db.host', 'localhost'],
            ['db.port', 3306],

            ['db.*', [
                'driver' => 'mysql',
                'host' => 'localhost',
                'port' => 3306,
            ]],

            ['log.debug.db', '*'],
            ['log.debug.file', '*'],
            ['log.prod.db', 'error,warning,info'],
            ['log.prod.file', 'error,warning,info'],

            ['log.*', [
                'debug.db' => '*',
                'debug.file' => '*',
                'prod.db' => 'error,warning,info',
                'prod.file' => 'error,warning,info',
            ]],

            ['log.debug.*', [
                'db' => '*',
                'file' => '*',
            ]],

            ['log.prod.*', [
                'db' => 'error,warning,info',
                'file' => 'error,warning,info',
            ]],

            ['*', [
                '' => 'empty',
                'foo' => 'bar',
                'array' => ['a', 'b', 'c'],

                'db.driver' => 'mysql',
                'db.host' => 'localhost',
                'db.port' => 3306,

                'log.debug.db' => '*',
                'log.debug.file' => '*',
                'log.prod.db' => 'error,warning,info',
                'log.prod.file' => 'error,warning,info',
            ]]
        ];
    }
}
