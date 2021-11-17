
------------------------------------------------------------
//Setting up mysql database
------------------------------------------------------------
Be sure to name the database and project folder correctly.

//Database name
Create a new database named "roadrunner" in Phpmyadmin.
Then, import the sql file included in the project folder.

If database is created with a different name, open the file
application-->config-->database.php

and look for the line

'database' => ''

Replace 'roadrunner' with the new database name.



------------------------------------------------------------
//Project folder name
Check if the website runs with proper formatting.

If things look broken, check
application-->config-->config.php

for

$config['base_url']

base_url should be the same as project folder name


------------------------------------------------------------
//About the folder structure of this project
------------------------------------------------------------

Default folders for Codeigniter is "models", "views" and "controllers" under application folder

But we have made changes to Codeigniter's core config files
to adapt to the Application Layer and Business Services Layer structure.
-application\core\MY_Loader.php
-system\core\Loader.php
-system\core\CodeIgniter.php

You can find the changes by using the ctrl + f function in your text editor by searching for
"Application Layer" and "Business Services Layer"

In addition to that, we made routes in application\config\routes.php to tell where to look for the controllers. The default behaviour in Codeigniter is to look for all controllers in the "controllers" folder. However using routes to reroute controllers is a very common use case to adapt the framework to the developer's project folder structure.





------------------------------------------------------------
//Application Layer and Business Services Layer
------------------------------------------------------------
All views are inside Application Layer, whereas controllers and models are inside Business Services Layer


In Application Layer:
Each package contains views related to the module.
Each view is only "main_content" of the entire page as a whole.
So, this means there is no need to maintain tens of html headers, navigation bars, scripts in every view.


//template package

template package holds sections of html that are important for loading all pages.
- header.php holds the opening <html>, <head>, <body> and scripts.
- template.php gives instruction on which files to load and the order they are to be loaded
	->$main_content in template.php is the file name passed from the controller.
You can open and check template.php yourself to see how it works.
- footer.php contains the html footer and closing </body, </html> tags
- nav1 through nav4 are the navigation bars for different user types


In Business Services Layer:
All packages except for User Data contain controllers related to the package name.
All of our models are stored in User Data.

Controllers are denoted with only a single word, starting with a capital letter
Models are denoted with a starting capital letter followed by _model.

Page.php is the default controller in Codeigniter. This is the controller that will be called when the base url (localhost/roadrunner) is called. Default controller cannot be moved out of the default controller folder (Business Services Layer) or rerouted because that will cause an error.


