<?php

namespace Application\Form;

use Zend\Form\Form;
	
class AttributeForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AddAttribute');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/formdata');
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        
        $this->add(array( 
            'name' => 'attribute_name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
                'class'	=> 'form-control'
            ), 
            'options' => array( 
                'label' => 'Nazwa atrybutu', 
            ), 
        )); 
		
		$this->add(array( 
            'name' => 'attribute_desc', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required', 
                'class'	=> 'form-control'
            ), 
            'options' => array( 
                'label' => 'Opis atrybutu', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'attribute_type', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'required' => 'required', 
                'value' => '0', 
                'class'	=> 'form-control'
            ), 
            'options' => array( 
                'label' => 'Typ atrybutu', 
                'value_options' => array(
                    '0' => 'zwykły tekst', 
                    '1' => 'lista predefiniowana', 
                ),
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'attribute_options', 
            'type' => 'Hidden', 
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
	public function populateForm($attribute){
		$this->get('id')->setValue($user->getId());
		$this->get('user_login')->setValue($user->getLogin());
		$this->get('user_name')->setValue($user->getFirstname());
		$this->get('user_lastname')->setValue($user->getLastname());
		$this->get('password')->setValue($user->getPassword());
	}
}