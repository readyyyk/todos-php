<?php
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

    public function __construct($table_name, array $addFields) {
        $this->table_name = $table_name;

        $this->countAddFields = count($addFields);

        $this->selectAllQuery = "SELECT * FROM $this->table_name WHERE TRUE";

        $this->selectEverythingByIdQuery = "SELECT * FROM $this->table_name WHERE `id` = ?";

        $this->addQuery = "INSERT INTO $this->table_name (".implode(",", $addFields).")
                            VALUES (".substr(str_repeat("?, ", count($addFields)), 0, -2).")";

        $this->deleteByIdQuery = "DELETE FROM $this->table_name WHERE `id` = ?";

        $this->baseUpdateByIdQuery = "UPDATE $this->table_name SET ".$this::replace_flag(0)."WHERE `id` = ?";
        $this->baseSelectQuery = "SELECT ".$this::replace_flag(0)." FROM $this->table_name WHERE ".$this::replace_flag(1)." ORDER BY ".$this::replace_flag(2);
    }

    protected function validateAddData (array $data): bool
    {
        return count($data) === $this->countAddFields;
    }
    protected function setupUpdateQuery(array $data): static
    {
        $params = array_reduce(
            array_keys($data),
            fn(array $acc, string $item) => array_push($acc, $item." = ?"),
            []
        );
        $this->updateQuery = str_replace($this::replace_flag(0), implode(", ", $params), $this->baseUpdateByIdQuery);
        var_dump($this->updateQuery);
        return $this;
    }

    protected function setupSelectQuery(array $fields=null, array $conditionFields=null, array $ordering = null):static
    {
        $fields_stringified = "*";
        if($fields){
            $fields_stringified = implode(", ", $fields);
        }

        $condition_stringified = "TRUE";
        if($conditionFields){
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
        if($ordering){
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

    public abstract function get(array $fields=null, array $conditionData=null, array $ordering = null): mysqli_stmt;
    abstract public function getById(int $id): mysqli_stmt;
    abstract public function add(...$data): mysqli_stmt;
    abstract public function deleteById(int $id): mysqli_stmt;
    abstract public function updateById(int $id, array $data): mysqli_stmt;
}

