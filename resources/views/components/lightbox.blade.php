@props(['images' => [], 'group' => 'default'])

@if(!empty($images))
    <div x-data="lightbox({{ $group }})" @keydown.escape.window="close()" class="contents">

        {{-- Thumbnails are rendered by the parent with @click="open(i, $event)" --}}

        {{-- Overlay --}}
        <div x-show="isOpen" x-cloak
            class="fixed inset-0 z-[100] bg-charcoal/95 backdrop-blur-sm flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.self="close()">

            {{-- Close button --}}
            <button type="button" @click="close()"
                class="absolute top-4 right-4 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                aria-label="Close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Image counter --}}
            <div class="absolute top-4 left-4 z-10 px-3 py-1.5 rounded-md bg-charcoal/60 text-cream text-sm">
                <span x-text="current + 1"></span> / <span x-text="total"></span>
            </div>

            {{-- Prev --}}
            <button type="button" x-show="total > 1" @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                aria-label="Previous image">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- Next --}}
            <button type="button" x-show="total > 1" @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-cream/10 backdrop-blur-sm border border-cream/20 text-cream hover:bg-cream/25 transition flex items-center justify-center"
                aria-label="Next image">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Main image --}}
            <img :src="images[current]?.src" :alt="images[current]?.alt" @click.self="close()"
                class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg shadow-2xl select-none">

            {{-- Caption --}}
            <div x-show="images[current]?.caption"
                class="absolute bottom-4 left-1/2 -translate-x-1/2 px-4 py-2 rounded-md bg-charcoal/70 text-cream text-sm max-w-2xl text-center"
                x-text="images[current]?.caption">
            </div>
        </div>
    </div>

    <script>
        function lightbox(group) {
            return {
                isOpen: false,
                current: 0,
                images: @json($images),
                group: group,
                get total() { return this.images.length; },
                open(index) {
                    this.current = index;
                    this.isOpen = true;
                    document.body.style.overflow = 'hidden';
                    window.dispatchEvent(new CustomEvent('lightbox:open:' + group));
                },
                close() {
                    this.isOpen = false;
                    document.body.style.overflow = '';
                },
                next() { this.current = (this.current + 1) % this.total; },
                prev() { this.current = (this.current - 1 + this.total) % this.total; },
            }
        }
    </script>
@endif