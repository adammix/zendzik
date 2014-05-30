<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use Application\Form\UserForm;

class IndexController extends AbstractActionController
{

    protected $_objectManager = null;

    public function indexAction()
    {
        $users = $this->getObjectManager()->getRepository('\Application\Entity\User')->findAll();
        return new ViewModel(array('users' => $users));
    }

    public function addAction()
    {
    	$form = new UserForm();
		
		
        if ($this->request->isPost()) {
            $user = new User();
            $user	->setLogin($this->getRequest()->getPost('user_login'))
					->setFirstname($this->getRequest()->getPost('user_name'))
					->setLastname($this->getRequest()->getPost('user_lastname'))
					->setPassword($this->getRequest()->getPost('password'));
            $this->getObjectManager()->persist($user);
            $this->getObjectManager()->flush();
            $newId = $user->getId();
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel(array('form' => $form));
    }

    public function editAction()
    {
    	$form = new UserForm();
		
		$id = (int) $this->params()->fromRoute('id', 0);
        $user = $this->getObjectManager()->find('\Application\Entity\User', $id);
		
        if ($this->request->isPost()) {
            $user	->setLogin($this->getRequest()->getPost('user_login'))
					->setFirstname($this->getRequest()->getPost('user_name'))
					->setLastname($this->getRequest()->getPost('user_lastname'))
					->setPassword($this->getRequest()->getPost('password'));
            $this->getObjectManager()->merge($user);
            $this->getObjectManager()->flush();
            return $this->redirect()->toRoute('home');
        }

		$form->populateForm($user);
		return new ViewModel(array('form' => $form));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $user = $this->getObjectManager()->find('\Application\Entity\User', $id);
        if ($this->request->isPost()) {
        	echo '<pre>';
			print_r($user);
			echo '</pre>';
			die;
            $this->getObjectManager()->remove($user);
            $this->getObjectManager()->flush();
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel(array('user' => $user));
    }
	
	protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->_objectManager;
    }
}

