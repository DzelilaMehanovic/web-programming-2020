<?php
/**
 *
 */
class StudentService{

  private $student_dao;

  public function __construct(){
    $this->student_dao = new StudentDao();
  }

  public function get_all_students(){
    $students = $this->student_dao->get_all();

    foreach ($students as $idx => $student) {
      $students[$idx]['delete_student'] = '<a onclick="delete_student('.$student['id'].')"> Delete </a>';
    }

    return $students;
  }
}



 ?>
