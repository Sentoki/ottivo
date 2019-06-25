<?php

namespace application\service;

use DateTime;
use PDO;

class Database
{
    /** @var PDO */
    protected $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->pdo = new PDO('sqlite:vacation.sqlite');
    }

    /**
     * @param DateTime $year
     * @return array
     */
    public function getEmployeesData(DateTime $year): array
    {
        $stmt = $this->pdo->prepare('select * from employees where start_timestamp<:timestamp');
        $stmt->bindValue('timestamp', $year->format('U'));
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
