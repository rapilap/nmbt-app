<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RentsController extends Controller
{
    public function index() {
        return view('products.index');
    }
}
