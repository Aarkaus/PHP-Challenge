@ECHO OFF
php app/console security:check
php app/console server:run

echo Press any key to continue
pause