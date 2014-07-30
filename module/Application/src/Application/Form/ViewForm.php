<?php

namespace Application\Form;

use Zend\Form\Form;

class ViewForm extends Form
{
    public function __construct($name = NULL)
    {
        parent::__construct('AddView');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/formdata');
        // FIELDS
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden'
        ));
        $this->add(array(
            'name' => 'view_active',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class'	=> 'form-control'
            ),
            'options' => array(
                'label' => 'Aktywność',
                'value_options' => array(
                    '0' => 'wyłączona',
                    '1' => 'włączona'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'view_name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Nazwa widoku'
            ),
        ));
        $this->add(array(
            'name' => 'view_type',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
                'value' => '0',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Typ widoku',
                'value_options' => array(
                    '1' => 'widok grupowy',
                    '2' => 'widok domenowy'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'view_domains',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'multiple' => 'multiple',
                'class'	=> 'form-control'
            ),
            'options' => array(
                'label' => 'Domeny',
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
}