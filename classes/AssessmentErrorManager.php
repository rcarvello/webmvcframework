<?php
/**
 * Class AssessmentErrorManager
 *
 * Handles some error assignment operations for Employee skill
 *
 * @package classes
 * @category Custom class
 * @author  Rosario Carvello - rosario.carvello@gmail.com
 */

namespace classes;

use models\beans\BeanErrorsAssignment;

class AssessmentErrorManager extends \mysqli
{

    private $errorsCount;
    private $lastErrorAssignment;
    private $errorCaption;
    private $errorCSSClass;
    private $errorLink;

    /**
     * Gets link of error record
     * @return string
     */
    public function getErrorLink()
    {
        return $this->errorLink;
    }

    /**
     * Gets errors total
     * @return int
     */
    public function getErrorsCount()
    {
        return $this->errorsCount;
    }

    /**
     * Gets last error assignment id
     * @return int
     */
    public function getLastErrorAssignment()
    {
        return $this->lastErrorAssignment;
    }

    /**
     * Gets error captions
     * @return string
     */
    public function getErrorCaption()
    {
        return $this->errorCaption;
    }

    /**
     * Gets error CSS class
     * @return string
     */
    public function getErrorCSsClass()
    {
        return $this->errorCSSClass;
    }


    /**
     * AssessmentErrorManager constructor.
     * @param int $idEmployee
     * @param int $idJob
     * @param int $idSkill
     */
    public function __construct($idEmployee,$idJob,$idSkill)
    {
        parent::__construct(DBHOST,DBUSER,DBPASSWORD,DBNAME);
        $sql = <<<SQL
        SELECT  
            MAX(id_assignment) as id_assignment,
            COUNT(id_assignment) as errors_count,
            id_employee,
            id_skill
        FROM 
            errors_assignment
        GROUP BY
           id_employee,id_skill
        HAVING
            id_employee=$idEmployee
            AND
            id_skill=$idSkill;
SQL;
        $result = $this->query($sql);
        if($result){
            $row = $result->fetch_object();
            @$this->errorsCount = $row->errors_count;
            @$this->lastErrorAssignment = $row->id_assignment;
            $error = new BeanErrorsAssignment($this->lastErrorAssignment);
            $twttp = $error->getTwttpResult();
            $herca = $error->getHercaResult();
            $this->errorLink= SITEURL . "/hr/assessment/error_record/open/" . $this->lastErrorAssignment. "/$idEmployee/$idJob/$idSkill";
            if ($twttp =="ko") {
                $this->errorCaption = "ko";
                $this->errorCSSClass = "danger";
            } elseif ($twttp =="ok" && !empty($herca)){
                $this->errorCaption = $herca;
                $this->errorCSSClass="warning";
            } elseif ($twttp == "ok" && empty($herca)) {
                $this->errorCaption = "ok";
                $this->errorCSSClass="warning";
            } else {
                $this->errorCaption = '<span class="glyphicon glyphicon-remove-sign"></span>';
                $this->errorCSSClass="default";
                $this->errorLink= SITEURL . "/hr/assessment/error_record/add/$idEmployee/$idJob/$idSkill";
            }
        }
    }

}