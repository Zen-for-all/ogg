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

  public $name;
  public $avatar;
  public $gender;
  public $birth_year;
  public $city;
  public $experience;
  public $ldcount;
  public $description;
  public $mission;
  public $ideology;
  public $contact;

  function __construct(int $id)
  {
    $this->id = $id;
    $this->loadInfo();
  }

  private function loadInfo()
  {
    global $connect;
    $query = "SELECT `login`, `password`, `email`, `date`, `ldlist`, `ldlocations`, `grouplist`, `anonym`, `name`, `avatar`, `gender`, `birth_year`, `city`, `experience`, `ldcount`, `description`, `mission`, `ideology`, `contact`
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