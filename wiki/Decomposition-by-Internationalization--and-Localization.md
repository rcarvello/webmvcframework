## Introduction

Definitions about internationalization and localization are:

_Internationalization_
> 1) Commerce: The growing tendency of corporations to operate across national boundaries.
>   2) Marketing and Computing: An approach to designing products and services that are easily adaptable to different
       cultures and languages.

_Localization_
> The practice of adjusting a product's functional properties and characteristics to accommodate the language, cultural,
> political, and legal differences of a foreign market or country.

Like other frameworks, WebMVC provides support to write software applications aiming at reaching a larger audience by
means of internationalization and localization. Definition 2) of internationalization is interpreted in WebMVC how the
capability to build, with little effort, the GUI of software in different natural languages. This capability allows the
presentation of your application to people of different nations or with specific visualization requirements.

The term localization is the counterpart of internationalization. Having a product or service that is ready for the
international market, with the term localization we refer to the process that adapts a product or service to meet the
needs of a language, culture, or desired population’s “look-and-feel”. From one side, we can say that the
internationalization focuses on the structure of your application because it builds several static contents ready to
serve people of different nations or cultures. On the other side, the localization process places a user within a
context that is near, familiar, and easy to use. It can be regarded as a dynamic aspect that restricts the wide context
of a multilinguistic application to the smaller context suitable for the user. It is trivially to observe that the most
important part of a localization process is the translation of a word or a text from one language to another, but
localization is a bit more. For example, a message could be written in a completely different manner when we write it
for a nation rather than another one, even if the message conveys the same semantics.

## Internationalization and Localization How To

These aspects are considered by WebMVC by means of a standard way to build multilanguage applications.

In the following figure, we show an example
of [WebMVC Assembly](https://github.com/rcarvello/webmvcframework/wiki/Understanding-WebMVC#insights-webmvc-assembly),
named **Localization**, that manages a GUI capable to shift the language from a page written in English to a page
written in Italian. The showed example is taken from examples we provide with the framework and it is located
under `examples/cms/localization` path of `controllers`, `models`, `views`, and `templates` directories.

So, by assuming your server is `localhost` and your project root is `webmvcframwork`, by
running `https://localhost/webmvcframework/examples/cms/localization?locale=en` the output will be showned in **English
**:

![Sample GUI using WebMVC localization_en](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/locale_gui_en.png)

By running `https://localhost/webmvcframework/examples/cms/localization?locale=it-t` the output will be showned in *
*Italian**:

![Sample GUI using WebMVC localization_it](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/locale_gui_it.png)

Note we used a URL parameter `locale` with a given value `en` or `it-it` to apply respectively English or Italian
translation of the content.

By running `https://localhost/webmvcframework/examples/cms/localization`, without `locale` parameter, the output will be
showned in the default browser language:

WebMVC manages the technicalities of internationalization/localization providing the folder `locales` where resource
files containing the presentation content can be placed in different subfolders, one for each natural language. Again,
the folder locales have to reflect the structure of system decomposition that we made for our
project `examples/cms/controllers`.   
The following image shows the files structure for `controllers`, `models`, `views`, `templates`, and `locales`

![locales](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/locale_folders.png)

As you can see, insides the folders locales (the blue box) you need to reflect the same system decomposition assigned to
the `controllers` folder (the red box, as well as `models`, `views`, and `templates`).  
In the blu box, the directories `en` and `it-it` contain the resource files for the translation of the content shown in
GUI. In particular, for the welcome page managed by the
controller `https://localhost/webmvcframework/examples/cms/localization`, the following files:

`locales/en/application.txt ` and `locales/it-it/application.txt`

contain a list of the resource identifiers that will be used to respectively translate, in English or Italian, and that
could also be shared among all controllers of your application

whereas the following files:

`locales/en/controllers/Localization.txt` and `locales/it-it/controllers/Localization.txt`

contain a list of the resource identifiers that will be used to respectively translate, in English or Italian, the page
content managed by the controller `controllers/examples/cms/Localization.php`.

By now, to show you as the resource identifiers are organized and managed by WebMVC for applying translations, in the
following sections, we illustrate the content of all .txt files and of the template file.  
Note: we just consider the resource files regarding English because for Italian, as well as for more other languages you
need, logic, structure, and principles are the same.

The code for HTM template file:  `template/examples/cms/localization.html.tpl` is:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Localization example</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{RES:ProjectName}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="">Home</a></li>
                <li><a href="#about">{RES:Contacts}</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{RES:Setting} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">{RES:LanguageSettings}</li>
                        <li><a href="?locale=en">{RES:English}</a></li>
                        <li><a href="?locale=it-it">{RES:Italian}</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">{RES:GuiSettings}</li>
                        <li><a href="">{RES:LookAndFeel}</a></li>
                    </ul>
                </li>
                <li><a href="..">{RES:Exit}</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1>{RES:Welcome}</h1>
    <p>{BodyMessage}</p>
    <p>{RES:InfoMessage}</p>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
```

In the above template we used a new type of placeholders defined by the format `{RES:PlaceHolderName}`.  
In the above HTML code they are:

```
{RES:ProjectName} 
{RES:Contacts}
{RES:Setting} 
{RES:LanguageSettings}
{RES:English}
{RES:Italian}
{RES:GuiSettings}
{RES:LookAndFeel}
{RES:Exit}
{BodyMessage}
{RES:InfoMessage}
and
{RES:Welcome}
```  

Values for this type of placeholders is automatically computed by the framework by using the following criteria:

* Determining the current locale language defined by the given URL parameter `locale` or by the browser default
  language  
  *Appling, to each placeholder, the corresponding value. Any values are phisically stored in an appropriate resource
  file, which is automatically selected by the framework depending on selected language and by the current running
  controller.

So, when we running `https://localhost/webmvcframework/examples/cms/localization?locale=en` WebMVC framework
automatically selects the resource file:

`locales/en/controllers/examples/cms/Localization.txt`, which contains:

```
#Comment:Translations for controller Localization
ProjectName=MRP Management System
Contacts=Contact us
Setting=Settings
LanguageSettings=Language settings
English=English
Italian=Italian
GuiSettings=GUI settings
LookAndFeel=Look and Feel
Exit=Exit (TOC)
InfoMessage=Click Settings->Language settings to change language. Traslations are placed into "locales" folder.
```

as well as the file  `locales/en/applicaton.txt`, which contains:

```
Welcome=Welcome
``` 

As you can note, these resource files selected contain the values for RES type placeholders of the template.

For example, the resource identifier `InfoMessage` is linked to the value ”_Message from the localization file: Click
Settings->Language settings to change language_” that will replace the placeholder `{RES:InfoMessage}` appearing in the
template

Just a bit more of information about the resource file: you can store in the file `application.txt` differents values
that you can be shared among many different controllers or use a specific resource file for a given controller like we
made when using `Localization.txt` for the controller `controllers\example\cms\Localizatio.php`.

Finally, we show you View and Model source code for Localization example

file `models\examples\cms\Localization.php`

```php
<?php
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
            "en"        =>  "This is the page objectContent for english language",
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

        if (isset($_REQUEST[LOCALE_REQUEST_PARAMETER])) {
            $locale = $_REQUEST[LOCALE_REQUEST_PARAMETER];
        }
        return $this->pageBodies[$locale];
    }
}
```

file `views\examples\cms\Localization.php`

```php
<?php

namespace views\examples\cms;

use framework\View;

class Localization extends View
{

    /**
    * Object constructor.
    *
    * @param string|null $tplName The html template containing the static design.
    */
    public function __construct($tplName = null)
    {
        if (empty($tplName))
            $tplName = "/examples/cms/localization";
        parent::__construct($tplName);
    }
    
    /**
    * Sets value for BodyMessage placeholder
    *
    * @param mixed $value
    */
    public function setVarBodyMessage($value)
    {
        $this->setVar("BodyMessage",$value);
    }

}
```