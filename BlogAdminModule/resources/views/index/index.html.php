<?php $view->extend('::admin.html.php'); ?>
<?php $view['slots']->start('include_css') ?>

<?php $view['slots']->stop(); ?>

<div class="inner">

    <div class="breadcrumb">
        <a href="<?= $view['router']->generate('Admin_Index'); ?>">Admin</a> >>
        <a href="<?= $view['router']->generate('Blog_Admin_Index'); ?>">Posts</a>
    </div>

    <div class="sub-menu">
        <ul>
            <li>
                <a href="<?= $view['router']->generate('Blog_Post_Add'); ?>">
                    <i class="icon-white icon-plus"></i>
                    Add Post
                </a>
            </li>
            <li><a href="<?=$view['router']->generate('Blog_Admin_Draft_Index');?>">View Drafts</a></li>
        </ul>
    </div>

    <div id="mass-email" class="widget-box">
        <div class="widget-title">
            <span class="icon"><i class="icon-align-justify"></i></span>
            <h5>Blog Posts</h5>
        </div>

        <div class="widget-content">

            <table class="table table-bordered table-striped data-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($posts)): ?>
                    <tr>
                        <td colspan="5"><p>There're no blog posts yet.</p></td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($posts as $row): ?>
                        <tr>
                            <td><?=$view->escape($row->getID());?></td>
                            <td><?=$view->escape($row->getTitle());?></td>
                            <td class="actions">

                                <a href="<?= $view['router']->generate('Blog_Post_Edit', array('id' => $row->getID())); ?>"
                                   title="Edit Post" class="btn deletePost" data-postid="<?= $row->getID(); ?>"><i
                                            class="icon-edit"></i>
                                </a>

                                <a href="<?= $view['router']->generate('Blog_Post_Delete', array('id' => $row->getID())); ?>"
                                   title="Delete Post" class="btn deletePost" data-userid="<?= $row->getID(); ?>"><i
                                            class="icon-remove"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>