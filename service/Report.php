<?php

namespace application\service;

use DateTime;
use Exception;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;

class Report
{
    public const MONTHS_IN_YEAR = 12;

    /** @var DateTime */
    protected $reportYear;

    public function __construct(DateTime $dateTime)
    {
        $this->reportYear = $dateTime;
    }

    /**
     * @param Employee $employee
     * @return int
     * @throws Exception
     */
    protected function getEmployeeAge(Employee $employee): int
    {
        $birthDate = $employee->getBirthDate();
        return $this->reportYear->diff($birthDate)->y;
    }

    protected function getCurrentTime(): DateTime
    {
        return new DateTime('now');
    }

    /**
     *
     * @param Employee $employee
     * @return int
     * @throws Exception
     */
    protected function getAccumulatedMonths(Employee $employee): int
    {
        $nowDate = $this->getCurrentTime();
        $employeeStartDate = $employee->getStartDate();

        if ($this->reportYear->format('Y') < $nowDate->format('Y')) {
            // report for previous years
            if ($employeeStartDate->format('Y') === $this->reportYear->format('Y')) {
                // employee started at explored year
                $endOfYear = new DateTime('last day of December ' . $employeeStartDate->format('Y'));
                $diff = $endOfYear->diff($employeeStartDate);

                return $diff->m;
            }
            // employee started earlier than explored year
            return self::MONTHS_IN_YEAR;
        }

        // report for current year
        $beginningOfYear = new DateTime('first day of january ' . $this->reportYear->format('Y'));

        $bonusMonth = 0;
        if ($employeeStartDate->format('Y-m-d') === $beginningOfYear->format('Y-m-d')) {
            /*
             * if at current year employee work from january first, at end of the year employee should be able
             * spend entire vacation, it is obvious, because employee work entire year
             */
            $bonusMonth = 1;
        }

        if ($employeeStartDate->format('Y') === $this->reportYear->format('Y')) {
            // employee started at current year
            $diff = $nowDate->diff($employeeStartDate);
            return $diff->m + $bonusMonth;
        }
        // employee started at previous years
        $diff = $nowDate->diff($beginningOfYear);
        return $diff->m + 1;
    }

    /**
     * @param Employee $employee
     * @return int
     * @throws Exception
     */
    protected function getYearsAtWork(Employee $employee): int
    {
        $startDate = $employee->getStartDate();
        return $this->reportYear->diff($startDate)->y;
    }

    /**
     * @param Employee $employee
     * @return int
     * @throws Exception
     */
    protected function getAllowedVacation(Employee $employee): int
    {
        $specialContractDays = $employee->getSpecialContractDays();
        if ($specialContractDays !== null) {
            return $specialContractDays;
        }

        $vacationDays = Employee::DEFAULT_VACATION;
        $yearsAtWork = $this->getYearsAtWork($employee);
        if ($yearsAtWork >= Employee::YEARS_FOR_ADDITIONAL_DAY &&
            $this->getEmployeeAge($employee) >= Employee::ADDITIONAL_DAY_AGE) {
            return $vacationDays + intdiv($yearsAtWork, Employee::YEARS_FOR_ADDITIONAL_DAY);
        }
        return Employee::DEFAULT_VACATION;
    }

    /**
     * @param Employee $employee
     * @return int
     * @throws Exception
     */
    public function getVacation(Employee $employee): int
    {
        $vacationPart = $this->getAllowedVacation($employee) / self::MONTHS_IN_YEAR;
        $months = $this->getAccumulatedMonths($employee);

        return floor($vacationPart * $months);
    }

    /**
     * @param Employee $employee
     * @return array
     * @throws Exception
     */
    public function getTableRow(Employee $employee): array
    {
        return [
            $employee->getId(),
            $employee->getName(),
            $this->getVacation($employee),
            $this->reportYear->format('Y'),
        ];
    }

    /**
     * @param Writer $csv
     * @param array $employeesData
     * @return string
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function generateReport(Writer $csv, array $employeesData): string
    {
        $csv->insertOne(['id', 'name', 'vacation days', 'year']);
        foreach ($employeesData as $one) {
            $employee = new Employee($one);
            $csv->insertOne($this->getTableRow($employee));
        }
        return $csv->getContent();
    }
}
