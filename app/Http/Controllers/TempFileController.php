<?php

namespace App\Http\Controllers;

use App\Models\TempFile;
use Illuminate\Support\Facades\Storage;

class TempFileController extends Controller
{
    //

    public function destroy(TempFile $tempFile)
    {
        if ($this->destroyOriginalFile($tempFile))
            return $tempFile->delete();

    }

    public function destroyOriginalFile(TempFile $tempFile)
    {

        if ($tempFile->type == 'directory')
            Storage::disk('public')->deleteDirectory($tempFile->path); //remove template folder
        else
            Storage::disk('public')->delete($tempFile->path);//remove .zipfile

        return true;
    }
}
