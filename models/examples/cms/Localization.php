<?php
/**
 * Class Localization
 *
 * {ModelResponsability}
 *
 * @package models\examples\cms
 * @category Application Model
 * @author  {AuthorName} - {AuthorEmail}
*/
namespace models\examples\cms;

use framework\Model;

class Localization extends Model
{

    private $pageBodies;

    public function __construct()
    {
        // Simulate a multi language database
        $bodiesDb = array(
            "it-it"     =>  "Questo è il contenuto della pagina per la lingua italiana.",
            "en"        =>  "This is the page content for english language",
        );

        $this->pageBodies = $bodiesDb;
    }

    /**
     *
     * Gets page body
     * @param string $locale string identifying LCID
     * @return string
     */
    public function getBody($locale)
    {

        if ($_REQUEST[LOCALE_REQUEST_PARAMETER])
            $locale = $_REQUEST[LOCALE_REQUEST_PARAMETER];
        return $this->pageBodies[$locale];
    }
}
