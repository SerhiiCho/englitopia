<img src="https://raw.githubusercontent.com/SerhiiCho/englitopia/master/media/img/banner1.jpg" style="text-align:center">

### About

This is my first website that I wrote just to practice PHP7. Here I'm using RedBean that is pretty awesome PHP ORM. The code is pretty ugly, there are some mistakes and not secure forms. But everything work well. 

### How to start

1. Rename config.example.php to config.php and put your settings there.
2. Create database with name "englitopia"
3. Import englitopia.sql dump file from the root of the app

### Additional information
After importing dump file there will be 2 users. One with username 'admin' and password '111111', and second is 'foo' with password '111111'.
There are 4 statuses that user can use, in order to add status you need manually go to a database and add statuses that you want user to have in 'members' table. You can add them separating them with comma. Example: admin, writer

* **admin** - can access Admin's room in settings /settings_menu.php He can see search statistics, create notifications to all members, can also see all user's information and their reports.
* **member** - just a regular authenticated user
* **host** - can upload podcasts and other things related to podcasts
* **writer** - can upload stories and other things related to stories