@extends('layouts.app')

@section('title', 'Contact Us — Buy Property Nairobi')
@section('meta_description', 'Contact Buy Property Nairobi for property enquiries, viewings and investment advice in Kilimani, Kileleshwa, Westlands and Karen.')

@section('content')

    @php
        $waNumber = preg_replace('/\D/', '', $primary->phone ?? '') ?: '254799934180';
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode('Hi Buy Property Nairobi, I would like to know more about your properties.');
        $others = ($allContacts ?? collect())->where('is_primary', false);
        $goldGradient = 'background-image: linear-gradient(115deg, #b47c2f, #dda950);';
        $field = 'w-full rounded-lg border-border-soft bg-cream/40 px-4 py-3 text-sm text-ink placeholder:text-muted/50 transition focus:border-gold focus:bg-white focus:ring-gold';
        $label = 'mb-2 block text-[11px] font-semibold uppercase tracking-[0.18em] text-gold-dark';
    @endphp

    {{-- ==================== HERO ==================== --}}
    <section class="relative isolate overflow-hidden bg-emerald-dark text-cream">
        <div class="pointer-events-none absolute -left-24 -top-24 -z-10 h-72 w-72 rounded-full bg-gold/15 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-32 right-0 -z-10 h-80 w-80 rounded-full bg-gold-dark/20 blur-3xl" aria-hidden="true"></div>

        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 md:py-28 lg:px-8">
            <div class="max-w-3xl">
                <div class="mb-5 flex items-center gap-3 text-sm font-medium uppercase tracking-widest text-gold">
                    <span class="h-px w-10 bg-gradient-to-r from-gold to-transparent" aria-hidden="true"></span>
                    Get in touch
                </div>
                <h1 class="mb-5 font-serif text-4xl font-semibold leading-tight text-white md:text-5xl">Contact Us</h1>
                <p class="max-w-2xl text-lg leading-relaxed text-cream/80">
                    Whether you are ready to book a viewing, exploring an investment, or just have a question, our team in Nairobi would love to hear from you.
                </p>
                <div class="mt-8 h-1 w-20 rounded-full bg-gradient-to-r from-gold to-gold-dark" aria-hidden="true"></div>
            </div>
        </div>
        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-gold/60 to-transparent" aria-hidden="true"></div>
    </section>

    <section class="bg-gradient-to-b from-cream via-white to-cream">
        <x-section>
            <div class="grid gap-10 lg:grid-cols-5 lg:gap-12">

                {{-- ==================== DETAILS ==================== --}}
                <div class="space-y-6 lg:col-span-2">
                    <div>
                        <div class="mb-2 text-xs font-semibold uppercase tracking-[0.25em] text-gold-dark">Reach our team</div>
                        <h2 class="font-serif text-2xl font-semibold text-ink md:text-3xl">We are here to help</h2>
                    </div>

                    @if($primary)
                        <div class="relative overflow-hidden rounded-2xl border border-border-soft bg-white p-6 shadow-sm">
                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-gold via-gold-dark to-gold" aria-hidden="true"></div>

                            <div class="mb-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-gold-dark">Primary contact</div>
                            <div class="font-serif text-xl font-semibold text-ink">{{ $primary->name }}</div>
                            @if($primary->role)
                                <div class="text-sm text-muted">{{ $primary->role }}</div>
                            @endif

                            <div class="mt-5 space-y-3 border-t border-border-soft pt-5">
                                @if($primary->phone)
                                    <a href="tel:{{ $primary->phone }}" class="group flex items-center gap-3 text-sm text-muted transition hover:text-gold-dark">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-cream text-gold-dark transition group-hover:bg-gold group-hover:text-white">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </span>
                                        {{ $primary->phone }}
                                    </a>
                                @endif
                                @if($primary->email)
                                    <a href="mailto:{{ $primary->email }}" class="group flex items-center gap-3 text-sm text-muted transition hover:text-gold-dark">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-cream text-gold-dark transition group-hover:bg-gold group-hover:text-white">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        {{ $primary->email }}
                                    </a>
                                @endif
                                <div class="flex items-center gap-3 text-sm text-muted">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-cream text-gold-dark">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </span>
                                    Nairobi, Kenya
                                </div>
                            </div>

                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1ebe5b]">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Chat on WhatsApp
                            </a>
                        </div>
                    @endif

                    {{-- Other team members --}}
                    @if($others->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($others as $contact)
                                <div class="rounded-xl border border-border-soft bg-white p-4 transition hover:border-gold/60 hover:shadow-md">
                                    <div class="text-sm font-semibold text-ink">{{ $contact->name }}</div>
                                    @if($contact->role)
                                        <div class="text-xs text-muted">{{ $contact->role }}</div>
                                    @endif
                                    @if($contact->email)
                                        <a href="mailto:{{ $contact->email }}" class="mt-1 inline-block text-xs text-gold-dark hover:underline">{{ $contact->email }}</a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Quick links --}}
                    <div class="rounded-2xl border border-border-soft bg-cream p-6">
                        <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.2em] text-gold-dark">Quick links</div>
                        <ul class="divide-y divide-border-soft text-sm">
                            @foreach([
                                [route('properties.index', ['purpose' => 'sale']), 'Browse properties for sale'],
                                [route('properties.index', ['purpose' => 'rent']), 'Browse rentals'],
                                [route('cooperate'), 'Partner with us'],
                                [route('media.faqs'), 'Frequently asked questions'],
                            ] as $link)
                                <li>
                                    <a href="{{ $link[0] }}" class="group flex items-center justify-between py-2.5 text-muted transition hover:text-gold-dark">
                                        {{ $link[1] }}
                                        <span class="text-gold-dark transition group-hover:translate-x-1" aria-hidden="true">→</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- ==================== FORM ==================== --}}
                <div class="lg:col-span-3">
                    <div class="relative overflow-hidden rounded-2xl border border-border-soft bg-white p-6 shadow-lg md:p-10">
                        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-gold via-gold-dark to-gold" aria-hidden="true"></div>

                        @if(session('success'))
                            <div class="mb-6 flex items-start gap-3 rounded-lg border-l-4 border-gold bg-cream p-4 text-ink" role="status">
                                <span class="text-gold-dark" aria-hidden="true">✓</span>
                                <span class="text-sm">{{ session('success') }}</span>
                            </div>
                        @endif

                        <div class="mb-1 text-xs font-semibold uppercase tracking-[0.25em] text-gold-dark">Enquiry</div>
                        <h2 class="mb-2 font-serif text-2xl font-semibold text-ink md:text-3xl">Send us a message</h2>
                        <p class="mb-8 text-sm text-muted">Tell us what you are looking for and we will get back to you shortly.</p>

                        <form action="{{ route('enquiry.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <input type="hidden" name="source" value="general">

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="{{ $label }}">Your Name</label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                                        placeholder="Jane Wanjiku" class="{{ $field }}">
                                </div>
                                <div>
                                    <label for="phone" class="{{ $label }}">Phone / WhatsApp</label>
                                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel"
                                        placeholder="+254 7XX XXX XXX" class="{{ $field }}">
                                </div>
                            </div>

                            <div>
                                <label for="email" class="{{ $label }}">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="you@example.com" class="{{ $field }}">
                            </div>

                            <div>
                                <label for="message" class="{{ $label }}">Your Message</label>
                                <textarea id="message" name="message" rows="6" required
                                    placeholder="Tell us the area, budget and type of property you are interested in."
                                    class="{{ $field }}">{{ old('message') }}</textarea>
                            </div>

                            @if($errors->any())
                                <div class="rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-center sm:justify-between">
                                <button type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-lg px-8 py-3 text-sm font-bold text-white shadow-md transition hover:brightness-110 sm:w-auto"
                                    style="{{ $goldGradient }}">
                                    Send message →
                                </button>
                                <p class="text-xs text-muted">Your details are only used to respond to your enquiry.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </x-section>
    </section>

@endsection