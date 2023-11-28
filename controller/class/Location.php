<?php
class Location
{
  public $id;
  public $title;
  public $text;
  public $user;

  function __construct(int $id)
  {
    $this->id = $id;
    $this->getInfo();
  }

  public function getInfo()
  {
    global $connect;
    $result = mysqli_query($connect, "SELECT * FROM `location` WHERE `id` = {$this->id}");
    $allInfo = mysqli_fetch_assoc($result);
    $this->title = $allInfo['title'];
    $this->text = $allInfo['text'];
    $this->user = $allInfo['user'];
  }
}