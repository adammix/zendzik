<?php

namespace Application\Form;

use Zend\Form\Form;
	
class ProductTypeForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AddProductType');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/formdata');
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        
        $this->add(array( 
            'name' => 'name', 
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
	public function populateForm($product_type){
		$this->get('id')->setValue($product_type->getId());
		$this->get('name')->setValue($user->getName());
	}
}