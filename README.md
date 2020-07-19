# concreteApi

Test assignment, created using symfony<br>
This is only rest-api, front-end link: "https://github.com/aquafinatrippy/ConcreteClient"

# Requirements

Git <br/>
composer <br/>
PHP<br/>
MySql<br/>
VsCode<br/>

# How to run project on local device

Open terminal/cmd and go folder, where you would like project to be<br/><br/>
Then run "git clone git@github.com:aquafinatrippy/concreteApi.git"<br/><br/>
Then run "cd concreteApi"<br/><br/>
Run "code ." (if on windows, otherwise open project with vscode)<br/><br/>
Open .env file and change DATABASE_URL=mysql://DB_USER_HERE:DB_PASSWORD_HERE@DB_SERVER/DataBaseName. Example= "DATABASE_URL=mysql://admin:admin123@127.0.0.1:3306/>concreteApi"<br/><br/>
Run "composer install"<br/><br/>
Start up MySql<br/><br/>
Run "php bin/console doctrine:database:create" in terminal/cmd <br> <br>
Run "php bin/console doctrine:fixtures:load" to get mock data to database <br> <br>
run "php bin/console make:migration"<br>
run "php bin/console doctrine:migrations:migrate"<br>
When its done then run "symfony server:start" to start application<br/><br/>
Go "http://localhost:8000/" to view/use application<br/><br/>

# Create mock products to database

run in console: php bin/console doctrine:fixtures:load
