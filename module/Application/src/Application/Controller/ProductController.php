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
            //die(var_dump($_FILES));
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
                if(preg_match('/attr_/', $key)){ // atrybuty opcjonalne
                    $attribute_key = explode("_", $key);
                    $attribute_entity = $this->getObjectManager()->getRepository('\Application\Entity\Attributes')->findOneById($attribute_key);
                    if(is_array($value)){
                        foreach($value as $item){
                            $database_attribute = new ProductsAttributes();
                            $database_attribute->setProducts($product_entity);
                            $database_attribute->setViews(NULL);
                            $database_attribute->setAttributes($attribute_entity);
                            $database_attribute->setAttributeValue($item);
                            $this->getObjectManager()->persist($database_attribute);
                        }
                    }else{
                        $database_attribute = new ProductsAttributes();
                        $database_attribute->setProducts($product_entity);
                        $database_attribute->setViews(NULL);
                        $database_attribute->setAttributes($attribute_entity);
                        $database_attribute->setAttributeValue($value);
                        $this->getObjectManager()->persist($database_attribute);
                    }
                    //$this->getServiceLocator()->get('log')->info($key);
                }
            }
            //die(var_dump($_FILES));
            foreach($_FILES as $key => $value){
                if(preg_match('/image_/', $key)){ // atrybut IMAGE
                    $attribute_key = explode("_", $key);
                    $attribute_entity = $this->getObjectManager()->getRepository('\Application\Entity\Attributes')->findOneById($attribute_key);

                    if (file_exists("public/product_images/" . $_FILES[$key]["name"])) {
                        //$this->getServiceLocator()->get('log')->info( $_FILES[$key]["name"]." already exists. ");
                        $this->flashMessenger()->addMessage('Zdjęcie o podnej nazwie już istnieje');
                        return $this->redirect()->toRoute('product', array( 'controller' => 'Products',
                                                                            'action' =>  'add',
                                                                            'id' => $product_type_entity->getId(),
                                                                            ));
                    } else {
                        $path = "public/product_images/" . $_FILES[$key]["name"];
                        move_uploaded_file($_FILES[$key]["tmp_name"], $path );
                        $this->getServiceLocator()->get('log')->info( "Stored in: " . "product_images/".$_FILES[$key]["name"]);

                        $database_attribute = new ProductsAttributes();
                        $database_attribute->setProducts($product_entity);
                        $database_attribute->setViews(NULL);
                        $database_attribute->setAttributes($attribute_entity);
                        $database_attribute->setAttributeValue($path);
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
            $this->flashMessenger()->addMessage('Produkt został dodany');
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
        $attributes_groups = $this->getObjectManager()->getRepository('\Application\Entity\AttributesGroups')->findBy(array('idProductType' => $id));
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
            }elseif($attr_id->getType() == 2){
                $form->add(array(
                    'name' => 'image_'.$attr_id->getId(),
                    'type' => 'Zend\Form\Element\File',
                    'attributes' => array(
                        'class' => 'form-image',
                    ),
                    'options' => array(
                        'label' => $attr_id->getName().' ('.$attr_id->getDescription().')',
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



        //$domains = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findBy(array('idProductType' => $id));

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
         * ++++++++++++ RECIEVE
         */
        if($this->request->isPost()){
            //die(var_dump($_POST));
            $id = $this->getRequest()->getPost('id');

            /**
             * GET PRODUCT
             */
            $product_entity = $this->getObjectManager()->getRepository('\Application\Entity\Products')->findOneById($id);


            /**
             * GET PRODUCT TYPE DATA
             */
            $product_type_entity = $product_entity->getIdProductTypes();

            /**
             * ATTRIBUTES SAVE
             */
            //GET ACTUAL PRODUCT ATTRIBUTES
            $attributes_products = $this->getObjectManager()->getRepository('\Application\Entity\ProductsAttributes')->findBy(array('products' => $product_entity->getId()));
            $attributes_products_array = array();
            foreach($attributes_products as $item){
                $attributes_products_array[$item->getAttributes()->getId()][] = $item;
            }
            //GET
            foreach($_POST as $key => $value){
                if(preg_match('/attr_/', $key)){
                    $attribute_key = explode("_", $key);
                    $attribute_key = $attribute_key[1];
                    //die(var_dump($attribute_key));
                    $attribute_entity = $this->getObjectManager()->getRepository('\Application\Entity\Attributes')->findOneById($attribute_key);
                    if(is_array($value)){
                        if(array_key_exists($attribute_key, $attributes_products_array)){ // old attribute
                            foreach($value as $item){
                                if(in_array($item, $attributes_products_array[$attribute_key])){
                                    $array_index = array_search($item, $attributes_products_array[$attribute_key]);
                                    unset($attributes_products_array[$attribute_key][$array_index]);
                                    $option_attribute = $this->getObjectManager()->getRepository('\Application\Entity\ProductsAttributes')->findBy(array(   'products' => $product_entity->getId(),
                                                                                                                                                           'attributes' => $attribute_key,
                                                                                                                                                            'attributeValue' => $value
                                                                                                                                                    ));
                                    //$this->getServiceLocator()->get('log')->info('xxxxxxxxxx');
                                    $option_attribute->setDomains(0);
                                    $option_attribute->setAttributeValue($item);
                                    $this->getObjectManager()->persist($option_attribute);
                                }
                                $database_attribute = new ProductsAttributes();
                                $database_attribute->setProducts($product_entity);
                                $database_attribute->setDomains(NULL);
                                $database_attribute->setAttributes($attribute_entity);
                                $database_attribute->setAttributeValue($item);
                                $this->getObjectManager()->persist($database_attribute);
                            }
                        }else{ // new attribute
                            foreach($value as $item){
                                $database_attribute = new ProductsAttributes();
                                $database_attribute->setProducts($product_entity);
                                $database_attribute->setDomains(NULL);
                                $database_attribute->setAttributes($attribute_entity);
                                $database_attribute->setAttributeValue($item);
                                $this->getObjectManager()->persist($database_attribute);
                            }
                        }
                    }else{
                        if(array_key_exists($attribute_key, $attributes_products_array)){
                            $option_attribute = $this->getObjectManager()->getRepository('\Application\Entity\ProductsAttributes')->findBy(array(   'products' => $product_entity->getId(),
                                                                                                                                                    'attributes' => $attribute_key,
                                                                                                                                                ));

                            if($option_attribute != NULL){
                                $option_attribute = $option_attribute[0];
                                $option_attribute->setDomains(NULL);
                                $option_attribute->setAttributeValue($value);
                                $this->getObjectManager()->persist($option_attribute);
                            }

                            $array_index = array_search($attribute_key, $attributes_products_array);
                            unset($attributes_products_array[$attribute_key]);
                            //$this->getServiceLocator()->get('log')->info($attributes_products_array);
                        }else{
                            $database_attribute = new ProductsAttributes();
                            $database_attribute->setProducts($product_entity);
                            $database_attribute->setDomains(NULL);
                            $database_attribute->setAttributes($attribute_entity);
                            $database_attribute->setAttributeValue($value);
                            $this->getObjectManager()->persist($database_attribute);
                        }
                    }
                    //$this->getServiceLocator()->get('log')->info($key);
                }
            }
            //die(var_dump($_FILES));
            foreach($_FILES as $key => $value){
                if(preg_match('/image_/', $key) && $value['size'] != NULL){ // atrybut IMAGE
                	$path_to_product = 'public/product_images/'.$product_entity->getId();
                	if (!file_exists($path_to_product)) {
					    mkdir($path_to_product, 0777, true);
					}
                    $attribute_key = explode("_", $key);
                    $attribute_entity = $this->getObjectManager()->getRepository('\Application\Entity\Attributes')->findOneById($attribute_key);
					
                    move_uploaded_file($_FILES[$key]["tmp_name"], $path_to_product .'/'. $_FILES[$key]["name"] );
                    if(array_key_exists($attribute_key, $attributes_products_array)){
                        $image_attribute = $this->getObjectManager()->getRepository('\Application\Entity\ProductsAttributes')->findBy(array( 	'products' => $product_entity->getId(),
                    																															'attributes' => $attribute_key,
                                                                                                                    						));
						$image_attribute->setAttributeValue($path_to_database);
						$this->getObjectManager()->persist($image_attribute);
                    } else {
                        $path_to_database = "product_images/".$product_entity->getId().'/'.$_FILES[$key]["name"];
                        
                        //$this->getServiceLocator()->get('log')->info( "Stored in: " . "product_images/".$_FILES[$key]["name"]);

                        $database_attribute = new ProductsAttributes();
                        $database_attribute->setProducts($product_entity);
                        $database_attribute->setDomains(NULL);
                        $database_attribute->setAttributes($attribute_entity);
                        $database_attribute->setAttributeValue($path_to_database);
                        $this->getObjectManager()->persist($database_attribute);
                    }
						

                    // }
// 
                    // if (file_exists("public/product_images/" . $_FILES[$key]["name"])) {
                        // //$this->getServiceLocator()->get('log')->info( $_FILES[$key]["name"]." already exists. ");
                        // $this->flashMessenger()->addMessage('Zdjęcie już istnieje');
                        // return $this->redirect()->toRoute('product', array( 'controller' => 'Products',
                            // 'action' =>  'add',
                            // 'id' => $product_type_entity->getId(),
                        // ));
                    

                    //$this->getServiceLocator()->get('log')->info($key);
                }
            }

            //usunięcie nieaktualnych wpisów
            foreach($attributes_products_array as $item){
                foreach($item as $item_options){
                    $this->getObjectManager()->remove($item_options);
                }
            }

            /**
             *  DOMAINS
             */
            $domains_post = array();
            if($this->getRequest()->getPost('domains') != NULL){
                $domains_post = $this->getRequest()->getPost('domains');
            }
            $domains = explode(";", $product_type_entity->getDomains());

            $product_domains_present = $this->getObjectManager()->getRepository('\Application\Entity\DomainsProducts')->findBy(array('idProducts' => $product_entity->getId()));
            $product_domains_array = array();
            foreach($product_domains_present as $product_domiain_present){
                $product_domains_array[$product_domiain_present->getId()] = $product_domiain_present;
            }

            foreach($domains as $item){
                if($item != ''){
                    $domain_entity = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findOneById($item);
                    $product_domains = $this->getObjectManager()->getRepository('\Application\Entity\DomainsProducts')->findBy(array('idProducts' => $product_entity->getId(), 'idDomains' => $domain_entity->getId()));

                    if(!empty($product_domains)){
                        foreach($product_domains as $product_domain){//
                            unset($product_domains_array[$product_domain->getId()]);
                            if(in_array($item, $domains_post)){
                                $product_domain->setStatus(1);
                            }else{
                                $product_domain->setStatus(0);
                            }
                            $product_domain->setIdDomains($domain_entity);
                            $product_domain->setIdProducts($product_entity);
                            $this->getObjectManager()->persist($product_domain);
                        }
                    }else{
                        $domains_products_entity = new DomainsProducts();
                        $domains_products_entity->setIdDomains($domain_entity);
                        $domains_products_entity->setIdProducts($product_entity);
                        $this->getObjectManager()->persist($domains_products_entity);
                    }
                }
            }

            //usunięcie domen które zostały usunięte z typu produktu
            foreach($product_domains_array as $item){
                $this->getObjectManager()->remove($item);
            }

            /**
             * CATEGORIES SAVE
             */
            $categories_post = $this->getRequest()->getPost('categories');

            if(!empty($categories_post) && $product_type_entity->getIsCategory() == 1){
                $categories_post = json_decode($categories_post);
                foreach($categories_post as $categories){
                    //die(var_dump($categories));
                    if($categories->id > 0){
                        $category_entity = $this->getObjectManager()->getRepository('\Application\Entity\Categories')->findOneById($categories->id);
                        $product_category = $this->getObjectManager()->getRepository('\Application\Entity\ProductsCategories')->findBy(array('products' => $product_entity->getId(), 'categories' => $categories->id));
                        $this->getServiceLocator()->get('log')->info(array($product_category));
                        //die();
                        if($product_category != NULL){
                            $product_category = $product_category[0];
                            //$this->getServiceLocator()->get('log')->info(array($product_category));
                            if($categories->state->selected == TRUE){
                                $product_category->setProducts($product_entity);
                                $product_category->setCategories($category_entity);
                                $this->getObjectManager()->persist($product_category);
                            }
                            else{
                                $this->getObjectManager()->remove($product_category);
                            }
                        }else{
                            if($categories->state->selected == TRUE){
                                $product_category_entity = new ProductsCategories();
                                $product_category_entity->setProducts($product_entity);
                                $product_category_entity->setCategories($category_entity);
                                $this->getObjectManager()->persist($product_category_entity);
                            }
                        }
                    }
                }
            }
            $this->getObjectManager()->flush();
           //die();
            return $this->redirect()->toRoute('product', array( 'controller' => 'Products',
                                                                'action' =>  'list',
                                                                'id' => $product_type_entity->getId()));
        }


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
        $attributes_groups = $this->getObjectManager()->getRepository('\Application\Entity\AttributesGroups')->findBy(array('idProductType' => $product_type->getId()));
        $attributes_products = $this->getObjectManager()->getRepository('\Application\Entity\ProductsAttributes')->findBy(array('products' => $product_id->getId()));
        $attributes_products_array = array();
        foreach($attributes_products as $item){
            $attributes_products_array[$item->getAttributes()->getId()][] = $item;
        }
        foreach($attributes_groups as $key => $value){
            $attribute = $attributes_groups[$key]->getIdAttributes();
			//$this->getServiceLocator()->get('log')->info($attributes_groups);
			//$this->getServiceLocator()->get('log')->info($attribute->getType());
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
            }elseif($attribute->getType() == 1 ){
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
                // atrybut IMAGE
            }elseif($attribute->getType() == 2){
            	$this->getServiceLocator()->get('log')->info($attributes_products_array);
                if(array_key_exists($attribute->getId(), $attributes_products_array)){
                    $attribute_present_values = end($attributes_products_array[$attribute->getId()]);
                    //die(var_dump($attribute_present_values));
                    //$this->getServiceLocator()->get('log')->info($attribute_present_values->getAttributeValue());

                    $form->add(array(
                        'name' => 'image_'.$attribute->getId(),
                        'type' => 'Zend\Form\Element\File',
                        'attributes' => array(
                            'class' => 'form-image',
                        ),
                        'options' => array(
                            'label' => $attribute->getName().' ('.$attribute->getDescription().')',
                        ),
                    ));
                    $form->add(array(
                        'name' => 'thumbnail_'.$attribute->getId(),
                        'type' => 'Zend\Form\Element\Image',
                        'attributes' => array(
                            'class' => 'form-thumbnail',
                            'src' => 'http://'.$_SERVER['SERVER_NAME'].'/'.$attribute_present_values->getAttributeValue(),
                        ),
                    ));
                }else{
                	$form->add(array(
                        'name' => 'image_'.$attribute->getId(),
                        'type' => 'Zend\Form\Element\File',
                        'attributes' => array(
                            'class' => 'form-image',
                        ),
                        'options' => array(
                            'label' => $attribute->getName().' ('.$attribute->getDescription().')',
                        ),
                    ));
                }
            }

        }
		
        //die(var_dump($attributes_products_array));

        /**
         * ====== DOMENY
         */
        $product_domains = $this->getObjectManager()->getRepository('\Application\Entity\DomainsProducts')->findBy(array('idProducts' => $product_id->getId()));
        $active_domains = array();
        foreach($product_domains as $item){
            if($item->getStatus() == 1) $active_domains[] = $item->getIdDomains()->getId();
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
        //$this->getServiceLocator()->get('log')->info($active_domains);

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



        //$domains = $this->getObjectManager()->getRepository('\Application\Entity\Domains')->findBy(array('idProductType' => $id));

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
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');

        $product = $this->getObjectManager()->getRepository('\Application\Entity\Products')->findOneById($id);

        $product_type = $product->getIdProductTypes();

        /**
         * ATTRIBUTES DELETE
         */
        $attributes_product = $this->getObjectManager()->getRepository('\Application\Entity\ProductsAttributes')->findBy(array('products' => $product->getId()));
        foreach($attributes_product as $item){
            $this->getObjectManager()->remove($item);
        }

        /**
         *  DOMAINS DELETE
         */
        $product_domains = $this->getObjectManager()->getRepository('\Application\Entity\DomainsProducts')->findBy(array('idProducts' => $product->getId()));
        foreach($product_domains as $item){
            $this->getObjectManager()->remove($item);
        }
        /**
         *  CATEGORIES DELETE
         */
        $product_category = $this->getObjectManager()->getRepository('\Application\Entity\ProductsCategories')->findBy(array('products' => $product->getId()));
        foreach($product_category as $item){
            $this->getObjectManager()->remove($item);
        }
        $this->getObjectManager()->remove($product);
        $this->getObjectManager()->flush();

        return $this->redirect()->toRoute('product', array( 'controller' => 'Products',
            'action' =>  'list',
            'id' => $product_type->getId()));
    }

    public function listAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $products = $this->getObjectManager()->getRepository('\Application\Entity\Products')->findBy(array('idProductTypes' => $id));
		$products_array = array();
		foreach($products as $product){
			//nazwa produktu
			
			$product_name = $this->getObjectManager()->getRepository('\Application\Entity\ProductsAttributes')->findBy(array(	'attributes' => '1',
																																'products' => $product->getId(),
																															));
			$products_array[$product->getId()]['id'] = $product->getId();
			$products_array[$product->getId()]['name']= '';
			if($product_name != NULL){
				//$this->getServiceLocator()->get('log')->info($product_name);																											
				$products_array[$product->getId()]['name'] = end($product_name)->getAttributeValue();
			}
			
		}
		$this->getServiceLocator()->get('log')->info($products_array);		
        return new ViewModel(array('products' => $products_array));
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
          //  $this->getServiceLocator()->get('log')->info('true');
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
            //$this->getServiceLocator()->get('log')->info($categories);
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

