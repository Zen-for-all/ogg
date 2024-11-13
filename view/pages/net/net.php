<?php
/**
 * @var $user
 */

//
if ($user->ldlist) {
  $ldArrayObjects = getLd($user->ldlist);
  $quantityLd = count($ldArrayObjects);
}

$login = $user->login;
$avatar = $user->avatar;
$gender = $user->gender;
$age = $user->age;
$city = $user->city;
$experience = $user->experience;
$ldcount = $user->ldcount;
$description = $user->description;
$mission = $user->mission;
$ideology = $user->ideology;
$contact = $user->contact;

?>

<section class="container">
  <div class="row mb-5">
    <h1><?= $login ?></h1>
  </div>

  <div class="row">
    <div class="col-md-4 col-12">
      <div class="avatar">
        <img src="<?= $avatar ?>" alt="ava <?= $login ?>">
      </div>
    </div>

    <div class="col-md-8 col-12">
      <div class="">
        <p>Всего ОСов: <b><?= $quantityLd ?? 0 ?></b></p>
      </div>

      <div class="">
        <p>Пол: <?= $gender ?></p>
      </div>

      <div class="">
        <p>Возраст: <?= $age ?></p>
      </div>

      <div class="">
        <p>Город: <?= $city ?></p>
      </div>

      <div class="">
        <p>Опыт: <?= $experience ?></p>
      </div>

      <div class="">
        <p>Приблизительное количество ОСов: <?= $ldcount ?></p>
      </div>

      <div class="">
        <p>О себе:</p>
        <div class=""><?= $description ?></div>
      </div>

      <div class="">
        <p>Цель аккаунта: <?= $mission ?></p>
      </div>

      <div class="">
        <p>Взгляд на ОСы: <?= $ideology ?></p>
      </div>

      <div class="">
        <p>Контакты:</p>
        <div class="">
          <?= $contact ?>
        </div>
      </div>
    </div>
  </div>
</section>
