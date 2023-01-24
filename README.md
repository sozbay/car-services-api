#  Car Services Api
With Car Services Api
- 
- Detailed listing of car services
- Order creation / listing
- Add balance
- Auth Transactions
- Car models listing<br><br>
<b>You Can Make Transactions<b>
<br> 

There are migration create table files under the database/migrations folder.

Installation for run<br>
- **php artisan migrate** <br>
  command should be run the auto seeder will work.

To add car information<br>
- **Php artisan car:get** <br>
  command should be run(It will be added automatically when the migrate command is run.)
  job works weekly
<br><br>
To enter sample data into tables;
There are seeder files under the database/seeders folder.

For authentication and authorization operations;
- **composer install** <br>
command should be run.

You need to generate a secret key to handle the token encryption. To do so, run this command:

- php artisan jwt:secret


**Authentication**

- {{base_url}}/auth/register --> Register
- {{base_url}}/auth/login --> Login with token

Create TOKEN and base_url variable in postman collection Environment, enter base_url value, token will be filled automatically

After login, the token will be automatically transferred to {{TOKEN}} variable

See all examples in **/data/Case.postman_collection.json**

