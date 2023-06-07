<?php
class Ld
{
  public $id;
  public $date;
  public $time;
  public $duration;
  public $location;
  public $quality;
  public $interest;
  public $method;
  public $text;
  public $notice;
  public $user;

  function __construct(int $id)
  {
    $this->id = $id;
    $this->getInfo();
  }

  public function getInfo()
  {
    global $connect;
    $result = mysqli_query($connect, "SELECT * FROM `ld` WHERE `id` = {$this->id}");
    $allInfo = mysqli_fetch_assoc($result);
    $this->date = $allInfo['date'];
    $this->time = $allInfo['time'];
    $this->duration = $allInfo['duration'];
    $this->location = $allInfo['location'];
    $this->quality = $allInfo['quality'];
    $this->interest = $allInfo['interest'];
    $this->method = $allInfo['method'];
    $this->text = $allInfo['text'];
    $this->notice = $allInfo['notice'];
    $this->user = $allInfo['user'];
  }
}