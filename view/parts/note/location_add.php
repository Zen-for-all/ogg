<?php
/**
 * @var bool|string $locationValue The ID of the location if editing an existing one, or false if adding a new location.
 * @var string $locationTitle The title of the location, used for pre-filling the title input field when editing.
 * @var string $locationText The description of the location, used for pre-filling the textarea when editing.
 */

// Determine the action URL based on the presence of $locationValue
$formAction = $locationValue ? 'model/note/edit_location.php' : 'model/note/add_location.php';
$formInput = $locationValue ? '<input type="hidden" name="id" value="' . $locationValue . '">' : '';

echo '<form action="' . $formAction . '" method="post">';
echo $formInput;
?>

<p>Заголовок</p>
<input type="text" class="form-control mb-4" name="title" value="<?= $locationTitle ?: '' ?>">

<p>Описание</p>
<textarea class="form-control mb-4" name="text"><?= $locationText ?: '' ?></textarea>

<input class="btn btn-outline-success me-3 mb-4" type="submit">

<?php unset($locationTitle, $locationText); ?>
</form>
