<?php

namespace application\command;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAndFillDatabaseCommand extends Command
{
    protected static $defaultName = 'app:create-database';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (file_exists('vacation.sqlite')) {
            unlink('vacation.sqlite');
        }

        $pdo = new PDO('sqlite:vacation.sqlite');
        $pdo->exec('create table employees
(
    id         integer not null
        constraint employees_pk
            primary key autoincrement,
    firstname  varchar not null,
    lastname   varchar not null,
    start_date text    not null,
    start_timestamp date    not null,
    birth_date text    not null,
    special_contract int
);');

        $pdo->exec('create unique index employees_id_uindex on employees (id);');

        $firstnames = [
            'Emma', 'Olivia', 'Ava', 'Isabella', 'Sophia', 'Charlotte', 'Mia', 'Amelia', 'Harper', 'Evelyn', 'Abigail', 'Emily', 'Elizabeth', 'Mila', 'Ella', 'Avery', 'Sofia', 'Camila', 'Aria', 'Scarlett', 'Victoria', 'Madison', 'Luna', 'Grace', 'Chloe', 'Penelope', 'Layla', 'Riley', 'Zoey', 'Nora', 'Lily', 'Eleanor', 'Hannah', 'Lillian', 'Addison', 'Aubrey', 'Ellie', 'Stella', 'Natalie', 'Zoe', 'Leah', 'Hazel', 'Violet', 'Aurora', 'Savannah', 'Audrey', 'Brooklyn', 'Bella', 'Claire', 'Skylar', 'Lucy', 'Paisley', 'Everly', 'Anna', 'Caroline', 'Nova', 'Genesis', 'Emilia', 'Kennedy', 'Samantha', 'Maya', 'Willow', 'Kinsley', 'Naomi', 'Aaliyah', 'Elena', 'Sarah', 'Ariana', 'Allison', 'Gabriella', 'Alice', 'Madelyn', 'Cora', 'Ruby', 'Eva', 'Serenity', 'Autumn', 'Adeline', 'Hailey', 'Gianna', 'Valentina', 'Isla', 'Eliana', 'Quinn', 'Nevaeh', 'Ivy', 'Sadie', 'Piper', 'Lydia', 'Alexa', 'Josephine', 'Emery', 'Julia', 'Delilah', 'Arianna', 'Vivian', 'Kaylee', 'Sophie', 'Brielle', 'Madeline', 'Noah', 'William', 'James', 'Logan', 'Benjamin', 'Mason', 'Elijah', 'Oliver', 'Jacob', 'Lucas', 'Michael', 'Alexander', 'Ethan', 'Daniel', 'Matthew', 'Aiden', 'Henry', 'Joseph', 'Jackson', 'Samuel', 'Sebastian', 'David', 'Carter', 'Wyatt', 'Jayden', 'John', 'Owen', 'Dylan', 'Luke', 'Gabriel', 'Anthony', 'Isaac', 'Grayson', 'Jack', 'Julian', 'Levi', 'Christopher', 'Joshua', 'Andrew', 'Lincoln', 'Mateo', 'Ryan', 'Jaxon', 'Nathan', 'Aaron', 'Isaiah', 'Thomas', 'Charles', 'Caleb', 'Josiah', 'Christian', 'Hunter', 'Eli', 'Jonathan', 'Connor', 'Landon', 'Adrian', 'Asher', 'Cameron', 'Leo', 'Theodore', 'Jeremiah', 'Hudson', 'Robert', 'Easton', 'Nolan', 'Nicholas', 'Ezra', 'Colton', 'Angel', 'Brayden', 'Jordan', 'Dominic', 'Austin', 'Ian', 'Adam', 'Elias', 'Jaxson', 'Greyson', 'Jose', 'Ezekiel', 'Carson', 'Evan', 'Maverick', 'Bryson', 'Jace', 'Cooper', 'Xavier', 'Parker', 'Roman', 'Jason', 'Santiago', 'Chase', 'Sawyer', 'Gavin', 'Leonardo', 'Kayden', 'Ayden', 'Jameson', 'Charlotte'
        ];

        $lastnames = [
            'Kline', 'Mccarty', 'Baker', 'Phelps', 'Stanton', 'Dawson', 'Holt', 'Dixon', 'Curry', 'Choi', 'Schwartz', 'Higgins', 'Owen', 'Carson', 'Ritter', 'Wilkins', 'Cisneros', 'Grant', 'Blanchard', 'Clements', 'Hutchinson', 'House', 'Wong', 'Arroyo', 'Wilson', 'Conley', 'Crosby', 'Ferguson', 'Atkinson', 'Bray', 'Aguirre', 'Gilbert', 'Lynch', 'Cooper', 'Schneider', 'Christian', 'Peterson', 'Shannon', 'Levy', 'Cruz', 'Black', 'Frost', 'Oliver', 'Gordon', 'Brown', 'Barton', 'Dougherty', 'Mays', 'Murillo', 'Graham', 'Bentley', 'Mcmillan', 'Lambert', 'Calhoun', 'Vaughn', 'Avery', 'Gonzales', 'Proctor', 'Palmer', 'Mason', 'Dickerson', 'Solomon', 'Stafford', 'Mills', 'Munoz', 'Gonzalez', 'Glenn', 'Hobbs', 'Mejia', 'Hicks', 'Griffith', 'Bruce', 'Dudley', 'Duarte', 'Hunter', 'Wiley', 'Valenzuela', 'Mcdonald', 'Vaughan', 'Olson', 'Kemp', 'Vang', 'Brooks', 'Williamson', 'Melton', 'Sweeney', 'Dunn', 'Glover', 'Weaver', 'James', 'Espinoza', 'Bauer', 'Keller', 'Mccoy', 'Hensley', 'Russo', 'Cannon', 'Burch', 'Davis', 'Jimenez'
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO employees (firstname, lastname, start_date, start_timestamp, birth_date, special_contract) VALUES (:firstname, :lastname, :start_date, :start_timestamp, :birth_date, :special_contract);'
        );

        $output->writeln('Adding workers to database');

        $progressBar = new ProgressBar($output, 1000);
        for ($i = 0; $i < 1000; $i++) {
            $stmt->bindValue('firstname', $firstnames[random_int(0, 199)]);
            $stmt->bindValue('lastname', $lastnames[random_int(0, 99)]);

            $birth_year = random_int(1955, 2003);
            $birth_date = $birth_year . '-' .
                sprintf('%02d', random_int(1, 12)) . '-' .
                sprintf('%02d', random_int(1, 28));
            $stmt->bindValue('birth_date', $birth_date);


            $start_year = random_int($birth_year + 16, 2019);
            $start_month = sprintf('%02d', random_int(1, 6));
            $start_day = random_int(0, 1) === 0 ? '01' : '15';
            $start_date = $start_year . '-' . $start_month . '-' . $start_day;
            $stmt->bindValue('start_date', $start_date);

            $start = new \DateTime($start_date);
            $stmt->bindValue('start_timestamp', $start->format('U'));

            if (random_int(1, 10) > 7) {
                $stmt->bindValue('special_contract', random_int(35, 40));
            } else {
                $stmt->bindValue('special_contract', null);
            }

            if (!$stmt->execute()) {
                throw new \RuntimeException('insert failed');
            }

            $progressBar->advance();
        }
        $progressBar->finish();
        $output->writeln('');
    }
}
