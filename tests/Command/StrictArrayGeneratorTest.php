<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\Command;

use eXtalion\PhpStrictArray\Command\Exception\StrictArrayValidationError;
use eXtalion\PhpStrictArray\Command\StrictArrayGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \eXtalion\PhpStrictArray\Command\StrictArrayGenerator
 */
final class StrictArrayGeneratorTest extends TestCase
{
    protected function setUp(): void
    {
        $this->command = new StrictArrayGenerator();
        $this->tester = new CommandTester($this->command);
    }

    /**
     * @dataProvider configuration
     */
    public function testConfiguration(string $configuration, $value): void
    {
        $this->assertSame(
            $value,
            $this->command->$configuration()
        );
    }

    public function configuration(): array
    {
        return [
            'name' => [
                'getName',
                'php-strict-array:generate-strict-array'
            ],
            'description' => [
                'getDescription',
                'Generate strict array'
            ]
        ];
    }
}
