<?php

namespace application\command;

use application\service\Database;
use application\service\Employee;
use application\service\Report;
use DateTime;
use Exception;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VacationDaysCommand extends Command
{
    protected static $defaultName = 'app:vacation-days';

    protected function configure()
    {
        $this->addArgument('year', InputArgument::REQUIRED, 'required year');

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

        $db = new Database();
        $employeesData = $db->getEmployeesData($year);

        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertOne(['id', 'name', 'vacation days', 'year']);

        $report = new Report($year);
        foreach ($employeesData as $one) {
            $employee = new Employee($one);
            $csv->insertOne($report->getTableRow($employee));
        }

        file_put_contents('users-' . $year->format('Y') . '.csv', $csv->getContent());
    }

}
