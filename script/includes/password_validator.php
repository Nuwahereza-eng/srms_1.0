<?php
if ($profile['password_updated'] == 'Yes') {
if (new DateTime() > new DateTime($profile['password_expiration'])) {
header("location:akaunti");
}
}else{
header("location:akaunti");
}
?>
