<?php

namespace App\Listeners;

use App\Events\TempFileDownloaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DeleteTempFiles implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param TempFileDownloaded $event
     * @return void
     */
    public function handle(TempFileDownloaded $event)
    {

        //

        if ($event->tempFile->type == 'directory')
            Storage::disk('public')->deleteDirectory($event->tempFile->path); //remove template folder
        else
            Storage::disk('public')->delete($event->tempFile->path);//remove .zipfile

    }
}
