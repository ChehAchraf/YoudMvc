<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Create your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Already have an account?
            <a href="<?php echo URLROOT; ?>/users/login" class="font-medium text-indigo-600 hover:text-indigo-500">
                Sign in here
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="<?php echo URLROOT; ?>/users/register" method="POST">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">
                        First Name
                    </label>
                    <div class="mt-1">
                        <input id="first_name" name="first_name" type="text" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            <?php echo (!empty($data['first_name_err'])) ? 'border-red-500' : ''; ?>"
                            value="<?php echo $data['first_name'] ?? ''; ?>"
                        >
                        <span class="text-red-500 text-xs italic"><?php echo $data['first_name_err'] ?? ''; ?></span>
                    </div>
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">
                        Last Name
                    </label>
                    <div class="mt-1">
                        <input id="last_name" name="last_name" type="text" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            <?php echo (!empty($data['last_name_err'])) ? 'border-red-500' : ''; ?>"
                            value="<?php echo $data['last_name'] ?? ''; ?>"
                        >
                        <span class="text-red-500 text-xs italic"><?php echo $data['last_name_err'] ?? ''; ?></span>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            <?php echo (!empty($data['email_err'])) ? 'border-red-500' : ''; ?>"
                            value="<?php echo $data['email'] ?? ''; ?>"
                        >
                        <span class="text-red-500 text-xs italic"><?php echo $data['email_err'] ?? ''; ?></span>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">
                        I want to
                    </label>
                    <div class="mt-1">
                        <select id="role" name="role" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            <?php echo (!empty($data['role_err'])) ? 'border-red-500' : ''; ?>"
                        >
                            <option value="student" <?php echo (isset($data['role']) && $data['role'] == 'student') ? 'selected' : ''; ?>>Learn - I'm a Student</option>
                            <option value="teacher" <?php echo (isset($data['role']) && $data['role'] == 'teacher') ? 'selected' : ''; ?>>Teach - I'm an Instructor</option>
                        </select>
                        <span class="text-red-500 text-xs italic"><?php echo $data['role_err'] ?? ''; ?></span>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            <?php echo (!empty($data['password_err'])) ? 'border-red-500' : ''; ?>"
                        >
                        <span class="text-red-500 text-xs italic"><?php echo $data['password_err'] ?? ''; ?></span>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <div class="mt-1">
                        <input id="confirm_password" name="confirm_password" type="password" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            <?php echo (!empty($data['confirm_password_err'])) ? 'border-red-500' : ''; ?>"
                        >
                        <span class="text-red-500 text-xs italic"><?php echo $data['confirm_password_err'] ?? ''; ?></span>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        I agree to the 
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Terms and Conditions</a>
                        and
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                    </label>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            Or continue with
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div>
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Sign up with Google</span>
                            <i class="fab fa-google text-red-500"></i>
                        </a>
                    </div>

                    <div>
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Sign up with GitHub</span>
                            <i class="fab fa-github text-gray-900"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
