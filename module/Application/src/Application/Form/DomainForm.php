<?php
    // filename : module/Users/src/Users/Form/RegisterForm.php
namespace Application\Form;

use Zend\Form\Element; 
use Zend\Form\Form; 
	
class DomainForm extends Form
{
	public function __construct($name = null) 
    { 
        parent::__construct('AddDomain'); 
        
        $this->setAttribute('method', 'post'); 
        
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
		
        $this->add(array( 
            'name' => 'name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'wpisz nazwę domeny...', 
                'required' => 'required', 
                'class'	=> 'form-control'
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
                'class'	=> 'form-control'
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
		
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'button',
				'class' => 'btn btn-outline btn-primary btn-lg',
			),
			'options' => array(
				'label' => 'BUTTON',
			),
		));      
    } 
	public function populateForm($domain){
		$this->get('id')->setValue($domain->getId());
		$this->get('name')->setValue($domain->getLogin());
		$this->get('url')->setValue($domain->getFirstname());
		$this->get('is_active')->setValue($domain->getLastname());
	}
}