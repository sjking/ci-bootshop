# Generator

Generate boilerplate for CodeIgniter application. Generate controller, model,
and view files. 

## Testing

Create a basic testing database:

	$ echo "CREATE DATABASE testing" | mysql -uroot -pROOTPASSWORD
	$ echo "GRANT ALL ON testing.* TO 'mysqluser'@'localhost'" | mysql -uroot -pROOTPASSWORD
	$ echo "flush privileges" | mysql -uroot -pROOTPASSWORD

