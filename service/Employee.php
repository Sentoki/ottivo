<?php

namespace application\service;

use DateTime;
use Exception;

class Employee
{
    public const ID = 'id';
    public const BIRTH_DATE = 'birth_date';
    public const START_DATE = 'start_date';
    public const FIRST_NAME = 'firstname';
    public const LAST_NAME = 'lastname';
    public const SPECIAL_CONTRACT  = 'special_contract';

    public const DEFAULT_VACATION = 26;

    protected $employeeData;
    /** @var DateTime */
    protected $reportYear;

    public function __construct(array $employeeData)
    {
        $this->employeeData = $employeeData;
        $this->reportYear = new DateTime('now');
    }

    public function getName(): string
    {
        return $this->employeeData[self::FIRST_NAME] . ' ' . $this->employeeData[self::LAST_NAME];
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getBirthDate(): DateTime
    {
        return new DateTime($this->employeeData[self::BIRTH_DATE]);
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getStartDate(): DateTime
    {
        return new DateTime($this->employeeData[self::START_DATE]);
    }

    public function getSpecialContractDays()
    {
        return $this->employeeData[self::SPECIAL_CONTRACT];
    }

    public function getId(): int
    {
        return $this->employeeData[self::ID];
    }
}
