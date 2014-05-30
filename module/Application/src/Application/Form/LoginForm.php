<?php
    // filename : module/Users/src/Users/Form/RegisterForm.php
namespace Application\Form;

use Zend\Form\Form;
	
class LoginForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('Login');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/formdata');
		$this->add(array(
			'name' => 'login',
			'attributes' => array(
				'type' => 'text',
			),
			'options' => array(
				'label' => 'Login',
			),
			'attributes' => array(
				'required' => 'required'
			),
		));
		$this->add(array(
			'name' => 'password',
			'attributes' => array(
				'type' => 'password',
			),
			'options' => array(
				'label' => 'Hasło',
			),
			'attributes' => array(
				'required' => 'required'
			),
		));
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'button',
			),
			'options' => array(
				'label' => 'Zaloguj',
			),
		));
	}
}