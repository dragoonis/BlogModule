<?php
namespace BlogAdminModule\Controller;

use BlogAdminModule\Controller\Shared as SharedController;

class Post extends SharedController
{

    public function createAction()
    {

        if (!$this->isAdmin()) {
            $this->setFlash('error', 'You don\'t have permission to access that page');
            return $this->redirectToRoute('User_Login');
        }

        // Create a draft..
        $cats    = $this->getService('category.storage')->getAll();
        $postId  = $this->getService('post.storage')
                        ->create(array(
            'title'       => '',
            'content'     => '',
            'slug'        => '',
            'avatar'      => '',
            'created_at'  => date('Y-m-d H:i:s'),
            'modified_at' => date('Y-m-d H:i:s')
        ));

        return $this->render('BlogAdminModule:post:create.html.php', compact('postId','cats'));
    }

    public function editAction()
    {

        $postId   = $this->getRouteParam('id');
        $helper   = $this->getService('post.helper');
        $post     = $helper->getPost($postId);
        $tags     = $helper->getPostTags($postId);
        $postCats = $helper->getPostCats($postId);
        $cats     = $this->getService('category.storage')->getAll();

        return $this->render('BlogAdminModule:post:edit.html.php', compact('post', 'postId', 'cats', 'tags', 'postCats'));
    }

    public function createsaveAction()
    {

        if (!$this->isAdmin()) {
            $this->setFlash('error', 'You don\'t have permission to access that page');
            return $this->redirectToRoute('User_Login');
        }

        $helper          = $this->getService('post.helper');
        $post            = $this->post();
        $requiredKeys    = array('title', 'content');

        // If any fields were missing, inform the client
        $missingFields = $this->checkMissingFields($post, $requiredKeys);
        if (!empty($missingFields)) {
            return $this->createResponse(array(
                'status' => 'error',
                'code'   => 'E_MISSING_FIELDS',
                'value'  => implode(',', $missingFields)
            ));
        }

        // update blog Post...
        $helper->savePost(
            array(
                'id'      => $post['postId'],
                'title'       => $post['title'],
                'content'     => $post['content'],
                'slug'        => $this->slug($post['title']),
                'modified_at' => date('Y-m-d H:i:s')
            )
        );

        // store tags
        if (!empty($post['tag'])) {
            $helper->saveTags($post['tag'], $post['postId']);
        }

        // store categories
        if (!empty($post['category'])) {
            $helper->saveCategories($post['category'], $post['postId']);
        }

        return $this->createResponse(array(
            'status'  => 'success',
            'code'    => 'OK',
            'message' => 'Blog post updated successfully.',
            'postId'  => $post['postId']
        ));

    }

    public function update()
    {

        if (!$this->isAdmin()) {
            $this->setFlash('error', 'You don\'t have permission to access that page');
            return $this->redirectToRoute('User_Login');
        }

        $storage         = $this->getService('post.storage');
        $post            = $this->post();
        $requiredKeys    = array('title');

        // If any fields were missing, inform the client
        $missingFields = $this->checkMissingFields($post, $requiredKeys);
        if (!empty($missingFields)) {
            return $this->createResponse(array(
                'status' => 'error',
                'code'   => 'E_MISSING_FIELDS',
                'value'  => implode(',', $missingFields)
            ));
        }

        $postId = $storage->update(
            array(
                'title'       => $post['title'],
                'content'     => $post['content'],
                'slug'        => $this->slug($post['title']),
                'modified_at' => date('Y-m-d H:i:s')
            ),
            array('id' => $post['postId'])
        );

        return $this->createResponse(array(
            'status'  => 'success',
            'code'    => 'OK',
            'message' => 'Blog Post Added successfully.',
            'postId'  => $postId
        ));
    }

    public function publishAction()
    {

        if (!$this->isAdmin()) {
            $this->setFlash('error', 'You don\'t have permission to access that page');
            return $this->redirectToRoute('User_Login');
        }

        $storage = $this->getService('post.storage');
        $post    = $this->post();

        $storage->update(
            array('published' => 1),
            array('id' => $post['id'])
        );

        return $this->createResponse(
            array(
                'status' => 'success',
                'code'   => 'OK'
            )
        );
    }

    public function deleteAction()
    {

        if (!$this->isAdmin()) {
            $this->setFlash('error', 'You don\'t have permission to access that page');
            return $this->redirectToRoute('User_Login');
        }

        $id = $this->getRouteParam('id');
        if(!filter_var($id, FILTER_VALIDATE_INT)) {
            die('E_INVALID_ID');
        }

        $this->getService('post.storage')->deleteByID($id);
        $this->setFlash('success', 'Blog Post was deleted successfully');

        return $this->redirectToRoute('Blog_Admin_Index');
    }

}