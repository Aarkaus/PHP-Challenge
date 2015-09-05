@echo off
php app/console doctrine:database:create
php app/console doctrine:schema:update --force

php app/console doctrine:query:sql "INSERT INTO `redeyecustomer`.`tier` (`tier_name`, `price_per_Artefact`, `range_minimum`, `range_maximum`) VALUES ('Tier 1', '1.00', '1', '1000')"
php app/console doctrine:query:sql "INSERT INTO `redeyecustomer`.`tier` (`tier_name`, `price_per_Artefact`, `range_minimum`, `range_maximum`) VALUES ('Tier 2', '0.70', '1001', '5000')"
php app/console doctrine:query:sql "INSERT INTO `redeyecustomer`.`tier` (`tier_name`, `price_per_Artefact`, `range_minimum`, `range_maximum`) VALUES ('Tier 3', '0.50', '5001', '15000')"

php app/console doctrine:query:sql "INSERT INTO `redeyecustomer`.`customer` (`id`, `username`, `password`, `is_active`, `title`, `company`, `address`, `email`, `mobile`, `phone`) VALUES (NULL, 'John Smith', '$2a$12$/QEPC9PvYLBhyMEHsTcWDOGNz8GwYMeMY0qPM/m2wMNO7DNw9Adj2', '', 'Mr', 'Company 1', '1 Main Street, Brisbane, QLD 4001', 'admin@company1.com', '+61 0400 000 000', '+61 0700 000 000');"
php app/console doctrine:query:sql "INSERT INTO `redeyecustomer`.`customer` (`id`, `username`, `password`, `is_active`, `title`, `company`, `address`, `email`, `mobile`, `phone`) VALUES (NULL, 'Jane Doe', '$2a$12$/QEPC9PvYLBhyMEHsTcWDOGNz8GwYMeMY0qPM/m2wMNO7DNw9Adj2', '', 'Miss', 'Company 2', '2 Main Street, Brisbane, QLD 4001', 'jane@company2.com', '+61 0400 000 001', '+61 0700 000 001');"

echo Press any key to continue
pause