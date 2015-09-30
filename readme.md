###STRUCTURE

T9 class is responsible for a T9 cipher code and search.

DB class is responsible for all database operations.

index.php has a user interface, imitation of a keyboard.

MYSQL.sql is a file with the dump of database.

###TEST DATA

The project has a small database, only 5 records. For tests, please use the input data from the
technical test, i.e.: for 688 fits to OTTo and NUTzer, the 724 for SCHmidt and RAHmen.

Input data is restricted to 4 symbols only. There will be no alarm message, just a restriction.

###MYSQL

 Since the requirement for the database was, that we'll have more than 1 mln. records, I used MyISAM
 engine for the phone_book table instead of InnoDB (ignoring better data recovery opportunity,
 available in InnoDB in this case) for the following reasons:
 1. it works faster on select operations;
 2. MyISAM has fulltext index that allowed to use here MATCH AGAINST search, which is much faster
 than "LIKE" and fits for our case the best.

 I used index for 2 fields to have opportunity to perform the search both on the name and last_name
 fields.

