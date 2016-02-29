<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Category::deleteAll();
          Task::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Work stuff";
            $test_Category = new Category($name);

            //Act
            $result = $test_Category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);

            //Act
            $result = $test_Category->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Work stuff";
            $test_Category = new Category($name);
            $test_Category->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_Category, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Work stuff";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            //Act
            $result = Category::find($test_Category->getId());

            //Assert
            $this->assertEquals($test_Category, $result);
        }
        function testUpdate()
        {
          //Arrange
          $name = "Home stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $new_name = "Work stuff";

          //Act
          $test_category->update($new_name);
          //Assert
          $this->assertEquals("Work stuff", $test_category->getName());
        }
        // function testDelete()
        // {
        //   //Arrange
        //   $name = "Work stuff";
        //   $id = null;
        //   $test_category = new Category($name, $id);
        //   $test_category->save();
        //
        //   $name2 = "Home stuff";
        //   $test_category2 = new Category($name2, $id);
        //   $test_category2->save();
        //
        //   //Act
        //   $test_category->delete();
        //   //Assert
        //   $this->assertEquals([$test_category2], Category::getAll());
        // }
        function testAddTask()
        {
          //Arrange
          $name = "Work stuff";
          $id = 1;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "File reports";
          $id2 = 2;
          $due = "2016-03-04";
          $test_task = new Task($description, $id2, $due);
          $test_task->save();
          //Act
          $test_category->addTask($test_task);
          //Assert
          $this->assertEquals($test_category->tasks(), [$test_task]);
        }
        function testGetTasks()
        {
        //Arrange
            $name = "Home stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $id2 = 2;
            $due = "2016-09-09";
            $test_task = new Task($description, $id2, $due);
            $test_task->save();

            $description2 = "Take out the trash";
            $id3 = 3;
            $due = "2016-03-09";
            $test_task2 = new Task($description2, $id3, $due);
            $test_task2->save();

            //Act
            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            //Assert
            $this->assertEquals($test_category->tasks(), [$test_task, $test_task2]);
        }
        function testDelete()
        {
          //Arrange
          $name = "Work stuff";
          $id = 1;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "File reports";
          $id2 = 2;
          $due = "2016-04-05";
          $test_task = new Task($description, $id2, $due);
          $test_task->save();
          //Act
          $test_category->addTask($test_task);
          $test_category->delete();
          //Assert
          $this->assertEquals([], $test_task->categories());
        }
        function testTasks()
        {
          //Arrange
          $name = "Home stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "wash the dog";
          $due = "2020-03-03";
          $test_task = new Task($description, $id, $due);
          $test_task->save();

          $description2 = "Take out the trash";
          $due = "2020-03-03";
          $test_task2 = new Task($description2, $id, $due);
          $test_task2->save();
          //Act
          $test_category->addTask($test_task);
          $test_category->addTask($test_task2);
          //Assert
          $this->assertEquals($test_category->tasks(), [$test_task, $test_task2]);
        }
    }

?>
