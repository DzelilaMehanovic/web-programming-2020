<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS, PATCH');

require '../vendor/autoload.php';

Flight::register('db', 'PDO', array('mysql:host=remotemysql.com;dbname=tEYQ0vL2Rn','tEYQ0vL2Rn','Xwqg1jEEB0'));

Flight::route('GET /students', function(){
  $students = Flight::db()->query('SELECT * FROM students', PDO::FETCH_ASSOC)->fetchAll();
  Flight::json($students);
});

Flight::route('POST /students', function(){
  $request = Flight::request()->data->getData();
  unset($request['psword']);
  $insert = 'INSERT INTO students (name, surname, phone_number, email) VALUES (:fname, :lname, :custom_email, :phone)';
  $stmt = Flight::db()->prepare($insert);
  $stmt->execute($request);
  Flight::json('Student has been added');
});

Flight::route('DELETE /student/@id', function($id){
  $delete = 'DELETE FROM students WHERE id = :id';
  $stmt = Flight::db()->prepare($delete);
  $stmt->execute([':id' => $id]);
});

Flight::route('GET /student', function(){
  $id = Flight::request()->query['id'];
  $stmt = Flight::db()->prepare("SELECT * FROM students WHERE id = :id");
  $stmt->execute([':id' => $id]);
  $student = $stmt->fetch();
  Flight::json($student);
});

Flight::start();
?>
