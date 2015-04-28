<?php

/* 
 * Copyright 2015 Daan Pape.
 */

/**
 * _ _   _   _  ___   ____      _        _    _   _   _____ _____   ____   _    ____ ____  _____ _   _   _ _ 
  | | | | \ | |/ _ \ / ___|    / \      / \  | \ | | |_   _| ____| |  _ \ / \  / ___/ ___|| ____| \ | | | | |
  | | | |  \| | | | | |  _    / _ \    / _ \ |  \| |   | | |  _|   | |_) / _ \ \___ \___ \|  _| |  \| | | | |
  |_|_| | |\  | |_| | |_| |  / ___ \  / ___ \| |\  |   | | | |___  |  __/ ___ \ ___) |__) | |___| |\  | |_|_|
  (_|_) |_| \_|\___/ \____| /_/   \_\/_/   \_\_| \_|   |_| |_____| |_| /_/   \_\____/____/|_____|_| \_| (_|_)
                                                                                                            
 * - Rules moeten opslaan of het over een INDICATOR, COMPETENCE of SUBCOMPETENCE gaat en dan de ID ervan onthouden. 
 * - De Grading engine moet met zijn eigen objecten worden aangesproken. 
 */


/**
 * The result of a grading action
 */
class GradingResult {
    public $score;      /* The project score, can later be translated to A, B, C, FAIL */
    public $remarks;    /* Array of remarks */
}

/**
 * The indicator object
 */
class Indicator {
    public $id;                 /* The ID of this indicator */
    public $score;              /* The score of an indicator */
    public $weight;             /* The weight of an indicator */
}

/**
 * The subcompetence object 
 */
class SubCompetence {
    public $id;                 /* The ID of the subcompetence */
    public $indicators;         /* The Indicator in this subcompetence */
    public $weight;             /* The weight of this subcompetence */
    public $score;              /* The calculated score */
}

/**
 * The competence object
 */
class Competence {
    public $id;                 /* The ID of the competence */
    public $subcompetences;     /* The SubCompetences in this competence */
    public $weight;             /* The weight of this subcompetence */
    public $score;              /* The calculated score */
}

/**
 * The rule object
 */
class Rule {
    public $type;               /* Does this work on INDICATOR, SUBCOMP or COMP? */
    public $id;                 /* The id of the item it works on */
    public $operator;           /* The comparison binary operator */
    public $value;              /* The value to compare with */
}

/**
 * The guts of the grader engine. 
 */
class GradingEngine {
    
    /*
     * Calculate grading result and give back result in a 
     * GradingResult object.
     * @param $competences: an array of Competence objects. 
     * @
     */
    public static function gradeProject($competences, $rules) {
        
    }
}

?>