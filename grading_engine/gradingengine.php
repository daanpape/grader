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
    public $sign;               /* The sign of the percent */
    public $percent;            /* The percent that gets added or subtracted of the action  */
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
    public static function gradeProjectForStudent($structure, $score, $rules) {

        // Create rule objects
        $projectRules = array();
        foreach($rules as $rule)
        {
            $newRule = new Rule();
            $newRule->type = $rule->action['subject'];
            $newRule->id = $rule->action['id'];
            $newRule->operator = $rule->operator;
            $newRule->value = $rule->result;
            $newRule->sign = $rule->sign;
            $newRule->percent = $rule->value;
            array_push($projectRules, $newRule);
        }

        // Calculate project structure
        $projectStructure = array();
        foreach($structure as $competence)
        {
            $newCompetence = new Competence();
            $newCompetence->id = $competence->id;
            $newCompetence->weight = $competence->weight;
            $newCompetence->subcompetences = array();
            foreach($competence->subcompetences as $subcompetence)
            {
                $newSubcompetence = new SubCompetence();
                $newSubcompetence->id = $subcompetence->id;
                $newSubcompetence->weight = $subcompetence->weight;
                $newSubcompetence->indicators = array();
                foreach($subcompetence->indicators as $indicator)
                {
                    $newIndicator = new Indicator();
                    $newIndicator->id = $indicator->id;
                    $newIndicator->weight = $indicator->weight;
                    array_push($newSubcompetence->indicators, $newIndicator);
                }
                array_push($newCompetence->subcompetences, $newSubcompetence);
            }
            array_push($projectStructure, $newCompetence);
        }

        // Calculate indicator points
        return $projectStructure[0];





    }
}

?>