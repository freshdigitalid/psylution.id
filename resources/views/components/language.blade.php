<div class="relative dropdown text-end">
    <button type="button"
        class="inline-flex items-center gap-3 transition-all duration-200 ease-linear dropdown-toggle btn border-slate-200 dark:border-zink-400/60 group/items focus:border-custom-500 dark:focus:border-custom-500"
        id="dropdownMenuButton" data-bs-toggle="dropdown">
        @switch(Session::get('lang'))
            @case('ru')
                <img src="{{ URL::asset('build/images/flags/20/ru.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
            @break

            @case('it')
                <img src="{{ URL::asset('build/images/flags/20/it.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
            @break

            @case('sp')
                <img src="{{ URL::asset('build/images/flags/20/es.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
            @break

            @case('ch')
                <img src="{{ URL::asset('build/images/flags/20/china.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
            @break

            @case('fr')
                <img src="{{ URL::asset('build/images/flags/20/fr.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
            @break

            @case('gr')
                <img src="{{ URL::asset('build/images/flags/20/de.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
            @break

            @case('ar')
                <img src="{{ URL::asset('build/images/flags/20/ae.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
            @break

            @case('jp')
                <img src="{{ URL::asset('build/images/flags/20/jp.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
            @break

            @default
                <img src="{{ URL::asset('build/images/flags/20/us.svg') }}" alt="" id="header-lang-img"
                    class="object-cover h-5 rounded-full">
        @endswitch
        <h6
            class="text-base font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
            English</h6>
    </button>

    <div class="absolute z-50 hidden p-3 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[9rem] flex flex-col gap-3 dark:bg-zink-600"
        aria-labelledby="dropdownMenuButton">
        <a href="#!" class="flex items-center gap-3 group/items">
            <img src="{{ URL::asset('build/images/flags/us.svg') }}" alt=""
                class="object-cover h-4 rounded-full">
            <h6
                class="text-sm font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
                English</h6>
        </a>
        <a href="#!" class="flex items-center gap-3 group/items">
            <img src="{{ URL::asset('build/images/flags/es.svg') }}" alt=""
                class="object-cover h-4 rounded-full">
            <h6
                class="text-sm font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
                Spanish</h6>
        </a>
        <a href="#!" class="flex items-center gap-3 group/items">
            <img src="{{ URL::asset('build/images/flags/de.svg') }}" alt=""
                class="object-cover h-4 rounded-full">
            <h6
                class="text-sm font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
                German</h6>
        </a>
        <a href="#!" class="flex items-center gap-3 group/items">
            <img src="{{ URL::asset('build/images/flags/fr.svg') }}" alt=""
                class="object-cover h-4 rounded-full">
            <h6
                class="text-sm font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
                French</h6>
        </a>
        <a href="#!" class="flex items-center gap-3 group/items">
            <img src="{{ URL::asset('build/images/flags/jp.svg') }}" alt=""
                class="object-cover h-4 rounded-full">
            <h6
                class="text-sm font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
                Japanese</h6>
        </a>
        <a href="#!" class="flex items-center gap-3 group/items">
            <img src="{{ URL::asset('build/images/flags/it.svg') }}" alt=""
                class="object-cover h-4 rounded-full">
            <h6
                class="text-sm font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
                Italian</h6>
        </a>
        <a href="#!" class="flex items-center gap-3 group/items">
            <img src="{{ URL::asset('build/images/flags/ru.svg') }}" alt=""
                class="object-cover h-4 rounded-full">
            <h6
                class="text-sm font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
                Russian</h6>
        </a>
        <a href="#!" class="flex items-center gap-3 group/items">
            <img src="{{ URL::asset('build/images/flags/ae.svg') }}" alt=""
                class="object-cover h-4 rounded-full">
            <h6
                class="text-sm font-medium transition-all duration-200 ease-linear text-slate-600 group-hover/items:text-custom-500 dark:text-zink-200 dark:group-hover/items:text-custom-500">
                Arabic</h6>
        </a>
    </div>
</div>
