@extends('layouts.app')

@section('title', 'Contact Us — Nanchong Group')
@section('meta_description', 'Get in touch with Nanchong Group — reach our team in Kenya and China for property enquiries, partnerships, or general questions.')

@section('content')

{{-- HERO --}}
<section class="bg-brand-gradient text-charcoal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-24">
        <div class="max-w-3xl">
            <div class="text-sm uppercase tracking-widest text-charcoal-soft mb-3">Get in touch</div>
            <h1 class="text-4xl md:text-5xl font-semibold leading-tight mb-4">
                Contact Us
            </h1>
            <p class="text-lg text-charcoal-soft max-w-2xl">
                Whether you're interested in a property, exploring a partnership, or have a general question — we'd love to hear from you.
            </p>
        </div>
    </div>
</section>

<x-section>
    <div class="grid lg:grid-cols-5 gap-10">

        {{-- Contact Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div>
                <h2 class="text-2xl font-semibold text-charcoal mb-6">Reach our team</h2>
            </div>

            @if($primary)
                <div class="bg-white border border-stone-line rounded-lg p-6">
                    <div class="text-xs uppercase tracking-wider font-semibold text-camel mb-2">Primary contact</div>
                    <div class="text-lg font-semibold text-charcoal">{{ $primary->name }}</div>
                    @if($primary->role)
                        <div class="text-sm text-charcoal-soft mb-4">{{ $primary->role }}</div>
                    @endif

                    <div class="space-y-2 mt-4">
                        @if($primary->phone)
                            <a href="tel:{{ $primary->phone }}" class="flex items-center gap-2 text-sm text-charcoal-soft hover:text-camel transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $primary->phone }}
                            </a>
                        @endif
                        @if($primary->email)
                            <a href="mailto:{{ $primary->email }}" class="flex items-center gap-2 text-sm text-charcoal-soft hover:text-camel transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $primary->email }}
                            </a>
                        @endif
                    </div>

                    {{-- WhatsApp CTA --}}
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $primary->phone ?? '254710998888') }}?text={{ urlencode('Hi, I would like to know more about Nanchong Group.') }}"
                       target="_blank" rel="noopener"
                       class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-md bg-[#25D366] text-white text-sm font-semibold hover:bg-[#1EBE5A] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Chat on WhatsApp
                    </a>
                </div>
            @endif

            {{-- All contacts --}}
            @php($others = $allContacts->where('is_primary', false))
            @if($others->isNotEmpty())
                <div class="space-y-3">
                    @foreach($others as $contact)
                        <div class="bg-white border border-stone-line rounded-lg p-4">
                            <div class="font-semibold text-charcoal text-sm">{{ $contact->name }}</div>
                            @if($contact->role)
                                <div class="text-xs text-charcoal-soft">{{ $contact->role }}</div>
                            @endif
                            @if($contact->email)
                                <a href="mailto:{{ $contact->email }}" class="text-xs text-camel hover:underline">{{ $contact->email }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Quick links --}}
            <div class="bg-cream border border-stone-line rounded-lg p-5">
                <div class="text-xs uppercase tracking-wider font-semibold text-camel mb-3">Quick Links</div>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('projects.index') }}" class="text-charcoal-soft hover:text-camel transition">Browse all projects</a></li>
                    <li><a href="{{ route('kenya') }}" class="text-charcoal-soft hover:text-camel transition">Kenya Division</a></li>
                    <li><a href="{{ route('cooperate') }}" class="text-charcoal-soft hover:text-camel transition">Land Partnership</a></li>
                    <li><a href="{{ route('media.faqs') }}" class="text-charcoal-soft hover:text-camel transition">FAQs</a></li>
                </ul>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="lg:col-span-3">
            <div class="bg-white border border-stone-line rounded-lg p-6 md:p-8">

                @if(session('success'))
                    <div class="bg-ash-grey border-l-4 border-camel text-charcoal p-4 mb-6 rounded-r-md">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="text-2xl font-semibold text-charcoal mb-2">Send us a message</h2>
                <p class="text-sm text-charcoal-soft mb-6">We typically respond within a few hours.</p>

                <form action="{{ route('enquiry.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="source" value="general">

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Your Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Phone / WhatsApp</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+254 7XX XXX XXX"
                                class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-camel mb-2">Your Message</label>
                        <textarea name="message" rows="6" required
                            placeholder="How can we help?"
                            class="w-full border-stone-line rounded-md focus:ring-camel focus:border-camel">{{ old('message') }}</textarea>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm p-3 rounded">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <button type="submit" class="btn-primary w-full sm:w-auto">
                        Send message
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-section>

@endsection