<?php
class session {

public function is_logged() {
if (isset($_SESSION['logged_account'])) {
return true;
}else{
return false;
}
}

public function create_session($account) {
$_SESSION['logged_account'] = $account;
return true;
}

public function destroy_session() {
unset($_SESSION['logged_in']);
unset($_SESSION['logged_account']);
return true;
}


}
?>
