<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
interface Template
{
    /**
     * Render template
     *
     * @param string $template
     * @param array $parameters
     *
     * @return string
     */
    public function render(string $template, array $parameters = []): string;
}
