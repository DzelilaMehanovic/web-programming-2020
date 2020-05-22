<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS, PATCH');

require_once '../vendor/autoload.php';

require_once 'config/config.php';
require_once 'utils/Auth.php';
require_once 'dao/BaseDao.php';
require_once 'dao/StudentDao.php';
require_once 'service/StudentService.php';
require_once 'routes/students.php';

Flight::register('student_service', 'StudentService');
Flight::register('student_dao', 'StudentDao');
//Flight::register('db', 'PDO', array('mysql:host=remotemysql.com;dbname=tEYQ0vL2Rn','tEYQ0vL2Rn','Xwqg1jEEB0'));

/*Flight::route('GET /students', function(){
  $data = apache_request_headers();
  $user_data = Auth::decode_jwt($data);

/*  if(!isset($user_data['data']['admin'])){
    Flight::halt(403, 'It is allowed only for admin users');
  }*/

//  $students = Flight::db()->query('SELECT * FROM students', PDO::FETCH_ASSOC)->fetchAll();
/*  $students = Flight::student_dao()->get_all();
  Flight::json($students);
});*/

Flight::route('GET /student', function(){
  $id = Flight::request()->query['id'];
/*  $stmt = Flight::db()->prepare("SELECT * FROM students WHERE id = :id");
  $stmt->execute([':id' => $id]);
  $student = $stmt->fetch();*/
  $student = Flight::student_dao()->get_by_id($id);
  Flight::json($student);
});

Flight::route('POST /students', function(){
  $request = Flight::request()->data->getData();
  /*unset($request['psword']);
  $insert = 'INSERT INTO students (name, surname, phone_number, email) VALUES (:fname, :lname, :custom_email, :phone)';
  $stmt = Flight::db()->prepare($insert);
  $stmt->execute($request);*/
  $request['name'] = $request['fname'];
  $request['surname'] = $request['lname'];
  $request['email'] = $request['custom_email'];
  $request['phone_number'] = $request['phone'];
  unset($request['fname'], $request['lname'], $request['custom_email'], $request['phone'], $request['psword']);
  Flight::student_dao()->add($request);
  Flight::json('Student has been added');
});

Flight::route('POST /student', function(){
  $request = Flight::request()->data->getData();
/*  unset($request['psword']);
  $update = "UPDATE students SET name = :fname, surname = :lname, phone_number = :phone, email = :custom_email WHERE id = :id";
  $stmt = Flight::db()->prepare($update);
  $stmt->execute($request);*/
  $id = 23;
  $request['name'] = $request['fname'];
  $request['surname'] = $request['lname'];
  $request['email'] = $request['custom_email'];
  $request['phone_number'] = $request['phone'];
  unset($request['fname'], $request['lname'], $request['custom_email'], $request['phone'], $request['psword'], $request['id']);
  Flight::student_dao()->update_student($request, $id);
  Flight::json('Updated');
});

Flight::route('DELETE /student/@id', function($id){
  /*$delete = 'DELETE FROM students WHERE id = :id';
  $stmt = Flight::db()->prepare($delete);
  $stmt->execute([':id' => $id]);*/

  Flight::student_dao()->delete_student($id);
});

Flight::route('POST /student/delete', function(){
    $request = Flight::request()->data->getData();
    Flight::student_dao()->remove_student($request['id']);
    Flight::json('Student Status Updated');
});

Flight::route('POST /login', function(){
  $user = Flight::request()->data->getData();
  $db_user = Flight::student_dao()->get_user_by_email($user['user_email']);

  if($db_user){
    if($db_user['password'] == $user['psword']){
      $token_data = [
        'id' => $db_user['id'],
        'email' => $db_user['email'],
        'name' => $db_user['name'],
        'is_admin' => false
      ];

      $jwt = Auth::encode_jwt($token_data);
      Flight::json(['user_token' => $jwt]);
    } else {
      Flight::halt(404, 'Password is not correct');
    }
  } else {
    Flight::halt(404, 'User not found');
  }
});


Flight::start();
?>
