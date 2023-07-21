<?php
namespace Todo;
use Exception;

const TODO_STATES_COLORS = [
    "passive"=>"body",
    "ongoing"=>"primary",
    "done"=>"success",
    "important"=>"warning",
    "expired"=>"danger",
];

class Todo {
    public int $id = -1;
    public string $title = "";
    public string $state = "";

    /**
     * @throws Exception
     */
    public function __construct(string $title, string $state, int $id) {
        // union of strings may be in php 8
        if(!in_array($state, array_keys(TODO_STATES_COLORS))){
            throw new Exception("Invalid todo state");
        }

        $this->title = $title;
        $this->state = $state;
        $this->id = $id;
    }

    public function render(): string
    {
        $currentState = $this->state;
        $current_state_color = TODO_STATES_COLORS[$currentState];
        $buttonOutlineOrNot = function (string $state) use($currentState): string {
            return $currentState!==$state?"-outline":"";
        };
        $actionPassiveOrNot = function (string $state) use($currentState): string {
            return $currentState===$state?"passive":$state;
        };
        return <<<HTML
<div class="col-6 col-md-4 col-lg-3">
    <div class="card bg-opacity-25 bg-$current_state_color">
        <div class="card-body">
            <h5 class="card-title">$this->title</h5>
            <form action="/handlers/todo-action.php" method="POST" class="d-flex btn-group">
                <button type="submit" name="make-{$actionPassiveOrNot("ongoing")}" class="card-link btn btn{$buttonOutlineOrNot("ongoing")}-primary border-secondary border-end-0">
                    <i class="bi bi-record-circle-fill"></i>
                </button>
                <button type="submit" name="make-{$actionPassiveOrNot("done")}" class="card-link btn btn{$buttonOutlineOrNot("done")}-success border-secondary border-start-0 border-end-0">
                    <i class="bi bi-check2-circle"></i>
                </button>
                <input type="hidden" name="id" value="$this->id">
                <button type="submit" name="make-{$actionPassiveOrNot("important")}" class="card-link btn btn{$buttonOutlineOrNot("important")}-warning border-secondary border-start-0 border-end-0">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </button>
                <button type="submit" name="delete" class="card-link btn btn-outline-danger border-secondary border-start-0">
                    <i class="bi bi-trash3-fill"></i>
                </button>
            </form>
        </div>
    </div>
</div>
HTML;
    }
}
