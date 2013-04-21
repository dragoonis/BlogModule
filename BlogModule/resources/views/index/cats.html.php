<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<?php $view['slots']->stop(); ?>

    <div class="cats" id="cats">

        <section class="content">
            <?php foreach ($posts as $post) : ?>
                <div class="box <?= $post->getCatsAsPlainText(); ?> <?= $post->getTagsAsPlainText(); ?>">
                    <div class="picture"><img
                            src="<?= $view['assets']->getUrl('uploads/blog/' . $post->getAvatar()); ?>>"/></div>
                    <div class="title">
                        <a href="<?= $view['router']->generate('Blog_View_Post', array('slug' => $post->getSlug())); ?>">
                            <?=$view->escape($post->getTitle());?>
                        </a>
                    </div>
                    <div class="text"><?=$post->getExcerpt(140);?></div>
                </div>
            <?php endforeach; ?>
        </section>
        <!-- / .Content -->

    </div>

<?php $view['slots']->start('include_js_body'); ?>
<?php $view['slots']->stop(); ?>