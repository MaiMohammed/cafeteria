<?php

class Application_Form_Product extends Zend_Form {

    public function init() {

        $this->setAttrib('enctype', 'multipart/form-data');
        //$this->setMethod("post");
        
        $proname = new Zend_Form_Element_Text("prod_name");
        $proname->setLabel("Product :");
        $proname->setRequired();
        $proname->addFilter(new Zend_Filter_StripTags());
        $proname->setAttrib("placeholder", "Enter Product Name");
        
        
        $proprice = new Zend_Form_Element_Text("prod_price");
        $proprice->setLabel("Price :");
        $proprice->setRequired();
        $proprice->addFilter(new Zend_Filter_StripTags());
        $proprice->setAttrib("placeholder", "Enter Product Price");
        
        $catName = new Zend_Form_Element_Select('cat_id'); 
        $catName->setLabel('Category :');
        
        $image = new Zend_Form_Element_File('prod_image');
        //$image->setLabel('Upload Product image:')->setDestination('/var/www/html/cafteria/upload');
        // ensure only 1 file
        $image->setLabel("Product Image :");
        $image->addValidator('Count', false, 1);
        $image->setRequired(true);
        // limit to 2mb
        //$image->addValidator('Size', false, 2097152);
        // only JPEG, PNG, and GIFs
        $image->addValidator('Extension', false, 'jpg,png,gif');

        $id=new Zend_Form_Element_Hidden("id");

        //var_dump($this->cats);
        //cats
        


        $submit = new Zend_Form_Element_Submit("Add");
        $reset = new Zend_Form_Element_Reset("Reset");


        $this->addElements(array($id,$proname, $proprice, $catName, $image, $submit, $reset));
    }

}
