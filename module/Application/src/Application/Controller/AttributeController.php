<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Attributes;
use Application\Entity\AttributesOption;
use Application\Form\AttributeForm;

class AttributeController extends AbstractActionController
{
	protected $_objectManager = null;

    public function indexAction()
    {
    	$attributes = $this->getObjectManager()->getRepository('\Application\Entity\Attributes')->findAll();
		return new ViewModel(array('attributes' => $attributes));
    }

    public function addAction()
    {
    	$form = new AttributeForm();
		
		if($this->request->isPost()){
			$attribute = new Attributes();
			$is_option = $this->getRequest()->getPost('attribute_type');//zmienna okreslajaca typ atrybutu (zwykly/select)
		 	$attribute 	->setName($this->getRequest()->getPost('attribute_name'))
						->setDescription($this->getRequest()->getPost('attribute_desc'))
						->setType($this->getRequest()->getPost('attribute_type'));
			$this->getObjectManager()->persist($attribute);			
			$this->getObjectManager()->flush();
			if($is_option == 1){
				$serialized = $this->getRequest()->getPost('attribute_options');
				$unserilized = json_decode($serialized);
				
				foreach ($unserilized as $key => $value) {
					$attribute_option = new AttributesOption();
					$attribute_option	-> setValue($value)
										-> setIdAttributes($attribute);
					$this->getObjectManager()->persist($attribute_option);
				}
				$this->getObjectManager()->flush();
			}
			
			//return new ViewModel(array('unserialized' => $unserilized, 'form' => $form));
			return  $this->redirect()->toRoute('attribute', array());
		}
		
		return new ViewModel(array('form' => $form));
    }

    public function editAction()
    {
    	
    	$id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
		$id ? $id : $id = $this->getRequest()->getPost('id');
		
		$form = new AttributeForm();
		
		$attribute = $this->getObjectManager()->find('\Application\Entity\Attributes', $id);
		
		$attribute_options = $this->getObjectManager()->getRepository('\Application\Entity\AttributesOption')->findBy(array('idAttributes' => $id));
		
		$data_options = array();
		if(!empty($attribute_options)){
			foreach ($attribute_options as $temp_attribute) {
				$data_options[$temp_attribute->getId()] = $temp_attribute->getValue();
			}
		}
		//die(var_dump($data_options));
		$data = array(
		    'id'    => $attribute->getId(),
		    'attribute_name' => $attribute->getName(),
		    'attribute_desc' => $attribute->getDescription(),
		    'attribute_type' => $attribute->getType(),
		    'attribute_options' => json_encode($data_options),
		);
		$form->setData($data);
		
		if($this->request->isPost()){
			
			$is_option = $this->getRequest()->getPost('attribute_type');
		 	$attribute  ->setName($this->getRequest()->getPost('attribute_name'))
						->setDesc($this->getRequest()->getPost('attribute_desc'))
						->setType($this->getRequest()->getPost('attribute_type'));
			$this->getObjectManager()->persist($attribute);			
			$this->getObjectManager()->flush();
			if($is_option == 1){
				$serialized = $this->getRequest()->getPost('attribute_options');
				$unserilized = json_decode($serialized);
				
				//die(var_dump($unserilized));
				
				//$data_options = 
				//die(var_dump($_POST));
				foreach ($unserilized as $key => $value) {
					
					$attribute_option = $this->getObjectManager()->find('\Application\Entity\AttributesOption', $key);
					
					if(!$attribute_option){
						$attribute_option = new AttributesOption();
						$attribute_option	-> setValue($value)
											-> setIdAttributes($attribute);
						$this->getObjectManager()->persist($attribute_option);
					}else{
						
						if( array_key_exists ( $key , $data_options ) ){// wydobycie opcji ktorych nie bylo w formularzu i praktycznie są do usunięcia
							unset($data_options[$key]);
						}
						
						$attribute_option	-> setValue($value)
											-> setIdAttributes($attribute);
						$this->getObjectManager()->persist($attribute_option);
						
					}
				}
				//usunięcie opcji których nie było w formularzu edycji
				foreach ($data_options as $key => $value) {
					$attribute_option = $this->getObjectManager()->find('\Application\Entity\AttributesOption', $key);
					$this->getObjectManager()->remove($attribute_option);
				}
				$this->getObjectManager()->flush();
			}
			
			//return new ViewModel(array('unserialized' => $unserilized, 'form' => $form));
			return  $this->redirect()->toRoute('attribute', array());
		}
		
		return new ViewModel(array('form' => $form));
		
    }

    public function deleteAction()
    {
    	$id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
		$attribute = $this->getObjectManager()->find('\Application\Entity\Attributes', $id);
		if ($attribute) {
            $this->getObjectManager()->remove($attribute);
			$attribute_temp = $this->getObjectManager()->getRepository('\Application\Entity\AttributesOption')->findBy(array('idAttributes' => $id));
			foreach ($attribute_temp AS $attribute_options) {
			    $this->getObjectManager()->remove($attribute_options);
			}
            $this->getObjectManager()->flush();
        }
        
        return $this->redirect()->toRoute('attribute', array());
    }
	
	protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->_objectManager;
    }

}

