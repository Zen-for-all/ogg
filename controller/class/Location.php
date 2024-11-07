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
    $this->loadInfo();
  }

  private function loadInfo()
  {
    global $connect;
    $query = "SELECT `title`, `text`, `user` FROM `location` WHERE `id` = {$this->id}";
    $result = mysqli_query($connect, $query);

    if ($result && $info = mysqli_fetch_assoc($result)) {
      foreach ($info as $key => $value) {
        $this->{$key} = $value;
      }
    }
  }
}
