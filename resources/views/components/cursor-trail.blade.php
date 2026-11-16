@props([
    'color' => '#C9A14A',      // brand gold
    'trailColor' => '#9B897A', // dusty taupe
    'enabled' => true,
])

@if($enabled)
    <canvas id="cursor-trail-canvas" class="pointer-events-none fixed inset-0 z-[60]" style="mix-blend-mode: screen;"
        aria-hidden="true"></canvas>

    <div id="cursor-touch-light" class="pointer-events-none fixed z-[55] -translate-x-1/2 -translate-y-1/2 rounded-full"
        style="width: 400px; height: 400px; opacity: 0; transition: opacity 300ms;
                   background: radial-gradient(circle, {{ $color }}22 0%, transparent 70%);
                   filter: blur(20px);" aria-hidden="true"></div>

    <script>
        (() => {
            if (window.matchMedia('(pointer: coarse)').matches) return; // skip on touch devices
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return; // accessibility

            const canvas = document.getElementById('cursor-trail-canvas');
            const light = document.getElementById('cursor-touch-light');
            if (!canvas || !light) return;

            const ctx = canvas.getContext('2d');
            const dots = [];
            const numDots = 12;
            const trailColor = '{{ $trailColor }}';
            const primaryColor = '{{ $color }}';

            let mouse = { x: -1000, y: -1000 };
            let target = { x: -1000, y: -1000 };
            let hasMoved = false;

            // Resize canvas
            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resize();
            window.addEventListener('resize', resize);

            // Pointer tracking
            window.addEventListener('mousemove', (e) => {
                target.x = e.clientX;
                target.y = e.clientY;
                if (!hasMoved) {
                    hasMoved = true;
                    light.style.opacity = '1';
                }
            });

            window.addEventListener('mouseleave', () => {
                light.style.opacity = '0';
            });

            window.addEventListener('mouseenter', () => {
                if (hasMoved) light.style.opacity = '1';
            });

            // Trail dots — each holds its own position with easing
            for (let i = 0; i < numDots; i++) {
                dots.push({
                    x: -1000,
                    y: -1000,
                    size: 6 - (i * 0.4),          // larger at front, smaller behind
                    alpha: 1 - (i * 0.06),        // fades toward the tail
                });
            }

            // Update
            function update() {
                // Smooth the light position
                mouse.x += (target.x - mouse.x) * 0.15;
                mouse.y += (target.y - mouse.y) * 0.15;

                // Move the light
                light.style.left = mouse.x + 'px';
                light.style.top = mouse.y + 'px';

                // Update dots — each lags one step behind the previous
                let leader = { x: mouse.x, y: mouse.y };
                dots.forEach((dot, i) => {
                    dot.x += (leader.x - dot.x) * (0.35 - i * 0.02);
                    dot.y += (leader.y - dot.y) * (0.35 - i * 0.02);
                    leader = { x: dot.x, y: dot.y };
                });
            }

            // Draw
            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // Trail (dot particles)
                dots.forEach((dot, i) => {
                    const alpha = dot.alpha * 0.6;
                    const radius = dot.size;

                    // Outer glow
                    const gradient = ctx.createRadialGradient(
                        dot.x, dot.y, 0,
                        dot.x, dot.y, radius * 2
                    );
                    gradient.addColorStop(0, hexToRgba(trailColor, alpha));
                    gradient.addColorStop(1, hexToRgba(trailColor, 0));

                    ctx.fillStyle = gradient;
                    ctx.beginPath();
                    ctx.arc(dot.x, dot.y, radius * 2, 0, Math.PI * 2);
                    ctx.fill();

                    // Core dot
                    ctx.fillStyle = hexToRgba(primaryColor, alpha);
                    ctx.beginPath();
                    ctx.arc(dot.x, dot.y, radius, 0, Math.PI * 2);
                    ctx.fill();
                });

                requestAnimationFrame(draw);
            }

            function hexToRgba(hex, alpha) {
                const h = hex.replace('#', '');
                const r = parseInt(h.substring(0, 2), 16);
                const g = parseInt(h.substring(2, 4), 16);
                const b = parseInt(h.substring(4, 6), 16);
                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            }

            // Animation loop
            function loop() {
                update();
                requestAnimationFrame(loop);
            }
            loop();
            draw();
        })();
    </script>
@endif