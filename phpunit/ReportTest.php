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
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '1986-06-22',
                ],
                '2019-06-24'
            ],
            [
                29,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '1990-01-01',
                ],
                '2019-01-01'
            ],
            [
                28,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '',
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
                4,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-05-30', // current date
            ],
            [
                3,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-02-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-05-30', // current date
            ],
            [
                0,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-05-30', // current date
            ],
            [
                0,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-01-31', // current date
            ],
            [
                2,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2018-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-31', // report date
                '2019-02-28' // current date
            ],
            [
                2,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2018-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-31', // report date
                '2019-02-01' // current date
            ],
            [
                12,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2010-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-12-31', // current date
            ],
            [
                6,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2010-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-06-23' // current date
            ],
            [
                12,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2010-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2018-01-01', // report date
                '2019-06-23' // current date
            ],
            [
                7,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2018-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2018-01-01', // report date
                '2019-06-23' // current date
            ],
            [
                12,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2010-05-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2013-01-01', // report date
                '2019-06-23' // current date
            ],
            [
                2,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-04-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-06-23' // current date
            ],
            [
                12,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-12-31' // current date
            ],
            [
                12,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-12-02' // current date
            ],
            [
                11,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-01-01', // report date
                '2019-11-30' // current date
            ],
        ];
    }

    /**
     * @dataProvider getAccumulatedMonthsProvider
     * @param $expected
     * @param $employeeData
     * @param $reportDate
     * @throws Exception
     */
    public function testGetAccumulatedMonths($expected, $employeeData, $reportDate, $currentDate)
    {
        $employee = new Employee($employeeData);

        $report = new class(new DateTime($reportDate)) extends Report {
            public $currentDate;
            public function getAccumulatedMonths(Employee $employee): int
            {
                return parent::getAccumulatedMonths($employee);
            }
            protected function getCurrentTime(): DateTime
            {
                return new DateTime($this->currentDate);
            }
        };
        $report->currentDate = $currentDate;

        $this->assertEquals($expected, $report->getAccumulatedMonths($employee));
    }

    public function getYearsAtWorkProvider()
    {
        return [
            [
                0,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-02-12'
            ],
            [
                0,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-15',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-12-12'
            ],
            [
                0,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2019-12-31'
            ],
            [
                1,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2020-01-01'
            ],
            [
                1,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2019-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2020-06-01'
            ],
            [
                15,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2005-01-01',
                    Employee::BIRTH_DATE => '',
                ],
                '2020-06-01'
            ],
            [
                15,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
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
            [26, '2019-02-01', '1979-02-01', null, '2019-06-01'],
            [26, '2019-03-15', '1995-03-14', null, '2019-06-01'],
            [26, '2018-03-15', '1998-04-16', null, '2019-06-01'],
            [27, '2013-03-15', '1989-05-18', null, '2019-06-01'],
            [27, '2013-04-15', '1988-03-31', null, '2019-06-01'],
            [26, '2004-04-15', '1991-03-31', null, '2019-06-01'],
            [29, '2004-04-15', '1989-04-31', null, '2019-06-01'],
            [56, '1869-04-15', '1839-05-24', null, '2019-06-01'],
            [126, '1519-04-01', '1489-03-12', null, '2019-06-01'],
            [30, '2019-02-01', '1979-03-01', 30, '2019-06-01'],
            [50, '2019-03-01', '1994-03-13', 50, '2019-06-01'],
            [10, '2016-03-01', '1996-03-13', 10, '2019-06-01'],
            [27, '2014-06-01', '1976-06-01', null, '2019-06-01'],
            [36, '2004-01-15', '1964-09-25', 36, '2018-06-01'],
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
    public function testGetAllowedVacation($expected, $startDate, $birthDate, $specialContractDays, $requestedYear)
    {
        $employee = new class([]) extends Employee {
            public $specialContractDays;
            public $startDate;
            public $birthDate;
            public function getSpecialContractDays(): ?int
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

        $report = new class(new DateTime($requestedYear)) extends Report {
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

    public function testGenerateReport()
    {
        $report = new class(new DateTime()) extends Report {
            public $getTableRowCalled = false;
            public function getTableRow(Employee $employee): array
            {
                $this->getTableRowCalled = true;
                return [1, 'name', 20, 2019];
            }
        };

        $csv = new class extends \League\Csv\Writer {
            public $document = [];
            public function __construct()
            {
            }
            public function insertOne(array $record): int
            {
                if (count($record) !== 4) {
                    throw new RuntimeException('wrong data');
                }
                $this->document[] = $record;
                return 1;
            }
            public function getContent(): string
            {
                return '';
            }
        };

        $report->generateReport($csv, [[]]);

        $this->assertCount(2, $csv->document);
        $this->assertTrue($report->getTableRowCalled);
    }

    public function testGetTableRow()
    {
        $report = new class(new DateTime('2019-06-01')) extends Report {
            public function getVacation(Employee $employee): int
            {
                return 10;
            }
        };


        $employee = new class([]) extends Employee {
            public function getId(): int
            {
                return 1;
            }
            public function getName(): string
            {
                return 'name';
            }
        };

        $row = $report->getTableRow($employee);

        $this->assertEquals(1, $row[0]);
        $this->assertEquals('name', $row[1]);
        $this->assertEquals(10, $row[2]);
        $this->assertEquals('2019', $row[3]);
    }

    public function testGetCurrentTime()
    {
        $report = new class(new DateTime()) extends Report {
            public function getCurrentTime(): DateTime
            {
                return parent::getCurrentTime();
            }
        };

        $this->assertEquals((new DateTime())->format('Y-m-d'), $report->getCurrentTime()->format('Y-m-d'));
    }
}
