<?php

namespace application\service;

use DateTime;
use Exception;

class Report
{
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

    /**
     * @param Employee $employee
     * @return int
     * @throws Exception
     */
    protected function getAccumulatedMonths(Employee $employee): int
    {
        $startDate = $employee->getStartDate();

        if ($this->reportYear->format('Y') > $startDate->format('Y')) {
            $startDate = new DateTime('first day of january');
            $startDate->modify('-1 month');
        } else {
            $startDate = new DateTime('first day of ' . $startDate->format('F'));
        }
        if ($this->reportYear->diff($startDate)->y > 0) {
            return 12;
        }
        return $this->reportYear->diff($startDate)->m;
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
        if ($yearsAtWork >= 5 && $this->getEmployeeAge($employee) >= 30) {
            return $vacationDays + intdiv($yearsAtWork, 5);
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
        $vacationPart = $this->getAllowedVacation($employee) / 12;
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
            $this->reportYear->format('Y-m-d'),
        ];
    }
}
