<?php
session_start();
if (isset($_SESSION['iuid'])) {
    if ($_SESSION['iupriv'] == 1)
        header("location: dashboard.php");
    elseif ($_SESSION['iupriv'] == 0)
        header("location: dashboard.php");
    else
        header("location: dashboard.php");
    ob_end_flush();;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <script src="/student-records/assets/js/vue.global.js"></script>
    <link href="/student-records/assets/css/daisy.css" rel="stylesheet" type="text/css" />
    <script src="/student-records/assets/js/tailwind.js"></script>
    <script src="/student-records/assets/js/sweetalert.js"></script>
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#036d21]">
            <div>
                <div class="pb-3 text-white">
                    <center>
                        <span class="text-2xl font-semibold">
                            <div>

                                <a href="/">
                                    <h1 class="text-5xl font-bold">Student Logs System</h1>
                                </a>
                                <!-- <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p> -->
                            </div>
                        </span>
                    </center>
                </div>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form id="loginForm">
                    <div class="mt-6">
                        <label class="block font-medium text-sm text-gray-700" for="username">Username</label>
                        <input v-model="username" type="text" name="username" placeholder="Username" class="input input-bordered w-full shadow-md">
                    </div>
                    <div class="mt-6">
                        <label class="block font-medium text-sm text-gray-700" for="password">Password</label>
                        <input v-model="password" id="password" type="password" name="password" placeholder="Password" required autocomplete="current-password" class="input input-bordered w-full shadow-md">
                    </div>
                    <div class="mt-4">
                        <a @click="submitForm" class="btn bg-[#036d21] hover:bg-green-900 text-white font-bold py-2 px-4 rounded-full w-full shadow-lg">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const app = Vue.createApp({
            data() {
                return {
                    username: '',
                    password: ''
                }
            },
            methods: {
                submitForm() {
                    console.log("qweq");
                    fetch("scripts/login.php", {
                            method: 'POST',
                            body: new FormData(loginForm)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                Swal.fire({
                                    title: "Login Error",
                                    text: data.error,
                                    icon: "error"
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }
        });

        app.mount('#loginForm');
    </script>
</body>

</html>
