<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Domains;
use Application\Form\DomainForm;

class DomainsController extends AbstractActionController
{
	protected $_objectManager = null;

    public function indexAction()
    {
    	$domains = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findAll();
		return new ViewModel(array('domains' => $domains));
    }
	
	
	
	/**
	 * 
	 * 
	 * @todo: dodać blokadę domeny o tym samym adresie mającym już wpis; 
	 */
    public function addAction()
    {
    	$form = new DomainForm();
		if($this->request->isPost()){
			$domain = new Domains();
			isset($_POST['is_active']) ? $checkboxValue = $_POST['is_active'] : $checkboxValue = 0 ;
			
			$domain	-> setName($this->getRequest()->getPost('name'))
					-> setUrl($this->getRequest()->getPost('url'))
					-> setIsActive($checkboxValue);
			$this->getObjectManager()->persist($domain);		
			$this->getObjectManager()->flush();
			return  $this->redirect()->toRoute('domains', array( 'action' => 'index'));
		}
        return new ViewModel(array('form'=> $form));
    }
	
    public function editAction()
    {
    	$form = new DomainForm();
		
		if($this->request->isPost()){
			
			$id = $this->getRequest()->getPost('id');
			$domain = $this->getObjectManager()->find('\Application\Entity\Domains', $id);
		 	$domain ->setName($this->getRequest()->getPost('name'))
					->setUrl($this->getRequest()->getPost('url'))
					->setIsActive($this->getRequest()->getPost('is_active'));
			$this->getObjectManager()->persist($domain);			
			$this->getObjectManager()->flush();
			return  $this->redirect()->toRoute('domains', array());
		}
		
		$id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
		$domain = $this->getObjectManager()->find('\Application\Entity\Domains', $id);
		$data = array(
		    'id'    => $domain->getId(),
		    'name' => $domain->getName(),
		    'url' => $domain->getUrl(),
		    'is_active' => $domain->getIsActive(),
		);
		$form->setData($data);
		
		return new ViewModel(array('form' => $form));
		
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
		$domain = $this->getObjectManager()->find('\Application\Entity\Domains', $id);
		if ($domain) {
            $this->getObjectManager()->remove($domain);
            $this->getObjectManager()->flush();
        }
        
        return $this->redirect()->toRoute('domains', array());
    }
	protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->_objectManager;
    }


}

