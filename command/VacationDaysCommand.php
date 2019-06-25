<?php

namespace application\command;

use application\service\{
    Database,
    Report
};
use DateTime;
use Exception;
use League\Csv\{
    CannotInsertRecord,
    Writer
};
use SplTempFileObject;
use Symfony\Component\Console\{
    Command\Command,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface
};

class VacationDaysCommand extends Command
{
    protected static $defaultName = 'app:vacation-days';

    protected function configure()
    {
        $this->addArgument('year', InputArgument::REQUIRED, 'required year');

        $this
            ->setDescription('Generates vacation report')
            ->setHelp('Specify year and run command, see \'usage\'');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws CannotInsertRecord
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getArgument('year');
        $year = DateTime::createFromFormat('Y', $year);
        $output->writeln('year: ' . $year->format('Y'));

        $report = new Report($year);

        $db = new Database();
        $employeesData = $db->getEmployeesData($year);

        $csv = Writer::createFromFileObject(new SplTempFileObject());

        $filename = 'users-' . $year->format('Y') . '.csv';
        file_put_contents($filename, $report->generateReport($csv, $employeesData));

        $output->writeln('filename: ' . $filename);
    }
}
