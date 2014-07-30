<?php

namespace Application\Controller;

use Application\Entity\ViewsDomains;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Entity\ProductTypes;
use Application\Entity\Views;
use Application\Form\ViewForm;

class ViewsController extends AbstractActionController
{
    protected $_objectManager = null;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        /**
         *
         * SAVE FORM
         *
         */
        if($this->request->isPost())
        {
            //die(var_dump($_POST));
            $id = (int)$this->getRequest()->getPost('id');
            $product_type = $this->getObjectManager()->getRepository('Application\Entity\ProductTypes')->findOneById($id);
            if($product_type)
            {
                /**
                 *
                 * check if chosen domains aren't allready included to other views
                 *
                 * */
                $view_domains_post = $this->getRequest()->getPost('view_domains');
                $views = $this->getObjectManager()->getRepository('Application\Entity\Views')->findBy( array( 'idProductType' => $product_type->getId(), 'type' => $this->getRequest()->getPost('view_type')));
                if($views){
                    $present_views = array();
                    $present_domains = array();
                    foreach($views as $value){
                        $present_views[] = $value->getId();
                    }
                    $qb = $this->getObjectManager();
                    $query = $qb->createQuery("SELECT ViewDomain FROM Application\Entity\ViewsDomains ViewDomain WHERE ViewDomain.idViews IN (".implode(', ',$present_views).")");
                    $result_views_domains = $query->getResult();
                    foreach($result_views_domains as $view_domain){
                        $present_domains[] = $view_domain->getIdDomains()->getId();
                    }
                    foreach($view_domains_post as $key => $value)
                    {
                        if( in_array($value, $present_domains)){
                            $this->flashMessenger()->addMessage('WTF -> Jedna z domen jest już przypisana do innego widoku');
                            return $this->redirect()->toRoute('products-type', array(
                                'action' =>  'edit',
                                'id' => $product_type->getId(),
                            ));
                        }
                    }
                }
                $view = new Views();
                $view->setName($this->getRequest()->getPost('view_name'));
                $view->setType($this->getRequest()->getPost('view_type'));
                $view->setIsActive((boolean)$this->getRequest()->getPost('view_active'));
                $view->setIdProductType($product_type);
                foreach($view_domains_post as $key => $value)
                {

                }

                $this->getObjectManager()->persist($view);
                $this->getObjectManager()->flush();

                foreach($view_domains_post as $key => $value)
                {
                    $domain = $this->getObjectManager()->getRepository('Application\Entity\Domains')->findOneById($value);
                    if($domain)
                    {
                        $view_domains = new ViewsDomains();
                        $view_domains->setIdDomains($domain);
                        $view_domains->setIdViews($view);
                        $this->getObjectManager()->persist($view_domains);
                    }
                }
                $this->getObjectManager()->flush();
                return $this->redirect()->toRoute('products-type', array(
                    'action' =>  'edit',
                    'id' => $product_type->getId(),
                ));
            }

        }

        /**
         *
         * GET READY FORM
         *
         */
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $product_type = $this->getObjectManager()->getRepository('Application\Entity\ProductTypes')->findOneById($id);
        if(!$product_type){
            $this->flashMessenger()->addMessage('WTF -> Typ produktu o podanym id nie istnieje');
            return $this->redirect()->toRoute('products-type');
        }
        $form = new ViewForm();
        $form->get('id')->setValue($product_type->getId());
        //pobranie domen dla
        $domains = $product_type->getDomains();
        $domains_active = explode(";", $product_type->getDomains());
        $qb = $this->getObjectManager();
        $query = $qb->createQuery("SELECT Domain FROM Application\Entity\Domains Domain WHERE Domain.id IN (".implode(', ',$domains_active).")");
        $result_domains = $query->getResult();
        $domain_options = array();
        foreach ($result_domains as $key => $value) {
            $domain_id = $value->getId();
            $domain_name = $value->getName();
            $domain_options[$domain_id] = $domain_name;
            //$this->getServiceLocator()->get('log')->info($attr_name);
        }
        $form->get('view_domains')->setAttribute('options', $domain_options);

        return new ViewModel(array('form'=> $form));
    }

    public function editAction()
    {
        /**
         * SAVE NEW VALUES OF VIEW
         */
        if($this->request->isPost())
        {
            //die(var_dump($_POST));
            $id = (int)$this->getRequest()->getPost('id');
            $view = $this->getObjectManager()->getRepository('Application\Entity\Views')->findOneById($id);
            $product_type = $view->getIdProductType();
            $view->setName($this->getRequest()->getPost('view_name'));
            $view->setType($this->getRequest()->getPost('view_type'));
            $view->setIsActive((boolean)$this->getRequest()->getPost('view_active'));


            $present_domains = array();
            $new_domains = array();
            if(is_array($this->getRequest()->getPost('view_domains'))){
                $new_domains = $this->getRequest()->getPost('view_domains');
            }
            $view_domains =  $this->getObjectManager()->getRepository('Application\Entity\ViewsDomains')->findBy(array('idViews' => $view->getId()));
            foreach($view_domains as $domain){
                $present_domains[] = $domain->getidDomains()->getId();
            }
            $domains_to_off = array_diff($present_domains, $new_domains);
            $domains_to_on = array_diff($new_domains, $present_domains);
            //die(var_dump($domains_to_off));
            if(!empty($domains_to_off)){
                //die(var_dump($domains_to_off));
                $qb = $this->getObjectManager();
                $query = $qb->createQuery("SELECT vd FROM Application\Entity\ViewsDomains vd WHERE vd.idViews = ". $id ." AND  vd.idDomains IN (".implode(', ',$domains_to_off).")");
                $result_domains = $query->getResult();
                foreach($result_domains as $result_domain){
                    $this->getObjectManager()->remove($result_domain);
                }
                $this->getServiceLocator()->get('log')->info($result_domains);
            }
            if(!empty($domains_to_on)){
                foreach($domains_to_on as $new_domain){
                    $actual_domain = $this->getObjectManager()->getRepository('Application\Entity\Domains')->findOneBy(array('id' => $new_domain ));
                    $view_domain = new ViewsDomains();
                    $view_domain->setIdViews($view);
                    $view_domain->setIdDomains($actual_domain);
                    $this->getObjectManager()->persist($view_domain);
                }
                //$this->getServiceLocator()->get('log')->info($view_domain);
            }
            $this->getObjectManager()->flush();
            return $this->redirect()->toRoute('products-type', array(
                'action' =>  'edit',
                'id' => $product_type->getId(),
            ));
        }

        /**
         *
         * SEND ACTUAL DATA TO USER
         *
         */
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $form = new ViewForm();
        $view =  $this->getObjectManager()->getRepository('Application\Entity\Views')->findOneById($id);
        $form->get('id')->setValue($id);
        $form->get('view_name')->setValue($view->getName());
        $form->get('view_active')->setValue($view->getIsActive());
        $form->get('view_type')->setValue($view->getType());


        $product_type = $view->getIdProductType();
        $domains_active = explode(";", $product_type->getDomains());

        //pobranie domen wzorcowych
        $qb = $this->getObjectManager();
        $query = $qb->createQuery("SELECT Domain FROM Application\Entity\Domains Domain WHERE Domain.id IN (".implode(', ',$domains_active).")");
        $result_domains = $query->getResult();

        //pobranie domen przypisanych do danego widoku
        $active_domains = array();
        $view_domains =  $this->getObjectManager()->getRepository('Application\Entity\ViewsDomains')->findBy(array('idViews' => $view->getId()));
        foreach($view_domains as $domain){
            $active_domains[] = $domain->getidDomains()->getId();
        }
        $domain_options = array();
        foreach ($result_domains as $key => $value) {
            $domain_id = $value->getId();
            $domain_name = $value->getName();

            $domain_options[$domain_id] = $domain_name;
            //$this->getServiceLocator()->get('log')->info($attr_name);
        }
        $form->get('view_domains')->setAttribute('options', $domain_options);
        $form->get('view_domains')->setValue($active_domains);

        return new ViewModel(array( 'form' => $form ));
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $view = $this->getObjectManager()->getRepository('\Application\Entity\Views')->findOneById($id);
        $product_type = $view->getIdProductType();

        if (!empty($view)) {
            $view_domains = $this->getObjectManager()->getRepository('\Application\Entity\ViewsDomains')->findBy(array('idViews' => $id));
            foreach($view_domains as $item){
                $this->getObjectManager()->remove($item);
            }
            $this->getObjectManager()->remove($view);
            $this->getObjectManager()->flush();
        }
        return $this->redirect()->toRoute('products-type', array(
            'action' =>  'edit',
            'id' => $product_type->getId(),
        ));
    }
    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->_objectManager;
    }
}

