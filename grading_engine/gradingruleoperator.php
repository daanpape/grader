<?php

/* 
 * Copyright 2015 Daan Pape.
 */

/**
 * Every RuleOperator must implement this interface. It
 * contains a function which evaluates two values and 
 * gives a boolean outcome. 
 */
interface RuleOperator
{
    public function evaluate($sysValue, $userValue);
}

/**
 * Represents a GradingRule operator. It encapsulates
 * a boolean operator on two values in a function
 */
class EqualsOperator implements RuleOperator{
    
    public function evaluate($sysValue, $userValue) {
        
    }
}
?>
