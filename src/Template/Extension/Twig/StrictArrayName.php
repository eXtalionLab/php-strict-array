<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Template\Extension\Twig;

use eXtalion\PhpStrictArray\DTO\ArrayDefinition;
use eXtalion\PhpStrictArray\Service\StrictArrayName as StrictArrayNameService;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
class StrictArrayName
{
    /**
     * @var \eXtalion\PhpStrictArray\Service\StrictArrayName
     */
    private $_arrayName;

    /**
     * @param \eXtalion\PhpStrictArray\Service\StrictArrayName $arrayName
     */
    public function __construct(StrictArrayNameService $arrayName)
    {
        $this->_arrayName = $arrayName;
    }

    public function nameForHuman(ArrayDefinition $arrayDefinition): string
    {
        return $this->_arrayName->forHuman($arrayDefinition);
    }

    public function nameForComputer(ArrayDefinition $arrayDefinition): string
    {
        return $this->_arrayName->forComputer($arrayDefinition);
    }
}
