<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Service;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
class FileSystem
{
    /**
     * Put content to the file
     *
     * If file exists, content will be overwrite
     *
     * @param string $file
     * @param string $content
     */
    public function put(string $file, string $content): void
    {
        \file_put_contents($file, $content);
    }
}
