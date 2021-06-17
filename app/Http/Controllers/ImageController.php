<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy (Image $image)
    {
        if (Auth::id() !== $image->event->author_id) {
            abort(401);
        }
        $image->delete();
    }
}
