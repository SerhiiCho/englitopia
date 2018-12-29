<img src="https://raw.githubusercontent.com/SerhiiCho/englitopia/master/src/media/img/banner1.jpg" style="text-align:center">

## About

This is my first website that I wrote just to practice PHP7 in June 2017. This repo is just like a memory how I started my programming way. For the first time in my life I'm using a PHP ORM (Object-relational mapping) [RedBean](https://www.redbeanphp.com/index.php). I fall in love with it after using it. My code is pretty ugly, there are some mistakes and not secure submit forms. But everything work well, and I've learned a lot. You can register and befriend someone by sending a friend request. You can chat without refreshing the page. If some people are morans, you can ban this acoount or also report. There more to it. That's pretty amazing what I've done not knowing how javascript really works. When I started coding this app I didn't know that there are OOP programming.

## The idea

The idea of this app was very simple. It should've been site for people who learn English. It has stories on different topics in English and different podcasts. For this moment it has 1 podcast from [Larave Podcast](http://www.laravelpodcast.com) site and one story just for example.

## Additional information

After importing dump file there will be 2 users. One is admin and other is just a regular member. But you can register your user on /signup.php.

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

## Get started without Docker

1. `git clone https://github.com/SerhiiCho/englitopia.git`
2. `cd englitopia/src`
3. Put your database settings in config.php
4. Create database with name "englitopia"
6. Import englitopia.sql dump file from the root of the app
7. `php -S localhost:7000` and go to a browser on localhost:7000

## Get started with Docker

1. `git clone https://github.com/SerhiiCho/englitopia.git`
2. `cd englitopia`
3. `docker-compose up -d` and go to a browser on localhost