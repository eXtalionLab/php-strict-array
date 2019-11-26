<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Template\Extension\Twig;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
class StrictArrayValidator
{
    /**
     * Print PHP code to validate key type
     *
     * @param string $type
     * @param string $variable
     *
     * @return string
     */
    public function validateKey(string $type, string $variable): string
    {
        return $this->validate($type, $variable, 'Key');
    }

    /**
     * Print PHP code to validate value type
     *
     * @param string $type
     * @param string $variable
     *
     * @return string
     */
    public function validateValue(string $type, string $variable): string
    {
        return $this->validate($type, $variable, 'Value');
    }

    private function validate(
        string $type,
        string $variable,
        string $message
    ): string {
        return "
            try {
                (function ({$type} ...\$v){})({$variable});
            } catch (\TypeError \$ex) {
                \$message = \preg_replace(
                    '/Argument/',
                    '{$message}',
                    \$ex->getMessage(),
                    1
                );
                \$message = \preg_replace(
                    '/\w+::{\w+}/',
                    __METHOD__,
                    \$message
                );

                throw new \TypeError(\$message);
            }
        ";
    }
}
