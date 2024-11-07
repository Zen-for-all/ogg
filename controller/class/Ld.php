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
  public $hashtags;
  public $public_text;
  public $publish;
  public $notice;
  public $user;

  function __construct(int $id)
  {
    $this->id = $id;
    $this->loadInfo();
  }

  private function loadInfo()
  {
    global $connect;
    $query = "SELECT `date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, 
                         `text`, `hashtags`, `public_text`, `publish`, `notice`, `user`
                  FROM `ld` 
                  WHERE `id` = {$this->id}";
    $result = mysqli_query($connect, $query);

    if ($result && $info = mysqli_fetch_assoc($result)) {
      foreach ($info as $key => $value) {
        $this->{$key} = $value;
      }
    }
  }
}
