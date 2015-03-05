<?php

/* 
 * Copyright 2015 Daan Pape.
 */

/**
 * This class can represent a SYSTEM_VALUE or USER_VALUE for
 * use in a GradingRule.
 */
class RuleValue {
    
    /**
     * The name of this value.
     */
    private $name;
    
    /**
     * The actual value of this RuleValue.
     */
    private $value;
    
    /**
     * Construct a new rule RuleValue.
     * @param name the name of this RuleValue.
     * @param value the value of this RuleValue.
     */
    function __construct($name, $value) {
       $this->name = $name;
       $this->value = $value;
   }
   
   public function getName() {
       return $this->name;
   }
   
   public function setName($name) {
       $this->name = $name;
   }
   
   public function getValue() {
       return $this->value;
   }
   
   public function setValue($value) {
       $this->value = $value;
   }
}

?>