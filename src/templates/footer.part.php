<?php

$posts = (mt_rand(1,10));

switch($posts) {
    case 1:
        $headline = 'Thomas A. Edison';
        $message = 'Our greatest weakness lies in giving up. The most certain way to succeed is always to try just one more time.';
        $picture = 'thomas-a-edison.jpg';
        break;
    case 2:
        $headline = 'Bruce Lee';
        $message = 'Always be yourself, express yourself, have faith in yourself, do not go out and look for a successful personality and duplicate it.';
        $picture = 'bruce-lee.jpg';
        break;
    case 3:
        $headline = 'Lao Tzu';
        $message = 'Do the difficult things while they are easy and do the great things while they are small. A journey of a thousand miles must begin with a single step.';
        $picture = 'lao-tzu.jpg';
        break;
    case 4:
        $headline = 'Arnold Schwarzenegger';
        $message = 'Strength does not come from winning. Your struggles develop your strengths. When you go through hardships and decide not to surrender, that is strength.';
        $picture = 'arnold-schwarzenegger.jpg';
        break;
    case 5:
        $headline = 'Walt Disney';
        $message = 'All the adversity I’ve had in my life, all my troubles and obstacles, have strengthened me.... You may not realize it when it happens, but a kick in the teeth may be the best thing in the world for you.';
        $picture = 'walt-disney.jpg';
        break;
    case 6:
        $headline = 'Muhammad Ali';
        $message = 'I set out on a journey of love, seeking truth, peace and understanding. I am still learning.';
        $picture = 'muhammad-ali.jpg';
        break;
    case 7:
        $headline = 'Nelson Mandela';
        $message = 'Education is the most powerful weapon which you can use to change the world.';
        $picture = 'nelson-mandela.jpg';
        break;
    case 8:
        $headline = 'Steve Jobs';
        $message = 'The only way to do great work is to love what you do. If you haven’t found it yet, keep looking. Don’t settle.';
        $picture = 'steve-jobs.jpg';
        break;
    case 9:
        $headline = 'Mark Twain';
        $message = 'Twenty years from now you will be more disappointed by the things that you didn’t do than by the ones you did do. So throw off the bowlines. Catch the trade winds in your sails. Explore. Dream. Discover.';
        $picture = 'mark-twain.jpg';
        break;
    case 10:
        $headline = 'Jacque Fresco';
        $message = 'I was asked once, "You are a smart man, why arn\'t you rich?" I replied "You are a rich man, why arn\'t you smart?"';
        $picture = 'jacque-fresco.jpg';
        break;
    default:
        $headline = 'Englitopia';
        $message = 'English as a driver of change.';
        $picture = 'logo.png';
}
?>
    <footer>
        <nav class="nav-footer">
            <div class="footer-col-first">
                <div>
                    <?= '<h3>'.$headline.'</h3>';?>
                    <?= '<span>“'.$message.'”</span>';?>
                </div>
                <?= '<img src="media/img/footer/'.$picture.'?v=1" alt="Quotes">';?>
            </div>
            <hr class="hr-mobile">
            <ul class="footer-col">
                <li><h3>Navigation</h3></li>
                <li><a href="podcasts.php">Podcast</a></li>
                <li><a href="stories.php">Stories</a></li>
                <li><a href="login.php">Log in</a></li>
                <li><a href="signup.php">Sign up</a></li>
                <li><a href="search.php">Search</a></li>
            </ul>
            <ul class="footer-col">
                <li><h3>Privacy &amp; Terms</h3></li>
                <li><a href="information.php">All Information</a></li>
                <li><a href="info_page.php?id=2">Privacy Policy</a></li>
                <li><a href="info_page.php?id=3">Terms and Conditions</a></li>
                <li><a href="info_page.php?id=1">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
            <ul class="footer-col-last">
                <li><h3>Follow Us</h3></li>
                <li>
                    <a href="https://www.twitter.com/englitopia">
                        <i class="fab fa-twitter"></i> twitter
                    </a>
                </li>
            </ul>
        </nav>
            <div class="copyright">
                <h4>
                    Copyright &copy; 2017 - <?= date("Y");?>
                    Englitopia by Serhii Cho
                </h4>
            </div>
    </footer>