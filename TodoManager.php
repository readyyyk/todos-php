<?php
namespace Todo;

include("Manager.php");

use Exception;
use mysqli_stmt;
use function Db\executeQuery;

class TodoManager extends \Manager {
    public function __construct($table_name="todos") {
        parent::__construct($table_name, ["title", "owner"]);
    }

    public function get(array $fields=null, array $conditionData=null   , array $ordering = null): mysqli_stmt {
        $this->setupSelectQuery($fields, array_keys($conditionData), $ordering);
        return executeQuery($this->selectQuery, array_values($conditionData));
    }
    public function getByOwner(int $ownerId, array $fields=null, array $ordering=null): mysqli_stmt {
        $this->setupSelectQuery($fields, ["owner"], $ordering);
        return executeQuery($this->selectQuery, [$ownerId]);
    }
    public function getById(int $id): mysqli_stmt {
        return executeQuery($this->selectEverythingByIdQuery, [$id], "i");
    }
    public function getByOwnerId(int $id): mysqli_stmt {
        return executeQuery($this->selectEverythingByIdQuery, [$id], "i");
    }

    /** @throws Exception */
    public function add(...$data): mysqli_stmt {
        if(!$this->validateAddData($data))
            throw new Exception("Invalid data array");
        list($title, $owner) = $data;
        return executeQuery($this->addQuery, [$title, $owner], "si");
    }

    public function deleteById(int $id): mysqli_stmt {
        return executeQuery($this->deleteByIdQuery, [$id], "i");
    }

    public function updateById(int $id, array $data): mysqli_stmt {
        $this->setupUpdateQuery($data);
        return executeQuery($this->updateQuery, [$id], "i");
    }
}
