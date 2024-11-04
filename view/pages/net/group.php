<?php
/**
 * @var $groupMissions
 * @var $groupChat
 */
?>

<a class="btn btn-light mb-4" href="/?page=groups"><- К списку групп</a>

<?php
$groupValue = $_GET['id'];

// get all info about group
$group = new Group($_GET['id']);

$groupTitle = $group->title;
$groupText = $group->text;
$admin = new User($group->admin);
$groupDate = $group->date;

// add Users
$groupUsersArray = [];
$userIdArray = json_decode($group->users, true);
$userCount = count($userIdArray);
foreach ($userIdArray as $id) {
  $groupUsersArray[] = new User($id);
}

// add Missions
$groupMissionArray = [];
$MissionIdArray = json_decode($group->mission, true);
foreach ($MissionIdArray as $id) {
  $groupMissionArray[] = $groupMissions[$id];
}

// add Chats
$groupChatArray = [];
$chats = json_decode($group->chats, true);
?>

<div class="">
  <h1><?=$groupTitle;?></h1>

  <p>
  <?php foreach ($groupMissionArray as $mission) { ?>
    <?php echo $mission . ' | '; ?>
  <?php } ?>
  </p>

  <p>
  <?php if ($groupText != false) {
    echo $groupText;
  } ?>
  </p>

  <p><b>Общение:</b></p>
  <p>
  <?php
  foreach ($chats as $title => $link) {
    if ($link != false) {
    ?>
      <span><?=$title?>: <?=$link?></span> |
    <?php
    }
  }
  ?>
  </p>

  <p>Админ: <a href="#<?=$admin->id?>"><?=$admin->login?></a></p>

  <p><b>Участники (<?=$userCount?>):</b></p>
  <p>
    <?php foreach ($groupUsersArray as $user) { ?>
      <a href="#<?=$user->id?>"><?=$user->login?></a> |
    <?php } ?>
  </p>

  <p>
  <?php if ($groupDate != false) {
    echo 'Дата создания: ' . $groupDate;
  } ?>
  </p>
</div>

<?php if(!(in_array($_SESSION['userid'], $userIdArray))) { ?>
  <!-- button to join the group -->
  <div class="delete_ld show mb-5">
    <form action="model/net/join_group.php" method="post">
      <input type="hidden" name="group_id" value="<?=$group->id?>">
      <input type="hidden" name="user_id" value="<?=$_SESSION['userid']?>">
      <input type="submit" value="Присоедениться" class="btn btn-outline-success">
    </form>
  </div>
<?php } else { ?>
  <!-- button to leave the group -->
  <div class="delete_ld show mb-5">
    <form action="model/net/leave_group.php" method="post">
      <input type="hidden" name="group_id" value="<?=$group->id?>">
      <input type="hidden" name="user_id" value="<?=$_SESSION['userid']?>">
      <input type="submit" value="Покинуть группу" class="btn btn-outline-danger">
    </form>
  </div>
<?php } ?>

<?php if($admin->id === $_SESSION['userid']) { ?>
  <div class="edit_ld_form hide mt-5">
    <h2>Редактировать группу:</h2>
    <?php include 'view/parts/net/group_add.php'; ?>
  </div>

  <!-- button for edit ld -->
  <div class="edit_ld_btn show btn mt-5 mb-3">
    <span class="show">Редактировать группу</span>
    <span class="hide">Отменить</span>
  </div>

  <!-- button for delete ld -->
  <div class="delete_ld show mb-5">
    <form action="model/net/delete_group.php" method="post">
      <input type="hidden" name="delete" value="<?=$group->id?>">
      <input type="submit" value="Удалить группу" class="btn btn-outline-danger">
    </form>
  </div>
<?php } ?>