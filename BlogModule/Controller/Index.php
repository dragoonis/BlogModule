<?php
namespace BlogModule\Controller;

use BlogModule\Controller\Shared as SharedController;

class Index extends SharedController
{

    public function indexAction()
    {

        $postStorage = $this->getService('post.storage');
        $sliders     = $this->getService('slider.storage')->getAll();
        $posts       = $postStorage->getSomePosts(3);

        $catsGroupedByPost =  $postStorage->getCatsByPostId($posts, $this->getService('post.category.storage'));
        foreach($posts as $key => $post) {
            if(isset($catsGroupedByPost[$post->getID()])) {
                $posts[$key]->setCats($catsGroupedByPost[$post->getID()]);
            }
        }

        $tagsGroupedByPost =  $postStorage->getTagsByPostId( $posts, $this->getService('post.tag.storage'));
        foreach($posts as $key => $post) {
            if(isset($tagsGroupedByPost[$post->getID()])) {
                $posts[$key]->setTags($tagsGroupedByPost[$post->getID()]);
            }
        }

        return $this->render('BlogModule:index:index.html.php', compact('sliders', 'posts'));
    }

    public function viewAction()
    {

        $slug   = $this->getRouteParam('slug');
        $helper = $this->getService('post.helper');
        $post   = $helper->getPostBySlug($slug);
        $tags   = $helper->getPostTags($post->getId());
        $cats   = $helper->getPostCats($post->getId());

        return $this->render('BlogModule:index:view.html.php', compact('post', 'cats', 'tags'));
    }

    public function catAction()
    {

        $catName     = $this->getRouteParam('cat');
        $postStorage = $this->getService('post.storage');
        $posts       = $postStorage->getPostsFromCat($catName);

        $catsGroupedByPost =  $postStorage->getCatsByPostId($posts, $this->getService('post.category.storage'));
        foreach($posts as $key => $post) {
            if(isset($catsGroupedByPost[$post->getID()])) {
                $posts[$key]->setCats($catsGroupedByPost[$post->getID()]);
            }
        }

        $tagsGroupedByPost =  $postStorage->getTagsByPostId( $posts, $this->getService('post.tag.storage'));
        foreach($posts as $key => $post) {
            if(isset($tagsGroupedByPost[$post->getID()])) {
                $posts[$key]->setTags($tagsGroupedByPost[$post->getID()]);
            }
        }

        return $this->render('BlogModule:index:cats.html.php', compact('posts'));
    }

    public function archiveAction()
    {

        $postStorage = $this->getService('post.storage');
        $posts       = $postStorage->getAllPublished();

        $catsGroupedByPost =  $postStorage->getCatsByPostId($posts, $this->getService('post.category.storage'));
        foreach($posts as $key => $post) {
            if(isset($catsGroupedByPost[$post->getID()])) {
                $posts[$key]->setCats($catsGroupedByPost[$post->getID()]);
            }
        }

        $tagsGroupedByPost =  $postStorage->getTagsByPostId( $posts, $this->getService('post.tag.storage'));
        foreach($posts as $key => $post) {
            if(isset($tagsGroupedByPost[$post->getID()])) {
                $posts[$key]->setTags($tagsGroupedByPost[$post->getID()]);
            }
        }

        return $this->render('BlogModule:index:archive.html.php', compact('posts'));
    }

}
