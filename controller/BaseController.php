<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 30/04/15
 * Time: 13:56
 */
class BaseController
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new PDO('mysql:host=localhost;dbname=tp_php', 'root', 'root');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connection->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
    }
}