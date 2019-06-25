<?php

use application\service\Employee;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{

    public function testConstructor()
    {
        $employee = new Employee([]);
        $this->assertInstanceOf(Employee::class, $employee);
    }

    public function getNameProvider()
    {
        return [
            [
                'asd fgh',
                [
                    'firstname' => 'asd',
                    'lastname' => 'fgh',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '',
                ],
            ],
            [
                'qwe rty',
                [
                    'firstname' => 'qwe',
                    'lastname' => 'rty',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '',
                ],
            ],
            [
                'zxc vbn',
                [
                    'firstname' => 'zxc',
                    'lastname' => 'vbn',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '',
                ],
            ],
        ];
    }

    /**
     * @dataProvider getNameProvider
     * @param $expected
     * @param $data
     */
    public function testGetName($expected, $data)
    {
        $employee = new Employee($data);
        $this->assertEquals($expected, $employee->getName());
    }

    public function getBirthDateProvider()
    {
        return [
            [
                '2001-04-14',
                [
                    'firstname' => '',
                    'lastname' => '',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '2001-04-14',
                ],
            ],
            [
                '1993-11-23',
                [
                    'firstname' => '',
                    'lastname' => '',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '1993-11-23',
                ],
            ],
            [
                '1987-04-13',
                [
                    'firstname' => '',
                    'lastname' => '',
                    'start_date' => '',
                    Employee::BIRTH_DATE => '1987-04-13',
                ],
            ],
        ];
    }

    /**
     * @dataProvider getBirthDateProvider
     * @param $expected
     * @param $data
     * @throws Exception
     */
    public function testGetBirthDate($expected, $data)
    {
        $employee = new Employee($data);
        $birthDate = $employee->getBirthDate();

        $this->assertEquals($expected, $birthDate->format('Y-m-d'));
    }

    public function getStartDateProvider()
    {
        return [
            [
                '2001-04-14',
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '2001-04-14',
                    Employee::BIRTH_DATE => '',
                ],
            ],
            [
                '1993-11-23',
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '1993-11-23',
                    Employee::BIRTH_DATE => '',
                ],
            ],
            [
                '1987-04-13',
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '1987-04-13',
                    Employee::BIRTH_DATE => '',
                ],
            ],
        ];
    }

    /**
     * @dataProvider getStartDateProvider
     * @param $expected
     * @param $data
     * @throws Exception
     */
    public function testGetStartDate($expected, $data)
    {
        $employee = new Employee($data);
        $startDate = $employee->getStartDate();

        $this->assertEquals($expected, $startDate->format('Y-m-d'));
    }

    public function getSpecialContractDaysProvider()
    {
        return [
            [
                null,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '',
                    Employee::SPECIAL_CONTRACT => null,
                ],
            ],
            [
                30,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '',
                    Employee::SPECIAL_CONTRACT => 30,
                ],
            ],
            [
                40,
                [
                    'firstname' => '',
                    'lastname' => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '',
                    Employee::SPECIAL_CONTRACT => 40,
                ],
            ],
        ];
    }

    /**
     * @dataProvider getSpecialContractDaysProvider
     * @param $expected
     * @param $data
     */
    public function testGetSpecialContractDays($expected, $data)
    {
        $employee = new Employee($data);
        $days = $employee->getSpecialContractDays();

        $this->assertEquals($expected, $days);
    }
}
