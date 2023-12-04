## Introduction

The code described in the [previous example](https://github.com/rcarvello/webmvcframework/wiki/View) shows in the
browser the static web page designed in the file `home.html.tpl`. Now, consider the typical situation where you have to
manage dynamic web pages.   
In this section, we expose a structure for defining dynamic content by using some static entities designed into the
Template. The static structure we are going to present will be later managed by the View for generating dynamic pages.

## Dynamic Content

Pages with dynamic content, have the information contained in the pages that change automatically, generally, the
changes are based on the contents of variables, arrays or database.   
WebMVC handles the dynamic content of web pages firstly by giving it a static representation in the Template. For this
purpose WebMVC use two elementary elements:

* Placeholder
* Block

Then it uses some features provided by the View for transforming the static representation of placeholders and
blocks into dynamic content.

## Understanding Placeholders

A placeholder is rather than a simple string enclosed with braces, which is located somewhere in the template.   
For example to define a placeholder named "UserName" located somewhere in the previous `templates\home.html.tpl` see the
code below:

```html
<!DOCTYPE html>
<html>
  <head>
    <title>Site home page</title>
  </head>
  <body>
    <p>Welcome to the site Home Page</p>
    <br />
    <p>Welcome {UserName}</p>
  </body>
</html>
```

The static output of a template like this is:

![placeholder](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/placeholder.png)

As you can guess from the output, we built a static structure that predisposes the dynamically showing of a username.

The role of a placeholder is to statically represent a place inside the HTML page where a value will be dynamically
shown at run-time by the View. In other terms, a placeholder, at run-time, is bound to a value.

> Note that placeholder doesn't invalidate HTML syntax. It doesn't introduce any new tags or pseudo code. It'is a simple
> string enclosed in braces.

**Important**: For naming a placeholder you don't must use space or starting the name with a number.

We will give you some practical examples on
the [next page](https://github.com/rcarvello/webmvcframework/wiki/Handling-placeholders) about the dynamic handling of
placeholders by using the Template, View, and Controller.

## Special PlaceHolders

WebMVC provides you with some special types of placeholders you can define at design time rather than assign them a
value at runtime. These special types are:

* GLOBAL placeholders
* RESOURCE placeholders

**Global placeholders** are simply PHP constants in the format, `GLOBAL_constant-name ` you can define into a special
framework configuration file: `config\globals.config.php` (pay attention to the comments)

```php
<?php
/**
 * gobals.config.php
 *
 * Main application global placeholders.
 * Scope and use:
 * A global placeholder can be used inside a template with the following
 * notation:{GLOBAL:PLACEHOLDER_NAME}. Template engine will replace it
 * automatically with its corresponding value.
 * Define:
 * A global placeholder is a common PHP defined constant that must be prefixed
 * with GLOBAL_.
 *
 * @filesource global.config.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

define("GLOBAL_SITEURL","http://localhost");
define("GLOBAL_WELCOMEMESSAGE","Welcome");

```

For example, if you design the placeholder `{GLOBAL:WELCOMEMESSAGE}` inside a template, at runtime WebMVC automatically
will assign to it the value of "Welcome".
On [this page](https://github.com/rcarvello/webmvcframework/wiki/Nesting-of-blocks#nesting-of-blocks-for-showing-a-subset-of-shared-values),
you can see in action an usage example of `{GLOBAL:SITEURL}` for automatically getting the website root URL.

**Resource placeholders** are designed for handling multi-language translations. We will discuss them
on [this page](https://github.com/rcarvello/webmvcframework/wiki/Decomposition-by-Internationalization--and-Localization)
in depth

## Understanding Blocks

A block is a generic HTML text encapsulated inside two special HTML comments. A block, like a placeholder, is also
located somewhere in the template. The content of a block can also contain placeholders.   
For example we now define a block named "Users" located somewhere in a new template
named `templates\user_manager.html.tpl`. See the code below:

```html
<!DOCTYPE html>
<html>
<head>
   <title>Users list</title>
</head>
<body>
   <h1>Users list</h1>
   <table>
      <thead>
         <tr>
            <th>User</th>
            <th>Email</th>
         <tr>
      </thead> 
      <tbody>
         <!-- BEGIN Users -->
         <tr>
            <td>{UserName}</td>
            <td>{UserEmail}</td>
         </tr>
        <!-- END Users -->
      </tbody>
    </table>
</body>
</html>
```

The static output of this template is:

   <h1>Users list</h1>
   <table>
      <thead>
         <tr>
            <th>User</th>
            <th>Email</th>
         <tr>
      </thead> 
      <tbody>
         <!-- BEGIN Users -->
         <tr>
            <td>{UserName}</td>
            <td>{UserEmail}</td>
         </tr>
        <!-- END Users -->
      </tbody>
    </table>

As you can guess from the output we built a static structure that predisposes the creation of a user list highlighting,
for each user, name, and email.

A block has different roles. Statically it just represents a place inside the HTML page where live some text. This text
may be characterized by any type of HTML/CSS/JavaScript code, also containing placeholders. At run-time, the View can
perform many actions against a block by doing different purposes to its text:

* It can dynamically assign values to its placeholders
* It can dynamically repeat N times its static text content
* It can dynamically repeat N times its static text by dynamically assigning, at each repetition, some values to
  placeholders which it contains
* It can dynamically replace its text content with another one
* It can hide its text

> Note that block doesn't invalidate HTML syntax. It doesn't introduce any new tags. It is text/HTML code enclosed in
> HTML comments.

**Important**: For naming a block you don't must use space or starting the name with a number.

A block can also contain nested block. See the `templates\user_skills_manager.html.tpl` template below:

```html
<!DOCTYPE html>
<html>
<head>
   <title>Users list</title>
</head>
<body>
   <h1>Users list</h1>
   <table>
      <thead>
         <tr>
            <th>User</th>
            <th>Email</th>
            <th>Skills</th>
         <tr>
      </thead> 
      <tbody>
         <!-- BEGIN Users -->
         <tr>
            <td>{UserName}</td>
            <td>{UserEmail}</td>
            <td>
               <ul>
                  <!-- BEGIN UserSkills -->
                  <li>{UserSkillName}</li>
                  <!-- END UserSkills -->
               </ul>
            </td>
         </tr>
        <!-- END Users -->
      </tbody>
    </table>
</body>
</html>
```

The static output is:
   <h1>Users list</h1>
   <table>
      <thead>
         <tr>
            <th>User</th>
            <th>Email</th>
            <th>Skills</th>
         <tr>
      </thead> 
      <tbody>
         <!-- BEGIN Users -->
         <tr>
            <td>{UserName}</td>
            <td>{UserEmail}</td>
            <td>
               <ul>
                  <!-- BEGIN UserSkills -->
                  <li>{UserSkillName}</li>
                  <!-- END UserSkills -->
               </ul>
            </td>
         </tr>
        <!-- END Users -->
      </tbody>
    </table>   

As you can guess from the output we built a static structure that predisposes the creation of a users list,
highlighting, for each user, name, email and more a bulleted list of skills.

> By using blocks, placeholders, and the View you will able to implement different types of the dynamism of web pages,
> such as data tables, numbered and unnumbered lists, options select, divs repetition, content hiding and much more.

We will give you some practical examples on
the [block page](https://github.com/rcarvello/webmvcframework/wiki/Handling-blocks) about the dynamic handling of blocks
and placeholders.

## Summary

You learned that, before beginning to generate dynamic content, WebMVC requires you must give a static representation of
it by using Placeholders and Blocks.

## Whats next

In the [next section](https://github.com/rcarvello/webmvcframework/wiki/Handling-placeholders), we start to speak how a
View can dynamically assign some values to the static content of placeholder 