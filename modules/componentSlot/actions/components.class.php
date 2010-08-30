<?php
class componentSlotComponents extends BaseaSlotComponents
{
  public function executeEditView()
  {
    // Must be at the start of both view components
    $this->setup();
    
    // Careful, don't clobber a form object provided to us with validation errors
    // from an earlier pass
    if (!isset($this->form))
    {
      $arrayValue = $this->slot->getArrayValue();
      if (isset($arrayValue['params'])) {
        try {
          $arrayValue['params'] = sfYaml::dump($arrayValue['params']);
        } catch (Exception $e) {}
      }
      $this->form = new componentSlotEditForm($this->id, $arrayValue);
    }
  }
  
  public function executeNormalView()
  {
    $this->setup();
    $this->module = null;
    $this->component = null;
    $this->values = $this->slot->getArrayValue();
    if (!isset($this->values['params']) || (isset($this->values['params']) && !is_array($this->values['params']))) {
      $this->values['params'] = array();
    }
    if (isset($this->values['module_component']) && ($moduleComponent = componentSlotEditForm::splitComponent($this->values['module_component']))) {
      $this->module = $moduleComponent['module'];
      $this->component = $moduleComponent['component'];
    }
  }
}
