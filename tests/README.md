# Generator

Generate boilerplate for CodeIgniter application. Generate controller, model,
and view files. 

## Testing

Create a basic testing database:

	$ echo "CREATE DATABASE testing" | mysql -uroot -pROOTPASSWORD
	$ echo "GRANT ALL ON testing.* TO 'mysqluser'@'localhost'" | mysql -uroot -pROOTPASSWORD
	$ echo "flush privileges" | mysql -uroot -pROOTPASSWORD

Run the script to create the table and populate with test data:

	$ mysql -u mysqluser -pdevelopment testing < /vagrant/generator/tests/test_data.sql

