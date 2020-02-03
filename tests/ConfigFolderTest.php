<?php namespace cklamm\Config\Tests;

use cklamm\Config\ConfigFolder;
use PHPUnit\Framework\TestCase;

class ConfigFolderTest extends TestCase
{
    protected $folder;

    public function setUp(): void
    {
        $this->folder = new ConfigFolder(__DIR__ . '/config');
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_config_folder($input, $expected)
    {
        $this->assertSame($expected, $this->folder->get($input));
    }

    public function dataProvider()
    {
        return [
            ['', null],
            ['*', null],
            ['db', null],
            ['log', null],

            ['db.', 'empty'],
            ['db.foo', 'bar'],
            ['db.driver', 'mysql'],
            ['db.host', 'localhost'],
            ['db.port', 3306],

            ['db.*', [
                '' => 'empty',
                'foo' => 'bar',
                'driver' => 'mysql',
                'host' => 'localhost',
                'port' => 3306,
            ]],

            ['log.', null],
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
        ];
    }
}
