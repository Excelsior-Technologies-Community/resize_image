
 Laravel 11 – Resize Image Before Upload (Full Documentation)
![Laravel](https://img.shields.io/badge/Laravel-11-orange)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Twilio](https://img.shields.io/badge/Twilio-OTP-red)
![Email](https://img.shields.io/badge/SMTP-Mail-green)
A complete step-by-step guide to **upload**, **resize**, and **generate thumbnails** using **Laravel 11** and **Intervention Image**.

---

 Overview
This project demonstrates how to:

- Upload an image  
- Validate the image  
- Resize it to **100×100 thumbnail**  
- Save original + thumbnail separately  
- Display both images after upload  

Perfect for:
- E-commerce sites  
- User profile images  
- Gallery systems  
- Admin dashboards  

---

Tech Stack

| Technology | Purpose |
|-----------|---------|
| **Laravel 11** | Backend Framework |
| **Intervention Image** | Image Resizing |
| **Bootstrap 5** | UI Styling |
| **Blade Templates** | Frontend Views |

---

 Project Directory Structure
```
/app
  /Http
    /Controllers
      ImageController.php

/public
  /images
      /thumbnail

/resources/views
  imageUpload.blade.php

/routes
  web.php
```

---
 Step-by-Step Implementation Guide

---

Step 1 — Install Laravel 11
```
composer create-project laravel/laravel example-app
```

---

 Step 2 — Install Intervention Image Package
```
composer require intervention/image-laravel
```

---

 Step 3 — Add Routes

**routes/web.php**
```php
use App\Http\Controllers\ImageController;

Route::get('image-upload', [ImageController::class, 'index']);
Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');
```

---

 Step 4 — Create Controller (ImageController.php)

Core resizing logic:

```php
$img = Image::read($image->path());

$img->resize(100, 100, function ($constraint) {
    $constraint->aspectRatio();
})->save(public_path('images/thumbnail/'.$imageName));

$image->move(public_path('images'), $imageName);
```

 How It Works:
| Step | Explanation |
|------|-------------|
| Validate Image | Makes sure only valid images are uploaded |
| Read Image | Using Intervention Image |
| Resize | Converts to 100×100 thumbnail |
| Save Thumbnail | Saved in `/public/images/thumbnail/` |
| Save Original | Saved in `/public/images/` |

---

 Step 5 — Upload Form (Blade File)

**resources/views/imageUpload.blade.php**

```php
<form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" class="form-control">
    <button class="btn btn-success mt-3">Upload</button>
</form>
```

 Show Uploaded Images:
```php
<img src="/images/{{ Session::get('imageName') }}" width="300px" />
<img src="/images/thumbnail/{{ Session::get('imageName') }}" />
```

---

 Run Laravel Project
Start server:

```
php artisan serve
```

Open in browser:

```
http://localhost:8000/image-upload
```

---

<img width="1588" height="811" alt="image" src="https://github.com/user-attachments/assets/ca5ad637-72f2-4604-8ed3-5d9fe521ccda" />




