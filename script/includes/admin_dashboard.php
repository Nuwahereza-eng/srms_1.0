<div class="row items-push">

<div class="col-sm-6 col-xl-3">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-book-open-reader text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->programmes()[0]['total_programmes']); ?></div>
<div class="text-muted mb-3">Academic Programmes</div>
</div>
</div>
</div>

<div class="col-sm-6 col-xl-3">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-book text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->subjects()[0]['total_subjects']); ?></div>
<div class="text-muted mb-3">Registered Subjects</div>
</div>
</div>
</div>

<div class="col-sm-6 col-xl-3">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-building text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->classes()[0]['total_classes']); ?></div>
<div class="text-muted mb-3">Registered Classes</div>
</div>
</div>
</div>

<div class="col-sm-6 col-xl-3">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-user-graduate text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->students()[0]['total_students']); ?></div>
<div class="text-muted mb-3">Registered Students</div>
</div>
</div>
</div>


<div class="col-sm-6 col-xl-3">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-chalkboard-user text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->teachers()[0]['total_teachers']); ?></div>
<div class="text-muted mb-3">Registered Teachers</div>
</div>
</div>
</div>

<div class="col-sm-6 col-xl-3">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-bars-progress text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->ca()[0]['total_ca']); ?></div>
<div class="text-muted mb-3">Continuous Assessments</div>
</div>
</div>
</div>

<div class="col-sm-6 col-xl-3">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-arrow-down-a-z text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->gs()[0]['total_gs']); ?></div>
<div class="text-muted mb-3">Grading Systems</div>
</div>
</div>
</div>

<div class="col-sm-6 col-xl-3">
<div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
<div class="block-content block-content-full flex-grow-1">
<div class="item item-circle bg-body-light mx-auto">
<i class="fa fa-2x fa-arrow-down-1-9 text-primary"></i>
</div>
<div class="fs-3 fw-bold"><?php echo number_format($dashboard->ds()[0]['total_ds']); ?></div>
<div class="text-muted mb-3">Division Systems</div>
</div>
</div>
</div>

</div>
