<?php

namespace App\Controllers;

use App\Models\Article;
use App\Core\View;

class ArticleController {
  public function lastArticles(){

    $article = Article::find(5);

    $article->delete();
  }
}
