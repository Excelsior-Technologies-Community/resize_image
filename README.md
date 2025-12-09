# Laravel 11 – Resize Image Before Upload (Using Intervention Image)
![Laravel](https://img.shields.io/badge/Laravel-11-orange)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Twilio](https://img.shields.io/badge/Twilio-OTP-red)
![Email](https://img.shields.io/badge/SMTP-Mail-green)
## 🚀 Features
- Upload Original Image  
- Auto-generate 100x100 Thumbnail  
- Uses Intervention Image Package  
- Laravel 11 Compatible  
- Clean Code + Fully Commented  

## 📦 Step 1: Install Laravel 11
```bash
composer create-project laravel/laravel example-app
```

## 🖼 Step 2: Install Intervention Image Package
```bash
composer require intervention/image-laravel
```

## 🛣 Step 3: Add Routes
```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Route::get('image-upload', [ImageController::class, 'index']);
Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');
```

## 🎮 Step 4: ImageController
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    public function index(): View
    {
        return view('imageUpload');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();

        $destinationPathThumbnail = public_path('images/thumbnail');
        $img = Image::read($image->path());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail.'/'.$imageName);

        $destinationPath = public_path('/images');
        $image->move($destinationPath, $imageName);

        return back()->with('success', 'Image Uploaded successfully!')
                     ->with('imageName', $imageName);
    }
}
```

## 🖥 Step 5: View File
```html
<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Resize Image Before Upload Example</title>
</head>
<body>
<div class="container">
    <h3>Laravel 11 Resize Image Before Upload Example</h3>
</div>
</body>
</html>
```

## 📁 Folder Structure
```
public/
 └── images/
       └── thumbnail/
```

## ▶ Run App
```bash
php artisan serve
```

Visit:
```
http://localhost:8000/image-upload

<img width="1588" height="811" alt="image" src="https://github.com/user-attachments/assets/ca5ad637-72f2-4604-8ed3-5d9fe521ccda" />




