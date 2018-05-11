<?php
/**
 * Class Notifier
 *
 * Notify managemnt fro new error assignment
 *
 * @package classes
 * @category Custom class
 * @author  Rosario Carvello - rosario.carvello@gmail.com
 */
namespace classes;

use models\beans\BeanEmployee;
use models\beans\BeanErrorsAssignment;
use models\beans\BeanJob;
use models\beans\BeanSkill;
use models\beans\BeanUser;

class Notifier extends \mysqli
{
    private $targets;
    private $htmlMmessage;
    private $allowEmailSend = false;
    private $success = false;
    public $debug = true;


    public function __construct()
    {
        $this->htmlMmessage = file_get_contents(RELATIVE_PATH ."templates/hr/assessment/mail_message.html");
        parent::__construct(DBHOST,DBUSER,DBPASSWORD,DBNAME);
        $this->loadTargets();
    }

    /**
     * Load error assignment for the error id and job id.
     *
     * @param int $errorId
     * @param int $jobId
     */
    public function loadAssignment($errorId,$jobId)
    {
       $error = new BeanErrorsAssignment($errorId);
       $job = new BeanJob($jobId);
       $skill = new BeanSkill($error->getIdSkill());
       $employee = new BeanEmployee($error->getIdEmployee());
       $assessor = new BeanUser($error->getAssignedBy());
       $message = $this->htmlMmessage;
       $message = str_replace( "{EmployeeName}", $employee->getLastName() . " " . $employee->getFirstName(),$message);
       $message = str_replace( "{JobName}", $job->getName(),$message);
       $message = str_replace( "{SkillName}", $skill->getName(),$message);
       $message = str_replace( "{Description}", str_replace("\n","<br>",$error->getDescription()),$message);
       $message = str_replace( "{ErrorsResult}", "<b>TWTTP</b>: " . $error->getTwttpResult() . "&nbsp;&nbsp;<b>HERCA</b>: " . $error->getHercaResult() ,$message);
       $message = str_replace( "{ErrroId}", $error->getIdAssignment(),$message);
       $message = str_replace( "{Assessor}", $assessor->getFullName(),$message);
       $timestamp = strtotime($error->getAssignmentDate());
       $message = str_replace( "{AssessmentDate}", date("d-m-Y",$timestamp),$message);
       $this->htmlMmessage = $message;
       $idAssignment = $error->getIdAssignment();
       $idJob = $job->getIdJob();
       if (!empty($this->targets) && !empty($idAssignment) && !empty($idJob) )
           $this->allowEmailSend = true;
    }

    /**
     * Notifie error
     */
    public function notifyError()
    {
        if (!$this->debug && $this->allowEmailSend) {
            $subject = 'Notifica nuovo assegnamento errore';
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=utf-8';
            $headers[] = 'From: Postmaster <postmaster@cmsapps.it>';
            $this->success = mail($this->targets, $subject, $this->htmlMmessage, implode("\r\n", $headers));
        }
    }

    /**
     * Gets notyfy status
     * @return string
     */
    public function getNotifyStatus()
    {
        // $this->success=true;
        if ($this->success && !$this->debug && $this->allowEmailSend){
            return "{RES:SendMailSucces}" . "<br>" . str_replace(",","<br>",$this->targets);
        } elseif (!$this->success && !$this->debug && $this->allowEmailSend){
            return "{RES:SendMailFailure}";
        } elseif (!$this->allowEmailSend && !$this->debug) {
            return "{RES:NoTargetsToNotify}";
        } elseif ($this->debug) {
          return '<a href="#" id="notify-link">{RES:MessageLink}</a> <div id="message" class="hide">' . $this->htmlMmessage . '</div>';
        }
    }

    private function loadTargets()
    {
        $sql = "SELECT * FROM user WHERE id_access_level=60";
        $result = $this->query($sql);
        if ($result->num_rows>0){
            while($target = $result->fetch_object()){
                $this->targets .= $target->email .",";
            }
            $this->targets = substr($this->targets,0,-1);
        }
    }

}