<x-filament-panels::page>
    <x-slot name="header"></x-slot>
    <div class="space-y-6">
        <!-- Patient Info Card -->
        <div class="bg-[#5271FF] text-black rounded-lg p-6 border-2 border-[#251D4C] shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-white/90 flex items-center justify-center">
                        <svg class="h-8 w-8 text-[#5271FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">John Anderson</h2>
                        <p class="text-sm opacity-90">Age: 34 • Consultation: Dec 15, 2024 • Visited: Active</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2 rounded-md bg-white/20 hover:bg-white/30 text-sm font-medium transition-colors">
                        Edit Profile
                    </button>
                    <button class="px-4 py-2 rounded-md bg-white/20 hover:bg-white/30 text-sm font-medium transition-colors">
                        Schedule
                    </button>
                </div>
            </div>
        </div>

        <!-- Three Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Sub-Page Profile -->
            <div class="rounded-lg border-2 border-[#251D4C] min-h-48 p-4 bg-white shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-8 w-8 rounded-lg bg-[#5271FF] flex items-center justify-center">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800">Sub-Page Profile</p>
                </div>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Phone:</span>
                        <span class="font-medium">+62 812-3456-7890</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Email:</span>
                        <span class="font-medium">john@email.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Address:</span>
                        <span class="font-medium">Jakarta, ID</span>
                    </div>
                </div>
            </div>

            <!-- History -->
            <div class="rounded-lg border-2 border-[#251D4C] min-h-48 p-4 bg-white shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-8 w-8 rounded-lg bg-[#5271FF] flex items-center justify-center">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800">History</p>
                </div>
                <div class="space-y-3">
                    <div class="text-sm p-3 bg-gray-50 rounded-md">
                        <p class="font-medium text-gray-700">Dec 15, 2024</p>
                        <p class="text-gray-600">General Consultation</p>
                    </div>
                    <div class="text-sm p-3 bg-gray-50 rounded-md">
                        <p class="font-medium text-gray-700">Nov 28, 2024</p>
                        <p class="text-gray-600">Follow-up Visit</p>
                    </div>
                </div>
            </div>

            <!-- Feedback -->
            <div class="rounded-lg border-2 border-[#251D4C] min-h-48 p-4 bg-white shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-8 w-8 rounded-lg bg-[#5271FF] flex items-center justify-center">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800">Feedback</p>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm font-medium">4.8/5.0</span>
                    </div>
                    <p class="text-sm text-gray-600">"Excellent service and very professional staff."</p>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Progress of Well-Being -->
            <div class="md:col-span-2 rounded-lg border-2 border-[#251D4C] min-h-60 p-6 bg-white shadow-md">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-8 w-8 rounded-lg bg-[#5271FF] flex items-center justify-center">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800 text-lg">Progress of Well-Being</p>
                </div>
                
                <!-- Progress indicators -->
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Overall Health</span>
                            <span class="font-medium text-[#5271FF]">85%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#5271FF] h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Mental Health</span>
                            <span class="font-medium text-green-600">92%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 92%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Physical Activity</span>
                            <span class="font-medium text-orange-600">78%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Section -->
            <div class="rounded-lg border-2 border-[#251D4C] p-4 bg-white shadow-md flex flex-col">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-8 w-8 rounded-full bg-[#EAF2FF] border-2 border-[#5271FF] flex items-center justify-center">
                        <svg class="h-4 w-4 text-[#5271FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-800">Dr. Sarah Johnson</span>
                </div>
                
                <!-- Chat Messages -->
                <div class="flex-1 space-y-3 mb-4">
                    <div class="bg-gray-100 rounded-lg p-3 text-sm">
                        <p class="text-gray-700">Good morning! How are you feeling today?</p>
                        <span class="text-xs text-gray-500 mt-1">10:30 AM</span>
                    </div>
                </div>
                
                <!-- Message Input -->
                <div class="mt-auto">
                    <div class="flex items-center border-2 border-gray-200 rounded-lg">
                        <input type="text" 
                               placeholder="Type message..." 
                               class="flex-1 px-3 py-2 text-sm border-none outline-none rounded-l-lg">
                        <button class="px-3 py-2 text-[#5271FF] hover:bg-gray-50 rounded-r-lg">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>