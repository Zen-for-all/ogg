<?php
/**
 * @var $groupMissions
 * @var $groupChat
 */
?>

<a class="btn btn-light mb-4" href="/groups"><- К списку групп</a>

<?php
$groupId = $_GET['id'];

// Retrieve group data
$group = new Group($groupId);
$groupTitle = $group->title;
$groupText = $group->text;
$admin = new User($group->admin);
$groupDate = $group->date;

// Fetch users in the group
$userIdArray = json_decode($group->users, true);
$userCount = count($userIdArray);
$groupUsersArray = array_map(fn($id) => new User($id), $userIdArray);

// Fetch missions
$MissionIdArray = json_decode($group->mission, true);
$groupMissionArray = array_map(fn($id) => $groupMissions[$id] ?? null, $MissionIdArray);

// Fetch chats
$chats = json_decode($group->chats, true);
?>

<div class="">
  <h1><?=$groupTitle;?></h1>

  <p>
    <?= implode(' | ', array_filter($groupMissionArray)) ?>
  </p>

  <p>
    <?= $groupText ?: '' ?>
  </p>

  <p><b>Общение:</b></p>
  <p>
    <?php foreach ($chats as $title => $link): ?>
      <?php if ($link): ?>
        <span><?=$title?>: <?=$link?></span> |
      <?php endif; ?>
    <?php endforeach; ?>
  </p>

  <p>Админ: <a href="#<?=$admin->id?>"><?=$admin->login?></a></p>

  <p><b>Участники (<?=$userCount?>):</b></p>
  <p>
    <?php foreach ($groupUsersArray as $user): ?>
      <a href="#<?=$user->id?>"><?=$user->login?></a> |
    <?php endforeach; ?>
  </p>

  <p>
    <?= $groupDate ? 'Дата создания: ' . $groupDate : '' ?>
  </p>
</div>

<?php if (!in_array($_SESSION['userId'], $userIdArray)): ?>
  <!-- Join group button -->
  <div class="delete_ld show mb-5">
    <form action="model/net/join_group.php" method="post">
      <input type="hidden" name="group_id" value="<?=$group->id?>">
      <input type="hidden" name="user_id" value="<?=$_SESSION['userId']?>">
      <input type="submit" value="Присоедениться" class="btn btn-outline-success">
    </form>
  </div>
<?php else: ?>
  <!-- Leave group button -->
  <div class="delete_ld show mb-5">
    <form action="model/net/leave_group.php" method="post">
      <input type="hidden" name="group_id" value="<?=$group->id?>">
      <input type="hidden" name="user_id" value="<?=$_SESSION['userId']?>">
      <input type="submit" value="Покинуть группу" class="btn btn-outline-danger">
    </form>
  </div>
<?php endif; ?>

<?php if ($admin->id === $_SESSION['userId']): ?>
  <div class="edit_ld_form hide mt-5">
    <h2>Редактировать группу:</h2>
    <?php
    $groupValue = $group->id;
    include 'view/parts/net/group_add.php';
    ?>
  </div>

  <!-- Edit and delete buttons for admin -->
  <div class="edit_ld_btn show btn mt-5 mb-3 me-3">
    <span class="show">Редактировать группу</span>
    <span class="hide">Отменить</span>
  </div>

  <a href="/group_delete?group_id=<?=$groupValue?>" class="btn btn-outline-danger mt-5 mb-3">Удалить группу</a>
<?php endif; ?>
