<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <x-slot name="styles">

        <!-- Custom Styles For Image Preview -->
        <style>

            #image_path {
                display: none;
            }

            img {
                cursor: pointer;
                width: 200px;
                height: 200px;
            }

            #user-img {
                margin-top: 10px;
                position: relative;
            }
            #user-img img{
                opacity: 0.8;
                border-radius: 50%
            }
            #overlay {
                position: absolute;
                padding: 80px;
                top: 0;
                left: 0
            }
            #overlay:hover {
                background-image: radial-gradient(ellipse farthest-corner at 45px 45px, rgba(50, 50, 50, 0.8) 0%, rgba(80, 80, 80, 0.2) );
            }

        </style>

    </x-slot>

    <x-slot name="scripts">

        <!-- Custom JS For Image Preview -->
        <script>

            $('#image_path').on('change', function() {
                $
                console.log(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                    $('#temp_pic').attr('src', reader.result).removeClass('default')
                    }
                }
            })

        </script>
    </x-slot>
</x-app-layout>


