<?php

namespace Akhenaton\Controllers;

use Akhenaton\Library\View;
use Akhenaton\Models\NewsModel;

class NewsController
{
    public function index()
    {
        $newsData = new NewsModel();
        $news = $newsData->all();

        View::render('home', ['news' => $news]);
    }
}
