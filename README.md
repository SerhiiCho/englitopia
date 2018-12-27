<img src="https://raw.githubusercontent.com/SerhiiCho/englitopia/master/media/img/banner1.jpg" style="text-align:center">

## About

This is my first website that I wrote just to practice PHP7 in June 2017. For the first time in my life I'm using a PHP ORM (Object-relational mapping) [RedBean](https://www.redbeanphp.com/index.php). I fall in love with it after using it. My code is pretty ugly, there are some mistakes and not secure submit forms. But everything work well, and I've learned a lot.

## The idea

The idea of this app was very simple. I should've been site for people who learn English. It has stories on different topics in English and different podcasts. For this moment it has some sudo material in it.

## Additional information

After importing dump file there will be 2 users. One is admin and other is just a regular member.

| Username | Password |
|----------|----------|
|  admin   |  111111  |
|   foo    |  111111  |

## Statuses

There are 4 statuses that user can use, in order to add status you need manually go to a database and add statuses that you want user to have in 'members' table. You can add them separating them with comma.

Example:
> admin, writer

* **admin** - can access Admin's room in settings /settings_menu.php He can see search statistics, create notifications to all members, can also see all user's information and their reports.
* **member** - just a regular authenticated user
* **host** - can upload podcasts and other things related to podcasts
* **writer** - can upload stories and other things related to stories

## Get started

1. Rename config.example.php to config.php and put your settings there.
2. Create database with name "englitopia"
3. Import englitopia.sql dump file from the root of the app
