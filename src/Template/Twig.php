<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Template;

use eXtalion\PhpStrictArray\Service\StrictArrayName as StrictArrayNameService;
use eXtalion\PhpStrictArray\Template;
use eXtalion\PhpStrictArray\Template\Extension\Twig\StrictArrayValidator;
use eXtalion\PhpStrictArray\Template\Extension\Twig\StrictArrayName;

class Twig implements Template
{
    /**
     * @var \Twig\Environment $twig
     */
    private $_twig;

    /**
     * @param \Twig\Environment $twig
     * @param \eXtalion\PhpStrictArray\Service\StrictArrayName $arrayName
     */
    public function __construct(
        \Twig\Environment $twig,
        StrictArrayNameService $arrayName
    ) {
        $this->_twig = clone $twig;
        $strictArrayValidator = new StrictArrayValidator();
        $strictArrayName = new StrictArrayName($arrayName);

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
        $this->_twig->addFunction(
            new \Twig\TwigFunction(
                'name_for_human',
                [
                    $strictArrayName,
                    'nameForHuman'
                ]
            )
        );
        $this->_twig->addFunction(
            new \Twig\TwigFunction(
                'name_for_computer',
                [
                    $strictArrayName,
                    'nameForComputer'
                ]
            )
        );
    }

    public function render(string $template, array $parameters = []): string
    {
        return $this->_twig->render($template, $parameters);
    }
}
