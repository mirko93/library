@extends('layouts.app')

@section('content')
    <div class="w-2/3 p-6 mx-auto bg-gray-200">
        <form action="/authors" method="POST">
            
            @csrf

            <h1>Add New Author</h1>
            
            <div class="pt-4">
                <input type="text" name="name" 
                    placeholder="Full Name"
                    class="w-1/2 px-4 py-2 rounded">
                @error('name')
                    <p class="text-red-600" role="alert">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="pt-4">
                <input type="text" name="dob" 
                    placeholder="Date of Birth"
                    class="w-1/2 px-4 py-2 rounded">
                @error('dob')
                    <p class="text-red-600" role="alert">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="pt-4">
                <button class="px-4 py-2 text-white bg-blue-400 rounded">Add New Author</button>
            </div>
        </form>
    </div>
@endsection