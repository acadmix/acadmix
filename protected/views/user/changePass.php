<style>
    
    body{
        background: none;
    }
    
</style>

<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td valign="top">
    <div class="cont_right formWrapper">


<h1>Update User <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
    </td>
  </tr>
</table>