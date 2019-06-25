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
                    Employee::FIRST_NAME => 'asd',
                    Employee::LAST_NAME => 'fgh',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '',
                ],
            ],
            [
                'qwe rty',
                [
                    Employee::FIRST_NAME => 'qwe',
                    Employee::LAST_NAME => 'rty',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '',
                ],
            ],
            [
                'zxc vbn',
                [
                    Employee::FIRST_NAME => 'zxc',
                    Employee::LAST_NAME => 'vbn',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '',
                ],
            ],
        ];
    }

    /**
     * @dataProvider getNameProvider
     * @param $expected
     * @param $data
     * @throws Exception
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
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '2001-04-14',
                ],
            ],
            [
                '1993-11-23',
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '1993-11-23',
                ],
            ],
            [
                '1987-04-13',
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '',
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
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '2001-04-14',
                    Employee::BIRTH_DATE => '',
                ],
            ],
            [
                '1993-11-23',
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '1993-11-23',
                    Employee::BIRTH_DATE => '',
                ],
            ],
            [
                '1987-04-13',
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
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
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '',
                    Employee::SPECIAL_CONTRACT => null,
                ],
            ],
            [
                30,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
                    Employee::START_DATE => '',
                    Employee::BIRTH_DATE => '',
                    Employee::SPECIAL_CONTRACT => 30,
                ],
            ],
            [
                40,
                [
                    Employee::FIRST_NAME => '',
                    Employee::LAST_NAME => '',
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
     * @throws Exception
     */
    public function testGetSpecialContractDays($expected, $data)
    {
        $employee = new Employee($data);
        $days = $employee->getSpecialContractDays();

        $this->assertEquals($expected, $days);
    }

    public function getIdProvider()
    {
        return [
            [
                1,
                [
                    Employee::ID => 1,
                ],
            ],
            [
                100,
                [
                    Employee::ID => 100,
                ],
            ],
            [
                333,
                [
                    Employee::ID => 333,
                ],
            ],
        ];
    }

    /**
     * @dataProvider getIdProvider
     * @param $expected
     * @param $data
     * @throws Exception
     */
    public function testGetId($expected, $data)
    {
        $employee = new Employee($data);
        $id = $employee->getId();

        $this->assertEquals($expected, $id);
    }
}
