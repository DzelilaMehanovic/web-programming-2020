<?php
require_once 'BaseDao.php';

class StudentDao extends BaseDao{

  public $table = 'students';

  public function __construct(){
    parent::__construct($this->table);
  }

  public function update_student($student, $student_id){
    $entity[':id'] = $student_id;
    $query= 'UPDATE '.  $this->table . ' SET ';
    foreach ($student as $key => $value) {
      $query .= $key . '=:' . $key . ', ';
      $entity[':' . $key] = $value;
    }
    $query = rtrim($query,', ') . ' WHERE id=:id';
    return $this->update($entity, $query);
  }

  public function delete_student($student_id){
    $entity[':id'] = $student_id;
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    return $this->execute($entity, $query);
  }

  public function remove_student($student_id){
    $this->execute([':student_id' => $student_id], 'UPDATE ' . $this->table . ' SET status = 0 WHERE id = :student_id');
  }

  public function get_user_by_email($user_email){
    return $this->execute_query("SELECT * FROM " . $this->table . " WHERE email = :email", [":email" => $user_email])[0];
  }

}

 ?>
