<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy (Image $image)
    {
        //Controllo permessi
        Storage::delete('/public/images/' . $image->file_name);
        $image->delete();
    }
}
