<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Tests\Service;

use eXtalion\PhpStrictArray\Enum;
use eXtalion\PhpStrictArray\DTO\ObjectDefinition;
use eXtalion\PhpStrictArray\DTO\ArrayDefinition;
use eXtalion\PhpStrictArray\Service\StrictArrayGenerator;
use eXtalion\PhpStrictArray\Service\StrictArrayName;
use eXtalion\PhpStrictArray\Template;
use PHPUnit\Framework\TestCase;

/**
 * @covers \eXtalion\PhpStrictArray\Service\StrictArrayGenerator
 */
final class StrictArrayGeneratorTest extends TestCase
{
    protected function setUp(): void
    {
        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'),
            [
                'debug' => false
            ]
        );
        $this->arrayName = new StrictArrayName();
        $template = new Template\Twig($twig, $this->arrayName);

        $this->service = new StrictArrayGenerator($template);
    }

    /**
     * @dataProvider arrayDefinition
     */
    public function testGeneratedStrictArrayIsValidPhpCode(
        ArrayDefinition $arrayDefinition
    ): void {
        $strictArrayFile = \tempnam(\sys_get_temp_dir(), 'php-sa');
        \file_put_contents(
            $strictArrayFile,
            $this->service->generate($arrayDefinition)
        );

        $output = [];
        $result = 0;
        \exec("php -l {$strictArrayFile}", $output, $result);

        $this->assertTrue(
            (bool) !$result,
            'Parse error: ' . \implode(' | ', $output)
        );

        \unlink($strictArrayFile);
    }

    /**
     * @dataProvider arrayDefinition
     */
    public function testStrictArrayName(
        ArrayDefinition $arrayDefinition
    ): void {
        $strictArray = $this->service->generate($arrayDefinition);
        $className = $this->arrayName->forComputer($arrayDefinition);

        $this->assertStringContainsString(
            "final class {$className}",
            $strictArray,
            "Strict array has incorrect name. Expects: {$className}"
        );
    }

    public function testUseStatementForObject(): void
    {
        $arrayDefinitions = \array_filter(
            $this->arrayDefinition(),
            function ($key) {
                return \strpos($key, 'object');
            },
            \ARRAY_FILTER_USE_KEY
        );

        foreach ($arrayDefinitions as $arrayDefinition) {
            $strictArray = $this->service->generate($arrayDefinition[0]);

            $this->assertStringContainsString(
                'use Name\\Space\\Foo as Foo;',
                $strictArray,
                'Strict array template is missing "use" statement for user object'
            );
        }
    }

    public function testVectorConstruct(): void
    {
        $strictArray = $this->service->generate(
            $this->arrayDefinition()['vector'][0]
        );

        $this->assertStringContainsString(
            '__construct(int ...$data)',
            $strictArray,
            'Strict array vector has wrong construct method'
        );
    }

    public function testMapConstruct(): void
    {
        $strictArray = $this->service->generate(
            $this->arrayDefinition()['map'][0]
        );

        $this->assertStringContainsString(
            '__construct(\\' . \Pair::class . ' ...$data)',
            $strictArray,
            'Strict array map has wrong construct method'
        );
    }

    public function testImplementStrictArrayInterface(): void
    {
        $strictArray = $this->service->generate(
            $this->arrayDefinition()['vector'][0]
        );

        $this->assertRegExp(
            '/implements.+StrictArray/',
            $strictArray,
            'Strict array not implements interface ' . \StrictArray::class
        );
    }

    public function arrayDefinition(): array
    {
        $objectDefinition = (new ObjectDefinition())
            ->setName('Name\\Space\\Foo')
            ->setAlias('Foo');

        return [
            'vector' => [
                (new ArrayDefinition())
                    ->setKey(Enum\KeyType::int())
                    ->setValue(Enum\ValueType::int())
            ],
            'vector object' => [
                (new ArrayDefinition())
                    ->setKey(Enum\KeyType::int())
                    ->setValue(Enum\ValueType::object())
                    ->setObjectDefinition($objectDefinition)
            ],
            'map' => [
                (new ArrayDefinition())
                    ->setKey(Enum\KeyType::string())
                    ->setValue(Enum\ValueType::int())
            ],
            'map object' => [
                (new ArrayDefinition())
                    ->setKey(Enum\KeyType::string())
                    ->setValue(Enum\ValueType::object())
                    ->setObjectDefinition($objectDefinition)
            ]
        ];
    }
}
