<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\ProductTypes;
//use Application\Entity\AttributesOption;
use Application\Form\ProductTypeForm;

class ProductTypeController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
    	 $form = new ProductTypeForm();
         return new ViewModel(array('form' => $form));
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }


}

