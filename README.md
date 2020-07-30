# concrete software full-stack

Test assignment, created using Symfony and Angular<br>
REST-api created with Symfony and front-end is powered by Angular

# Backend required software

Git <br/>
https://git-scm.com/book/en/v2/Getting-Started-Installing-Git<br><br>
composer <br/>
https://getcomposer.org/download/<br><br>
PHP<br/>
or use stack like: xampp, lamp etc... <br>
https://www.w3schools.com/php/php_install.asp<br><br>
MySql<br/>
If you have some php stack then you have mysql aswell<br>
else: https://dev.mysql.com/downloads/installer/<br><br>
VsCode<br/>
https://code.visualstudio.com/

# Front-end required software
Angular cli is needed.<br>
Run in terminal: "npm install -g @angular/cli" to get it<br>
Node js is needed <br>
https://nodejs.org/en/download/

# How to run back-end on local device

Open terminal/cmd and go folder, where you would like project to be<br/><br/>
Then run "git clone git@github.com:aquafinatrippy/concreteFullStack.git"<br/><br/>
Then run "cd concreteFullStack"<br/><br/>
Run "code ." (if on windows, otherwise open project with vscode)<br/><br/>
Open .env file and change DATABASE_URL=mysql://DB_USER_HERE:DB_PASSWORD_HERE@DB_SERVER/DataBaseName.
<br> Example db string= "DATABASE_URL=mysql://admin:admin123@127.0.0.1:3306/>concreteApi"<br/><br/>
Run "composer install"<br/><br/>
Start up MySql<br/><br/>
Run "php bin/console doctrine:database:create" in terminal/cmd <br> <br>
run "php bin/console make:migration"<br>
run "php bin/console doctrine:migrations:migrate"<br>
Run "php bin/console doctrine:fixtures:load" to get mock data to database <br> <br>
When its done then run "symfony serve" to start application<br/><br/>
In console theres url. Thats server local running url<br/><br/>

# How to run front-end on local device

Open terminal/cmd and go to project folder then "cd client" <br>
Run command: "npm install"<br>
With code editor open client/src/environments/environments and change apiUrl to back-end url.<br>
Run command: "ng serve"
