# How to set up the project
This guide will walk you through the steps required to set up the project on your local machine.

Prerequisites
Before you begin, make sure you have the following installed on your machine:

PHP 8.1 or later<br>
Composer<br>
MySQL<br>

Obs: Observe Magento 2.4.6 requirements, you can consult in the link below.
[Magento 2.4.6 System Requirements](https://experienceleague.adobe.com/docs/commerce-operations/installation-guide/system-requirements.html)

## Steps
Clone the repository to your local machine using the command:

git clone [https://github.com/lmarquine/deviget-test](URL "https://github.com/lmarquine/deviget-test") or using SSH [git@github.com:lmarquine/deviget-test.git](git@github.com:lmarquine/deviget-test.git)

1. Copy the env.php and config.php files from the environment folder to your app/etc directory.

2. Create a new database for the project on your local machine.

3. Import the dump.sql file from the environment folder into your newly created database, either via command line or a database management tool.

4. In the env.php file, update the database credentials to match your local environment.

5. Access your database and in the core_config_data table, change the website domain to your local domain.

6. Run the command composer install to install all the project dependencies.

7. Run the command bin/magento setup:upgrade to run the Magento setup upgrade.

8. The Home and Profile pages are generated via data patch by the Deviget_Configs module. As a best practice, the pub/media folder is not committed to the repository. Therefore, the images are added via data patch and then deleted from the module locally.

If you have any questions or concerns, feel free to contact us via WhatsApp at **+55 47 996365402**.
