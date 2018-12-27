<img src="https://raw.githubusercontent.com/SerhiiCho/englitopia/master/media/img/banner1.jpg" style="text-align:center">

### About

This is my first website. Here I've build everything with procedural PHP7, and Red Bean Php that is pretty awesome ORM. The code is pretty ugly, but common, your first app was probably ugly too. ))

### How to start

1. Rename config.example.php to config.php and put your settings there.
2. Create database with name "englitopia", tables will be created for you by RedBeanPhp.
3. Go to a website and reload the browser.
4. (Optional) You can set 'freeze' option to true in /includes/dbh.inc.php, it will make less requests to the database

```php
R::freeze( true );
```


