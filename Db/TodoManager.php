<?php
namespace Db;

include("Manager.php");

use Exception;
use mysqli_stmt;

class TodoManager extends Manager {
    public function __construct($table_name="todos") {
        parent::__construct($table_name, ["title", "owner"]);
    }

    protected function validateAddData(array $data): Exception|null
    {
        if(count($data) !== $this->countAddFields)
            return new Exception("Array has wrong number values.\nMust be passed: $this->countAddFields, Passed: {${count($data)}}");
        list($title, $owner) = $data;
        if(!isset($title, $owner))
            return new Exception("Invalid data array:\nProvide data as [\$title, \$owner]");
        if(!(string)$title || !(int)$owner)
            return new Exception("Invalid data types:\n\$title must be `string`, owner - `int`");
        return null;
    }

    public function getByOwnerId(int $ownerId, array $fields=null, array $ordering=null): mysqli_stmt {
        $this->setupSelectQuery($fields, ["owner"], $ordering);
        return executeQuery($this->selectQuery, [$ownerId]);
    }

    /**
     * @param mixed $data string $title, int $owner
     * @throws Exception
     */
    public function add(...$data): mysqli_stmt {
        return parent::add(...$data);
    }
}

return new TodoManager();
