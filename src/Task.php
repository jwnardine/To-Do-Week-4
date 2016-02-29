<?php
class Task
{
    private $description;
    private $category_id;
    private $id;
    private $due;

    function __construct($description, $id = null, $category_id, $due)
    {
      $this->description = $description;
      $this->id = $id;
      $this->category_id = $category_id;
      $this->due = $due;
    }
    function getId()
    {
      return $this->id;
    }
    function setDue($new_due)
    {
      $this->due = (string) $new_due;
    }
    function getDue()
    {
      return $this->due;
    }
    function getCategoryId()
    {
      return $this->category_id;
    }
    function setDescription($new_description)
    {
      $this->description = (string) $new_description;
    }
    function getDescription()
    {
      return $this->description;
    }
    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO tasks (description, category_id, due) VALUES ('{$this->getDescription()}', {$this->getCategoryId()}, '{$this->getDue()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }
    static function getAll()
    {
      $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks ORDER BY description");

      $tasks = array();
      foreach($returned_tasks as $task) {
          $description = $task['description'];
          $id = $task['id'];
          $category_id = $task['category_id'];
          $due = $task['due'];
          $new_task = new Task($description, $id, $category_id, $due);
          array_push($tasks, $new_task);
      }
      return $tasks;
    }

    static function deleteAll()
    {
       $GLOBALS['DB']->exec("DELETE FROM tasks;");
    }
    static function find($search_id)
    {
      $found_task = null;
      $tasks = Task::getAll();
      foreach($tasks as $task)
      {
        $task_id = $task->getId();
        if ($task_id == $search_id)
          {
            $found_task = $task;
          }
      } return $found_task;
    }
    
}
?>
