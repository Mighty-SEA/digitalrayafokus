<div class="flex items-center gap-3 transition duration-300 hover:opacity-80">
    @if(\App\Models\Settings::get('company_logo'))
        <img 
            src="{{ asset('storage/' . \App\Models\Settings::get('company_logo')) }}" 
            alt="Logo" 
            class="h-6 drop-shadow-md transition-transform hover:scale-105"
        >
    @endif
    <div x-data x-show="!$store.sidebar.isCollapsed" x-transition>
        <span class="text-base font-bold bg-gradient-to-r from-amber-500 to-amber-700 bg-clip-text text-transparent whitespace-nowrap">
            {{ \App\Models\Settings::get('company_name') ?? config('app.name') }}
        </span>
        <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">Digital Solutions Provider</span>
    </div>
</div> 