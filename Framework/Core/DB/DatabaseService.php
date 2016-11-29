<?php

namespace App\Core\DB;

use PDO;

class DatabaseService
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var
     */
    private static $instance;

    /**
     * @var
     */
    private static $defaultPDOParametrs;

    /**
     * DatabaseService constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * @param array $defaultPDOParametrs
     */
    public static function setDefaultPDOParametrs(array $defaultPDOParametrs)
    {
        self::$defaultPDOParametrs = $defaultPDOParametrs;
    }

    /**
     * @return DatabaseService
     */
    public static function getInstance()
    {
        if( empty(self::$instance) ){
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$instance = new self($pdo);
        }

        return self::$instance;
    }
}