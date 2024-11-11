<h3 class="mb-5">Подтвердите, что желаете удалить группу навсегда.</h3>
<div class="d-flex">
  <div class="mb-3 me-3">
    <form action="model/net/delete_group.php" method="post">
      <input type="hidden" name="delete" value="<?=$_GET['group_id']?>">
      <input type="submit" value="Подтверждаю" class="btn btn-outline-secondary">
    </form>
  </div>

  <a class="btn btn-outline-secondary mb-3 " href="javascript:history.back()">Отменить</a>
</div>
