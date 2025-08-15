
@use('Namu\WireChat\Facades\WireChat')

<header class="px-3 z-10 sticky top-0 w-full py-2 " dusk="header">


    {{-- Title/name and Icon --}}
    <section class=" justify-between flex items-center   pb-2">

        @if (isset($title))
            <div class="flex items-center gap-2 truncate  " wire:ignore>
                <h2 class=" text-2xl font-bold dark:text-white"  dusk="title">{{$title}}</h2>
            </div>
        @endif
    </section>

    {{-- Search input --}}
    @if ($allowChatsSearch)
        <section class="mt-4">
            <div class="px-2 rounded-lg dark:bg-[var(--wc-dark-secondary)]  bg-[var(--wc-light-secondary)]  grid grid-cols-12 items-center">

                <label for="chats-search-field" class="col-span-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 w-5 h-5 dark:text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </label>

                <input id="chats-search-field" name="chats_search" maxlength="100" type="search" wire:model.live.debounce='search'
                    placeholder="{{ __('wirechat::chats.inputs.search.placeholder')  }}" autocomplete="off"
                    class=" col-span-11 border-0  bg-inherit dark:text-white outline-hidden w-full focus:outline-hidden  focus:ring-0 hover:ring-0">

                </div>

        </section>
    @endif

</header>
