<?php
/**
 * @var $missionList
 * @var $groupChat
 */
?>

<a class="btn btn-light mb-4" href="/groups"><- К списку групп</a>

<?php
$groupId = $_GET['id'];

// Retrieve group data
$group = new Group($groupId);
$groupAvatar = $group->avatar;
$groupTitle = $group->title;
$groupText = $group->text;
$admin = new User($group->admin);
$groupDate = $group->date;

// Fetch users in the group
$userIdArray = json_decode($group->users, true);
$userCount = count($userIdArray);
$groupUsersArray = array_map(fn($id) => new User($id), $userIdArray);

// Fetch missions
$missionIdArray = json_decode($group->mission, true);
$groupMissionArray = array_map(fn($id) => $missionList[$id] ?? null, $missionIdArray);

// Fetch chats
$chats = json_decode($group->chats, true);

// Get city name
$groupCity = $group->city;
?>

<div class="groupContent">
  <div class="row flex-row-reverse">
    <div class="col-md-4 col-12 mb-3">
      <div class="avatar">
        <?php if (!empty($groupAvatar)): ?>
          <img src="<?= $groupAvatar ?>" alt="ava">
        <?php endif; ?>
      </div>
    </div>

    <div class="col-md-8 col-12">
      <h1><?=$groupTitle;?></h1>

      <?php if (!empty($groupMissionArray)) : ?>
        <div class="groupMission mb-3"><?= implode(' | ', array_filter($groupMissionArray)) ?></div>
      <?php endif; ?>

      <?php if (!empty($groupCity)) : ?>
        <div class="groupCity mb-5">Город: <?= $groupCity ?></div>
      <?php endif; ?>

      <?php if (!empty($groupText)) : ?>
        <div class="groupDescription mb-5">
          <?= $groupText ?: '' ?>
        </div>
      <?php endif; ?>

      <?php if (array_filter($chats)): ?>
        <div class="groupChats mb-5">
          <p><b>Общение:</b></p>
          <p>
            <?php foreach ($chats as $title => $link): ?>
              <?php if ($link): ?>
                <span><?=$title?>: <?=$link?></span> |
              <?php endif; ?>
            <?php endforeach; ?>
          </p>
        </div>
      <?php endif; ?>

      <div class="groupAdmin mb-5">Админ: <a href="/?page=profile&id=<?=$admin->id?>"><?=$admin->login?></a></div>

      <div class="groupUsers mb-5">
        <p><b>Участники (<?=$userCount?>):</b></p>
        <p>
          <?php foreach ($groupUsersArray as $user): ?>
            <a href="/?user=<?=$user->id?>"><?= $user->login ?></a> |
          <?php endforeach; ?>
        </p>
      </div>

      <div class="groupDate"><?= $groupDate ? 'Дата создания: ' . $groupDate : '' ?></div>
    </div>
  </div>
</div>

<?php if (!in_array($_SESSION['userId'], $userIdArray)): ?>
  <!-- Join group button -->
  <div class="delete_ld show mb-5">
    <form action="model/net/join_group.php" method="post">
      <input type="hidden" name="group_id" value="<?=$group->id?>">
      <input type="submit" value="Присоедениться" class="btn btn-outline-success">
    </form>
  </div>
<?php else: ?>
  <!-- If NOT admin -->
  <?php if ($admin->id !== $_SESSION['userId']): ?>
    <!-- Leave group button -->
    <div class="delete_ld show mb-5">
      <form action="model/net/leave_group.php" method="post">
        <input type="hidden" name="group_id" value="<?=$group->id?>">
        <input type="submit" value="Покинуть группу" class="btn btn-outline-danger">
      </form>
    </div>
  <?php endif; ?>
<?php endif; ?>

<!-- If admin -->
<?php if ($admin->id === $_SESSION['userId']): ?>
  <div class="edit_ld_form hide mt-5">
    <h2>Редактировать группу:</h2>
    <?php
    $groupValue = $group->id;
    include 'view/parts/net/group_add.php';
    ?>
  </div>

  <!-- Edit button for admin -->
  <div class="edit_ld_btn show btn mt-5 mb-3 me-3">
    <span class="show">Редактировать группу</span>
    <span class="hide">Отменить</span>
  </div>

  <!-- Delete button for admin -->
  <?php $_SESSION['group_id'] = $group->id; ?>
  <a href="/group_delete" class="btn btn-outline-danger mt-5 mb-3">Удалить группу</a>
<?php endif; ?>
