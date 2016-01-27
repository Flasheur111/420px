<?php

/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 25/04/15
 * Time: 01:59
 */
include_once('../controller/BaseController.php');
class UserController extends BaseController
{
    public function createUser($pseudo, $password)
    {
        $login = htmlspecialchars($pseudo);
        $pass = hash('sha512', htmlspecialchars($password));
        if ($this->checkUserExist($login) > 0) {
            return "User already exist";
        }

        if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $login)) {
            return 'You password need to be as following : </br>
                        First character must be alphanumeric </br>
                        For other characters, you can only use a-z, A-Z or 0-9 characters </br>
                        Password must be 5 to 31 characters length';
        }
        try {
            $request = $this->connection->prepare('INSERT INTO users (login, password) VALUES (:login,:pass)');
            $request->bindParam(':login', $login);
            $request->bindParam(':pass', $pass);
            $request->execute();
            $_SESSION["user"] = $login;
            return "OK";
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return "FALSE";
    }


    public
    function checkUserExist($pseudo)
    {
        $input_pseudo = htmlspecialchars($pseudo);
        try {
            $result = $this->connection->prepare('SELECT * FROM users WHERE login=:login');
            $result->bindParam(':login', $input_pseudo);
            $result->execute();
            return $result->rowCount();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return 0;
    }

    public
    function login($pseudo, $password)
    {
        $login = htmlspecialchars($pseudo);
        $pass = hash('sha512', htmlspecialchars($password));
        try {
            $result = $this->connection->prepare('SELECT * FROM users WHERE login=:login AND password=:pass');
            $result->bindParam(':login',$login);
            $result->bindParam(':pass', $pass);
            $result->execute();
            if ($result->rowCount() > 0) {
                $_SESSION["user"] = $login;
                return "OK";
            }
        } catch (Exception $e) {
        }
        return "Error";
    }

    function listUsers()
    {
        try
        {
            $result = $this->connection->prepare('SELECT login FROM users');
            $result->execute();
            $formatted_list = "";

            while ($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                $formatted_list = $formatted_list . '"' . $row['login'] . '",';
            }
            return $formatted_list;
        }
        catch(Exception $e){
        }
        return "Error";
    }

    function listUsersStack()
    {
        try
        {
            $result = $this->connection->prepare('SELECT login FROM users');
            $result->execute();
            $stack = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                array_push($stack, $row['login']);
            }
            return $stack;;
        }
        catch(Exception $e){
        }
        return null;
    }


} ?>