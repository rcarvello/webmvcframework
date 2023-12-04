## Subsystem examples

Into WebMVC package you will find different examples of source code located under the `examples` subfolder.
They give you a demonstration of the main WebMVC functionalities, as well as, how to organize software into subsystems.
Subsystems of the provided examples are organized as follow:

* `examples` - which is the main subsystem
*
    * `about` - it contains a simple demonstration of coding a source code information helper
*
    * `cms` - this subsystem contains general examples about how showing contents by using WebMVC
*
    * `db` - this subsystem contains some DB related examples

Below is the directory/files structure:

![Exaple](https://github.com/rcarvello/webmvcframework/blob/master/docs/wiki_resource/examples_folders-controllers.png).  
Rember that, due to the MVC design pattern, you will find a replica of `examples` folders/files structure also
under `models`, `views` and, `templates` folders.

You can run a demo from [here](https://www.webmvcframework.com/)

## Conclusion

As we just described in the [previous page](https://github.com/rcarvello/webmvcframework/wiki/Subsystems)
a subsystem, in WebMVC, is identified at two levels:

1. a physical level, by defining a **path** in the file system. For example, the pathname `examples/cms` identify the
   subsystem `cms` which is contained into the main subsystem `examples`;
2. a logical level, by using **namespace** in source code and its name must be equal to filesystem pathname. In this
   case, it is the name `examples/cms` and must be equal to its pathname. Namespaces are used in source code for
   structuring and organizing naming conflicts.

> So, for each subsystem, WebMVC uses a directory for physically storing of all its classes and uses a namespace to
> refer each class when it needs to be instantiated and executed; **directories and namespaces must have identical names**
> that are conventionally written in lowercase.

> In conclusion, you need to take in mind that there are two decomposition levels when writing code with WebMVC:
> * First is the MVC decomposition (directories: controllers, models, views and templates)
> * Second is provided by the application subsystems, that is a folders/files structure you need to replicate within the
    controllers, models, views, as well as, for the templates directory.  
    Also, remember that the directory controllers are the root directory from which all application controllers for the
    defined subsystems can be invoked. This is because in WebMVC the directory controllers are the entry point to access
    application software functionalities.

> Inside all levels live WebMVC assemblies. An assembly is represented by a logical name you need to choose to identify
> the aggregation of the classes for Model, View, and, Controller and also for the HTML. Then when you coding classes for
> Model, View, and, Controller and also for the HTML you can use the same logical name for storing these files.

