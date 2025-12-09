
# PHP_Laravel11_Resize_Images_Before_Upload

This guide explains how to upload an image and automatically generate a resized thumbnail before saving it.  
It uses the **Intervention Image Library** for resizing.  
Based on your provided tutorial.

---

# Step 1: Install Laravel 11

If you haven’t created a Laravel project yet, run:

```
composer create-project laravel/laravel example-app
```

---

# Step 2: Install Intervention Image Package

Install the image processing library:

```
composer require intervention/image-laravel
```

This package helps in resizing images and generating thumbnails.

---

# Step 3: Create Routes

Add these routes inside `routes/web.php`:

```php
use App\Http\Controllers\ImageController;

Route::get('image-upload', [ImageController::class, 'index']);
Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');

Route::get('/', function () {
    return view('welcome');
});
```

---

# Step 4: Create Controller File

Create ImageController:

```
php artisan make:controller ImageController
```

Open `app/Http/Controllers/ImageController.php` and paste this code:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    public function index()
    {
        return view('imageUpload');
    }

    public function store(Request $request)
    {
        // Validate uploaded image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Get uploaded file
        $image = $request->file('image');

        // Create unique image name
        $imageName = time().'.'.$image->extension();

        /**
         * STEP 1: Create and Save Thumbnail (100x100)
         */
        $destinationPathThumbnail = public_path('images/thumbnail');

        $img = Image::read($image->path());

        $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
        })->save($destinationPathThumbnail.'/'.$imageName);

        /**
         * STEP 2: Save Original Image
         */
        $destinationPath = public_path('images');
        $image->move($destinationPath, $imageName);

        /**
         * STEP 3: Return With Success Message
         */
        return back()->with('success', 'Image Uploaded successfully!')
                     ->with('imageName', $imageName);
    }
}
```

Make sure folders exist:  
- `public/images`  
- `public/images/thumbnail`

---

# Step 5: Create View File (imageUpload.blade.php)

Create: `resources/views/imageUpload.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Resize Image Before Upload Example</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
<div class="container">

    <div class="card mt-5">
        <h3 class="card-header p-3">
            <i class="fa fa-star"></i> Laravel 11 Resize Image Before Upload Example
        </h3>

        <div class="card-body">

            <!-- Validation Errors -->
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success message + Show images -->
            @session('success')
                <div class="alert alert-success">{{ $value }}</div>

                <div class="row">
                    <div class="col-md-4">
                        <strong>Original Image:</strong><br/>
                        <img src="/images/{{ Session::get('imageName') }}" width="300px" />
                    </div>

                    <div class="col-md-4">
                        <strong>Thumbnail Image:</strong><br/>
                        <img src="/images/thumbnail/{{ Session::get('imageName') }}" />
                    </div>
                </div>
            @endsession

            <!-- Upload Form -->
            <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Image:</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Upload
                </button>
            </form>

        </div>
    </div>

</div>
</body>
</html>
```

---

 Run App

```
php artisan serve
```

Open:

```
http://localhost:8000/image-upload

```



<img width="1588" height="811" alt="image" src="https://github.com/user-attachments/assets/ca5ad637-72f2-4604-8ed3-5d9fe521ccda" />




