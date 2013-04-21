<?php
namespace BlogAdminModule\Controller;

use BlogAdminModule\Controller\Shared as SharedController;

class Index extends SharedController
{

    public function indexAction()
    {

        $posts = $this->getService('post.storage')
                ->getPublishedPosts();

        return $this->render('BlogAdminModule:index:index.html.php', compact('posts'));
    }

    public function draftsAction()
    {
        $posts = $this->getService('post.storage')
                ->getDraftedPosts();

        return $this->render('BlogAdminModule:index:index.html.php', compact('posts'));
    }

}
