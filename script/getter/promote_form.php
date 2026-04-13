<?php
chdir('../');
require_once 'autoload.php';
$classes = new classes_controller;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$data = $classes->show($_POST['class']);

if ($data['award_method'] == 'AVERAGE') {

?>
<div class="row">
<label class="col-sm-12 col-form-label"></label>
<div class="col-sm-12">
<div class="form-check form-switch">
<input class="form-check-input" type="checkbox" name="promote_all" id="check_all" ochange="update_promotion_form();">
<label class="form-check-label">PROMOTE ALL STUDENTS WITHOUT CRITERIA</label>
</div>
</div>
</div>

<div class="row">
<label class="col-sm-12 col-form-label">Average</label>
<div class="col-sm-12">
<input id="average" type="text" class="form-control score-range" name="required_score">
</div>
</div>

<div class="row">
<label class="col-sm-12 col-form-label">Promote Criteria</label>
<div class="col-sm-12">
<select id="criteria" style="width:100%;" class="form-control" name="criteria" required>
<option value="" selected disabled></option>
<option value="LESS THAN">LESS THAN</option>
<option value="GREATOR THAN">GREATOR THAN</option>
</select>
</div>
</div>

<?php

}else{

?>
<div class="row">
<label class="col-sm-12 col-form-label"></label>
<div class="col-sm-12">
<div class="form-check form-switch">
<input class="form-check-input" type="checkbox" name="promote_all" id="check_all" ochange="update_promotion_form();">
<label class="form-check-label">PROMOTE ALL STUDENTS WITHOUT CRITERIA</label>
</div>
</div>
</div>

<div class="row">
<label class="col-sm-12 col-form-label">Points</label>
<div class="col-sm-12">
<input type="text" id="points" class="form-control score-range" name="required_score">
</div>
</div>

<div class="row">
<label class="col-sm-12 col-form-label">Promote Criteria</label>
<div class="col-sm-12">
<select style="width:100%;" id="criteria" class="form-control" name="criteria" required>
<option value="" selected disabled></option>
<option value="LESS THAN">LESS THAN</option>
<option value="GREATOR THAN">GREATOR THAN</option>
</select>
</div>
</div>

<?php
}
?>



<?php
}
?>
