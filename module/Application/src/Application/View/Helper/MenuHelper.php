<?php

namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface; 
class MenuHelper extends AbstractHelper 
{
 	protected $sm;

    public function __construct($sm) {
        $this->sm = $sm;
    }
	
	public function __invoke()
	{
		$objectManager = $this->sm->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		
		$product_types = $objectManager->getRepository('\Application\Entity\ProductTypes')->findAll();
		$output = '<ul class="nav nav-second-level">';
		$output .= '<li><a href="/product">+ Dodaj Produkt</a></li>';
		foreach($product_types as $product_type){
        	$output .= '<li><a href="' . $this->view->url('product', array('action'=>'list', 'id' => $product_type->getId())) . '">' . $product_type->getName() . '</a> </li>';
        }
        $output .= '</ul>';
		return $output;
	}
	
}
