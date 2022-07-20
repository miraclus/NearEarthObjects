<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function index(): string
    {
        return json_encode(['hello' => "MacPaw Internship 2022!"]);
    }
}
