<?php
    // filename : module/Users/src/Users/Form/RegisterForm.php
namespace Application\Form;

use Zend\Form\Form;
	
class UserForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('AddUser');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/formdata');
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
		$this->add(array(
			'name' => 'user_login',
			'attributes' => array(
				'type' => 'text',
				'class'  => 'form-control',
				'required' => 'required'
			),
			'options' => array(
				'label' => 'Login',
				'label_attributes' => array(
            		'class'  => 'mycss'
        		),
			),
		));
		$this->add(array(
			'name' => 'user_name',
			'attributes' => array(
				'type' => 'text',
				'class'  => 'form-control',
				'required' => 'required'
			),
			'options' => array(
				'label' => 'Imie',
			),
		));
		$this->add(array(
			'name' => 'user_lastname',
			'attributes' => array(
				'type' => 'text',
				'class'  => 'form-control',
				'required' => 'required'
			),
			'options' => array(
				'label' => 'Nazwisko',
			),
		));
		
		$this->add(array(
			'name' => 'password',
			'attributes' => array(
				'type' => 'password',
				'class'  => 'form-control',
				'required' => 'required'
			),
			'options' => array(
				'label' => 'Hasło',
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
	public function populateForm($user){
		$this->get('id')->setValue($user->getId());
		$this->get('user_login')->setValue($user->getLogin());
		$this->get('user_name')->setValue($user->getFirstname());
		$this->get('user_lastname')->setValue($user->getLastname());
		$this->get('password')->setValue($user->getPassword());
	}
}