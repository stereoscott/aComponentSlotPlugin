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
      $this->form = new componentSlotEditForm($this->id, $this->slot->getArrayValue());
    }
  }
  public function executeNormalView()
  {
    $this->setup();
    $this->values = $this->slot->getArrayValue();
    $this->componentParameters = array();
    if (!empty($this->values['params'])) {
      try {
        $params = sfYaml::load($this->values['params']);
        $this->componentParameters = $params;
      } catch (Exception $e) {}
    }
  }
}
