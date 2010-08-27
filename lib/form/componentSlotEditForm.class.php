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
      $selectOptions = array('' => '');
      foreach ($componentSlotModules as $option) {
        $selectOptions[$option['component']] = $option['label'];
      }
      $validOptions = array_keys($selectOptions);
      $this->widgetSchema['module_component'] = new sfWidgetFormSelect(array('choices' => $selectOptions));
      $this->validatorSchema['module_component'] = new sfValidatorChoice(array('required' => true, 'choices' => $validOptions));
    } else {
      $this->widgetSchema['module_component'] = new sfWidgetFormInputText();
      $this->validatorSchema['module_component'] = new sfValidatorString(array('required' => true, 'max_length' => 100));
    }    
    
    $this->widgetSchema->setLabel('module_component', 'Module');    
    
    $this->widgetSchema['params'] = new sfWidgetFormTextarea();
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
      $data = sfYaml::load($value);
    } catch (Exception $e) {
      throw new sfValidatorError($validator, $e->getMessage());
    }
    
    return $data;
  }
  
  public static function splitComponent($value = null)
  {
    $arr = explode('/', $value, 2);
    if (isset($arr[0]) && isset($arr[1])) {
      return array(
        'module' => $arr[0],
        'component' => $arr[1]
      );
    } else {
      return false;
    }
  }
}
