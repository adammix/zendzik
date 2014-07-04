<?php

namespace Application\Controller;

use Application\Form\ProductForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Entity\Attributes;
use Application\Entity\AttributesGroups;
use Application\Entity\Categories;
use Application\Entity\Domains;
use Application\Entity\DomainsProducts;
use Application\Entity\ProductTypes;
use Application\Entity\Products;
use Application\Entity\ProductsAttributes;
use Application\Entity\ProductsCategories;




class ProductController extends AbstractActionController
{

    protected $_objectManager = null;

    public function indexAction()
    {
        $product_types = $this->getObjectManager()->getRepository('\Application\Entity\ProductTypes')->findAll();
        return new ViewModel(array('product_types' => $product_types));

    }

    public function addAction()
    {
        /**
         * ++++++++++++RECIEVE
         */
        if($this->request->isPost()){
           //die(var_dump($_POST));
            $id = $this->getRequest()->getPost('id');

            /**
             * GET PRODUCT TYPE DATA
             */
            $product_type_entity = $this->getObjectManager()->getRepository('\Application\Entity\ProductTypes')->findOneById($id);

            /**
             * CREATE PRODUCT
             */
            $product_entity = new Products();
            $product_entity->setIdProductTypes($product_type_entity);
            $this->getObjectManager()->persist($product_entity);
            $this->getObjectManager()->flush();

            /**
             * CREATE DOMAINS PRODUCT CONNECTION
             */
            //GET AVAILABLE DOMAINS
            $domains = explode(";", $product_type_entity->getDomains());
            $domains_post = $this->getRequest()->getPost('domains');
            foreach($domains as $item){
                if($item != ''){
                    $domain_entity = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findOneById($item);
                    $domains_products_entity = new DomainsProducts();
                    $domains_products_entity->setIdDomains($domain_entity);
                    $domains_products_entity->setIdProducts($product_entity);
                    //IS DOMAIN IS ACTIVE FOR CURRENT DOMAIN
                    if(in_array($item, $domains_post)){
                        $domains_products_entity->setStatus('1');
                    }else{
                        $domains_products_entity->setStatus('0');
                    }
                    $this->getObjectManager()->persist($domains_products_entity);
                }
            }
            /**
             * ATTRIBUTES SAVE
             */

            foreach($_POST as $key => $value){
                if(preg_match('/attr_/', $key)){
                    $attribute_key = explode("_", $key);
                    $attribute_entity = $this->getObjectManager()->getRepository('\Application\Entity\Attributes')->findOneById($attribute_key);
                    if(is_array($value)){
                        foreach($value as $item){
                            $database_attribute = new ProductsAttributes();
                            $database_attribute->setProducts($product_entity);
                            $database_attribute->setDomains(NULL);
                            $database_attribute->setAttributes($attribute_entity);
                            $database_attribute->setAttributeValue($item);
                            $this->getObjectManager()->persist($database_attribute);
                        }
                    }else{
                        $database_attribute = new ProductsAttributes();
                        $database_attribute->setProducts($product_entity);
                        $database_attribute->setDomains(NULL);
                        $database_attribute->setAttributes($attribute_entity);
                        $database_attribute->setAttributeValue($value);
                        $this->getObjectManager()->persist($database_attribute);
                    }
                    //$this->getServiceLocator()->get('log')->info($key);
                }
            }
            /**
             * CATEGORIES SAVE
             */
            $categories_post = $this->getRequest()->getPost('categories');

            if(!empty($categories_post)){
                $categories_post = json_decode($categories_post);
                foreach($categories_post as $categories){
                    //die(var_dump($categories));
                    if($categories->state->selected == TRUE){
                        if($categories->id > 0){
                            $category_entity = $this->getObjectManager()->getRepository('\Application\Entity\Categories')->findOneById($categories->id);
                            //$this->getServiceLocator()->get('log')->info($categories->state->selected);
                            $product_category_entity = new ProductsCategories();
                            $product_category_entity->setProducts($product_entity);
                            $product_category_entity->setCategories($category_entity);
                            $this->getObjectManager()->persist($product_category_entity);
                        }
                    }
                }
            }

            $this->getObjectManager()->flush();
            return $this->redirect()->toRoute('product', array());
        }


        /**
         * +++++++++++++++++++++SEND EMPTY FORM
         */
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $form = new ProductForm();

        /**
         * ===== ATRYBUTY
         */
        $form->get('id')->setValue($id);
        //die(var_dump($id));
        $product_type = $this->getObjectManager()->getRepository('\Application\Entity\ProductTypes')->findOneById($id);
        $attributes_groups = $this->getObjectManager()->getRepository('\Application\Entity\AttributesGroups')->findBy(array('idProductTypes' => $id));
        foreach($attributes_groups as $key => $value){
            $attr_id = $attributes_groups[$key]->getIdAttributes();

            //$attribute = $this->getObjectManager()->getRepository('\Application\Entity\Attributes')->findOneById($attr_id);
            //
            //atrybut prosty
            if($attr_id->getType() == 0){
                $form->add(array(
                    'name' => 'attr_'.$attr_id->getId(),
                    'type' => 'Zend\Form\Element\Text',
                    'attributes' => array(
                        'class'	=> 'form-control'
                    ),
                    'options' => array(
                        'label' => $attr_id->getName().' ('.$attr_id->getDescription().')',
                    ),
                ));
            //atrybut multi-option
            }elseif($attr_id->getType() == 1){
                $attribute_options = $this->getObjectManager()->getRepository('\Application\Entity\AttributesOption')->findBy(array('idAttributes' => $attr_id->getId()));
                $data_options = array();
                if(!empty($attribute_options)){
                    foreach ($attribute_options as $temp_attribute) {
                        $data_options[$temp_attribute->getId()] = $temp_attribute->getValue();
                    }
                }
                $form->add(array(
                    'name' => 'attr_'.$attr_id->getId(),
                    'type' => 'Zend\Form\Element\Select',
                    'attributes' => array(
                        'multiple' => 'multiple',
                        'class' => 'form-control',
                    ),
                    'options' => array(
                        'label' => $attr_id->getName().' ('.$attr_id->getDescription().')',
                        'value_options' => $data_options,
                    ),
                ));
            }
        }

        /**
         * ====== DOMENY
         */
        $domains = explode(";", $product_type->getDomains());
        $data_options = '';

        //die(var_dump( $product_type->getDomains()));
        foreach($domains as $item){
            if($item != ''){
                $domains_collection = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findOneById($item);
                $data_options[$domains_collection->getId()] = $domains_collection->getName();
            }
        }


        $form->add(array(
            'name' => 'domains',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'multiple' => 'multiple',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Aktywne domeny',
                'value_options' => $data_options,
            ),
        ));

        /**
         * ===== KATEGORIE
         */

        if($product_type->getIsCategory() == 1){
            $categories_tree = $this->get_categories_selected_tree($product_type, NULL, NULL);

            $categories_tree = json_encode($categories_tree);
            //$this->getServiceLocator()->get('log')->info($categories_table);
            $form->add(array(
                'name' => 'categories',
                'type' => 'Hidden',
                'value' => $categories_tree,
            ));
            $form->get('categories')->setValue($categories_tree);

        }



        //$domains = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findBy(array('idProductTypes' => $id));

        //dodanie przycisku submit do formularza
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-outline btn-primary btn-lg',
            ),
        ));

        return new ViewModel(array('form'=> $form));
    }

    public function editAction()
    {
        /**
         * ++++++++++++RECIEVE
         */
//        if($this->request->isPost()){
//            //die(var_dump($_POST));
//            $id = $this->getRequest()->getPost('id');
//
//            /**
//             * GET PRODUCT TYPE DATA
//             */
//            $product_type_entity = $this->getObjectManager()->getRepository('\Application\Entity\ProductTypes')->findOneById($id);
//
//            /**
//             * CREATE PRODUCT
//             */
//            $product_entity = new Products();
//            $product_entity->setIdProductTypes($product_type_entity);
//            $this->getObjectManager()->persist($product_entity);
//            $this->getObjectManager()->flush();
//
//            /**
//             * CREATE DOMAINS PRODUCT CONNECTION
//             */
//            //GET AVAILABLE DOMAINS
//            $domains = explode(";", $product_type_entity->getDomains());
//            $domains_post = $this->getRequest()->getPost('domains');
//            foreach($domains as $item){
//                if($item != ''){
//                    $domain_entity = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findOneById($item);
//                    $domains_products_entity = new DomainsProducts();
//                    $domains_products_entity->setIdDomains($domain_entity);
//                    $domains_products_entity->setIdProducts($product_entity);
//                    //IS DOMAIN IS ACTIVE FOR CURRENT DOMAIN
//                    if(in_array($item, $domains_post)){
//                        $domains_products_entity->setStatus('1');
//                    }else{
//                        $domains_products_entity->setStatus('0');
//                    }
//                    $this->getObjectManager()->persist($domains_products_entity);
//                }
//            }
//            /**
//             * ATTRIBUTES SAVE
//             */
//
//            foreach($_POST as $key => $value){
//                if(preg_match('/attr_/', $key)){
//                    $attribute_key = explode("_", $key);
//                    $attribute_entity = $this->getObjectManager()->getRepository('\Application\Entity\Attributes')->findOneById($attribute_key);
//                    if(is_array($value)){
//                        foreach($value as $item){
//                            $database_attribute = new ProductsAttributes();
//                            $database_attribute->setProducts($product_entity);
//                            $database_attribute->setDomains(NULL);
//                            $database_attribute->setAttributes($attribute_entity);
//                            $database_attribute->setAttributeValue($item);
//                            $this->getObjectManager()->persist($database_attribute);
//                        }
//                    }else{
//                        $database_attribute = new ProductsAttributes();
//                        $database_attribute->setProducts($product_entity);
//                        $database_attribute->setDomains(NULL);
//                        $database_attribute->setAttributes($attribute_entity);
//                        $database_attribute->setAttributeValue($value);
//                        $this->getObjectManager()->persist($database_attribute);
//                    }
//                    //$this->getServiceLocator()->get('log')->info($key);
//                }
//            }
//            /**
//             * CATEGORIES SAVE
//             */
//            $categories_post = $this->getRequest()->getPost('categories');
//
//            if(!empty($categories_post)){
//                $categories_post = json_decode($categories_post);
//                foreach($categories_post as $categories){
//                    //die(var_dump($categories));
//                    if($categories->state->selected == TRUE){
//                        if($categories->id > 0){
//                            $category_entity = $this->getObjectManager()->getRepository('\Application\Entity\Categories')->findOneById($categories->id);
//                            //$this->getServiceLocator()->get('log')->info($categories->state->selected);
//                            $product_category_entity = new ProductsCategories();
//                            $product_category_entity->setProducts($product_entity);
//                            $product_category_entity->setCategories($category_entity);
//                            $this->getObjectManager()->persist($product_category_entity);
//                        }
//                    }
//                }
//            }
//
//            $this->getObjectManager()->flush();
//            return $this->redirect()->toRoute('product', array());
//        }


        /**
         * +++++++++++++++++++++SEND FORM WITH PREVIOUS VALUES
         */
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $product_id = $this->getObjectManager()->getRepository('\Application\Entity\Products')->findOneById($id);

        $form = new ProductForm();

        /**
         * ===== ATRYBUTY
         */
        $form->get('id')->setValue($id);
        //die(var_dump($id));
        $product_type = $product_id->getIdProductTypes();
        $attributes_groups = $this->getObjectManager()->getRepository('\Application\Entity\AttributesGroups')->findBy(array('idProductTypes' => $product_type->getId()));
        $attributes_products = $this->getObjectManager()->getRepository('\Application\Entity\ProductsAttributes')->findBy(array('products' => $product_id->getId()));
        $attributes_products_array = array();
        foreach($attributes_products as $item){
            $attributes_products_array[$item->getAttributes()->getId()][] = $item;
        }
        foreach($attributes_groups as $key => $value){
            $attribute = $attributes_groups[$key]->getIdAttributes();

            //atrybut prosty
            if($attribute->getType() == 0){
                if(array_key_exists($attribute->getId(), $attributes_products_array)){
                    $attribute_present_value = $attributes_products_array[$attribute->getId()][0]->getAttributeValue();
                    //die(var_dump($attribute_present_value));
                }else{
                    $attribute_present_value = '';
                }
                $form->add(array(
                    'name' => 'attr_'.$attribute->getId(),
                    'type' => 'Zend\Form\Element\Text',
                    'attributes' => array(
                        'class'	=> 'form-control',
                        'value' => $attribute_present_value
                    ),
                    'options' => array(
                        'label' => $attribute->getName().' ('.$attribute->getDescription().')',
                    ),
                ));
                //atrybut multi-option
            }elseif($attribute->getType() == 1){
                if(array_key_exists($attribute->getId(), $attributes_products_array)){
                    $attribute_present_values = $attributes_products_array[$attribute->getId()];
                    $selected_options = array();
                    foreach($attribute_present_values as $attribute_option_value){
                        $selected_options[] = $attribute_option_value->getAttributeValue();
                    }
                    //die(var_dump($selected_options));
                }else{
                    $selected_options = '';
                }
                $attribute_options = $this->getObjectManager()->getRepository('\Application\Entity\AttributesOption')->findBy(array('idAttributes' => $attribute->getId()));
                $data_options = array();

                if(!empty($attribute_options)){
                    foreach ($attribute_options as $temp_attribute) {
                        $data_options[$temp_attribute->getId()] = $temp_attribute->getValue();

                    }
                }
                $form->add(array(
                    'name' => 'attr_'.$attribute->getId(),
                    'type' => 'Zend\Form\Element\Select',
                    'attributes' => array(
                        'multiple' => 'multiple',
                        'class' => 'form-control',
                        'value' => $selected_options,
                    ),
                    'options' => array(
                        'label' => $attribute->getName().' ('.$attribute->getDescription().')',
                        'value_options' => $data_options,

                    ),
                ));
            }
        }
        //die(var_dump($attributes_products_array));

        /**
         * ====== DOMENY
         */
        $product_domains = $this->getObjectManager()->getRepository('\Application\Entity\DomainsProducts')->findBy(array('idProducts' => $product_id->getId()));
        $active_domains = array();
        foreach($product_domains as $item){
            if($item->getStatus() == 1) $active_domains[] = $item->getIdDomains();
        }
        $domains = explode(";", $product_type->getDomains());
        $data_options = '';

        //die(var_dump( $product_type->getDomains()));
        foreach($domains as $item){
            if($item != ''){
                $domains_collection = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findOneById($item);
                $data_options[$domains_collection->getId()] = $domains_collection->getName();
            }
        }


        $form->add(array(
            'name' => 'domains',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'multiple' => 'multiple',
                'class' => 'form-control',
                'value' => $active_domains
            ),
            'options' => array(
                'label' => 'Aktywne domeny',
                'value_options' => $data_options,
            ),
        ));

        /**
         * ===== KATEGORIE
         */

        if($product_type->getIsCategory() == 1){
            $categories_tree = $this->get_categories_selected_tree($product_type, $product_id, false);

            $categories_tree = json_encode($categories_tree);
            //$this->getServiceLocator()->get('log')->info($categories_table);
            $form->add(array(
                'name' => 'categories',
                'type' => 'Hidden',
                'value' => $categories_tree,
            ));
            $form->get('categories')->setValue($categories_tree);

        }



        //$domains = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findBy(array('idProductTypes' => $id));

        //dodanie przycisku submit do formularza
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-outline btn-primary btn-lg',
            ),
        ));

        return new ViewModel(array('form'=> $form));
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $products = $this->getObjectManager()->getRepository('\Application\Entity\Products')->findBy(array('idProductTypes' => $id));
        return new ViewModel(array('products' => $products));
    }

    protected function getObjectManager()
    {
        if(!$this->_objectManager){
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->_objectManager;
    }

    protected function get_categories_selected_tree($productTypeId, $current_product = NULL, $is_index = NULL){
        if($current_product != NULL){
            $products_categories = $this->getObjectManager()->getRepository('\Application\Entity\ProductsCategories')->findBy(array('products' => $current_product->getId()));
            $active_categories = array();
            foreach($products_categories as $item){
                $active_categories[$item->getCategories()->getId()] = TRUE;
            }
        }else{
            $active_categories = array();
        }

        $categories = $this->getObjectManager()->getRepository('\Application\Entity\Categories')->findBy(array('idproducttypes' => $productTypeId->getId()));
        $categories_table = array();
        if($is_index){//tablica z indeksami dla potrzeb akcji edycji
            $this->getServiceLocator()->get('log')->info('true');
            foreach($categories as $key => $value){
                $is_selected = FALSE;
                if(array_key_exists($value->getId(), $active_categories)){
                    $is_selected = TRUE;
                }
                if( $value->getParentid() == 0){
                    $categories_table[$value->getId()] = (object) array(    'id' => $value->getId(),
                        'parent' => '#',
                        'text' => $value->getName(),
                        'state' => (object) array( 'selected' => $is_selected),
                    );
                }else{
                    $categories_table[$value->getId()] = (object) array( 'id' => $value->getId(),
                        'parent' => $value->getParentid(),
                        'text' => $value->getName(),
                        'state' => (object) array( 'selected' => $is_selected ),
                    );
                }
            }
        }else{
            $this->getServiceLocator()->get('log')->info($categories);
            foreach($categories as $key => $value){
                $is_selected = FALSE;
                if(array_key_exists($value->getId(), $active_categories)){
                    $is_selected = TRUE;
                }
                if( $value->getParentid() == 0){
                    $categories_table[] = (object) array( 'id' => $value->getId(),
                        'parent' => '#',
                        'text' => $value->getName(),
                        'state' => array( 'selected' => $is_selected,
                                                    "loaded" => true,
                                                    "opened" => true,
                                                    "disabled" => false,
                                                ),
                    );
                }else{
                    $categories_table[] = (object) array( 'id' => $value->getId(),
                        'parent' => $value->getParentid(),
                        'text' => $value->getName(),
                        'state' =>  array( 'selected' => $is_selected,
                                                    "loaded" => true,
                                                    "opened" => true,
                                                    "disabled" => false,
                                                ),
                    );
                }
            }
            //die(var_dump($categories_table));
        }
        return $categories_table;
    }
}

