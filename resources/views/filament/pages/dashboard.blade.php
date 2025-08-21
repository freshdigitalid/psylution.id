<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-bold mb-4">Welcome to Psylution Admin Dashboard</h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Manage your application users, monitor system statistics, and oversee the platform operations.
                </p>
            </div>
        </div>

        <!-- Three Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-2 border-gray-200 dark:border-gray-700">
                <div class="p-6 h-32 flex items-center justify-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Lorem Ipsum</h3>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-2 border-gray-200 dark:border-gray-700">
                <div class="p-6 h-32 flex items-center justify-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Lorem Ipsum</h3>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-2 border-gray-200 dark:border-gray-700">
                <div class="p-6 h-32 flex items-center justify-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Lorem Ipsum</h3>
                </div>
            </div>
        </div>

        <!-- Schedule Table Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-2 border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <!-- Header with Title and Buttons -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Schedule</h3>
                    <div class="flex space-x-2">
                        <input type="text" placeholder="Search..." 
                               class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <button class="px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium">
                            Add New
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Nama Lengkap
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Umur
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Jenis Kelamin
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Kondisi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">1</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">XX</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">2</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">XX</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">3</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">XX</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">4</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">XX</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">5</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">XX</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">6</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">XX</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-800 dark:text-blue-200">7</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">XX</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Lorem Ipsum</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>