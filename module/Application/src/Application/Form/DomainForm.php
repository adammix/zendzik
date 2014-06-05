<?php
    // filename : module/Users/src/Users/Form/RegisterForm.php
namespace Application\Form;

use Zend\Form\Element; 
use Zend\Form\Form; 
	
class DomainForm extends Form
{
	public function __construct($name = null) 
    { 
        parent::__construct(''); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'wpisz nazwę domeny...', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Nazwa domeny', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'url', 
            'type' => 'Zend\Form\Element\Url', 
            'attributes' => array( 
                'placeholder' => 'http://www.najlepsza-focia.com', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Adres url domeny', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'is_active', 
            'type' => 'Zend\Form\Element\MultiCheckbox', 
            'attributes' => array( 
                'required' => 'required', 
                'value' => '0', 
            ), 
            'options' => array( 
                'value_options' => array(
                    '0' => 'Aktywna', 
                ),
            ), 
        ));       
    } 
}