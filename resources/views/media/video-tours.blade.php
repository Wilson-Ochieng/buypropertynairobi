@extends('layouts.app')
@section('title', 'Video Tours — Nanchong Group')
@section('meta_description', 'Watch project walkthroughs and video tours from Nanchong Group.')

@section('content')

    <x-section eyebrow="Media" title="Video Tours"
        subtitle="Walk through our projects — recorded tours, virtual viewings, and building highlights.">

        @if($videos->isEmpty())
            <div class="bg-cream border border-stone-line rounded-lg p-10 text-center text-charcoal-soft">
                No video tours have been published yet. Check back soon.
            </div>
        @else
            <div class="space-y-12">
                @foreach($videos as $projectName => $group)
                    <div>
                        <h2 class="text-xl font-semibold text-charcoal mb-4 flex items-center gap-2">
                            <span class="text-camel">●</span>
                            {{ $projectName }}
                            <span class="text-xs text-charcoal-soft font-normal">
                                ({{ $group->count() }} {{ Str::plural('video', $group->count()) }})
                            </span>
                        </h2>

                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($group as $video)
                                @php
                                    $videoId = 'vid-' . $video->id;
                                @endphp

                                <div x-data="{ playing: false }" class="bg-white border border-stone-line rounded-lg overflow-hidden">

                                    {{-- Thumbnail (clickable) --}}
                                    <div x-show="!playing" class="relative aspect-video bg-charcoal cursor-pointer"
                                        @click="playing = true">
                                        @if($video->poster_url)
                                            <img src="{{ $video->poster_url }}" alt="{{ $video->title ?? 'Project video' }}"
                                                class="absolute inset-0 w-full h-full object-cover opacity-90">
                                        @else
                                            <div class="absolute inset-0 bg-gradient-to-br from-charcoal to-charcoal-soft"></div>
                                        @endif

                                        {{-- Play button --}}
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div
                                                class="w-16 h-16 rounded-full bg-cream/95 backdrop-blur-sm flex items-center justify-center shadow-lg hover:scale-110 transition">
                                                <svg class="w-7 h-7 text-charcoal ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z" />
                                                </svg>
                                            </div>
                                        </div>

                                        {{-- Optional title overlay --}}
                                        @if($video->title)
                                            <div
                                                class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-charcoal/90 to-transparent">
                                                <div class="text-xs font-semibold text-cream">{{ $video->title }}</div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Player (shown after click) --}}
                                    {{-- Player (shown after click) --}}
                                    <div x-show="playing"
                                        style="position: relative; width: 100%; aspect-ratio: 16 / 9; background: #000;">
                                        @if($video->type === 'mp4' && $video->video_path)
                                            <video src="{{ asset('storage/' . $video->video_path) }}" controls autoplay playsinline
                                                style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain;">
                                                Your browser does not support the video tag.
                                            </video>
                                        @elseif(in_array($video->type, ['youtube', 'vimeo']) && $video->video_id)
                                            <iframe src="{{ $video->embed_url }}" title="{{ $video->title ?? 'Project video' }}"
                                                style="position: absolute; inset: 0; width: 100%; height: 100%; border: 0;"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                                                allowfullscreen>
                                            </iframe>
                                        @else
                                            <div
                                                style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: white;">
                                                Video unavailable
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Meta --}}
                                    <div class="p-4">
                                        <div class="text-sm font-semibold text-charcoal">
                                            {{ $video->title ?: 'Project tour' }}
                                        </div>
                                        @if($video->project?->country)
                                            <div class="text-xs text-charcoal-soft mt-1">
                                                {{ $video->project->country->name }}
                                                @if($video->project->location) · {{ $video->project->location }} @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </x-section>

@endsection