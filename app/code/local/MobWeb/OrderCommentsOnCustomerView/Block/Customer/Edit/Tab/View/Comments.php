<?php
 
class MobWeb_OrderCommentsOnCustomerView_Block_Customer_Edit_Tab_View_Comments extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('customer_view_comments_grid');
    }
 
    public function getComments()
    {
        $comments = array();
 
        $orders = Mage::getModel('sales/order')
            ->getCollection()
            ->addFieldToFilter('customer_id', array('eq' => array(Mage::registry('current_customer')->getId())))
            ->setOrder('entity_id');
 
        foreach ($orders as $order) {
            $orderComments = $order->getAllStatusHistory();
 
            foreach ($orderComments as $comment) {
                if($body = trim($comment->getData('comment'))) {
                    // Order comments containing certain strings defined in the Admin Panel will
                    // be filtered automatically
                    $filter = explode("\r\n", Mage::getStoreConfig('customer/order_comment_display/filter_strings'));
                    foreach($filter AS $needle) {
                        if(strpos($body, $needle) !== false) {
                            continue 2;
                        }
                    }
 
                    // Save the comment
                    $comments[] = array(
                        'created_at' => $comment->getData('created_at'),
                        'order' => $order->getIncrementId(),
                        'order_status' => $order->getStatus(),
                        'comment' => $body
                    );
                }
            }
        }

        // Sort the comments so that the newest one appears first
        if(!function_exists('compareCreatedAt')) {
            function compareCreatedAt($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            }
        }
        usort($comments, 'compareCreatedAt');

        return $comments;
    }
    public function initForm()
    {
        $form = new Varien_Data_Form();
 
        $this->setForm($form);
 
        return $this;
    }
}