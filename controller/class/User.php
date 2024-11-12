<?php
class User
{
  public $id;
  public $login;
  public $password;
  public $email;
  public $date;
  public $ldlist;
  public $ldlocations;
  public $grouplist;
  public $anonym;

  function __construct(int $id)
  {
    $this->id = $id;
    $this->loadInfo();
  }

  private function loadInfo()
  {
    global $connect;
    $query = "SELECT `login`, `password`, `email`, `date`, `ldlist`, `ldlocations`, 
                         `grouplist`, `anonym`
                  FROM `user` 
                  WHERE `id` = {$this->id}";
    $result = mysqli_query($connect, $query);

    if ($result && $info = mysqli_fetch_assoc($result)) {
      foreach ($info as $key => $value) {
        $this->{$key} = $value;
      }
    }
  }
}
