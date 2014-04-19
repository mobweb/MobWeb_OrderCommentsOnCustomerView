<?php

class MobWeb_OrderCommentsOnCustomerView_Block_Customer_Tab_View_Comments extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
   /**
     * Set the template for the block
     *
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('customer/tab/view/comments.phtml');
    }
   /**
     * Retrieve the label used for the tab relating to this block
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Order Comment History');
    }
   /**
     * Retrieve the title used by this tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Order Comment History');
    }
   /**
     * Determines whether to display the tab
     * Add logic here to decide whether you want the tab to display
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * Stops the tab being hidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    public function getComments()
    {
        // Get the comments from the other block
        return $this->getLayout()->createBlock('ordercommentsoncustomerview/customer_edit_tab_view_comments')->getComments();
    }
}