<?php

namespace App;

class TaskManager implements TaskInterface {
    private $name;
    private $duration;
    private $priority;
    private $category;
    private $completed = false;

    public function __construct($name, $duration, $priority, $category) {
        $this->name = $name;
        $this->duration = $duration;
        $this->priority = $priority;
        $this->category = $category;
    }

    public function completeTask() {
        $this->completed = true;
    }

    public function displayTask() {
        echo "<h5>{$this->name}</h5>";
        echo "<p>Duration: {$this->duration} minutes</p>";
        echo "<p>Priority: {$this->priority}</p>";
        echo "<p>Category: {$this->category}</p>";
        echo "<p>Status: " . ($this->completed ? 'Completed' : 'Incomplete') . "</p>";
    }
}