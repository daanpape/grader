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
    public $count;              /* Number of times an indicator got judged */
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

class Document {
    public $id;
    public $name;
    public $nrDocuments;
    public $notSubmitted;
    public $result;
}

/**
 * The guts of the grader engine. 
 */
class GradingEngine {

    public $documentArray;

    public static function createProjectStructure($structure)
    {
        $projectStructure = array();
        foreach($structure as $competence)
        {
            $newCompetence = new Competence();
            $newCompetence->id = $competence->id;
            $newCompetence->weight = $competence->weight;
            $newCompetence->description = $competence->description;
            $newCompetence->score = 0;
            $newCompetence->subcompetences = array();
            foreach($competence->subcompetences as $subcompetence)
            {
                $newSubcompetence = new SubCompetence();
                $newSubcompetence->id = $subcompetence->id;
                $newSubcompetence->weight = $subcompetence->weight;
                $newSubcompetence->description = $subcompetence->description;
                $newSubcompetence->score = 0;
                $newSubcompetence->indicators = array();
                foreach($subcompetence->indicators as $indicator)
                {
                    $newIndicator = new Indicator();
                    $newIndicator->id = $indicator->id;
                    $newIndicator->weight = $indicator->weight;
                    $newIndicator->description = $indicator->description;
                    $newIndicator->score = 0;
                    $newIndicator->count = 0;
                    //array_push($newSubcompetence->indicators, $newIndicator);
                    $newSubcompetence->indicators[$newIndicator->id] = $newIndicator;
                }
                //array_push($newCompetence->subcompetences, $newSubcompetence);
                $newCompetence->subcompetences[$newSubcompetence->id] = $newSubcompetence;
            }
            //array_push($projectStructure, $newCompetence);
            $projectStructure[$newCompetence->id] = $newCompetence;
        }
        return $projectStructure;
    }

    public static function calculateIndicatorPoints(&$projectStructure,$score)
    {
        // Calculate indicator points

        foreach($score as $point)
        {
            $projectStructure[$point['competence']]->subcompetences[$point['subcompetence']]->indicators[$point['indicator']]->score += $point['score'];
            $projectStructure[$point['competence']]->subcompetences[$point['subcompetence']]->indicators[$point['indicator']]->count++;
        }

        // Calculate the average score of indicator (total / count )

        foreach($projectStructure as $competence)
        {
            foreach($competence->subcompetences as $subcompetence)
            {
                foreach($subcompetence->indicators as $indicator)
                {
                    $indicator->score = ceil($indicator->score / $indicator->count);
                }
            }
        }
    }

    public static function calculateFinalScoreWithoutRules(&$projectStructure)
    {
        // Calculate the weighted arithmetic mean

        $totalScore = 0;
        $totalWeight = 0;
        foreach($projectStructure as $competence)
        {
            $competenceScore = 0;
            $competenceWeight = 0;
            foreach($competence->subcompetences as $subcompetence)
            {
                $score = 0;
                $weight = 0;
                foreach($subcompetence->indicators as $indicator)
                {
                    $score += $indicator->score * $indicator->weight;
                    $weight += $indicator->weight;
                }
                $subcompetence->score = ceil($score / $weight);

                $competenceScore += $subcompetence->score * $subcompetence->weight;
                $competenceWeight += $subcompetence->weight;
            }
            $competence->score  = ceil($competenceScore / $competenceWeight);

            $totalScore += $competence->score * $competence->weight;
            $totalWeight += $competence->weight;
        }

        // Final Point for project without rules

        $finalScore = ceil($totalScore / $totalWeight);

        return $finalScore;
    }

    public static function applyRule(&$finalScore,$rule)
    {
        if($finalScore > $rule->result)
        {
            $finalScore = $rule->result;
        }
    }

    public static function checkRules(&$projectStructure,$rules,$documents,&$finalScore)
    {
        // Check if rules are broken

        foreach($rules as $rule) {
            if ($rule->action['subject'] == "subcompetence") {
                if ($rule->operator == '<') {
                    foreach ($projectStructure as $competence) {
                        foreach ($competence->subcompetences as $subcompetence) {
                            if ($rule->action['id'] == $subcompetence->id) {
                                if ($subcompetence->score < $rule->value) {
                                    GradingEngine::applyRule($finalScore,$rule);
                                }
                            }
                        }
                    }
                } elseif ($rule->operator == '>') {
                    foreach ($projectStructure as $competence) {
                        foreach ($competence->subcompetences as $subcompetence) {
                            if ($rule->action['id'] == $subcompetence->id) {
                                if ($subcompetence->score > $rule->value) {
                                    GradingEngine::applyRule($finalScore,$rule);
                                }
                            }
                        }
                    }
                }
            } elseif ($rule->action['subject'] == "competence") {
                if ($rule->operator == '<') {
                    foreach ($projectStructure as $competence) {
                        if ($rule->action['id'] == $competence->id) {
                            if ($competence->score < $rule->value) {
                                GradingEngine::applyRule($finalScore,$rule);
                            }
                        }
                    }
                } elseif ($rule->operator == '>') {
                    foreach ($projectStructure as $competence) {
                        if ($rule->action['id'] == $competence->id) {
                            if ($competence->score > $rule->value) {
                                GradingEngine::applyRule($finalScore,$rule);
                            }
                        }
                    }
                }
            } elseif ($rule->action['subject'] == "indicator") {
                if ($rule->operator == '<') {
                    foreach ($projectStructure as $competence) {
                        foreach ($competence->subcompetences as $subcompetence) {
                            foreach ($subcompetence->indicators as $indicator) {
                                if ($rule->action['id'] == $indicator->id) {
                                    if ($indicator->score < $rule->value) {
                                        GradingEngine::applyRule($finalScore,$rule);
                                    }
                                }
                            }
                        }
                    }
                } elseif ($rule->operator == '>') {
                    foreach ($projectStructure as $competence) {
                        foreach ($competence->subcompetences as $subcompetence) {
                            foreach ($subcompetence->indicators as $indicator) {
                                if ($rule->action['id'] == $indicator->id) {
                                    if ($indicator->score > $rule->value) {
                                        GradingEngine::applyRule($finalScore,$rule);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function calculateFinalScoreWithDocuments($documents,$allDocuments)
    {
        $documentWeight = 0.0;

        foreach($allDocuments as $allDocument)
        {
            $singleWeight = $allDocument['weight'] / $allDocument['nr_documents'];
            $documentWeight = $documentWeight + ($singleWeight * $allDocument['not_submitted']);

            $doc = new Document();
            $doc->id = $allDocument['id'];
            //$doc-name = $allDocument->
            //$doc->nrDocuments;
            //$doc->notSubmitted;
            //$doc->result;

            //$this->documentArray[$count] = new Document()
        }

        foreach($documents as $document)
        {
            $singleWeight = $document->weight / $document->nr_documents; // 12,5
            $singleDocumentWeight = 100 / $singleWeight; // 8

            $documentScore = $document->score / $singleDocumentWeight; // 6,25

            $finalDocumentScore = $singleWeight - $documentScore; // 12,5 - 6,25 = 6,25

            $documentWeight = $documentWeight + $finalDocumentScore;
            error_log("New Data: ".$documentScore,0);
        }

        return $allDocuments;
    }

    /*
     * Calculate grading result and give back result in a 
     * GradingResult object.
     * @param $competences: an array of Competence objects. 
     * @
     */
    public static function gradeProjectForStudent($structure, $score, $rules, $documents, $allDocuments) {

        $projectStructure = GradingEngine::createProjectStructure($structure);

        GradingEngine::calculateIndicatorPoints($projectStructure,$score);

        $finalScore = GradingEngine::calculateFinalScoreWithoutRules($projectStructure);
        $documentWeight = 0;
        //$documentWeight = GradingEngine::calculateFinalScoreWithDocuments($documents,$allDocuments);

        //$finalScore = $finalScore - $documentWeight;

        foreach($rules as $rule)
        {
            if($rule->action['subject'] == "totalDocument")
            {
                if($rule->operator == ">")
                {
                    if($documentWeight > $rule->value)
                    {
                        GradingEngine::applyRule($finalScore,$rule);
                    }
                }
                else if($rule->operator == "<")
                {
                    if($documentWeight < $rule->value)
                    {
                        GradingEngine::applyRule($finalScore,$rule);
                    }
                }
            }
        }

        GradingEngine::checkRules($projectStructure,$rules,$documents,$finalScore);

        $finalScoreProject = new Competence();
        $finalScoreProject->id = "0";
        $finalScoreProject->weight = "100";
        $finalScoreProject->score =  ceil($finalScore);
        $finalScoreProject->description = "Final score";

        $projectStructure[0] = $finalScoreProject;

        return GradingEngine::calculateFinalScoreWithDocuments($documents,$allDocuments);
        //return $finalScore;

        // Add final score to projectstructure

        //return $projectStructure;
    }
}

?>