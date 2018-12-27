<img src="https://raw.githubusercontent.com/SerhiiCho/englitopia/master/media/img/banner1.jpg" style="text-align:center">

### About

This is my first website. Here I've build everything with procedural PHP7, and Red Bean Php that is pretty awesome ORM. The code is pretty ugly, but common, your first app was probably ugly too. ))

### How to start

1. Rename config.example.php to config.php and put your settings there.
2. Create database with name "englitopia"
3. Import englitopia.sql dump file from the root of the app

### Additional information
#### User status

There are 4 statuses that user can use, in order to add status you need manually go to a database and add statuses that you want user to have in 'members' table. You can add them separating them with comma. Example: admin, writer

* **admin** - can access Admin's room in settings /settings_menu.php He can see search statistics, create notifications to all members, can also see all user's information and their reports.
* **member** - just a regular authenticated user
* **host** - can upload podcasts and other things related to podcasts
* **writer** - can upload stories and other things related to stories

After importing dump file there will be 2 users. One with username 'admin' and password '111111', and second is 'foo' with password '111111'.