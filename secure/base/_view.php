<?php


class wireapp_base extends wireapp_super {
 
  ##########################################
  # index 
  ##########################################
  function index() {    
    $test = new dbo('user');
    $test->find();
    include $this->template();
  }
  ##########################################
 
  
  ##########################################
  # logout
  ##########################################
  function logout() {
    $this->_logout();
    $this->redirect("/index");
  }
  ##########################################
  



}
?>