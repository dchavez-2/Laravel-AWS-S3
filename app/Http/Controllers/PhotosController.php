<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

use App\Models\Photos;

class PhotosController extends Controller
{
    public function getPhotos(): Response
    {
        try {
            $photos = Photos::orderBy('id', 'desc')->get();

            return Response()->json(
                [
                    'data' => $photos,
                    'message' => 'all photos successfully',
                    'status' => 200,
                ],
                200
            );
        } catch (\Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }

    public function createPhoto(Request $request): Response
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            // 'photo' => 'required|mimes:jpg,png,jpeg',
        ]);
        try {
            $input = $request->all();

            $photo = new Photos();
            $photo->name = $input['name'];
            $photo->description = $input['description'];

            $folder = 'photos';

            $photo_path = Storage::disk('s3')->put(
                $folder,
                $input['photo'],
                'public'
            );

            $photo->photo_path = $photo_path;

            return Response()->json(
                [
                    'message' => 'Photo successfully created.',
                    'status' => 200,
                ],
                200
            );
        } catch (\Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }

    public function updatePhoto(Request $request): Response
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            // 'photo' => 'required|mimes:jpg,png,jpeg',
        ]);

        try {
            $id = $request->id;
            $photo = Photos::where([
                'id' => $id,
            ])->firstOrFail();
            $photoPath = $photo->photo_path;
            Storage::disk('s3')->delete($photoPath);
            $photo->delete();

            return Response()->json(
                [
                    'message' => 'Photo successfully deleted.',
                    'status' => 200,
                ],
                200
            );
        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }

    public function deletePhoto(Request $request): Response
    {
        try {
            $input = $request->all();

            $photo = Photos::findOrFail($request->id);
            $photo->name = $input['name'];
            $photo->description = $input['description'];
            $photoPath = $company->photo_path;
            Storage::disk('s3')->delete($photoPath);

            $folder = 'photo';

            $photoPath = Storage::disk('s3')->put(
                $folder,
                $input['photo'],
                'public'
            );
            $photo->photo_path = $photoPath;

            $photo->save();
            return Response()->json(
                [
                    'message' => 'Photo successfully updated.',
                    'status' => 200,
                ],
                200
            );
        } catch (Exception $error) {
            return Response()->json(
                [
                    'message' => $error->getMessage(),
                    'line' => $error->getLine(),
                    'file' => $error->getFile(),
                ],
                500
            );
        }
    }
}
