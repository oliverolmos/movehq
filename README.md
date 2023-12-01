
This is a basic Admin Panel featuring Vue.js and Yii2. This version was created using MariaDB, but soon it will support other databases. 

Installation Requirements
- Node.js 16.4 or above
- MariaDB 10.6.5
- Apache 2.2 or 2.4
- PHP 7.4 or above
- Composer

Installation Steps
1. Setup the document root for your apache installation or for a virtualhost. The document root should use this path: api/app_backend/web from the project.
2. Modify your hosts file if you decided to use a domain name instead of you IP. Example: **127.0.0.1 api.movehq.local**
3. Create the datababase to be used for the application.
4. Create a copy of the **file global_conf.json.dist** and name it **global_conf.json** then make the following changes on the new file: 
  - Use the domain name you just created or the IP of your server for the **backend_url** param.
  - Once you run de Vue app it will default to **http://localhost:8001/** so use this as the **frontend_url** unless you are planning to change it on the **client/package.json** file.
  - Provide the MySQL database server credentials and the database name you created on step 4.
5. Give write permissions to the following paths:
  - api\app_backend\runtime
  - api\common\runtime
  - api\console\runtime
6. Navigate to the api folder and download all dependencies by running **composer install**
7. On the same api folder execute the following commands which will create the database tables and will insert test data:
  - yii migrations
  - yii test-data
8. Navigate to the **client** folder and execute **npm install** then **npm run serve**
9. Open the fronted URL (http://localhost:8001) on a browser and use the following test credentials:
  - Username: olmosoliver@gmail.com
  - Password: 12345678



