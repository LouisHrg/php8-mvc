<?php

namespace App\Controllers;

use App\Models\Article;
use App\Core\View;

class ArticleController {
  public function lastArticles(){

    $result = Article::where('title', 'mon-super-article')
    ->get();

    var_dump($result);
  }
}
