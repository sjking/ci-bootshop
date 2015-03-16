# Using Generator

## Revision History

| Version | Date          | Author     | Description       |
|---------|---------------|------------|-------------------|
| 0.1     | Mar. 11, 2015 | Steve King | Document Created. |
|         |               |            |                   |
|         |               |            |                   |

## Introduction

This is a tutorial on using the generator scripts to generate a user interface
for a database table. Generator will generate most of the files needed for a 
new module in codeIgniter. These files include the controller, the model, the
views, and the javascript file. The generated modules also depend on project 
wide assets, including css files, jQuery, and the bootstrap library. The 
advantage of using these scripts in generating a new module is that much of the
generic functionality that we want to reproduce in similar interfaces is 
already worked out in the generated files. We can then focus more closely on 
implementing the specific business requirements of each new module. Having a 
boilerplate generated also gives the added benefit that coding style and 
user interface functions become more consistent and predictable.

This tutorial steps through three examples of how the generater scripts are used. Once it is understood how these scripts are used, and how to read them, you will be able to generate the same style of user interface for any database tables. To generate a new user interface, we can simply duplicate one of the testing scripts and change the necessary options for our specific database table.

### Directory structure

From the root of the Generator repository, we will be working with the 'Modules/Tracs/scripts' folder. This folder contains the testing scripts used in this tutorial. This folder should also be the location of new scripts you write to generate new interfaces in TRACS. 

### Setup

To do the tutorial, we will need to setup some database tables in your virtual machines MySQL database. Access phpMyAdmin on your virtual machine. It should be located at the url: pma.busdevw. Now choose the Import menu in phpMyAdmin. There is a file called vegetable.sql. Import this sql file. After importing you should have two new database tables: vegetable and vegetable_fans. Go ahead and take a look at these tables to familiarize yourself. The vegetable table is a lookup table that the vegetable_fans table uses.

## Look-up tables

There are two testing scripts that generate interfaces for managing lookup tables in TRACS. The lookup table interface is located at '/tracs/admin/lut'. Each of the two generators for lookup table interfaces creates a master-detail view. The master view shows a table with all of the data, and it may be truncated. The master view also has filters to search for specific data in the tabels. On each column of the master view, there is an edit button. When the edit button is clicked, it will take you to a detailed view for the entry in the row that was clicked. 

The script ordering_test_lut.php generates a lookup table interface that allows re-ordering of the entries with up and downs arrows on each row. The script sorting_test_lut.php creates an interfaces where the columns of the master table view can be sorted in ascending or descending order.

TO-DO: Finish tutorial on the look-up tables

## Filter Table

There is a testing script that generates a simple one-page interfaces that
includes a filter form and a master table view. Each row of the filter table interface can be sorted in ascending or descending order. The file 'filter_table_test.php' will generate a testing interfaces located at '/tracs/admin/vegetable_filter'. 

### Running the Script

Login to the virtual machine. Go to the directory that contains the script and run it:

    $ cd /vagrant/generator/Modules/Tracs/scripts
    $ php -f filter_table_test.php
    Created 8 files:
    /vagrant/sites/beedie-ssl/tracs/application/views/admin/vegetable_filter/vegetable_filter_table_view.php
    /vagrant/sites/beedie-ssl/tracs/application/views/admin/vegetable_filter/vegetable_filter_panel_footer_view.php
    /vagrant/sites/beedie-ssl/tracs/application/views/admin/vegetable_filter/vegetable_filter_panel_header_view.php
    /vagrant/sites/beedie-ssl/tracs/application/views/admin/vegetable_filter/vegetable_filter_filter_panel_view.php
    /vagrant/sites/beedie-ssl/tracs/application/controllers/admin/vegetable_filter.php
    /vagrant/sites/beedie-ssl/tracs/application/views/admin/vegetable_filter/vegetable_filter_view.php
    /vagrant/sites/beedie-ssl/tracs/application/models/vegetable_filter_model.php
    /vagrant/sites/beedie-ssl/tracs/assets/js/vegetable_filter/vegetable_filter_table.js

Now, navigate to the address '/tracs/admin/vegetable_filter'.