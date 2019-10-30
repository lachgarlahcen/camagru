<?php

class Pages extends Controller
{
    public function __construct()
    {
    }
    public function windex()
    {
        $this->view('pages/index',['title' => 'welcome']);
    }

    public function wabout()
    {
        $this->view('pages/about',['title' => 'ABOUT']);
    }
}