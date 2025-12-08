<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Resize Image Before Upload Example - ItSolutionStuff.com</title>

    <!-- Bootstrap 5 CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Font Awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
        
<body>
<div class="container">
  
    <!-- Card container for the UI structure -->
    <div class="card mt-5">

        <!-- Card Header -->
        <h3 class="card-header p-3">
            <i class="fa fa-star"></i> Laravel 11 Resize Image Before Upload Example - ItSolutionStuff.com
        </h3>

        <div class="card-body">

            <!-- Display validation errors -->
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
  
            <!-- Display success message and show uploaded images -->
            @session('success')
                <div class="alert alert-success" role="alert"> 
                    {{ $value }}
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <!-- Display original uploaded image -->
                        <strong>Original Image:</strong>
                        <br/>
                        <img src="/images/{{ Session::get('imageName') }}" width="300px" />
                    </div>

                    <div class="col-md-4">
                        <!-- Display generated thumbnail image -->
                        <strong>Thumbnail Image:</strong>
                        <br/>
                        <img src="/images/thumbnail/{{ Session::get('imageName') }}" />
                    </div>
                </div>
            @endsession
            
            <!-- Image Upload Form -->
            <!-- enctype="multipart/form-data" is required for file uploads -->
            <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
        
                <!-- File Input Field -->
                <div class="mb-3">
                    <label class="form-label" for="inputImage">Image:</label>
                    <input 
                        type="file" 
                        name="image" 
                        id="inputImage"
                        class="form-control @error('image') is-invalid @enderror">

                    <!-- Display input validation error -->
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
         
                <!-- Submit Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Upload
                    </button>
                </div>
             
            </form>
        </div>
    </div>
</div>
</body>
</html>
