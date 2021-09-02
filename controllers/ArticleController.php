<?php

namespace App\Controllers;

use App\Models\Article;
use App\Core\View;

class ArticleController {
  public function lastArticles(){

    $articles = Article::all();

    return new View('articles/index', [
      'articles' => $articles
    ]);
  }
  public function newArticle(){

    $article = new Article;
    $article->title = 'new';
    $article->slug = "new";
    $article->save();
  }
}
