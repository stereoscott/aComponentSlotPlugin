<?php include_partial('a/simpleEditButton', array('slot' => $slot, 'name' => $name, 'pageid' => $pageid, 'permid' => $permid)) ?>
<?php if ($module):     
?>
  <?php include_component($module, $component, $values['params']) ?>
<?php endif ?>
