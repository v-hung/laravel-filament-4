<header class="bg-white shadow">
    <div class="page-container py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="" alt="Logo" class="h-10 w-auto" loading="lazy">
        </div>

        <!-- Menu -->
        <nav class="hidden md:flex space-x-6">
            <a href="#" class="text-gray-700 hover:text-blue-600 transition">Item</a>
            <!-- Thêm các menu item khác tại đây nếu cần -->
        </nav>

        <!-- Icons -->
        <div class="flex items-center space-x-4">
            <!-- Account icon -->
            <a href="@auth {{ route('profile') }} @else {{ route('login') }} @endauth"
                class="text-gray-700 hover:text-blue-600 transition">
                <x-heroicon-o-user class="w-6 h-6" />
            </a>

            <!-- Wishlist -->
            <a href="#" class="text-gray-700 hover:text-red-500 transition">
                <x-heroicon-o-heart class="w-6 h-6" />
            </a>

            <!-- Cart -->
            <a href="#" class="text-gray-700 hover:text-green-500 transition">
                <x-heroicon-o-shopping-cart class="w-6 h-6" />
            </a>

            <!-- Language -->
            <a href="#" class="text-gray-700 hover:text-blue-500 transition">
                <x-heroicon-o-globe-alt class="w-6 h-6" />
            </a>
        </div>
    </div>
</header>
