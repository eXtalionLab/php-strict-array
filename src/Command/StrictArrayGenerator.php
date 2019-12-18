<?php
declare(strict_types=1);

namespace eXtalion\PhpStrictArray\Command;

use eXtalion\PhpStrictArray\DTO\ArrayDefinition;
use eXtalion\PhpStrictArray\DTO\ObjectDefinition;
use eXtalion\PhpStrictArray\Enum;
use eXtalion\PhpStrictArray\Service\FileSystem;
use eXtalion\PhpStrictArray\Service\StrictArrayGenerator as StrictArrayGeneratorService;
use eXtalion\PhpStrictArray\Service\StrictArrayName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
     * @var \eXtalion\PhpStrictArray\Service\StrictArrayName
     */
    private $_arrayName;

    /**
     * @var \eXtalion\PhpStrictArray\Service\FileSystem
     */
    private $_fileSystem;

    /**
     * @var \eXtalion\PhpStrictArray\DTO\ArrayDefinition
     */
    private $_arrayDefinition;

    /**
     * @param \eXtalion\PhpStrictArray\Service\StrictArrayGenerator $arrayGenerator
     * @param \eXtalion\PhpStrictArray\Service\StrictArrayName $arrayName
     * @param \eXtalion\PhpStrictArray\Service\FileSystem $fileSystem
     */
    public function __construct(
        StrictArrayGeneratorService $arrayGenerator,
        StrictArrayName $arrayName,
        FileSystem $fileSystem
    ) {
        parent::__construct();

        $this->_arrayGenerator = $arrayGenerator;
        $this->_arrayName = $arrayName;
        $this->_fileSystem = $fileSystem;
        $this->_arrayDefinition = new ArrayDefinition();
    }

    protected function configure(): void
    {
        $this
            ->setName('php-sa')
            ->setDescription('Generate strict array')
            ->setHelp('This command allows you to create a strict array')
            ->setProcessTitle('php-strict-array')
            //
            ->addArgument(
                'directory',
                InputArgument::OPTIONAL,
                "Directory where strict array will be save.\n"
                .'When omit strict array code will be output to STDOUT'
            );
    }

    protected function initialize(
        InputInterface $input,
        OutputInterface $output
    ): void {
        $directory = $input->getArgument('directory');

        if ($directory) {
            if (!\file_exists($directory)) {
                \mkdir($directory, 0777, true);
            }

            if (!\is_dir($directory)) {
                throw new \RuntimeException(
                    "\"{$directory}\" is a file, expect directory"
                );
            }

            if (!\is_writable($directory)) {
                throw new \RuntimeException(
                    "Directory \"{$directory}\" is not writable"
                );
            }
        }
    }

    protected function interact(
        InputInterface $input,
        OutputInterface $output
    ): void {
        $io = new SymfonyStyle($input, $output);
        $this->askForKey($io);
        $this->askForValue($io);
    }

    private function askForKey(SymfonyStyle $io): void
    {
        $question = new Question\ChoiceQuestion(
            'Strict array key type',
            \array_combine(
                Enum\KeyType::VALUES,
                [
                    'vector - array<type>',
                    'map    - array<key, type>'
                ]
            )
        );
        $type = $io->askQuestion($question);
        $this->_arrayDefinition->setKey(Enum\KeyType::$type());
    }

    private function askForValue(SymfonyStyle $io): void
    {
        $question = new Question\ChoiceQuestion(
            'Strict array value type',
            Enum\ValueType::VALUES
        );
        $type = $io->askQuestion($question);
        $this->_arrayDefinition->setValue(Enum\ValueType::$type());

        if ($this->_arrayDefinition->getValue() === Enum\ValueType::object()) {
            $className = $this->askForObject($io);

            if ($className) {
                $alias = $this->askForAlias($io, $className);
                $objectDefinition = new ObjectDefinition();
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
        $arrayClass = $this->_arrayGenerator->generate($this->_arrayDefinition);
        $io = new SymfonyStyle($input, $output);
        $io->success(
            \sprintf(
                'Strict array generated: %s',
                $this->_arrayName->forHuman($this->_arrayDefinition)
            )
        );

        $directory = $input->getArgument('directory');

        if ($directory) {
            $directory = \rtrim($directory, '/');
            $arrayComputerName = $this->_arrayName
                ->forComputer($this->_arrayDefinition);
            $file = \sprintf('%s/%s.php', $directory, $arrayComputerName);
            $this->_fileSystem->put($file, $arrayClass);
            $io->note("Run: \$a = new \\{$arrayComputerName}();");
        } else {
            $io->text($arrayClass);
        }

        return 0;
    }
}
