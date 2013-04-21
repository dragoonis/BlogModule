<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('blog/css/single.css') ?>"/>
<?php $view['slots']->stop(); ?>

    <div class="blog index" id="blog-index">

        <div class="left-side content">

            <div class="post">
                <h1 class="post-title"><?=utf8_encode($post->getTitle());?></h1>

                <div class="social-share">
                    <span class='st_sharethis_large' displayText='ShareThis'></span>
                    <span class='st_facebook_large' displayText='Facebook'></span>
                    <span class='st_twitter_large' displayText='Tweet'></span>
                    <span class='st_pinterest_large' displayText='Pinterest'></span>
                    <span class='st_email_large' displayText='Email'></span>
                </div>

                <div class="post-content">
                    <?=utf8_encode($post->getContent()); ?>
                </div>
                <div class="post-meta"></div>
                <div class="date-area">
                    <div class="inner">
                        <span><?=$post->getMonth(); ?></span>
                        <span class="day"><?=$post->getDay();?></span>
                        <span><?=$post->getYear(); ?></span>
                    </div>
                </div>


                <div class="comments">
                    <div id="disqus_thread"></div>
                    <script type="text/javascript">
                        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                        var disqus_shortname = 'YOURDISQUSUSERID'; // required: replace example with your forum shortname

                        /* * * DON'T EDIT BELOW THIS LINE * * */
                        (function () {
                            var dsq = document.createElement('script');
                            dsq.type = 'text/javascript';
                            dsq.async = true;
                            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments
                            powered by Disqus.</a></noscript>
                    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span
                            class="logo-disqus">Disqus</span></a>
                </div>

            </div>
            <!-- / .post -->
        </div>
        <!-- / .left-side.content -->

        <aside class='sidebar right-side'>
            <!-- @TODO To be implemented. -->
        </aside>
        <!-- / .sidebar -->

    </div> <!-- / .blog-index -->

<?php $view['slots']->start('include_js_body') ?>
    <script type="text/javascript">var switchTo5x = true;</script>
    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher: "YOUR-SHARE-THIS-PUBLISHER-ID"});</script>
<?php $view['slots']->stop(); ?>