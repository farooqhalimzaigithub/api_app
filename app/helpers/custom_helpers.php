<?php

if (!function_exists('ApiResponse')) {
    /**
     * Return a standardized JSON response.
     *
     * @param  bool  $status
     * @param  string  $message
     * @param  mixed  $data
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
    function ApiResponse($status = true, $message = '', $data = null, $code = 200)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}

if (!function_exists('UploadPhoto')) {
    /**
     * Upload a photo to the specified folder.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @param  string  $folder
     * @return string|null
     */
    function UploadPhoto($photo, $folder = 'images')
    {
        if (!$photo || !$photo->isValid()) {
            return null;
        }

        // Create the folder if it doesn't exist
        $destinationPath = public_path($folder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Generate a unique name for the image
        $imageName = time() . '_photo.' . $photo->getClientOriginalExtension();

        // Move the uploaded file to the public folder
        $photo->move($destinationPath, $imageName);

        // Return the relative file path
        return '/' . $folder . '/' . $imageName;
    }
}

if (!function_exists('uploadProfileImage')) {
    /**
     * Upload a profile image and return its uploaded path.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $path
     * @param  string|null  $fileName
     * @return string|null
     */
    function uploadProfileImage($file, $path, $fileName = null)
    {
        if (!$file) {
            return null;
        }

        // Generate a file name if none is provided
        $fileName = $fileName ?: time() . '.png';

        // Use the Storage facade to store the file in the specified path
        $storedPath = $file->storeAs($path, $fileName, 'public');

        return $storedPath;
    }
}

if (!function_exists('generateVerificationCode')) {
    /**
     * Generate a 6-digit verification code.
     *
     * @return string
     */
    function generateVerificationCode()
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
