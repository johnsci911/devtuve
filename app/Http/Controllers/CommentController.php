<?php

namespace App\Http\Controllers;

use App\Models\Video;

class CommentController extends Controller
{
    public function index(Video $video)
    {
        return $video->comments()->paginate(5);
    }
}
