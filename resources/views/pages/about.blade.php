@extends('layouts.app')
@section('title', 'About — Nanchong Group')
@section('meta_description', 'Nanchong Group — founded 2010 in Fuzhou, Jiangxi. Building homes for love, quality Nanchong across China and Kenya.')

@section('content')

    @php
        // Hero image priority: 1) $group->hero_image (storage)  2) public/images/about-hero.jpg  3) gradient only
        $heroImage = null;
        if (!empty($group?->hero_image)) {
            $heroImage = asset('storage/' . $group->hero_image);
        } elseif (file_exists(public_path('images/about-hero.jpg'))) {
            $heroImage = asset('images/about-hero.jpg');
        }

        // Key facts: empty values are dropped automatically
        $facts = array_filter([
            'Founded' => $group?->founded_year,
            'Headquarters' => $group?->hq_city,
            'Origin' => $group?->origin_city,
            'Registered capital' => $group?->registered_capital,
            'Planned area' => $group?->total_area,
            'Planned homes' => $group?->planned_homes,
            'Four-star hotels' => $group?->hotels_count,
        ]);

        $industries = [
            ['Real Estate', 'Residential and mixed-use developments across China and Kenya.'],
            ['Hotels', 'Four-star hospitality assets operated within our group.'],
            ['Construction', 'First-class construction delivery through Tianying Construction.'],
            ['Property Management', 'Jinkey-6S certified post-handover property services.'],
            ['Landscaping', 'In-house landscape engineering for gardens and outdoor environments.'],
        ];
    @endphp

    {{-- ==================== HERO ==================== --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-br from-charcoal via-charcoal-soft to-charcoal text-cream">
        @if($heroImage)
            <img src="{{ $heroImage }}" alt="" aria-hidden="true" fetchpriority="high"
                class="absolute inset-0 -z-20 h-full w-full object-cover">
        @endif

        {{-- readability overlays (also give the no-image version its depth) --}}
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-charcoal/90 via-charcoal/65 to-charcoal/25"
            aria-hidden="true"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-charcoal/60 via-transparent to-transparent"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -left-24 -top-24 -z-10 h-72 w-72 rounded-full bg-camel/20 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-32 right-0 -z-10 h-80 w-80 rounded-full bg-dusty-taupe/25 blur-3xl"
            aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 lg:py-40">
            <div class="max-w-3xl">
                <div class="mb-5 flex items-center gap-3 text-sm font-medium uppercase tracking-widest text-camel">
                    <span class="h-px w-10 bg-gradient-to-r from-camel to-transparent" aria-hidden="true"></span>
                    About the Group
                </div>
                <h1 class="mb-5 text-4xl font-semibold leading-tight text-white md:text-6xl">
                    {{ $group->hero_title ?? 'Nanchong Group' }}
                </h1>
                <p class="max-w-2xl text-lg leading-relaxed text-silver-2 md:text-xl">
                    {{ $group->brand_tenet ?? 'Building homes for love, quality Nanchong' }}
                </p>
                <div class="mt-8 h-1 w-20 rounded-full bg-gradient-to-r from-camel to-dusty-taupe" aria-hidden="true">
                </div>
            </div>
        </div>

        {{-- soft fade into the page below --}}
        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-camel/60 to-transparent"
            aria-hidden="true"></div>
    </section>

    {{-- ==================== STORY ==================== --}}
    <section class="bg-gradient-to-b from-cream via-white to-cream">
        <x-section eyebrow="Our Story" title="Who We Are">
            <div class="grid items-start gap-10 lg:grid-cols-3 lg:gap-14">

                <div class="space-y-4 leading-relaxed text-charcoal-soft lg:col-span-2">
                    @foreach(preg_split('/\n\s*\n/', $group->intro_text ?? '') as $para)
                        <p class="first:text-lg first:leading-relaxed first:text-charcoal">{{ trim($para) }}</p>
                    @endforeach
                </div>

                @if(count($facts))
                    <aside
                        class="relative h-fit overflow-hidden rounded-2xl border border-stone-line bg-gradient-to-br from-white via-cream to-ash-grey/70 p-6 shadow-sm lg:sticky lg:top-28">
                        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-camel via-dusty-taupe to-camel"
                            aria-hidden="true"></div>
                        <div class="mb-4 text-sm font-semibold uppercase tracking-wider text-camel">Key Facts</div>
                        <dl class="divide-y divide-stone-line/80 text-sm">
                            @foreach($facts as $label => $value)
                                <div class="flex justify-between gap-3 py-3 first:pt-0 last:pb-0">
                                    <dt class="text-charcoal-soft">{{ $label }}</dt>
                                    <dd class="text-right font-medium text-charcoal">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </aside>
                @endif
            </div>
        </x-section>
    </section>

    {{-- ==================== INDUSTRIES ==================== --}}
    <section class="border-y border-stone-line/70 bg-gradient-to-b from-ash-grey/50 via-ash-grey/30 to-cream">
        <x-section eyebrow="What We Do" title="Five Integrated Business Sectors">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 lg:gap-5">
                @foreach($industries as $i => $industry)
                    <div
                        class="group relative overflow-hidden rounded-xl border border-stone-line bg-white p-5 shadow-sm transition duration-300 hover:border-camel hover:shadow-lg motion-safe:hover:-translate-y-1">
                        <span
                            class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-gradient-to-r from-camel to-dusty-taupe transition-transform duration-300 group-hover:scale-x-100"
                            aria-hidden="true"></span>
                        <div class="mb-3 bg-gradient-to-br from-camel to-dusty-taupe bg-clip-text text-3xl font-semibold text-transparent"
                            aria-hidden="true">
                            {{ sprintf('%02d', $i + 1) }}
                        </div>
                        <div class="mb-2 text-base font-semibold text-charcoal transition-colors group-hover:text-camel">
                            {{ $industry[0] }}
                        </div>
                        <div class="text-sm leading-relaxed text-charcoal-soft">{{ $industry[1] }}</div>
                    </div>
                @endforeach
            </div>
        </x-section>
    </section>

    {{-- FOUR GREAT VALUES --}}
    <section class="bg-white">
        <x-section eyebrow="Our Values" title="The Four Great Values"
            subtitle="The principles that guide every Nanchong Group decision — from how we build, to how we work with partners and employees.">

            {{-- Intro paragraph --}}
            {{-- Intro: image on left, text on right --}}
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center mb-14">

                {{-- Left: image --}}
                <div class="order-1">
                    <div class="aspect-[4/3] rounded-lg overflow-hidden bg-ash-grey shadow-lg">
                        <img src="{{ asset('images/about/values.jpg') }}" alt="Nanchong Group — our values"
                            class="w-full h-full object-cover" loading="lazy">
                    </div>
                </div>

                {{-- Right: intro text --}}
                <div class="order-2">
                    <h3 class="text-2xl font-semibold text-charcoal mb-4">Focusing on the Development Path</h3>
                    <p class="text-charcoal-soft leading-relaxed">
                        Nanchong Group adheres to four core values, insists on high-quality development, guided by advanced
                        corporate culture, and maintains a stable and intelligent business model — making the company the
                        most popular and respected enterprise by customers, employees, and partners. The company always
                        manages with transparency and efficiency, inspiring creativity and wisdom from all levels, so that
                        every employee can love their job and fully realize their personal value.
                    </p>
                </div>
            </div>

            {{-- 4 value cards --}}
            <div class="grid md:grid-cols-2 gap-6">

                {{-- Value 1 — Sincere Heart --}}
                <div class="bg-cream border border-stone-line rounded-lg p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-12 h-12 rounded-md bg-camel text-charcoal font-bold flex items-center justify-center text-lg shrink-0">
                            I
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-charcoal">Based on a Sincere Heart</h3>
                            <p class="text-xs uppercase tracking-wider text-camel font-medium">Foundation of business faith
                            </p>
                        </div>
                    </div>
                    <p class="text-sm text-charcoal-soft leading-relaxed">
                        Nanchong Group is committed to building a clean business environment, leading a healthy atmosphere
                        and purifying the social environment. Adhering to the national advocacy of the three main social
                        concepts of "openness, greenness, and integrity" in business partnerships, we actively encourage all
                        employees to abide by professional ethics, strictly observe the moral bottom line, and carry forward
                        the style of dedication and integrity — consciously resisting unhealthy tendencies.
                    </p>
                </div>

                {{-- Value 2 — Pragmatism --}}
                <div class="bg-cream border border-stone-line rounded-lg p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-12 h-12 rounded-md bg-camel text-charcoal font-bold flex items-center justify-center text-lg shrink-0">
                            II
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-charcoal">Based on Pragmatism</h3>
                            <p class="text-xs uppercase tracking-wider text-camel font-medium">Benchmark of the enterprise
                            </p>
                        </div>
                    </div>
                    <p class="text-sm text-charcoal-soft leading-relaxed">
                        The development of an enterprise cannot be separated from the spirit of hard work. Because of the
                        efforts of our Chairman, Nanchong Group has developed rapidly. An enterprise that understands the
                        spirit of hard work — the vision, the mood, the ideas of dealing with problems and the strength of
                        the work — accelerates the pace of development. That spirit of hard work is not just a work style,
                        but a noble character of the enterprise.
                    </p>
                </div>

                {{-- Value 3 — Innovation --}}
                <div class="bg-cream border border-stone-line rounded-lg p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-12 h-12 rounded-md bg-camel text-charcoal font-bold flex items-center justify-center text-lg shrink-0">
                            III
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-charcoal">Innovation and Intelligence</h3>
                            <p class="text-xs uppercase tracking-wider text-camel font-medium">Leading development</p>
                        </div>
                    </div>
                    <p class="text-sm text-charcoal-soft leading-relaxed">
                        With fierce competition in the real estate industry, we adapt to new forms, new environments, and
                        the trend of the times — relying on the core advantages of the group and our brand strength to
                        actively integrate the advantageous resources of all parties. Through cooperation, Nanchong Group
                        eliminates barriers between online and offline channels, continuously improves its ecological chain,
                        and gradually shifts its core business towards "real estate+" by providing customers with
                        value-added services and a systematic service that integrates commerce, excellence, and
                        entertainment.
                    </p>
                </div>

                {{-- Value 4 — People-oriented --}}
                <div class="bg-cream border border-stone-line rounded-lg p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-12 h-12 rounded-md bg-camel text-charcoal font-bold flex items-center justify-center text-lg shrink-0">
                            IV
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-charcoal">People-Oriented</h3>
                            <p class="text-xs uppercase tracking-wider text-camel font-medium">Cornerstone of enterprise
                                existence</p>
                        </div>
                    </div>
                    <p class="text-sm text-charcoal-soft leading-relaxed mb-4">
                        Employees are a company's biggest productivity. Since our establishment, Nanchong Group has
                        maintained respect, equality, sincerity and love for its employees — practicing humanistic care and
                        striving for high-quality, warm development. Warm holiday benefits, solid employee training, and
                        excellent team building create value for customers while creating a happy life for employees.
                    </p>
                    <div class="grid grid-cols-3 gap-3 pt-4 border-t border-stone-line">
                        <div>
                            <div class="text-2xl font-bold text-charcoal">300+</div>
                            <div class="text-xs text-charcoal-soft">Employees</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-charcoal">48</div>
                            <div class="text-xs text-charcoal-soft">Senior Professionals</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-charcoal">80%</div>
                            <div class="text-xs text-charcoal-soft">Party Members in Leadership</div>
                        </div>
                    </div>
                </div>

            </div>
        </x-section>
    </section>
    {{-- ==================== CTA ==================== --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-br from-charcoal via-charcoal-soft to-charcoal text-cream">
        <div class="pointer-events-none absolute -left-24 top-0 -z-10 h-72 w-72 rounded-full bg-camel/20 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 -z-10 h-72 w-72 rounded-full bg-dusty-taupe/25 blur-3xl"
            aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center">
            <div class="mx-auto mb-6 h-px w-24 bg-gradient-to-r from-transparent via-camel to-transparent"
                aria-hidden="true"></div>
            <h2 class="mb-4 text-3xl font-semibold md:text-4xl lg:text-5xl">
                <span class="text-cream">Building homes for love,</span>
                <span class="bg-gradient-to-r from-camel to-white bg-clip-text text-transparent">quality Nanchong.</span>
            </h2>
            <p class="mx-auto mb-10 max-w-2xl leading-relaxed text-silver-2">
                Explore our portfolio or get in touch with our team.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('projects.index') }}" class="btn-primary">Explore our projects</a>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center rounded-md border border-silver-2 px-5 py-2.5 text-silver-2 transition hover:bg-silver-2 hover:text-charcoal focus:outline-none focus-visible:ring-2 focus-visible:ring-camel">
                    Contact us
                </a>
            </div>
        </div>
    </section>

@endsection