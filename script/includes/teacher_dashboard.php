<div class="row items-push">

<div class="col-sm-6 col-xl-4" >
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-book text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->my_subjects($profile['id'])[0]['total']); ?></div>
<div class="text-muted mb-3">Subjects I'm Teaching</div>
</div>
</div>
</div>

<div class="col-sm-6 col-xl-4">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-building text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->my_classes($profile['id'])[0]['total']); ?></div>
<div class="text-muted mb-3">Classes I'm Teaching</div>
</div>
</div>
</div>

<div class="col-sm-6 col-xl-4">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-user-graduate text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->my_students($profile['id'])[0]['total']); ?></div>
<div class="text-muted mb-3">Students I'm Teaching</div>
</div>
</div>
</div>



</div>
