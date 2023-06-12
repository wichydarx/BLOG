<?php

namespace Model;

use Model\Model;

class PostModel extends Model
{
    protected $table = 'posts';

    public function createPost($title, $author, $body, $category_id, $slug)
    {
        $query = "INSERT INTO $this->table (title, author, body, category_id, slug) VALUES (:title, :author, :body, :category_id, :slug)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':slug', $slug);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            printf("Error: %s.\n",$error[2]);
            return false;
        }
    }

    public function updatePost($id,$title,$author,$body,$category_id,$slug){
        $query = "UPDATE articles SET title = :title, author = :author, body = :body, category_id = :category_id, slug = :slug WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':slug', $slug);

        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            printf("Error: %s.\n", $errorInfo[2]);
            return false;
        }

    }
}
