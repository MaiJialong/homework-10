<?php

namespace app\controllers;

use app\models\Post;

class PostController {

    public function validatePost($inputData) {
        $errors = [];
        $title = $inputData['title'];
        $content = $inputData['content'];

        if ($title) {
            $title = htmlspecialchars($title, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($title) < 3) {
                $errors['titleShort'] = 'Title is too short';
            }
        } else {
            $errors['titleRequired'] = 'Title is required';
        }

        if ($content) {
            $content = htmlspecialchars($content, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
        } else {
            $errors['contentRequired'] = 'Content is required';
        }

        return $errors;
    }

    public function index() {
        $postModel = new Post();
        $posts = $postModel->getAllPosts();
        include 'views/posts/view-all.html';
    }

    public function create() {
        include 'views/posts/create.html';
    }

    public function store() {
        $postModel = new Post();
        $errors = $this->validatePost($_POST);

        if (empty($errors)) {
            $postModel->createPost($_POST);
            header('Location: /posts');
        } else {
            include 'views/posts/create.html';
        }
    }

    public function edit($id) {
        $postModel = new Post();
        $post = $postModel->getPostById($id);
        include 'views/posts/edit.html';
    }

    public function update($id) {
        $postModel = new Post();
        $errors = $this->validatePost($_POST);

        if (empty($errors)) {
            $postModel->updatePost($id, $_POST);
            header('Location: /posts');
        } else {
            $post = $_POST;
            $post['id'] = $id;
            include 'views/posts/edit.html';
        }
    }

    public function delete($id) {
        $postModel = new Post();
        $postModel->deletePost($id);
        header('Location: /posts');
    }
}
?>
