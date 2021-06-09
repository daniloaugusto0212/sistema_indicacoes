<?php

namespace Anexus\Controllers;

class HomeController
{
    public function index()
    {
        \Anexus\Views\MainView::render('home');
    }
}
