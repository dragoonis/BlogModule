<?php $view->extend('::admin.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<link type="text/css" rel="stylesheet" href="<?= $view['assets']->getUrl('blog/css/libs/jquery.tagsinput.css'); ?>"/>
<link type="text/css" rel="stylesheet" href="<?= $view['assets']->getUrl('blog/css/create.css'); ?>"/>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('include_js_body') ?>
<script src="<?php echo $view['assets']->getUrl('js/libs/tiny_mce/tiny_mce.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('js/libs/tiny_mce/jquery.tinymce.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('blog/js/libs/jquery.tagsinput.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('blog/js/post/create.js') ?>"></script>
<?php $view['slots']->stop(); ?>

<div class="inner">

    <div class="breadcrumb">
        <a href="<?= $view['router']->generate('Admin_Index'); ?>">Admin</a> >>
        <a href="<?= $view['router']->generate('Blog_Admin_Index'); ?>"> Blog</a> >>
        Add Post
    </div>

    <div id="add-blog-post" class="widget-box">
        <div class="widget-title">
            <span class="icon"><i class="icon-align-justify"></i></span>
            <h5>Add Blog Post</h5>
        </div>

        <div class="widget-content">

            <div class="alert alert-error"></div>
            <div class="alert alert-success"></div>

            <form action="<?= $view['router']->generate('Blog_Post_Admin_Submit'); ?>"
                  method="post" id="addBlogPost"
                  enctype="multipart/form-data">

                <input type="hidden" id="postId" name="postId" value="<?=$postId;?>" />

            <div class="blog-post-form">

                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="input-xxlarge validate[required]"
                                   id="title" placeholder='Title' name="title" value="">
                            <span rel="title" class="help-inline"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <textarea class="input-xxlarge" id="content" name="content" cols="45" rows="24"></textarea>
                            <span rel="content" class="help-inline"></span>
                        </div>
                    </div>

            </div>

            <aside class="sidebar">

                <div class="widget-title">
                    <span class="icon"><i class="icon-align-justify"></i></span>
                    <h5>Options</h5>
                </div>

                <div class="content section publish">
                    <input type="submit" name="submit" value="Publish"
                           class="btn btn-large btn-primary" data-id='<?=$postId;?>'>
                    <button class="btn btn-medium saveDraft" data-id='<?=$postId;?>'>Save Draft</button>
                </div>

                <div class="content section categories">

                    <h6>Select Categories</h6>

                    <!-- <input class="category" name="category" id="category"/> -->

                    <div class="control-group">
                        <?php foreach ($cats as $cat) : ?>
                            <div class="controls">
                                <input type="checkbox" id="category[]" name="category[]"
                                       value="<?= $cat->getId(); ?>"> <?=$cat->getTitle();?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="content section tags">

                    <h6>Post Tags</h6>

                    <input class="tag" name="tag" id="tag"/>
                </div>

                <div class="content section tags">

                    <h6>Main Picture</h6>

                    <a href="javascript://" class="mainPicture">Select main picture</a>
                </div>
            </aside>

            </form>

            <div class="clear"></div>
        </div>
    </div>
</div>