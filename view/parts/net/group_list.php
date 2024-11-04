<?php
/**
 * @var $user
 * @var $title
 * @var $groupMissions
 * @var $groupChat
 */
?>

<h2 class="pb-5"><?=$title?></h2>

<div class="row">

  <?php
  // Get groups
  $groupArray = getAllGroups();
  if (!empty($groupArray)) {
    foreach ($groupArray as $group) {
      $groupTitle = $group->title;
      $groupText = $group->text;

      // missions
      $groupMissionArray = [];
      $MissionIdArray = json_decode($group->mission, true);
      foreach ($MissionIdArray as $id) {
        $groupMissionArray[] = $groupMissions[$id];
      }

      // users
      $userIdArray = json_decode($group->users, true);
      $userCount = count($userIdArray);
      ?>

      <!-- Print info about group -->
      <div class="location_item col-md-6 mb-5 <?php if(in_array($_SESSION['userid'], $userIdArray)) { echo ' group-active'; } ?>">
        <div class="card px-3 py-3 h100">
          <div class="location_info show">
            <h4 class="mb-3"><?= $groupTitle ?></h4>
            <?php if ($groupText != false) { ?>
              <p><?=$groupText?></p>
            <?php } ?>

            <?php if (!empty($groupMissionArray)) { ?>
              <span><b>Цели:</b></span>
              <p>
                <?php foreach ($groupMissionArray as $mission) { ?>
                  <?php echo $mission . ' | '; ?>
                <?php } ?>
              </p>
            <?php } ?>

            <p>Участников: <?=$userCount?></p>

            <a class="btn btn-outline-secondary mt-4 mb-3" href="/?page=group&id=<?=$group->id?>">Подробнее</a>
          </div>
        </div>
      </div>

      <?php
    }
  }
  ?>

</div>