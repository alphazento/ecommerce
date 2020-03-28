<?php

namespace Zento\Backend\Http\Controllers\Api;

use Request;
use Route;
use Storage;
use Zento\StoreFront\Consts;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Illuminate\Support\Str;

class StorageFileFinder extends ApiBaseController
{
    /**
     * find specified files in specified folder
     * @group FileFinder
     * @urlParam visibility required string availabe values ['public', 'private']
     * @urlParam folder string find in specified folder
     * @bodyParam type required string find file type
     * @bodyParam text required string find file name
     */
    public function findFiles() {
        $visibility = Route::input('visibility');
        $folder = Route::input('folder', '');
        $fileType = Request::get('type');
        $searchText = Request::get('text');

        $strategy = $this->getStrategy($visibility);
        switch($strategy) {
            case 'local':
            case 'both':
                $disk = config($visibility === 'public' ? Consts::PUBLIC_FILE_UPLOAD_STORAGE : Consts::PRIVATE_FILE_UPLOAD_STORAGE);
                $items = $this->findInLocal($disk, $folder, $searchText, $fileType);
                $total = count($items);
                $lastPage = ceil($total / 9);

                $data = [
                    'data' => $items,
                    'per_page' => 9,
                    'last_page' => $lastPage,
                    'from' => 1,
                    'to' => $total > 9 ? 9 : $total,
                    'total' => $total,
                    'local_pagination' => true
                ];
                break;
            case 'cloud':
                $disk = config(CLOUD_STORAGE);
                break;
        }

        return $this->success(200)->withData($data);
    }

    protected function getStrategy($visibility) {
        return config($visibility === 'public' ? Consts::PUBLIC_FILE_UPLOAD_STORE_STRATEGY : Consts::PRIVATE_FILE_UPLOAD_STORE_STRATEGY, 'local');
    }

    /**
     * find in local, ignore page, return all results.
     */
    protected function findInLocal($disk, $folder, $searchText, $fileType) {
        $storage = Storage::disk($disk);
        $searchIn = $storage->path($folder);
        $pattern = "";
        if ($searchText) {
            $searchText = sprintf('*{%s}*', $searchText);
        } else {
            $searchText = '*';
        }
        switch($fileType) {
            case 'image':
            break;
            case 'all':
            case '*':
                $pattern = sprintf('%s/%s', $searchIn, $searchText);
            break;
            
            case '':
                $pattern = sprintf('%s/%s.%s', $searchIn, $searchText, $fileType);
            break;
            default:
                $pattern = sprintf('%s/%s.{%s}', $searchIn, $searchText, $fileType);
            break;
        }

        $files = glob($pattern, GLOB_BRACE);
        $ds = [];
        $storagePath = $storage->path('');
        $appUrl = env('APP_URL');
        foreach($files as $file) {
            $name = Str::replaceFirst($storagePath, '', $file);
            $url = $storage->url($name);
            $value = Str::replaceFirst($appUrl, '', $url);
            $ds[] = [
                'url' => $url,
                'thumbnail' => $url,
                'name' => basename($name),
                'value' => $value
            ];
        }
        return $ds;
    }
}
