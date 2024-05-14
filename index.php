<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue with Tailwind CSS, DaisyUI, and Composition API</title>
    <script src="/pharmacy_vue_php/assets/js/vue.global.js"></script>
    <link href="/pharmacy_vue_php/assets/css/daisy.css" rel="stylesheet" type="text/css" />
    <script src="/pharmacy_vue_php/assets/js/tailwind.js"></script>
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#036d21]">
            <div>
                <div class="pb-3 text-white">
                    <center>
                        <span class="text-2xl font-semibold">
                            <div>
                                <a href="#">
                                    <img src="/pharmacy_vue_php/assets/img/mmwghlogo.png" alt="Logo" class="w-40 h-40">
                                </a>
                                <a href="/">
                                    <h1 class="text-5xl font-bold">IMIS Pharmacy System</h1>
                                </a>
                                <!-- <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p> -->
                            </div>
                        </span>
                    </center>
                </div>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form method="post" action="scripts/login.php">
                    <div class="mt-6 ">
                        <label class="block font-medium text-sm text-gray-700" for="username" value="Username" />
                        <input type='text' name='username' placeholder='Username' class="input input-bordered w-full shadow-md" />
                    </div>
                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700" for="password" value="Password" />
                        <div class="relative">
                            <input id="password" type='password' name='password' placeholder='Password' required autocomplete='current-password' class="input input-bordered w-full shadow-md">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn bg-[#036d21] hover:bg-green-900 text-white font-bold py-2 px-4 rounded-full w-full shadow-lg" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
