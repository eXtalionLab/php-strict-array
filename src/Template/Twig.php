<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Template;

use eXtalion\PhpStrictArray\Template;
use eXtalion\PhpStrictArray\Template\Extension\Twig\StrictArrayValidator;

class Twig implements Template
{
    /**
     * @var \Twig\Environment $twig
     */
    private $_twig;

    /**
     * @param \Twig\Environment $twig
     */
    public function __construct(\Twig\Environment $twig)
    {
        $this->_twig = clone $twig;
        $strictArrayValidator = new StrictArrayValidator();

        $this->_twig->addFunction(
            new \Twig\TwigFunction(
                'validate_key',
                [
                    $strictArrayValidator,
                    'validateKey'
                ]
            )
        );
        $this->_twig->addFunction(
            new \Twig\TwigFunction(
                'validate_value',
                [
                    $strictArrayValidator,
                    'validateValue'
                ]
            )
        );
    }

    public function render(string $template, array $parameters = []): string
    {
        return $this->_twig->render($template, $parameters);
    }
}
