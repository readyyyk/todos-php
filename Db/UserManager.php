<?php

namespace Db;

use Exception;
use mysqli_stmt;

class UserManager extends Manager
{
    private string $USERNAME_PATTERN = "/^\w{3}\w+$/im";
    private string $PASSWORD_PATTERN = "/^.{3}.+$/im";

    public function __construct($table_name="users") {
        parent::__construct($table_name, ["username", "password"]);
    }

    protected function validateAddData(array $data): Exception|null
    {
        if(count($data) !== $this->countAddFields)
            return new Exception("Array has wrong number values.\nMust be passed: $this->countAddFields, Passed: {${count($data)}}!");

        list($username, $password) = $data;

        if(!isset($username, $password))
            return new Exception("Invalid data array:\nProvide data as [\$username, \$password]!");

        if(!(string)$username || !(string)$password)
            return new Exception("Invalid data types:\n\$username and \$password must be `string`!");

        return null;
    }

    protected function validateRegData(string $username, string $password): Exception|null
    {
        if(!preg_match($this->PASSWORD_PATTERN, $password))
            return new Exception("Password doesn't match pattern ( $this->PASSWORD_PATTERN )!");

        if(!preg_match($this->USERNAME_PATTERN, $username))
            return new Exception("Username doesn't match pattern ( $this->USERNAME_PATTERN )!");

        if ($this->getByUsername($username)->get_result()->num_rows)
            return new Exception("User with this username already exists!");

        return null;
    }

    public function getByUsername($username): mysqli_stmt
    {
        return $this->get(null, ["username"=>$username]);
    }

    public function register(string $username, string $password): Exception|array
    {
        $validationError = $this->validateRegData($username, $password);
        if(!empty($validationError))
            return $validationError;
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
        try {
            $userData = $this->add($username, $passwordHashed)->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return $e;
        }
        return ["id"=>$userData["id"], "username"=>$userData["username"]];
    }

    /**
     * @return Exception|array ["id"=>id, "username"=>username]
     *
     */
    public function login(string $username, string $password): Exception|array
    {
        $dbResult = $this->get(["id", "username", "password"], ["username"=>$username])->get_result();
        if(!$dbResult->num_rows)
            return new Exception("User not found");
        list($id, $username, $passwordHashed) = $dbResult->fetch_array();

        $isValidPassword = password_verify($password, $passwordHashed);
        if (!$isValidPassword)
            return new Exception("Password is not verified");
        return ["id"=>$id, "username"=>$username];
    }
}

return new UserManager();
