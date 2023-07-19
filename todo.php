<?php
const TODO_STATES_COLORS = [
    "passive"=>"body",
    "ongoing"=>"primary",
    "done"=>"success",
    "important"=>"warning",
    "expired"=>"danger",
];

class Todo {
    public string $title = "";
    public string $state = "";

    /**
     * @throws Exception
     */
    public function __construct(string $title, string $state) {
        // union of strings may be in php 8
        if(!in_array($state, array_keys(TODO_STATES_COLORS))){
            throw new Exception("Invalid todo state");
        }

        $this->title = $title;
        $this->state = $state;
    }

    public function render(): string
    {
        $current_state_color = TODO_STATES_COLORS[$this->state];
        return <<<HTML
<div class="col-6 col-md-4 col-lg-3">
    <div class="card bg-opacity-25 bg-{$current_state_color}">
        <div class="card-body">
            <h5 class="card-title">{$this->title}</h5>
            <div class="d-flex btn-group">
                <a href="#" class="card-link btn btn-outline-success border-secondary border-end-0">
                    <i class="bi bi-check2-circle"></i>
                </a>
                <a href="#" class="card-link btn btn-outline-warning border-secondary border-start-0 border-end-0">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </a>
                <a href="#" class="card-link btn btn-outline-danger border-secondary border-start-0">
                    <i class="bi bi-trash3-fill"></i>
                </a>
            </div>
        </div>
    </div>
</div>
HTML;

    }
}
