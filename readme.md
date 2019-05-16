1. Using standard lamp stack
2. Setup MYSQL database called 'am_books'
	"CREATE DATABASE am_books;"
3. Create privaliged user 'joe' with password 'password'
	"mysql -u root -p"
	"GRANT ALL PRIVILEGES ON *.* TO 'joe'@'localhost' IDENTIFIED BY 'password';"
	
4. Run migration 'php artisan migrate'

5. Run 'vendor/bin/phpunit' from project root directory to load sample books.

6. Run server 'php artisan serve'

7. Open browser and visit below to verify setup works:
	i.  'http://localhost:8000/api/book'
	ii. 'http://localhost:8000/api/book/titles'

For use of the API:
Use below table for entry points:
+--------+-----------+----------------------+--------------+-------------------------------------------------+------------+
| Domain | Method    | URI                  | Name         | Action                                          | Middleware |
+--------+-----------+----------------------+--------------+-------------------------------------------------+------------+
|        | GET|HEAD  | api/book             | book.index   | App\Http\Controllers\API\BookController@index   | api        |
|        | POST      | api/book             | book.store   | App\Http\Controllers\API\BookController@store   | api        |
|        | GET|HEAD  | api/book/create      | book.create  | App\Http\Controllers\API\BookController@create  | api        |
|        | GET|HEAD  | api/book/titles      | book.titles  | App\Http\Controllers\API\BookController@titles  | api        |
|        | GET|HEAD  | api/book/{book}      | book.show    | App\Http\Controllers\API\BookController@show    | api        |
|        | PUT|PATCH | api/book/{book}      | book.update  | App\Http\Controllers\API\BookController@update  | api        |
|        | DELETE    | api/book/{book}      | book.destroy | App\Http\Controllers\API\BookController@destroy | api        |
|        | GET|HEAD  | api/book/{book}/edit | book.edit    | App\Http\Controllers\API\BookController@edit    | api        |
+--------+-----------+----------------------+--------------+-------------------------------------------------+------------+


Conditions for entries as per below. Code qualifies entries and returns notification if data supplied doesn't comply with 
requirements. Returned fault code is '500' + message

    "title"         - Book title, limited to 200 characters,
    "author"        - Book author, limited to 100 characters,
    "blurb"         - Book blurb,
    "ISBN"          - Book ISBN ,limtied to 13 characters
    "release_year"  - Book release year, limited to 4 characters
    "number_pages"  - Numer of pages, must be numeric

    All data required for sucsessful entry. NULL is not acceptable for any value.


Example:
    "title":"Book 1",
    "author":"Person 1",
    "blurb":"Info 1",
    "ISBN":"1236454",
    "release_year":"2019",
    "number_pages":"345"
