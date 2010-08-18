<?php    
class componentSlotEditForm extends BaseForm
{
  // Ensures unique IDs throughout the page
  protected $id;
  public function __construct($id, $defaults = array(), $options = array(), $CSRFSecret = null)
  {
    $this->id = $id;
    parent::__construct($defaults, $options, $CSRFSecret);
  }
  public function configure()
  {

    if ($componentSlotModules = sfConfig::get('app_a_component_slot_modules')) {
      $selectOptions = array_combine($componentSlotModules, $componentSlotModules);
      $this->widgetSchema['module'] = new sfWidgetFormSelect(array('choices' => $selectOptions));
      $this->validatorSchema['module'] = new sfValidatorChoice(array('required' => true, 'choices' => $componentSlotModules));
    } else {
      $this->widgetSchema['module'] = new sfWidgetFormInputText();
      $this->validatorSchema['module'] = new sfValidatorString(array('required' => true, 'max_length' => 100));
    }
    
    $this->widgetSchema['component'] = new sfWidgetFormInputText();
    $this->widgetSchema['params'] = new sfWidgetFormInputText();
    
    $this->validatorSchema['component'] = new sfValidatorString(array('required' => true, 'max_length' => 100));
    $this->validatorSchema['params'] = new sfValidatorCallback(array('required' => false, 'callback' => array($this, 'validateYaml')));

    $this->widgetSchema->setLabel('params', 'Parameters');
    $this->widgetSchema->setHelp('params', 'In YAML format');
        
    // Ensures unique IDs throughout the page. Hyphen between slot and form to please our CSS
    $this->widgetSchema->setNameFormat('slot-form-' . $this->id . '[%s]');
    
    // You don't have to use our form formatter, but it makes things nice
    $this->widgetSchema->setFormFormatterName('aAdmin');
  }
  
  public function validateYaml($validator, $value, $args)
  {
    try {
      sfYaml::load($value);
    } catch (Exception $e) {
      throw new sfValidatorError($validator, $e->getMessage());
    }
    
    return $value;
  }
}
