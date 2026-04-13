<?php
chdir('../');
require_once 'autoload.php';
$an = new announcements_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $an->show($_POST['id']);

?>
<div class="mb-2">
<label class="form-label">Announcement Title</label>
<input type="text" required value="<?php echo $data['title']; ?>" class="form-control txt_cap" name="title" placeholder="Enter announcement title">
</div>
<div class="mb-2">
<label class="form-label">Audience</label>
<select required class="form-control" name="audience">
<option value="" selected disabled>Select Audience</option>
<option <?php echo $data['audience'] == 'Teachers' ? ' selected ' : ''; ?> value="Teachers">Teachers</option>
<option <?php echo $data['audience'] == 'Students' ? ' selected ' : ''; ?> value="Students">Students</option>
<option <?php echo $data['audience'] == 'Both' ? ' selected ' : ''; ?> value="Both">Teachers & Students</option>
</select>
</div>
<div class="mb-3">
<label class="form-label">Announcement</label>
<textarea name="announcement" class="form-control editor_2" placeholder="Enter announcement here" required><?php echo $data['announcement']; ?></textarea>
</div>
<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
<div class="mb-4">
<button type="submit" class="btn btn-primary">Save</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
<?php
}
?>
