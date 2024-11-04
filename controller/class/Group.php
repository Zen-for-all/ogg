<?php
class Group
{
  public $id;
  public $title;
  public $text;
  public $mission;
  public $admin;
  public $users;
  public $chats;
  public $date;
  public $private;

  function __construct(int $id) {
    $this->id = $id;
    $this->getInfo();
  }

  public function getInfo() {
    global $connect;
    $result = mysqli_query($connect, "SELECT * FROM `groups` WHERE `id` = {$this->id}");
    $allInfo = mysqli_fetch_assoc($result);
    $this->title = $allInfo['title'];
    $this->text = $allInfo['text'];
    $this->mission = $allInfo['mission'];
    $this->admin = $allInfo['admin'];
    $this->users = $allInfo['users'];
    $this->chats = $allInfo['chats'];
    $this->date = $allInfo['date'];
    $this->private = $allInfo['private'];
  }
}