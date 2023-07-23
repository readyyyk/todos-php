<?php

namespace Db;
use mysqli_stmt;

abstract class Manager
{
    private static function replace_flag(int $id): string
    {
        return "/!<$id>!/";
    }

    protected readonly string $table_name;
    protected readonly string $addQuery;

    protected readonly string $baseSelectQuery;
    protected readonly string $selectQuery;
    protected readonly string $selectAllQuery;
    protected readonly string $selectEverythingByIdQuery;

    protected readonly string $baseUpdateByIdQuery;
    protected readonly string $updateQuery;

    protected readonly string $deleteByIdQuery;

    protected int $countAddFields;

    public function __construct($table_name, array $addFields)
    {
        $this->table_name = $table_name;

        $this->countAddFields = count($addFields);

        $this->selectAllQuery = "SELECT * FROM $this->table_name WHERE TRUE";

        $this->selectEverythingByIdQuery = "SELECT * FROM $this->table_name WHERE `id` = ?";

        $this->addQuery = "INSERT INTO $this->table_name (" . implode(",", $addFields) . ")
                            VALUES (" . substr(str_repeat("?, ", count($addFields)), 0, -2) . ")";

        $this->deleteByIdQuery = "DELETE FROM $this->table_name WHERE `id` = ?";

        $this->baseUpdateByIdQuery = "UPDATE $this->table_name SET " . $this::replace_flag(0) . "WHERE `id` = ?";
        $this->baseSelectQuery = "SELECT " . $this::replace_flag(0) . " FROM $this->table_name WHERE " . $this::replace_flag(1) . " ORDER BY " . $this::replace_flag(2);
    }


    /**
     * example:
     *
     * {
     *      if(count($data) !== $this->countAddFields)
     *          return new Exception("Invalid data array");
     *      return null;
     * }
     */
    protected abstract function validateAddData(array $data): \Exception|null;

    protected function setupUpdateQuery(array $data): static
    {
        var_dump(array_reduce(
            array_keys($data),
            function (array $acc, string $item) {
                $acc[] = "$item = ?";
                return $acc;
            },
            []
        ));
        $params = implode(
            ", ",
            array_reduce(
                array_keys($data),
                function (array $acc, string $item) {
                    $acc[] = "$item = ?";
                    return $acc;
                },
                []
            )
        );
        $this->updateQuery = str_replace($this::replace_flag(0), $params." ", $this->baseUpdateByIdQuery);
        var_dump($this->updateQuery);
        return $this;
    }

    protected function setupSelectQuery(array $fields = null, array $conditionFields = null, array $ordering = null): static
    {
        $fields_stringified = "*";
        if ($fields) {
            $fields_stringified = implode(", ", $fields);
        }

        $condition_stringified = "TRUE";
        if ($conditionFields) {
            $condition_stringified =
                implode(
                    " AND ",
                    array_reduce(
                        $conditionFields,
                        function (array $acc, string $cur) {
                            $acc[] = "$cur = ?";
                            return $acc;
                        },
                        []
                    )
                );
        }

        $ordering_stringified = "id ASC";
        if ($ordering) {
            $ordering_stringified =
                implode(
                    ", ",
                    array_reduce(
                        array_keys($ordering),
                        function (array $acc, string $cur) use ($ordering) {
                            $acc[] = "$cur $ordering[$cur]";
                            return $acc;
                        },
                        []
                    )
                );
        }
        $this->selectQuery = str_replace(
            [$this::replace_flag(0), $this::replace_flag(1), $this::replace_flag(2)],
            [$fields_stringified, $condition_stringified, $ordering_stringified],
            $this->baseSelectQuery
        );
        return $this;
    }

    public function get(array $fields = null, array $conditionData = null, array $ordering = null): mysqli_stmt
    {
        $this->setupSelectQuery($fields, array_keys($conditionData), $ordering);
        return executeQuery($this->selectQuery, array_values($conditionData));
    }

    /**
     * executes $this->validateAddData($data);
     * @throws \Exception
     */
        public function add(...$data): mysqli_stmt {
            $validationError = $this->validateAddData($data);
            if(!empty($validationError))
                throw $validationError;
            return executeQuery($this->addQuery, $data);
        }

    public function getById(int $id): mysqli_stmt {
        return executeQuery($this->selectEverythingByIdQuery, [$id], "i");
    }

    public function deleteById(int $id): mysqli_stmt {
        return executeQuery($this->deleteByIdQuery, [$id], "i");
    }

    public function updateById(array $data, int $id): mysqli_stmt {
        $this->setupUpdateQuery($data);
        return executeQuery(
            $this->updateQuery,
            [...array_values($data), $id],
            str_repeat("s", count(array_values($data)))."i"
        );
    }
}

