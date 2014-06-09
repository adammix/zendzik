<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Domains;
use Application\Form\DomainForm;

class DomainsController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
    	$form = new DomainForm();
		if($this->request->isPost()){
			$domain = new Domains();
			$this->getServiceLocator()->get('log')->info($this->getRequest()->getPost());
			$domain	-> setName($this->getRequest()->getPost('name'))
					-> setUrl($this->getRequest()->getPost('url'))
					-> setIsActive($this->getRequest()->getPost('is_active'));
			$this->getObjectManager()->persist($domain);			
			$this->getObjectManager()->flush();
			//return  $this->redirect()->toRoute('default', array( 'controller' => 'domains', 'action' => 'index'));
		}
		
        return new ViewModel(array('form'=> $form));
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }
	protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->_objectManager;
    }


}

