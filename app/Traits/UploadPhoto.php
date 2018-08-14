<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Storage;

trait UploadPhoto
{
    private function uploadPhoto(Request $request, $picture, $imageableData)
    {
        if ($request->hasFile('file.' . $picture)) {

            if ($request->file('file.' . $picture)->isValid()) {

                $file = $request->file('file.' . $picture);

                $extension = $file->getClientOriginalExtension();

                if (!in_array($extension, ['png', 'jpg', 'gif'])) {

                    return $this->response->array(['message' => 'upload image an error.']);

                }

                $fileName      = uniqid() . str_random(5) . '.' . $extension;
                $path          = 'upload/' . $picture . '/';
                $fileImageData = getimagesize($file);

                $photo = [
                    'imageable_type' => $picture,
                    'name'           => $fileName,
                    'orig_name'      => $file->getClientOriginalName(),
                    'type'           => $file->getClientMimeType(),
                    'path'           => $path,
                    'size'           => $file->getSize(),
                    'width'          => $fileImageData[0],
                    'height'         => $fileImageData[1],
                ];

                $path = config('filesystems.upload_path') . $path;

                Storage::putFileAs($path, $file, $fileName);

                $imageableDataPhoto = $imageableData->photo;

                if (!is_null($imageableDataPhoto)) {
                    Storage::delete($path . $imageableDataPhoto->name);

                    $imageableData->photo()->update($photo);
                } else {
                    $imageableData->photo()->create($photo);
                }

                return $this->response->array('');
            }
        } else if (isset($request->input($picture)['del_photo'])) {

            $imageableDataPhoto = $imageableData->photo;

            if (!is_null($imageableDataPhoto)) {

                Storage::delete(config('filesystems.upload_path') . $imageableDataPhoto->path . $imageableDataPhoto->name);

                $imageableData->photo()->delete();
            }

        }

        return $this->response->array('');

    }
}
