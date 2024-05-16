<?php
session_start();
if (empty($_SESSION['iuid'])) {
    header("location: index.php");
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
                        <li><a href="/student-records/dashboard.php">Home</a></li>
                        <li><a>Item 3</a></li>
                    </ul>
                </div>

                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1">
                        <li><a href="/student-records/dashboard.php">Home</a></li>
                    </ul>
                </div>
            </div>

            <div class="navbar-end">
                <div class="dropdown dropdown-hover dropdown-left">
                    <div tabindex="0" role="button" class="btn m-1">Hey, <?= $_SESSION['ifname'] ?></div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 text-black">
                        <li><a>Item 1</a></li>
                        <hr>
                        <li class="mt-10"><a class="btn btn-error" href="/student-records/scripts/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container pt-10 px-10 mx-auto  justify-center items-center">
            <div>
                <button class="btn" onclick="my_modal_1.showModal()">Add Student</button>
                <dialog id="my_modal_1" class="modal">
                    <div class="modal-box">
                        <form @submit.prevent="handleSubmit">
                            <input type="hidden" v-model="state.form.id">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Student ID</span>
                                </label>
                                <input type="text" v-model="state.form.student_id_number" placeholder="Student ID" class="input input-bordered" required>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">RFID</span>
                                </label>
                                <input type="text" v-model="state.form.rfid" placeholder="RFID" class="input input-bordered" required>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">First Name</span>
                                </label>
                                <input type="text" v-model="state.form.first_name" placeholder="First Name" class="input input-bordered" required>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Last Name</span>
                                </label>
                                <input type="text" v-model="state.form.last_name" placeholder="Last Name" class="input input-bordered" required>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Email</span>
                                </label>
                                <input type="email" v-model="state.form.email" placeholder="Email" class="input input-bordered" required>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Username</span>
                                </label>
                                <input type="text" v-model="state.form.username" placeholder="Username" class="input input-bordered" required>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Password</span>
                                </label>
                                <input type="password" v-model="state.form.password" placeholder="Password" class="input input-bordered">
                            </div>
                            <div class="form-control mt-6">
                                <button type="submit" class="btn btn-primary">{{ state.form.id ? 'Update' : 'Create' }}</button>
                            </div>
                        </form>


                        <form method="dialog">
                            <div class="form-control mt-3">
                                <button type="submit" class="btn btn-error">Close</button>
                            </div>
                        </form>

                    </div>
                </dialog>

            </div>

            <div class="mt-10">
                <h2 class="text-2xl mb-4">Student List</h2>
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>RFID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student in state.students" :key="student.id">
                            <td>{{ student.student_id_number }}</td>
                            <td>{{ student.rfid }}</td>
                            <td>{{ student.first_name }}</td>
                            <td>{{ student.last_name }}</td>
                            <td>{{ student.email }}</td>
                            <td>{{ student.username }}</td>
                            <td>
                                <button @click="fetchStudentData(student.id)" class="btn btn-sm btn-info mx-2">
                                    View Entry Logs
                                </button>
                                <button @click="editStudent(student)" onclick="my_modal_1.showModal()" class="btn btn-sm btn-info" v-if="student.deleted_at">Edit</button>
                                <button @click="deleteStudent(student.id)" class="btn btn-sm btn-error" v-if="!student.deleted_at">Delete</button>
                                <button @click="restoreStudent(student.id)" class="btn btn-sm btn-warning" v-if="student.deleted_at">Restore</button>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="isModalOpen" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded-lg p-8 max-w-md mx-auto">
                <h2 class="text-2xl font-semibold mb-4">Student Entry Logs</h2>
                <div v-if="isLoading"><span class="loading loading-spinner loading-lg"></span></div>
                <div v-else>
                    <div v-if="studentInfo.student" class="divide-y divide-gray-200">
                        <div v-for="(entry, index) in studentInfo.student" :key="index" class="py-2">
                            <kbd class="kbd">{{index}}</kbd>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>Datetime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="entries in entry">
                                        <td></td>
                                        <td>{{entries['type'] == 'IN' ? '✓' : ''}}</td>
                                        <td>{{entries['type'] == 'OUT' ? '✓' : ''}}</td>
                                        <td>{{formatTime(entries['created_at'])}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p v-else-if="studentInfo.error">{{studentInfo.error}}</p>
                </div>
                <button @click="closeModal" class="mt-4 btn bg-gray-300 hover:bg-gray-400">Close</button>
            </div>
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
            reactive,
            onMounted,
            ref
        } = Vue;

        createApp({
            setup() {
                const isModalOpen = ref(false);
                const isLoading = ref(false);
                const studentInfo = ref('');
                const state = reactive({
                    students: [],
                    form: {
                        id: '',
                        student_id_number: '',
                        rfid: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        username: '',
                        password: ''
                    }
                });

                const loadStudents = () => {
                    fetch('/student-records/scripts/student_records.php')
                        .then(response => response.json())
                        .then(data => {
                            state.students = data;
                        });
                };

                const handleSubmit = () => {
                    const formData = new FormData();
                    Object.keys(state.form).forEach(key => {
                        formData.append(key, state.form[key]);
                    });

                    const action = state.form.id ? 'update' : 'create';
                    formData.append(action, true);

                    fetch('/student-records/scripts/student_records.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert(data);
                            resetForm();
                            loadStudents();
                        });
                };

                const editStudent = (student) => {
                    state.form = {
                        ...student,
                        password: ''
                    };
                };

                const deleteStudent = (id) => {
                    fetch('/student-records/scripts/student_records.php', {
                            method: 'POST',
                            body: new URLSearchParams({
                                delete: true,
                                id
                            })
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert(data);
                            loadStudents();
                        });
                };

                const restoreStudent = (id) => {
                    fetch('/student-records/scripts/student_records.php', {
                            method: 'POST',
                            body: new URLSearchParams({
                                restore: true,
                                id
                            })
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert(data);
                            loadStudents();
                        });
                };

                const resetForm = () => {
                    state.form = {
                        id: '',
                        student_id_number: '',
                        rfid: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        username: '',
                        password: ''
                    };
                };

                onMounted(() => {
                    loadStudents();
                });
                const closeModal = () => {
                    isModalOpen.value = false;
                };
                const fetchStudentData = async (id) => {
                    isLoading.value = true;

                    const response = await fetch('/student-records/scripts/rfid.php?student_id=!@!!!'.replace("!@!!!", id));
                    const data = await response.json();
                    studentInfo.value = data;

                    isModalOpen.value = true;
                    isLoading.value = false;

                };
                const formatTime = (datetime) => {
                    const date = new Date(datetime);
                    return date.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true
                    });
                };
                return {
                    state,
                    handleSubmit,
                    editStudent,
                    deleteStudent,
                    restoreStudent,
                    resetForm,
                    closeModal,
                    fetchStudentData,
                    isModalOpen,
                    studentInfo,
                    isLoading,
                    formatTime,
                };
            }
        }).mount('#app');
    </script>
</body>

</html>
