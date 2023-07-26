<?php
/*
 * This file is part of VFS
 *
 * Copyright (c) 2015 Andrew Lawson <http://adlawson.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vfs\Test;

use \PHPUnit\Framework\TestCase;
use RuntimeException;
use Vfs\FileSystemBuilder;

class FunctionalTestCase extends TestCase
{
    protected $scheme = 'foo';

    protected $fs = null;

    public function setUp(): void
    {
        $builder = new FileSystemBuilder($this->scheme);
        $this->fs = $builder->build();
    }

    public function tearDown(): void
    {
        if ($this->isMounted($this->scheme)) {
            $this->fs->unmount();

            if ($this->isMounted($this->scheme)) {
                throw new RuntimeException('Problem unmounting file system ' . $this->scheme);
            }
        }
    }

    protected function isMounted($scheme)
    {
        return in_array($scheme, stream_get_wrappers());
    }
}
