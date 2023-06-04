<?php


abstract class User
{
  private $id;
  private $name;

  function __construct(int $id)
  {
    $this->id = $id;
  }
}