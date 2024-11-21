<?php

namespace app\models;

// Using the database class namespace
use app\models\Model;

class Post extends Model {

    public function getAllPosts() {
        $query = "SELECT * FROM posts";
        return $this->fetchAll($query);
    }

    public function getPostById($id) {
        $query = "SELECT * FROM posts WHERE id = :id";
        return $this->fetchOneWithParams($query, ['id' => $id]);
    }

    public function createPost($data) {
        $query = "INSERT INTO posts (title, content, author, created_at) VALUES (:title, :content, :author, NOW())";
        return $this->execute($query, [
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => $data['author']
        ]);
    }

    public function updatePost($id, $data) {
        $query = "UPDATE posts SET title = :title, content = :content, author = :author WHERE id = :id";
        return $this->execute($query, [
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => $data['author'],
            'id' => $id
        ]);
    }

    public function deletePost($id) {
        $query = "DELETE FROM posts WHERE id = :id";
        return $this->execute($query, ['id' => $id]);
    }
}
?>
