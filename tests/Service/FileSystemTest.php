<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\Service;

use eXtalion\PhpStrictArray\Service\FileSystem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \eXtalion\PhpStrictArray\Service\FileSystem
 */
final class FileSystemTest extends TestCase
{
    private $_file;

    protected function setUp(): void
    {
        $this->fileSystem = new FileSystem();
    }

    protected function tearDown(): void
    {
        if ($this->_file && \file_exists($this->_file)) {
            \unlink($this->_file);
        }
    }

    public function testPutToNotExistingFile(): void
    {
        $this->_file = __DIR__ . '/some_file';
        $this->fileSystem->put($this->_file, 'Lorem ipsum');

        $this->assertTrue(\file_exists($this->_file));
        $this->assertSame(
            'Lorem ipsum',
            \file_get_contents($this->_file)
        );
    }

    public function testPutToExistingFile(): void
    {
        $this->_file = __DIR__ . '/some_file';
        \file_put_contents($this->_file, 'old Lorem ipsum');

        $this->assertSame(
            'old Lorem ipsum',
            \file_get_contents($this->_file)
        );

        $this->fileSystem->put($this->_file, 'Lorem ipsum');

        $this->assertSame(
            'Lorem ipsum',
            \file_get_contents($this->_file)
        );
    }
}
