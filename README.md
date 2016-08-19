# CodeIgniter Bootshop User Interface Generator

## Overview

I developed CodeIgniter Bootshop while working at the Beedie School of Business at SFU during a co-op work term. Working on the school's internal web information system, there was a desire to have an integrated system for managing database lookup tables. Most interfaces for managing simple database lookup tables can be categorized as a [Master-Detail](http://en.wikipedia.org/wiki/Master%E2%80%93detail_interface) style interface. the CodeIgniter Bootshop program was designed to reproduce those types of interfaces from a relatively simple script which describes the database tables and the user interface components.

CodeIgniter Bootshop is a program that will generate most of the files needed for a 
new module in a CodeIgniter application. These files include the controller, the model, the
views, and the javascript file. The generated modules also depend on project 
wide assets, including css files, jQuery, and the bootstrap library. 

The advantage of using these scripts in generating a new module is that much of the
generic functionality of a user interface can be reproduced in the generated files. This functionality includes filtering and sorting data, as well as updating, deleting, and creating (CRUD operations) data records. It then becomes possible to be able to focus more closely on 
implementing the specific business requirements of each new module. Having a 
boilerplate generated also gives the added benefit that coding style and 
user interface functions become more consistent and predictable.

## Links

* Fork the project on <a href="https://github.com/sjking/ci-bootshop" target="_blank">GitHub</a>.
* Get the Demo repository <a href="https://github.com/sjking/codeigniter-bootshop-demo" target="_blank">here</a>.

## Tutorial

The following tutorial goes into detail in describing an example module generated using the CodeIgniter Bootshop program. Once it is understood how the generator scripts are used, and how to read them, you will be able to generate the same style of user interface for any similar database tables. To generate a new user interface, we can simply duplicate one of the testing scripts and change the necessary options for our specific database table.

### Directory structure

From the root of the Generator repository, we will be working with the 'Modules/Examples/scripts' folder. This folder contains the testing script used in this tutorial. 

### Setup

It is recommended that you download the demo application <a href="https://github.com/sjking/codeigniter-bootshop-demo" target="_blank">here</a>. This is a CodeIgniter application that has assets installed for running the program. Once the application is installed on a development machine, make sure to edit the `config.ini` file location in the `Modules/Examples` folder, setting the correct absolute paths for the generated files to be put into.

To do the tutorial, we will need to setup a database and some database tables in your development machines MySQL database. The demo CodeIgniter application uses a database called *codeigniter*, a user called *mysqluser*, with a password of *development*. Feel free to modify these if you wish. There is a file called vegetable.sql located in the scripts folder. Import this sql file. After importing you should have two new database tables: vegetable and vegetable_fans. Go ahead and take a look at these tables to familiarize yourself. The vegetable table is a lookup table that the vegetable_fans table uses.

### Filter Table

There is a testing script that generates a simple one-page interfaces that
includes a filter form and a master table view. Each row of the filter table interface can be sorted in ascending or descending order. 

### Running the Script

Login to the development machine. Go to the directory that contains the script and run it:

    $ php -f filter_table_test.php
    Created 8 files:
    /vagrant/sites/codeigniter/application/views/admin/vegetable_filter/vegetable_filter_table_view.php
    /vagrant/sites/codeigniter/application/views/admin/vegetable_filter/vegetable_filter_panel_footer_view.php
    /vagrant/sites/codeigniter/application/views/admin/vegetable_filter/vegetable_filter_panel_header_view.php
    /vagrant/sites/codeigniter/application/views/admin/vegetable_filter/vegetable_filter_filter_panel_view.php
    /vagrant/sites/codeigniter/application/controllers/admin/vegetable_filter.php
    /vagrant/sites/codeigniter/application/views/admin/vegetable_filter/vegetable_filter_view.php
    /vagrant/sites/codeigniter/application/models/vegetable_filter_model.php
    /vagrant/sites/codeigniter/assets/js/vegetable_filter/vegetable_filter_table.js

Now, navigate to the address '/vegetable_filter' in your CodeIgniter application. You should see a new filter table interface.

### Explanation of the Script

In this section we will step through the script file 'filter_table_test.php', and explain how it works. After understanding how this test script works, you should be able to use this script as a template for new scripts to generator interfaces for other database tables.

The first few lines include the necessary Generator driver class. It is also a good idea to use header comments for describing the purpose and reason for the interface. The next few lines set some variable names that define the name of the new interface, as well as the database table name that this interface is for. 

In the section "Main List View data" we are defining the database column names, and the attributes for these columns. These column names are translated as table columns in the interface. In this case, there is four columns: name, occupation, vegetable_id, and vegetable_status. We use the TableColumn class to instantiate new columns. The first parameter of the constructor is the database column name, and the second parameter is an option array of html parameters. In this script, we are passing in class parameter so that we can use bootstraps grid layout feature to size our table columns. We also define the display name for each column if we want it to differ from the database column name.

After creating all of our table columns, we create a table by instantiating a new instance of TableModel class. The first parameter for the constructor for TableModel takes a name, which is used in the naming of the filename. The second parameter for the TableModel constructor takes a table name. In our script we are passing in the name 'vegetable_fans'. The third parameter of the TableModel constructor takes an array of TableColumn objects. The fourth parameter of TableModel constructor takes a value for the primary key column of the table we passed in the second paramter. In this case, the primary key for the vegetable_fans table is called 'id'. The fifth parameter of the TableModel constructor takes an array of optional html parameters. In this script we pass in values to set the id and class of the table element.

In the section called 'Filter form Data', we set all the data to generate the filter form. The filter form is above the filter table, and is contained in a grey rounded panel. The process of configuring a form to be generated is similar to that for the table we did above. The first step is to instantiate all the FormFieldModel objects we need to represent form fields. The second step is to instantiate a FormModel, passing in our FormFieldModel objects as well as other configuration data to generate the filter form.

All FormFieldModel objects we use are extended from the base FormFieldModel abstract class. In this example, we create form fields for a dropdown, a checkbox, and a radio input. 

The DropdownFormFieldModel uses the vegetable lookup table for populating it's options. The first parameter we pass to DropdownFormFieldModel is the foreign key column name in the vegetable_fans table. The second parameter to the constructor is the type of form element, 'dropdown'. The third parameter is an array of options we use for setting the id and class of the select input element. After instantiating the DropdownFormFieldModel object, we use the set_table_col instance method to configure this form element to use a lookup table. The first parameter of the set_table_col instance method is the lookup table's name. The second parameter of the set_table_col instance method is the primary key column name in the lookup table. The third parameter of the set_table_col instance method is the column in the lookup table we want to use for the display in the html dropdown. The column 'name' in the vegetable lookup table has all the vegetable names, which is what we want users to see when they use the form dropdown. Finally, we use the set_label_name instance method, which is common to all FormFieldModel sub-classes, to set the label text that users will see.

The CheckboxFormFieldModel uses a boolean-like datatype, where 1 is true, and 0 is false. This form element represents the column called 'vegetarian' in the vegetable_fans table. The vegetarian column has a tinyint datatype. The set_checked_value and set_default_value instance methods of the CheckboxFormFieldModel class are flexible, since we might want to use enums instead of a tinyint for a boolean value. For example, 'Yes' or 'No'.

The RadioFormFieldModel is used to create a 'vegetable_status' dropdown. The RadioFormFieldModel if very similar to the DropdownFormFieldModel. Both of them can be setup to use either a lookup table, or an enum array. For the vegetable_status radio, we use an enum array. This enum array will also be inserted into the codeIgniter model class when the files are generated.

Another form dropdown is created to show the results per page choices. Like the radio above, we again use an enum array that we have defined. We also use the set_default_value setter method to define which of the enum values we wish to be chosen by default.

After creating all of the form elements for the filter form, we are ready to initialize the FormModel object that represents the filter form. The first parameter of the FormModel constructor is a name. The name is used for naming the data variable that is used to store the filter data in the controller. I suggest you pass the controller name in for the name. The second parameter the is database table name. The third parameter is your array of FormFieldModel objects. The fourth parameter is the primary key column name for the table. The fifth parameter in an associative array which is used for the html form element; we use it here for setting the form's id, class and method. The sixth parameter to the FormModel constructor is an associative array for setting the label form element selectors for the filter form. Finally, the seventh parameter is an associative array for setting parameters on the filter form buttons.

Finally, now that all of the interface configuration is set, we are ready to run the generator script. The Generator_filter_table class is extended from the Generator class. The Generator class is the driver that does all of the processing, compiling and writing of files. 

The Generator constructor takes four parameters. The first parameter is the name. The name must be the same as the name of the controller. The second parameter is a GeneratorConfig instance, which was loaded at the top of the script from the file 'config.ini'. The config object contains project settings that define directory structure for the codeIgniter project. The third parameter to the constructor is the table model that we instantiated ealier. And the fourth parameter is the filter model object we created previously. After creating the generator, we call the init method, which is used to add some additional data. Finally, we call the generate method, and then the output method to print out the list of files that were created.