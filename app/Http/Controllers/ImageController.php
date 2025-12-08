<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    /**
     * Show the image upload form.
     *
     * @return View
     */
    public function index(): View
    {
        // Return the image upload blade file
        return view('imageUpload');
    }
        
    /**
     * Handle image upload, resize and save.
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the uploaded image (only specific formats allowed)
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
   
        // Get the uploaded image from the request
        $image = $request->file('image');

        // Create a unique image name using current timestamp + original extension
        $imageName = time().'.'.$image->extension();
       
        /**
         * ---------------------------------------------------------
         * STEP 1: Create and Save Thumbnail (Resize to 100x100)
         * ---------------------------------------------------------
         */

        // Set the path where thumbnail will be saved (public/images/thumbnail)
        $destinationPathThumbnail = public_path('images/thumbnail');

        // Read the uploaded image using Intervention Image Library
        $img = Image::read($image->path());

        // Resize image to 100x100 while keeping aspect ratio
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })

        // Save the resized thumbnail image in the thumbnail folder
        ->save($destinationPathThumbnail.'/'.$imageName);
     
        /**
         * ---------------------------------------------------------
         * STEP 2: Save Original Image
         * ---------------------------------------------------------
         */

        // Set the path for saving the original uploaded image
        $destinationPath = public_path('/images');

        // Move original image to public/images folder
        $image->move($destinationPath, $imageName);
     
        /**
         * ---------------------------------------------------------
         * STEP 3: Return with Success Message
         * ---------------------------------------------------------
         */

        // Redirect back with success message and image name
        return back()->with('success', 'Image Uploaded successfully!')
                     ->with('imageName', $imageName);
    }
}
