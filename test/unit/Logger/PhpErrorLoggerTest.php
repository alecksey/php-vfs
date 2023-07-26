<?php
namespace Vfs\Logger;

use ArrayIterator;
use Mockery;
use Vfs\Test\UnitTestCase;

class PhpErrorLoggerTest extends UnitTestCase
{
    public function setUp() : void
    {
        $this->logger = new PhpErrorLogger();
    }

    public function dataLog()
    {
        return [
            ['emergency', '\PHPUnit\Framework\Error\Error'],
            ['alert',     '\PHPUnit\Framework\Error\Error'],
            ['critical',  '\PHPUnit\Framework\Error\Error'],
            ['error',     '\PHPUnit\Framework\Error\Error'],
            ['warning',   '\PHPUnit\Framework\Error\Warning'],
            ['notice',    '\PHPUnit\Framework\Error\Notice'],
            ['info',      '\PHPUnit\Framework\Error\Notice'],
            ['debug',     '\PHPUnit\Framework\Error\Notice']
        ];
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $this->logger);
    }

    /**
     * @dataProvider dataLog
     */
    public function testLog($level, $expectation)
    {
        $this->expectException($expectation);

        $this->logger->log($level, 'foo', []);
    }

    public function testLogReplacesPlaceholders()
    {
        try {
            $this->logger->log('debug', 'foo {bar} baz', ['bar' => 'BAR']);
        } catch (\PHPUnit\Framework\Error\Notice $e) {
            $this->assertMatchesRegularExpression('/foo BAR baz/', $e->getMessage());
            return;
        }

        $this->fail('A PHP Notice should have been triggered');
    }

    public function testEmergency()
    {
        $this->expectException('\PHPUnit\Framework\Error\Error');

        $this->logger->emergency('foo', []);
    }

    public function testAlert()
    {
        $this->expectException('\PHPUnit\Framework\Error\Error');

        $this->logger->alert('foo', []);
    }

    public function testCritical()
    {
        $this->expectException('\PHPUnit\Framework\Error\Error');

        $this->logger->critical('foo', []);
    }

    public function testError()
    {
        $this->expectException('\PHPUnit\Framework\Error\Error');

        $this->logger->error('foo', []);
    }

    public function testWarning()
    {
        $this->expectException('\PHPUnit\Framework\Error\Warning');

        $this->logger->warning('foo', []);
    }

    public function testNotice()
    {
        $this->expectException('\PHPUnit\Framework\Error\Notice');

        $this->logger->notice('foo', []);
    }

    public function testInfo()
    {
        $this->expectException('\PHPUnit\Framework\Error\Notice');

        $this->logger->info('foo', []);
    }

    public function testDebug()
    {
        $this->expectException('\PHPUnit\Framework\Error\Notice');

        $this->logger->debug('foo', []);
    }
}
