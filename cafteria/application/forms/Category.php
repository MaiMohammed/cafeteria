<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        $catname = new Zend_Form_Element_Text("cat_name	");
        $catname->setLabel("Category :");
        $catname->setRequired();
        $catname->addFilter(new Zend_Filter_StripTags());
        $catname->setAttrib("placeholder", "Enter Category Name");
        
        $submit = new Zend_Form_Element_Submit("Add");

        $this->addElements(array($catname, $submit));
    }


}

