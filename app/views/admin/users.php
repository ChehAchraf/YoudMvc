<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-100">
    <!-- Admin Navigation -->
    <?php require APPROOT . '/views/inc/admin_nav.php'; ?>

    <div class="py-10">
        <header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">
                    Manage Users
                </h1>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Message -->
                <?php flash('admin_message'); ?>

                <!-- Users Table -->
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Email
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach($data['users'] as $user): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo $user->first_name . ' ' . $user->last_name; ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        <?php echo $user->email; ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        <?php echo $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                            ($user->role === 'teacher' ? 'bg-green-100 text-green-800' : 
                                                            'bg-blue-100 text-blue-800'); ?>">
                                                        <?php echo ucfirst($user->role); ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        <?php echo $user->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                            ($user->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                            'bg-red-100 text-red-800'); ?>">
                                                        <?php echo ucfirst($user->status); ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <?php if($user->role !== 'admin'): ?>
                                                        <?php if($user->status === 'pending'): ?>
                                                            <a href="<?php echo URLROOT; ?>/admin/users/approve/<?php echo $user->id; ?>" 
                                                               class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                                Approve
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if($user->status !== 'blocked'): ?>
                                                            <a href="<?php echo URLROOT; ?>/admin/users/block/<?php echo $user->id; ?>" 
                                                               class="text-red-600 hover:text-red-900">
                                                                Block
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="<?php echo URLROOT; ?>/admin/users/approve/<?php echo $user->id; ?>" 
                                                               class="text-green-600 hover:text-green-900">
                                                                Unblock
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 