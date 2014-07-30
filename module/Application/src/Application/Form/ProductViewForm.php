<?php

namespace Application\Form;

use Zend\Form\Form;
	
class ProductViewForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AddViewProduct');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/formdata');
        $this->setAttribute('action', $this->url('product', array('action' => 'saveView')));
        $this->add(array(
            'name' => 'product_id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'view_id',
            'type' => 'Hidden',
        ));

	}
	public function populateForm($product_type){
		// $this->get('id')->setValue($product_type['id']);
		// $this->get('name')->setValue($product_type->getName());
        // $this->get('domains')->setValue($product_type->getName());

	}
}