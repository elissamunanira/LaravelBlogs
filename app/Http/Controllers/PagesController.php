<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'WELCOME TO BLOGS APP';
        // return view('pages/index', compact ('title'));
        return view('pages/index')-> with ('title', $title);
    }
    public function about(){
        $title = 'About us';
        return view('pages/about')-> with ('title' , $title);
    }
    public function services(){
        $data = array (
            'title' => 'Services',
            'services' => ['We help the new users to create their own blogs ', 'We give the Advice about how can create the websites blogsapp']
        );
        return view('pages/services')-> with($data);
    }
}
