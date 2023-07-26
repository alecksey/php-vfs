<?php
namespace Vfs;

use Mockery;
use Vfs\Test\UnitTestCase;

class FileSystemRegistryTest extends UnitTestCase
{
    public function setUp(): void
    {
        $this->fsA = $a = Mockery::mock('Vfs\FileSystemInterface');
        $this->fsB = $b = Mockery::mock('Vfs\FileSystemInterface');
        $this->fsC = $c = Mockery::mock('Vfs\FileSystemInterface');
        $this->fss = ['foo' => $a, 'bar' => $b, 'baz' => $c];

        $this->registry = new FileSystemRegistry($this->fss);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Vfs\RegistryInterface', $this->registry);
    }

    public function testAdd()
    {
        $fs = Mockery::mock('Vfs\FileSystemInterface');
        $this->registry->add('bam', $fs);

        $this->assertSame($fs, $this->registry->get('bam'));
    }

    public function testAddThrowsWhenSchemeRegistered()
    {
        $fs = Mockery::mock('Vfs\FileSystemInterface');

        $this->expectException('Vfs\Exception\RegisteredSchemeException');

        $this->registry->add('foo', $fs);
    }

    public function testGet()
    {
        $this->assertSame($this->fsA, $this->registry->get('foo'));
    }

    public function testGetThrowsWhenSchemeUnregistered()
    {
        $this->expectException('Vfs\Exception\UnregisteredSchemeException');

        $this->registry->get('bam');
    }

    public function testHasIsTrue()
    {
        $this->assertTrue($this->registry->has('foo'));
    }

    public function testHasIsFalse()
    {
        $this->assertFalse($this->registry->has('bam'));
    }

    public function testRemove()
    {
        $this->registry->remove('foo');

        $this->assertFalse($this->registry->has('foo'));
    }

    public function testRemoveThrowsWhenSchemeUnregistered()
    {
        $this->expectException('Vfs\Exception\UnregisteredSchemeException');

        $this->registry->remove('bam');
    }
}
