<?php
$this->breadcrumbs=array(
	'Student Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StudentCategories', 'url'=>array('index')),
	array('label'=>'Manage StudentCategories', 'url'=>array('admin')),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
    <?php $this->renderPartial('/default/left_side');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
<h1>Create StudentCategories</h1><br />

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
 	</div>
    </td>
  </tr>
</table>