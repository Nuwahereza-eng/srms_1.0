<?php
if (isset($_SESSION['alert'])) {

$alert_type = $_SESSION['alert'][0][0];
$alert_msg = $_SESSION['alert'][0][1];
?>

<script>


Swal.fire({
title: '<?php echo $alert_msg; ?>',
icon: '<?php echo $alert_type; ?>',
confirmButtonText: 'Okay',
confirmButtonColor: "#0665d0",
allowOutsideClick: false,
customClass: {
icon: 'swal2-icon-small'
}
})
</script>
<?php
unset($_SESSION['alert']);
}
?>
