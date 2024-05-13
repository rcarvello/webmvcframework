<?php
/**
 * Uploader
 * Handling PHP uploads
 * Usage example:
 *
 *     $uploader   =   new Uploader();
 *     $uploader->setDir('uploads/images/');
 *     $uploader->setExtensions(array('jpg','jpeg','png','gif'));  // allowed extensions list //
 *     $uploader->setMaxSize(.5);                                  // set max file size to be allowed in MB //
 *       if($uploader->uploadFile('txtFile')) {          // txtFile is the filebrowse element name //
 *               $image  =   $uploader->getUploadName(); // get uploaded file name, renames on upload //
 *       } else {   //upload failed
 *              $uploader->getMessage(); //get upload error message
 *       }
 *
 * @package framework/classes
 * @filesource framework/classes/Uploader.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2024 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\classes;

class Uploader
{
    private $destinationPath;
    private $errorMessage;
    private $extensions;
    private $allowAll;
    private $maxSize;
    private $uploadName;

    public $name = 'Uploader';
    private $sameFileName;
    private $sameName;
    private $imageSeq;


    function setDir($path)
    {
        $this->destinationPath = $path;
        $this->allowAll = false;
    }

    function allowAllFormats()
    {
        $this->allowAll = true;
    }

    function setMaxSize($sizeMB)
    {
        $this->maxSize = $sizeMB * (1024 * 1024);
    }

    function setExtensions($options)
    {
        $this->extensions = $options;
    }

    function setSameFileName()
    {
        $this->sameFileName = true;
        $this->sameName = true;
    }

    function getExtension($string)
    {
        $ext = "";
        try {
            $parts = explode(".", $string);
            $ext = strtolower($parts[count($parts) - 1]);
        } catch (\Exception $c) {
            $ext = "";
        }
        return $ext;
    }

    function setMessage($message)
    {
        $this->errorMessage = $message;
    }

    function getMessage()
    {
        return $this->errorMessage;
    }

    function getUploadName()
    {
        return $this->uploadName;
    }

    function setSequence($seq)
    {
        $this->imageSeq = $seq;
    }

    function getRandom()
    {
        return strtotime(date('Y-m-d H:i:s')) . rand(1111, 9999) . rand(11, 99) . rand(111, 999);
    }

    function sameName($true)
    {
        $this->sameName = $true;
    }

    function uploadFile($fileBrowse)
    {
        $result = false;
        $size = $_FILES[$fileBrowse]["size"];
        $name = $_FILES[$fileBrowse]["name"];
        $ext = $this->getExtension($name);
        if (!is_dir($this->destinationPath)) {
            $this->setMessage("Destination folder is not a directory ");
        } else if (!is_writable($this->destinationPath)) {
            $this->setMessage("Destination is not writable !");
        } else if (empty($name)) {
            $this->setMessage("File not selected ");
        } else if ($size > $this->maxSize) {
            $this->setMessage("Too large file !");
        } else if ($this->allowAll || (!$this->allowAll && in_array($ext, $this->extensions))) {

            if ($this->sameName == false) {
                $this->uploadName = $this->imageSeq . "-" . substr(md5(rand(1111, 9999)), 0, 8) . $this->getRandom() . rand(1111, 1000) . rand(99, 9999) . "." . $ext;
            } else {
                $this->uploadName = $name;
            }
            if (move_uploaded_file($_FILES[$fileBrowse]["tmp_name"], $this->destinationPath . $this->uploadName)) {
                $result = true;
            } else {
                $this->setMessage("Upload failed , try later !");
            }
        } else {
            $this->setMessage("Invalid file format !");
        }
        return $result;
    }

    function deleteUploaded()
    {
        unlink($this->destinationPath . $this->uploadName);
    }

}