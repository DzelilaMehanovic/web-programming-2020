<?php
Flight::route('GET /students', function(){
  $data = apache_request_headers();
  $user_data = Auth::decode_jwt($data);

/*  if(!isset($user_data['data']['admin'])){
    Flight::halt(403, 'It is allowed only for admin users');
  }*/

//  $students = Flight::db()->query('SELECT * FROM students', PDO::FETCH_ASSOC)->fetchAll();
  $students = Flight::student_service()->get_all_students();
  Flight::json($students);
});


?>
