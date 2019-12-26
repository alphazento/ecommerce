<?php

namespace Zento\Backend\Http\Controllers\Api;

use Auth;
use Route;
use Storage;
use Zento\StoreFront\Consts;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileUploadController extends ApiBaseController
{
    public function uploadFile(Request $request) {
        if(!$request->hasFile('file0')) {   
            return $this->error(422, 'upload file not found');
        }
        $file = $request->file('file0');
        if(!$file->isValid()) {
            return $this->error(422, 'invalid file upload');
        }

        return $this->saveFile($file, Route::input('folder', ''), Route::input('visibility'));
    }

    protected function saveFile($file, $folder, $visibility) {
        $strategy = $this->getStrategy($visibility);
        $fileName = $this->prettyName($file->getClientOriginalName());

        $url = '';
        switch($strategy) {
            case 'local':
                $disk = config($visibility === 'public' ? Consts::PUBLIC_FILE_UPLOAD_STORAGE : Consts::PRIVATE_FILE_UPLOAD_STORAGE);
                $path = $file->storeAs($folder, $fileName, compact('disk', 'visibility'));
                $url = Storage::disk($disk)->url($path);
                break;
            case 'cloud':
                $disk = config(CLOUD_STORAGE);
                $path = $file->storeAs($folder, $fileName, compact('disk', 'visibility'));
                $url = Storage::disk($disk)->url($path);
                break;
            case 'both':
                $disk = config($visibility === 'public' ? Consts::PUBLIC_FILE_UPLOAD_STORAGE : Consts::PRIVATE_FILE_UPLOAD_STORAGE);
                $path = $file->storeAs($folder, $fileName, compact('disk', 'visibility'));
                $url = Storage::disk($disk)->url($path);

                $disk = config(CLOUD_STORAGE);
                $path = sprintf('%s/%s', $visibility, $folder);
                $file->storeAs($path, Str::slug($file->getClientOriginalName()), compact('disk', 'visibility'));
                break;
        }
                
        if (Str::startsWith($url, env('APP_URL'))){
            $url = Str::replaceFirst(env('APP_URL'), '', $url);
            $url = Str::start($url, '/');
        }
        return $this->success(200)->withData(compact('url'));
    }

    protected function getStrategy($visibility) {
        return config($visibility === 'public' ? Consts::PUBLIC_FILE_UPLOAD_STORE_STRATEGY : Consts::PRIVATE_FILE_UPLOAD_STORE_STRATEGY, 'local');
    }

    protected function prettyName($name) {
        if ($ext = pathinfo($name, PATHINFO_EXTENSION)) {
            $main = substr($name, 0, strlen($name) - strlen($ext));
            return strtolower(sprintf('%s.%s', Str::slug($main), $ext));
        }
        return Str::slug($name);
    }
}
