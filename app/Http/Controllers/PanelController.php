<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PanelController extends Controller
{
    public function __invoke()
    {
        return view('panel.index');
    }
}
