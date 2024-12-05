<?php
class News
{
  public $id;
  public $title;
  public $text;
  public $date;
  public $admin;
  public $groupid;
  public $eventid;

  function __construct(int $id) {
    $this->id = $id;
    $this->loadInfo();
  }

  private function loadInfo() {
    global $connect;
    $query = "SELECT `title`, `text`, `date`, `admin`, `groupid`, `eventid` 
                  FROM `news` 
                  WHERE `id` = {$this->id}";
    $result = mysqli_query($connect, $query);

    if ($result && $info = mysqli_fetch_assoc($result)) {
      foreach ($info as $key => $value) {
        $this->{$key} = $value;
      }
    }
  }
}
