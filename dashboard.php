<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Order System | EFMU</title>
    <script src="/pharmacy_vue_php/assets/js/vue.global.js"></script>
    <link href="/pharmacy_vue_php/assets/css/daisy.css" rel="stylesheet" type="text/css" />
    <script src="/pharmacy_vue_php/assets/js/tailwind.js"></script>
    <style>
        body {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }
    </style>
</head>

<body class="bg-[#036d21]">
    <div id="app" class="bg-white min-h-screen flex flex-col">
        <div class="navbar bg-[#036d21] text-white fixed top-0 left-0 w-full z-10">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="/pharmacy_vue/dashboard.php">Home</a></li>
                        <li><a>Item 3</a></li>
                    </ul>
                </div>
                <a class="btn btn-ghost text-xl"><img class="h-12 w-auto" src="/pharmacy_vue_php/assets/img/mmwghlogo.png" alt="Logo"></a>
                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1">
                        <li><a href="/pharmacy_vue/dashboard.php">Home</a></li>
                        <!-- <li><a>Item 3</a></li> -->
                    </ul>
                </div>
            </div>

            <div class="navbar-end">
                <div class="dropdown dropdown-hover dropdown-left">
                    <div tabindex="0" role="button" class="btn m-1">Hey, #NAME</div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 text-black">
                        <li><a>Item 1</a></li>
                        <hr>
                        <li class="mt-10"><a class="btn btn-error" href="/pharmacy_vue_php/logout.php">Logout</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="container pt-10 px-10">

            {{state.message}}
            <input v-model="state.message" type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />

        </div>

        <footer class="fixed bottom-0 left-0 w-full bg-[#036d21] text-white z-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-white hover:text-gray-200">Privacy Policy</a>
                    <a href="#" class="text-white hover:text-gray-200">Terms of Service</a>
                    <a href="#" class="text-white hover:text-gray-200">Contact Us</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        const {
            createApp,
            reactive
        } = Vue

        createApp({
            setup() {
                const state = reactive({
                    message: 'Hello vue!',
                    isMenuOpen: false
                })

                const toggleMenu = () => {
                    state.isMenuOpen = !state.isMenuOpen
                }

                return {
                    state,
                    toggleMenu
                }
            }
        }).mount('#app')
    </script>
</body>

</html>
