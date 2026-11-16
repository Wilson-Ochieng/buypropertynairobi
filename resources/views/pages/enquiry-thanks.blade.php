@extends('layouts.app')

@section('title', 'Thank You — Nanchong Group')
@section('meta_description', 'Thank you for your enquiry. The Nanchong Group team will be in touch shortly.')
@section('robots', 'noindex, nofollow')

@section('content')

    <section class="relative isolate overflow-hidden bg-gradient-to-b from-cream via-white to-cream">
        {{-- soft decorative glows --}}
        <div class="pointer-events-none absolute -left-24 top-10 -z-10 h-72 w-72 rounded-full bg-camel/15 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-24 bottom-10 -z-10 h-72 w-72 rounded-full bg-dusty-taupe/15 blur-3xl"
            aria-hidden="true"></div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">

            <div
                class="relative overflow-hidden rounded-2xl border border-stone-line bg-gradient-to-br from-white via-white to-cream p-8 text-center shadow-lg md:p-12">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-camel via-dusty-taupe to-camel"
                    aria-hidden="true"></div>

                {{-- Check mark --}}
                <div class="relative mx-auto mb-6 h-20 w-20">
                    <div class="absolute inset-0 rounded-full bg-camel/20 blur-xl" aria-hidden="true"></div>
                    <div
                        class="relative flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-camel to-dusty-taupe shadow-md ring-4 ring-camel/20">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <div
                    class="mb-3 flex items-center justify-center gap-3 text-sm font-medium uppercase tracking-widest text-camel">
                    <span class="h-px w-8 bg-gradient-to-r from-transparent to-camel" aria-hidden="true"></span>
                    Enquiry received
                    <span class="h-px w-8 bg-gradient-to-l from-transparent to-camel" aria-hidden="true"></span>
                </div>

                <h1 class="mb-4 text-3xl font-semibold text-charcoal md:text-4xl">Thank you</h1>

                <p class="mx-auto max-w-xl text-lg leading-relaxed text-charcoal-soft" role="status" aria-live="polite">
                    {{ session('success', 'Thank you — we will be in touch shortly.') }}
                </p>

                @if(ctype_digit((string) request('ref')))
                    <div
                        class="mt-5 inline-flex items-center gap-2 rounded-full border border-stone-line bg-cream px-4 py-1.5 text-xs text-charcoal-soft">
                        <span class="uppercase tracking-wider">Reference</span>
                        <span class="font-semibold text-charcoal">#{{ request('ref') }}</span>
                    </div>
                @endif

                {{-- WhatsApp: pre-filled message from the controller --}}
                @if(session('whatsapp_url'))
                    <div class="mt-10 rounded-xl border border-[#25D366]/30 bg-gradient-to-br from-[#25D366]/10 to-white p-6">
                        <p class="mb-1 font-semibold text-charcoal">Want a faster reply?</p>
                        <p class="mb-5 text-sm leading-relaxed text-charcoal-soft">
                            Continue the conversation on WhatsApp. Your details are already filled in, so you only need to
                            press send.
                        </p>
                        <a href="{{ session('whatsapp_url') }}" target="_blank" rel="noopener noreferrer"
                            class="group inline-flex items-center justify-center gap-3 rounded-full bg-[#25D366] px-6 py-3 font-medium text-white shadow-md transition hover:bg-[#1ebe5b] hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-[#25D366] focus-visible:ring-offset-2 motion-safe:hover:-translate-y-0.5">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                            Continue on WhatsApp
                            <span class="transition-transform motion-safe:group-hover:translate-x-1" aria-hidden="true">→</span>
                        </a>
                    </div>
                @endif
            </div>

            {{-- What happens next --}}
            <div class="mt-12">
                <div class="mb-6 text-center">
                    <h2 class="text-xl font-semibold text-charcoal">What happens next</h2>
                    <div class="mx-auto mt-2 h-0.5 w-12 rounded-full bg-gradient-to-r from-camel to-dusty-taupe"
                        aria-hidden="true"></div>
                </div>

                <ol class="grid gap-4 sm:grid-cols-3">
                    @foreach([
                            ['We review', 'Our team reads your enquiry and matches it with the right specialist.'],
                            ['We get in touch', 'You will hear from us by phone, email or WhatsApp, whichever you gave us.'],
                            ['We help you decide', 'Ask questions, arrange a viewing, and take your time choosing a home.'],
                        ] as $i => $step)
                        <li class="relative rounded-xl border border-stone-line bg-white p-5 shadow-sm">
                            <div class="mb-2 bg-gradient-to-br from-camel to-dusty-taupe bg-clip-text text-2xl font-semibold text-transparent"
                                aria-hidden="true">{{ sprintf('%02d', $i + 1) }}</div>
                            <div class="mb-1 font-semibold text-charcoal">{{ $step[0] }}</div>
                            <div class="text-sm leading-relaxed text-charcoal-soft">{{ $step[1] }}</div>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Next actions --}}
            <div class="mt-12 flex flex-wrap justify-center gap-3">
                <a href="{{ route('projects.index') }}" class="btn-primary">Explore our projects</a>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center rounded-md border border-dusty-taupe px-5 py-2.5 font-medium text-dusty-taupe transition hover:bg-dusty-taupe hover:text-cream focus:outline-none focus-visible:ring-2 focus-visible:ring-camel">
                    Back to home
                </a>
            </div>
        </div>
    </section>

@endsection