<?php
class Group
{
  public $id;
  public $avatar;
  public $title;
  public $text;
  public $mission;
  public $admin;
  public $users;
  public $chats;
  public $city;
  public $date;
  public $private;

  function __construct(int $id) {
    $this->id = $id;
    $this->loadInfo();
  }

  private function loadInfo() {
    global $connect;
    $query = "SELECT `avatar`, `title`, `text`, `mission`, `admin`, `users`, `chats`, `city`, `date`, `private` 
                  FROM `groups` 
                  WHERE `id` = {$this->id}";
    $result = mysqli_query($connect, $query);

    if ($result && $info = mysqli_fetch_assoc($result)) {
      foreach ($info as $key => $value) {
        $this->{$key} = $value;
      }
    }
  }
}
