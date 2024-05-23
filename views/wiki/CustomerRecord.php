<?php
/**
 * Class CustomerRecord
 *
 * {ViewResponsability}
 *
 * @package controllers
 * @category Application View
 * @author  {AuthorName} - {AuthorEmail}
 */

namespace views\wiki;

use framework\View;

class CustomerRecord extends View
{

    /**
     * Object constructor.
     *
     * @param string|null $tplName The html template containing the static design.
     */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/customer_record";
        parent::__construct($tplName);
    }

    public function initFormFields(\models\wiki\CustomerRecord $model)
    {

        $name = isset($_POST["name"]) ? $_POST["name"] : $model->getName();
        $email = isset($_POST["email"]) ? $_POST["email"] : $model->getEmail();
        $nationality = isset($_POST["nationality"]) ? $_POST["nationality"] : $model->getNationality();
        $assurance = isset($_POST["assurance"]) ? $_POST["assurance"] : $model->getAssurance();
        $customer_id = isset($_POST["customer_id"]) ? $_POST["customer_id"] : $model->getCustomerId();

        $this->setVar("name", $name);
        $this->setVar("email", $email);
        $this->initCustomerNationalities($model->getCustomerNationalitiesList(), $nationality);
        $this->initCustomerAssurances($model->getCustomerAssurancesList(), $assurance);
        $this->setVar("customer_id", $customer_id);

        if (empty($model->getCustomerId())) {
            $this->setVar("Operation", "New Customer");
            $this->hide("EditMode");
        } else {
            $this->setVar("Operation", "Edit Customer");
            $this->hide("AddMode");

        }

        if (!isset($_SESSION["mysql_error"])) {
            $this->hide("DBError");
        } else {
            $this->setVar("Errors", $_SESSION["mysql_error"]);
            unset($_SESSION["mysql_error"]);
        }
    }

    private function initCustomerNationalities($nationalities, $checkedItem = "")
    {
        $this->openBlock("NationalitiesCheckboxes");
        foreach ($nationalities as $nationality) {
            $this->setVar("nationality", $nationality[0]);
            if ($checkedItem == $nationality[0]) {
                $this->setVar("is_checked", "checked");
            } else {
                $this->setVar("is_checked", "");
            }
            $this->setVar("nationality_text", $nationality[1]);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }

    private function initCustomerAssurances($assurances, $selectedIdem = "")
    {
        $this->openBlock("AssuranceOptions");
        foreach ($assurances as $assurance) {
            $this->setVar("assurance", $assurance[0]);
            if ($selectedIdem == $assurance[0]) {
                $this->setVar("is_selected", "selected");
            } else {
                $this->setVar("is_selected", "");
            }
            $this->setVar("assurance_text", $assurance[1]);
            $this->parseCurrentBlock();
        }
        $this->setBlock();
    }
}
