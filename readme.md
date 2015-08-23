Simple Rest Api Created With Alto Router

Dependency

1. AltoRouter
2. NotORM for database access

How to use

first create virtual host in your apache webserver, and copy all file to root folder, and then type command "composer install" to get all dependency installed, dont copy to sub folder, this will not work, for data example you can import buku.sql to your database and change the database name in PDO config in index.php  ,you can use mozilla add on HttpRequester, or Postman in Google Chrome to do crud operation.

example to do CRUD operation

GET http://example.com/buku -> to retrieve all data, returned in json
POST http://example.com/buku -> to post/save new data, you must send the data with this format, data={"name":<string>,"price":<integer>,"image":<string>}
GET http://example.com/buku/id -> to retrieve data according to given id
PUT http://example.com/buku/id -> to edit data according to given id, with format data={"name":<string>} <- only name updated, data={"name":<string>, "image":<string>} <- name and image updated
DELETE http://example.com/buku/id -> to delete data according to given id