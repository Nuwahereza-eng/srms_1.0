document.querySelectorAll('input').forEach(el => {
el.setAttribute('autocomplete', 'off');
});

var loader = "<div class='d-flex justify-content-center'><div class='spinner-border' style='height:16px; width:16px; margin-top:4px;'  role='status'><span class='sr-only'></span></div>&nbsp;Fetching information, please wait...</div>";

$("#sub_btnp").on("click", function(){
$("#sub_btnp").blur();
var current_pw = document.getElementById('cpass').value;
var new_pw = document.getElementById('npass').value;
var confirm_pw = document.getElementById('cnpass').value;

if (current_pw == "") {


Swal.fire({
title: 'Please enter your current password',
icon: 'warning',
showDenyButton: false,
confirmButtonText: 'Okay',
confirmButtonColor: "#0665d0",
allowOutsideClick: false,
customClass: {
icon: 'swal2-icon-small'
}
})

document.getElementById('cpass').focus();
return false;
}

if (new_pw == "") {

Swal.fire({
title: 'Please enter your new password',
icon: 'warning',
showDenyButton: false,
confirmButtonText: 'Okay',
confirmButtonColor: "#0665d0",
allowOutsideClick: false,
customClass: {
icon: 'swal2-icon-small'
}
})


document.getElementById('npass').focus();
return false;
}

if((new_pw).length < 8)
{

Swal.fire({
title: 'New password should be minimum 8 characters',
icon: 'warning',
showDenyButton: false,
confirmButtonText: 'Okay',
confirmButtonColor: "#0665d0",
allowOutsideClick: false,
customClass: {
icon: 'swal2-icon-small'
}
})

document.getElementById('npass').focus();
return false;
}

if (confirm_pw == "") {

Swal.fire({
title: 'Please enter confirmation password',
icon: 'warning',
showDenyButton: false,
confirmButtonText: 'Okay',
confirmButtonColor: "#0665d0",
allowOutsideClick: false,
customClass: {
icon: 'swal2-icon-small'
}
})

document.getElementById('cnpass').focus();
return false;
}

if((confirm_pw).length < 8)
{

Swal.fire({
title: 'Confirmation password should be minimum 8 characters',
icon: 'warning',
showDenyButton: false,
confirmButtonText: 'Okay',
confirmButtonColor: "#0665d0",
allowOutsideClick: false,
customClass: {
icon: 'swal2-icon-small'
}
})

document.getElementById('cnpass').focus();
return false;
}


if(confirm_pw != new_pw)
{

Swal.fire({
title: 'Password confirmation does not match',
icon: 'warning',
showDenyButton: false,
confirmButtonText: 'Okay',
confirmButtonColor: "#0665d0",
allowOutsideClick: false,
customClass: {
icon: 'swal2-icon-small'
}
})

document.getElementById('cnpass').focus();
return false;
}

})

function drop(url, title) {

Swal.fire({
title: title,
showDenyButton: false,
icon: 'question',
showCancelButton: true,
confirmButtonText: 'Yes',
cancelButtonText: 'No',
confirmButtonColor: "#e04f1a",
cancelButtonColor: "#0665d0",
allowOutsideClick: false,
customClass: {
icon: 'swal2-icon-small'
}
}).then((result) => {
if (result.isConfirmed) {
window.location.assign(url);
} else if (result.isDenied) {

}
});

}

$(".app_frm").on("submit", function(){
$(".app_btn").blur();
var current_effect = 'bounce';
run_waitMe(current_effect);
function run_waitMe(effect){
$('.app_frm').waitMe({

effect: 'bouncePulse',
text: '',

bg: 'rgba(255,255,255,0.6)',

color: '#0665d0',

maxSize: '',

waitTime: -1,
source: '',

textPos: 'vertical',

fontSize: '',
onClose: function() {}

});
}
})



function get_subject(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_subject.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;
}
});

}


function get_ca(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_ca.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;
}
});

}


function get_programme(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_programme.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;
$(".select_2_edit").select2({ dropdownParent: document.querySelector("#modal-edit")})
}
});

}


function get_term(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_term.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;
$(".select_2_edit").select2({ dropdownParent: document.querySelector("#modal-edit")})
}
});

}


function get_teacher(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_teacher.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;
}
});

}



function start_combination(id) {

document.getElementById('sub_lists').innerHTML = '';

var current_effect = 'bounce';
run_waitMe(current_effect);
function run_waitMe(effect){
$('.app_frm').waitMe({

effect: 'bouncePulse',
text: 'Fetching subject information....',

bg: 'rgba(255,255,255,0.4)',

color: '#0665d0',

maxSize: '',

waitTime: -1,
source: '',

textPos: 'vertical',

fontSize: '',
onClose: function() {}

});
}

$.ajax({
type: 'POST',
url: 'getter/get_sub_lists.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('sub_lists').innerHTML = callback_data;
$(".select_teachers").select2({ dropdownParent: document.querySelector("#modal-add")})
$('.app_frm').waitMe('hide');
}
});

}


function get_class(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_class.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;
$(".select_2_edit").select2({ dropdownParent: document.querySelector("#modal-edit")})
}
});

}


function get_announcement(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_announcement.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;

var customButtons = [
['font', ['bold', 'italic', 'underline', 'clear']],
['para', ['ul', 'ol', 'paragraph']],
['view', ['codeview']]
];

$('.editor_2').summernote({
toolbar: customButtons,
tabsize: 2,
height: 200
});

}
});

}


function get_grading_system(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_grading_system.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;
}
});

}


function get_division_system(id) {

document.getElementById('ajax_response').innerHTML = '<div class="alert alert-dismissible alert-info"><strong>'+loader+'</strong></div>';

$.ajax({
type: 'POST',
url: 'getter/get_division_system.php',
data: 'id='+id+'',
success: function (callback_data) {
document.getElementById('ajax_response').innerHTML = callback_data;
}
});

}



function start_import(id) {

document.getElementById('feedback').innerHTML = '';
$('#subject_select').find('option').remove();

var current_effect = 'bounce';
run_waitMe(current_effect);
function run_waitMe(effect){
$('.app_frm').waitMe({

effect: 'bouncePulse',
text: 'Fetching class information....',

bg: 'rgba(255,255,255,0.4)',

color: '#0665d0',

maxSize: '',

waitTime: -1,
source: '',

textPos: 'vertical',

fontSize: '',
onClose: function() {}

});
}


$.ajax({
type: 'POST',
url: 'getter/export_student_sheet.php',
data: 'class='+id+'',
success: function (callback_data) {

let json = callback_data;
let data = JSON.parse(json);

document.getElementById('feedback').innerHTML = data.message;
$('#subject_select').append(data.subs);

$('.app_frm').waitMe('hide');

}
});

}




function start_manage(id) {

$('#student_select').find('option').remove();
$('#subject_select').find('option').remove();

var current_effect = 'bounce';
run_waitMe(current_effect);
function run_waitMe(effect){
$('.app_frm').waitMe({

effect: 'bouncePulse',
text: 'Fetching class information....',

bg: 'rgba(255,255,255,0.4)',

color: '#0665d0',

maxSize: '',

waitTime: -1,
source: '',

textPos: 'vertical',

fontSize: '',
onClose: function() {}

});
}


$.ajax({
type: 'POST',
url: 'getter/manage_student_results.php',
data: 'class='+id+'',
success: function (callback_data) {

let json = callback_data;
let data = JSON.parse(json);

$('#student_select').append(data.students);
$('#subject_select').append(data.subs);

$('.app_frm').waitMe('hide');

}
});

}



function get_ca_info(id) {

$('#ca_select').find('option').remove();

var current_effect = 'bounce';
run_waitMe(current_effect);
function run_waitMe(effect){
$('.app_frm').waitMe({

effect: 'bouncePulse',
text: 'Fetching CA information....',

bg: 'rgba(255,255,255,0.4)',

color: '#0665d0',

maxSize: '',

waitTime: -1,
source: '',

textPos: 'vertical',

fontSize: '',
onClose: function() {}

});
}


$.ajax({
type: 'POST',
url: 'getter/fetch_CA.php',
data: 'term='+id+'',
success: function (callback_data) {
$('#ca_select').append(callback_data);
$('.app_frm').waitMe('hide');
}
});

}




function get_promote_settings(id) {

document.getElementById('promote_feedback').innerHTML = '';

var current_effect = 'bounce';
run_waitMe(current_effect);
function run_waitMe(effect){
$('.app_frm').waitMe({

effect: 'bouncePulse',
text: 'Fetching class information....',

bg: 'rgba(255,255,255,0.4)',

color: '#0665d0',

maxSize: '',

waitTime: -1,
source: '',

textPos: 'vertical',

fontSize: '',
onClose: function() {}

});
}


$.ajax({
type: 'POST',
url: 'getter/promote_form.php',
data: 'class='+id+'',
success: function (callback_data) {

document.getElementById('promote_feedback').innerHTML = callback_data;

$('.app_frm').waitMe('hide');

}
});

}
