<?php
namespace ypl;

class Shortcode {
   public function __construct() {
       $this->init();
   }

   private function init() {
       add_shortcode('ypl_poll', array($this, 'poll'), 1);
   }

    public function poll($args) {
       if(empty($args['id'])) {
           return '';
       }
       $id = (int)$args['id'];
       $obj = Poll::findById($id);
       if(empty($obj)) {
           return '';
       }
		
       return $obj->renderForm();
    }

   public static function getInstance() {
       new self();
   }
}