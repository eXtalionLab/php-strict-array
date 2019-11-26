<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Service;

use eXtalion\PhpStrictArray\DTO\ArrayDefinition;
use eXtalion\PhpStrictArray\Template;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
class StrictArrayGenerator
{
    /**
     * @var \eXtalion\PhpStrictArray\Template
     */
    private $_template;

    /**
     * @param \eXtalion\PhpStrictArray\Template $template
     */
    public function __construct(Template $template)
    {
        $this->_template = $template;
    }

    /**
     * Generate strict array
     *
     * @param \eXtalion\PhpStrictArray\DTO\ArrayDefinition $arrayDefinition
     *
     * @return string
     */
    public function generate(ArrayDefinition $arrayDefinition): string
    {
        return $this->_template->render(
            'strict_array.php.twig',
            [
                'array' => $arrayDefinition
            ]
        );
    }
}
