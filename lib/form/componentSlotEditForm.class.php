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
    // ADD YOUR FIELDS HERE
    
    // A simple example: a slot with a single 'text' field with a maximum length of 100 characters
    $this->setWidgets(array(
      'module' => new sfWidgetFormInputText(),
      'component' => new sfWidgetFormInputText(),
      'params' => new sfWidgetFormTextarea(),
    ));
    
    $this->setValidators(array(
      'module' => new sfValidatorString(array('required' => true, 'max_length' => 100)),
      'component' => new sfValidatorString(array('required' => true, 'max_length' => 100)),
      'params' => new sfValidatorCallback(array('required' => false, 'callback' => array($this, 'validateYaml'))),
    ));
    
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
