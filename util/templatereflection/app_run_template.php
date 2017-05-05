<?php
include_once("TemplateReflection.php");
$templateReflection = new TemplateReflection("standard_bootstrap_template.html");
$blocks = $templateReflection->getBlocks();
echo "<pre>";
 print_r($templateReflection->getComponents());
echo "</pre>";
echo "<pre>";
print_r($blocks);
echo "</pre>";
