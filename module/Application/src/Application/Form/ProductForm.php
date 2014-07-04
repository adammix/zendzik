<?php

namespace Application\Form;

use Zend\Form\Form;
	
class ProductForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AddProduct');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/formdata');
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

	}
	public function populateForm($product_type){
		// $this->get('id')->setValue($product_type['id']);
		// $this->get('name')->setValue($product_type->getName());
        // $this->get('domains')->setValue($product_type->getName());

	}
}