<?php

use application\service\Employee;
use application\service\Report;
use PHPUnit\Framework\TestCase;

class ReportTest extends TestCase
{
    public function testConstructor()
    {
        $employee = new Report(new DateTime());
        $this->assertInstanceOf(Report::class, $employee);
    }

    public function getEmployeeAgeProvider()
    {
        return [
            [
                33,
                [
                    'firstname' => '',
                    'lastname' => '',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '1986-06-22',
                ],
                '2019-06-24'
            ],
            [
                29,
                [
                    'firstname' => '',
                    'lastname' => '',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '1990-01-01',
                ],
                '2019-01-01'
            ],
            [
                28,
                [
                    'firstname' => '',
                    'lastname' => '',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '1990-01-01',
                ],
                '2018-12-31'
            ],
        ];
    }

    /**
     * @dataProvider getEmployeeAgeProvider
     *
     * @param $expected
     * @param $employeeData
     * @param $today
     * @throws Exception
     */
    public function testGetEmployeeAge($expected, $employeeData, $today)
    {
        $report = new class(new DateTime($today)) extends Report {
            public function getEmployeeAge(Employee $employee): int
            {
                return parent::getEmployeeAge($employee);
            }
        };
        $employee = new Employee($employeeData);
        $this->assertEquals($expected, $report->getEmployeeAge($employee));
    }

    public function getAccumulatedMonthsProvider()
    {
        return [
            [
                1,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-02-12'
            ],
            [
                1,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-02-12'
            ],
            [
                5,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-06-30'
            ],
            [
                1,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-02-28'
            ],
            [
                2,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2018-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-02-28'
            ],
            [
                2,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2018-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-02-01'
            ],
            [
                12,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2018-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-12-15'
            ],
            [
                12,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2018-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-12-31'
            ],
            [
                12,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2015-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-12-31'
            ],
            [
                12,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2010-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-12-31'
            ],
            [
                4,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2010-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-04-15'
            ],
        ];
    }

    /**
     * @dataProvider getAccumulatedMonthsProvider
     * @param $expected
     * @param $employeeData
     * @param $today
     * @throws Exception
     */
    public function testGetAccumulatedMonths($expected, $employeeData, $today)
    {
        $employee = new Employee($employeeData);

        $report = new class(new DateTime($today)) extends Report {
            public function getAccumulatedMonths(Employee $employee): int
            {
                return parent::getAccumulatedMonths($employee);
            }
        };

        $this->assertEquals($expected, $report->getAccumulatedMonths($employee));
    }

    public function getYearsAtWorkProvider()
    {
        return [
            [
                0,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-02-12'
            ],
            [
                0,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-12-12'
            ],
            [
                0,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-12-31'
            ],
            [
                1,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2020-01-01'
            ],
            [
                1,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2020-06-01'
            ],
            [
                15,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2005-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2020-06-01'
            ],
            [
                15,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2005-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2020-12-31'
            ],
        ];
    }

    /**
     * @dataProvider getYearsAtWorkProvider
     * @param $expected
     * @param $employeeData
     * @param $today
     * @throws Exception
     */
    public function testGetYearsAtWork($expected, $employeeData, $today)
    {
        $employee = new Employee($employeeData);

        $report = new class(new DateTime($today)) extends Report {
            public function getYearsAtWork(Employee $employee): int
            {
                return parent::getYearsAtWork($employee);
            }
        };

        $this->assertEquals($expected, $report->getYearsAtWork($employee));
    }

    public function getAllowedVacationProvider()
    {
        return [
            [26, '2019-02-01', '1979-02-01', null],
            [26, '2019-03-15', '1995-03-14', null],
            [26, '2018-03-15', '1998-04-16', null],
            [27, '2013-03-15', '1989-05-18', null],
            [27, '2013-04-15', '1988-03-31', null],
            [26, '2004-04-15', '1991-03-31', null],
            [29, '2004-04-15', '1989-04-31', null],
            [56, '1869-04-15', '1839-05-24', null],
            [126, '1519-04-01', '1489-03-12', null],
            [30, '2019-02-01', '1979-03-01', 30],
            [50, '2019-03-01', '1994-03-13', 50],
            [10, '2016-03-01', '1996-03-13', 10],
        ];
    }

    /**
     * @dataProvider getAllowedVacationProvider
     * @param $expected
     * @param $startDate
     * @param $birthDate
     * @param $specialContractDays
     * @throws Exception
     */
    public function testGetAllowedVacation($expected, $startDate, $birthDate, $specialContractDays)
    {
        $employee = new class([]) extends Employee {
            public $specialContractDays;
            public $startDate;
            public $birthDate;
            public function getSpecialContractDays()
            {
                return $this->specialContractDays;
            }
            public function getStartDate(): DateTime
            {
                return $this->startDate;
            }
            public function getBirthDate(): DateTime
            {
                return $this->birthDate;
            }
        };
        $employee->specialContractDays = $specialContractDays;
        $employee->startDate = new DateTime($startDate);
        $employee->birthDate = new DateTime($birthDate);

        $report = new class(new DateTime('2019-06-01')) extends Report {
            public function getAllowedVacation(Employee $employee): int
            {
                return parent::getAllowedVacation($employee);
            }
        };

        $this->assertEquals($expected, $report->getAllowedVacation($employee));
    }

    public function getVacationProvider()
    {
        return [
            [10, 26, 5],
            [2, 10, 3],
            [30, 30, 12],
            [15, 30, 6],
        ];
    }

    /**
     * @dataProvider getVacationProvider
     *
     * @param $expected
     * @param $allowedVacation
     * @param $accumulatedMonths
     * @throws Exception
     */
    public function testGetVacation($expected, $allowedVacation, $accumulatedMonths)
    {

        $report = new class(new DateTime()) extends Report {
            public $allowedVacation;
            public $accumulatedMonths;
            protected function getAllowedVacation(Employee $employee): int
            {
                return $this->allowedVacation;
            }
            protected function getAccumulatedMonths(Employee $employee): int
            {
                return $this->accumulatedMonths;
            }
        };
        $employee = new Employee([]);

        $report->allowedVacation = $allowedVacation;
        $report->accumulatedMonths = $accumulatedMonths;

        $this->assertEquals($expected, $report->getVacation($employee));
    }
}
