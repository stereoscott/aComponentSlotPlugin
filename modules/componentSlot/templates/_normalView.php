<?php include_partial('a/simpleEditButton', array('name' => $name, 'pageid' => $pageid, 'permid' => $permid)) ?>
<?php if (isset($values['module']) && $values['component']):     
?>
  <?php include_component($values['module'], $values['component'], $componentParameters) ?>
<?php endif ?>
