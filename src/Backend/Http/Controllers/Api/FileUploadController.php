<?php

namespace Zento\Backend\Http\Controllers\Api;

use Auth;
use Route;
use Illuminate\Http\Request;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class FileUploadController extends ApiBaseController
{
    public function uploadFile(Request $request) {
        if(!$request->hasFile('file0')) {   
            return $this->result(false, 'upload file not found');
        }
        $file = $request->file('file0');
        if(!$file->isValid()) {
            return $this->result(false, 'invalid file upload');
        }

        $fileName = $file->getPathname();
        $folder = $this->checkFolder(Route::input('folder', ''));
        $file->move($folder, $newName);
        return $this->result(true, sprintf('%s/%s', $folder, $fileName));
    }

    protected function checkFolder($folder) {
        $folder = sprintf('uploads/%s', $folder);
        $folder = storage_path($folder);
        if (!file_exists($folder)) {
            mkdir($folder, 0775, true);
        }
        return $folder;
    }
}
