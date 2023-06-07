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
  public $anonym;
  public $achieves;

  function __construct(int $id)
  {
    $this->id = $id;
    $this->getInfo();
  }

  public function getInfo()
  {
    global $connect;
    $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = {$this->id}");
    $mainInfo = mysqli_fetch_assoc($result);
    $this->login = $mainInfo['login'];
    $this->password = $mainInfo['password'];
    $this->email = $mainInfo['email'];
    $this->date = $mainInfo['date'];
    $this->ldlist = $mainInfo['ldlist'];
    $this->ldlocations = $mainInfo['ldlocations'];
    $this->anonym = $mainInfo['anonym'];
    $this->achieves = $mainInfo['achieves'];
  }
}