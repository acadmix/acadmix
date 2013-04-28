<?php
$this->breadcrumbs=array(
	'Divisions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Divisions', 'url'=>array('index')),
	array('label'=>'Create Divisions', 'url'=>array('create')),
	array('label'=>'Update Divisions', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Divisions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Divisions', 'url'=>array('admin')),
);
?>

<h1>View Divisions #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'course_id',
		'start_date',
		'end_date',
		'is_active',
		'is_deleted',
		'employee_id',
	),
)); ?>
