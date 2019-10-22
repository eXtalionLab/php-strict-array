<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Command;

use eXtalion\PhpStrictArray\DTO;
use eXtalion\PhpStrictArray\Enum;
use eXtalion\PhpStrictArray\Service;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Damian Glinkowski <damian@d0niek.pl>
 */
final class StrictArrayGenerator extends Command
{
    /**
     * @var \eXtalion\PhpStrictArray\Service\StrictArrayGenerator
     */
    private $_arrayGenerator;

    /**
     * @var \eXtalion\PhpStrictArray\DTO\StrictArrayDefinition
     */
    private $_arrayDefinition;

    /**
     * @param \eXtalion\PhpStrictArray\Service\StrictArrayGenerator $arrayGenerator
     */
    public function __construct(Service\StrictArrayGenerator $arrayGenerator)
    {
        parent::__construct();

        $this->_arrayGenerator = $arrayGenerator;
        $this->_arrayDefinition = new DTO\StrictArrayDefinition();
    }

    protected function configure(): void
    {
        $this
            ->setName('php-strict-array:generate-strict-array')
            ->setDescription('Generate strict array')
            ->setProcessTitle('php-strict-array');
    }

    protected function interact(
        InputInterface $input,
        OutputInterface $output
    ): void {
        $io = new SymfonyStyle($input, $output);
        $this->askForArrayType($io);

        if ($this->_arrayDefinition->isMap()) {
            $this->askForKeyType($io);
        }

        $this->askForValueType($io);
    }

    private function askForArrayType(SymfonyStyle $io): void
    {
        $question = new Question\ChoiceQuestion(
            'Strict array type',
            Enum\ArrayTypes::VALUES
        );
        $type = $io->askQuestion($question);
        $this->_arrayDefinition->setArrayType(Enum\ArrayTypes::$type());
    }

    private function askForKeyType(SymfonyStyle $io): void
    {
        $question = new Question\ChoiceQuestion(
            'Strict array key type',
            Enum\KeyTypes::VALUES
        );
        $type = $io->askQuestion($question);
        $this->_arrayDefinition->setKeyType(Enum\KeyTypes::$type());
    }

    private function askForValueType(SymfonyStyle $io): void
    {
        $question = new Question\ChoiceQuestion(
            'Strict array value type',
            Enum\ValueTypes::VALUES
        );
        $type = $io->askQuestion($question);
        $this->_arrayDefinition->setValueType(Enum\ValueTypes::$type());

        if ($this->_arrayDefinition->isObject()) {
            $className = $this->askForObject($io);

            if ($className) {
                $alias = $this->askForAlias($io, $className);
                $objectDefinition = new DTO\ObjectDefinition();
                $objectDefinition
                    ->setName($className)
                    ->setAlias($alias);
                $this->_arrayDefinition
                    ->setObjectDefinition($objectDefinition);
            }
        }
    }

    private function askForObject(SymfonyStyle $io): ?string
    {
        $question = new Question\Question(
            'Object class name (leave blank for core "object" type)'
        );
        $question->setAutocompleterValues($this->getLoadedClasses());
        $question->setValidator(function ($object) {
            if ($object && !\class_exists($object)) {
                throw new \RuntimeException("Class \\{$object} not exists");
            }

            return $object;
        });

        return $io->askQuestion($question);
    }

    private function getLoadedClasses(): array
    {
        $declaredObject = \array_merge(
            \get_declared_classes(),
            \get_declared_interfaces()
        );
        \sort($declaredObject);

        return $declaredObject;
    }

    private function askForAlias(SymfonyStyle $io, string $className): string
    {
        $classNamePos = (int) \strrpos($className, '\\');

        if ($classNamePos) {
            $classNamePos++;
        }

        $alias = \substr($className, $classNamePos);
        $question = new Question\Question('Class alias', $alias);

        return $io->askQuestion($question);
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $this->_arrayGenerator->generate($this->_arrayDefinition);
        $io = new SymfonyStyle($input, $output);
        $io->note("Strict array generated: {$this->_arrayDefinition}");

        return 0;
    }
}
