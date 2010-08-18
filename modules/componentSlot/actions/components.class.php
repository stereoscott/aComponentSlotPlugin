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
    $this->values = $this->slot->getArrayValue();
    $this->componentParameters = array();
  }
}
