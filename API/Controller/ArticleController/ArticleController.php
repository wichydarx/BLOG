<?php

namespace Controller\ArticleController;
use PDO;
use Model\PostModel;

class ArticleController
{
    static function getArticles(){
        $post = new PostModel();

        $result = $post->getAll();

        $num_row = $result->rowCount();

        if($num_row > 0){
            
            $post_arr =[];
            $post_arr['data'] = [];
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $post_item = [
                    'id' => $id,
                    'title' => $title,
                    'slug' => $slug,
                    'author' => $author,
                    'post_body' => $body,
                    'category_id' => $category_id,
                    'category_name' => $category_name,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ];
                array_push($post_arr['data'], $post_item);
            }
            echo json_encode($post_arr);
        }else{
            echo json_encode([
                'error' => 'Articles not found'
            ]);
        }
    }

}
