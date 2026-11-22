{{-- resources/views/components/layouts/public.blade.php --}}
@props(['title' => 'UBERBITE — Archive & Objects'])
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            overflow-x: hidden;
        }
        .font-serif-luxury {
            font-family: 'Cormorant Garamond', Georgia, serif;
        }
        .font-mono-tech {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Grain cinéma subtil en mode secret */
        .film-grain {
            background-image: radial-gradient(rgba(197, 164, 126, 0.07) 1px, transparent 0);
            background-size: 24px 24px;
        }

        /* Bandeau défilant Awwwards (Marquee) */
        @keyframes marqueeScroll {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: marqueeScroll 36s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }

        /* Masquer la scrollbar native sur les galeries horizontales */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Effet Anomalie / Glitch quand Ctrl+Maj+S (Clé 1/2) est armée */
        @keyframes glitchPulse {
            0%, 100% { transform: translate(0); }
            25% { transform: translate(-1.5px, 0.5px); }
            50% { transform: translate(1.5px, -0.5px); }
            75% { transform: translate(-0.5px, -1px); }
        }
        .anomaly-armed .glitch-target {
            animation: glitchPulse 0.4s infinite;
            color: #C5A47E !important;
            background-color: #08080A !important;
        }

        /* Onde d'Éclipse Solaire (Transition circulaire) */
        .eclipse-wave {
            clip-path: circle(0% at 50% 50%);
            transition: clip-path 1.1s cubic-bezier(0.77, 0, 0.175, 1);
        }
        .eclipse-wave.eclipse-open {
            clip-path: circle(150% at 50% 50%);
        }

        /* Système de retournement 3D des cartes (Objet Façade <-> Portrait Secret) */
        .card-3d-scene {
            perspective: 1600px;
        }
        .card-3d-object {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 1.05s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .card-3d-object.is-flipped {
            transform: rotateY(180deg);
        }
        .card-3d-face {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        .card-3d-back {
            transform: rotateY(180deg);
        }

        /* Vibration du Sceau de Bronze pendant le maintien du clic */
        @keyframes sealShake {
            0%, 100% { transform: scale(1.04) rotate(0deg); }
            25% { transform: scale(1.07) rotate(-2deg); }
            50% { transform: scale(1.09) rotate(2deg); }
            75% { transform: scale(1.07) rotate(-1.5deg); }
        }
        .seal-holding {
            animation: sealShake 0.14s infinite;
        }

        /* Dégradé Champagne Bronze Haute Couture */
        .bronze-shimmer {
            background: linear-gradient(135deg, #F5E6D3 0%, #C5A47E 50%, #8C6D46 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body
    x-data="{
        secretMode: localStorage.getItem('vesper_secret_mode') === 'true',
        stepOneArmed: false,
        stepOneTimer: null,
        eclipseRunning: false,
        eclipseExpanded: false,
        eclipseHeading: '',
        eclipseSub: '',
        lastEscTime: 0,

        // Système Signature : Le Sceau de Bronze (Hold-to-Unseal)
        unsealedIds: JSON.parse(localStorage.getItem('vesper_unsealed_ids') || '[]'),
        holdingId: null,
        holdProgress: 0,
        holdInterval: null,
        justUnsealedId: null,

        isUnsealed(id) {
            return this.unsealedIds.includes(String(id));
        },

        startHoldSeal(id, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const key = String(id);
            if (this.isUnsealed(key)) return;

            this.holdingId = key;
            this.holdProgress = 0;
            if (this.holdInterval) clearInterval(this.holdInterval);

            const startTime = Date.now();
            const duration = 1200; // 1.2s de maintien pour desceller

            this.holdInterval = setInterval(() => {
                const elapsed = Date.now() - startTime;
                this.holdProgress = Math.min(100, Math.round((elapsed / duration) * 100));

                if (this.holdProgress >= 100) {
                    clearInterval(this.holdInterval);
                    this.holdInterval = null;
                    this.holdingId = null;
                    this.holdProgress = 0;
                    this.breakSeal(key);
                }
            }, 25);
        },

        cancelHoldSeal(event) {
            if (event) {
                event.stopPropagation();
            }
            if (this.holdInterval) {
                clearInterval(this.holdInterval);
                this.holdInterval = null;
            }
            this.holdingId = null;
            this.holdProgress = 0;
        },

        breakSeal(key) {
            if (!this.unsealedIds.includes(key)) {
                this.unsealedIds.push(key);
                localStorage.setItem('vesper_unsealed_ids', JSON.stringify(this.unsealedIds));
            }
            this.justUnsealedId = key;
            setTimeout(() => {
                if (this.justUnsealedId === key) this.justUnsealedId = null;
            }, 2200);
        },

        // Déchiffrement matriciel lettre par lettre
        runCipherDecryption() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789·—°';
            const elements = document.querySelectorAll('[data-cipher-secret]');
            elements.forEach((el) => {
                const targetText = this.secretMode
                    ? el.getAttribute('data-cipher-secret')
                    : el.getAttribute('data-cipher-facade');
                if (!targetText) return;

                let iteration = 0;
                const interval = setInterval(() => {
                    el.innerText = targetText
                        .split('')
                        .map((letter, index) => {
                            if (letter === ' ') return ' ';
                            if (index < iteration) return targetText[index];
                            return chars[Math.floor(Math.random() * chars.length)];
                        })
                        .join('');

                    if (iteration >= targetText.length) {
                        clearInterval(interval);
                        el.innerText = targetText;
                    }
                    iteration += Math.max(1, targetText.length / 14);
                }, 30);
            });
        },

        handleKeydown(e) {
            const isMod = e.ctrlKey || e.metaKey;

            // ACTE 1 : Ctrl + Maj + S -> Arme l'anomalie
            if (isMod && e.shiftKey && (e.key === 'S' || e.key === 's')) {
                e.preventDefault();
                this.stepOneArmed = true;
                if (this.stepOneTimer) clearTimeout(this.stepOneTimer);
                this.stepOneTimer = setTimeout(() => {
                    this.stepOneArmed = false;
                }, 5000);
                return;
            }

            // ACTE 2 : Ctrl + Maj + E -> Déclenche l'Éclipse
            if (isMod && e.shiftKey && (e.key === 'E' || e.key === 'e')) {
                if (this.stepOneArmed) {
                    e.preventDefault();
                    this.stepOneArmed = false;
                    if (this.stepOneTimer) clearTimeout(this.stepOneTimer);
                    this.triggerEclipseTransition(!this.secretMode);
                }
                return;
            }

            // Panic Button : Double Échap rapide -> Retour immédiat à la façade
            if (e.key === 'Escape' && this.secretMode) {
                const now = Date.now();
                if (now - this.lastEscTime < 600) {
                    this.lockSecretMode();
                }
                this.lastEscTime = now;
            }
        },

        triggerEclipseTransition(targetMode) {
            if (targetMode) {
                this.eclipseHeading = 'V E S P E R';
                this.eclipseSub = '43°36\'16&quot;N 01°26\'38&quot;E — ACCÈS PRIVÉ DÉVERROUILLÉ';
            } else {
                this.eclipseHeading = 'U B E R B I T E';
                this.eclipseSub = 'RESTAURATION DE L\'ARCHIVE PUBLIQUE';
            }

            this.eclipseRunning = true;
            setTimeout(() => {
                this.eclipseExpanded = true;
            }, 30);

            setTimeout(() => {
                this.secretMode = targetMode;
                localStorage.setItem('vesper_secret_mode', this.secretMode ? 'true' : 'false');
                this.runCipherDecryption();
            }, 620);

            setTimeout(() => {
                this.eclipseExpanded = false;
            }, 1400);

            setTimeout(() => {
                this.eclipseRunning = false;
            }, 2150);
        },

        lockSecretMode() {
            this.secretMode = false;
            localStorage.setItem('vesper_secret_mode', 'false');
            this.runCipherDecryption();
        }
    }"
    @keydown.window="handleKeydown($event)"
    @mouseup.window="cancelHoldSeal()"
    @touchend.window="cancelHoldSeal()"
    :class="[
        secretMode
            ? 'bg-[#08080A] text-[#EAE6DF] film-grain selection:bg-[#C5A47E] selection:text-[#08080A]'
            : 'bg-[#F6F5F0] text-[#111111] selection:bg-[#111111] selection:text-[#F6F5F0]',
        stepOneArmed ? 'anomaly-armed' : ''
    ]"
    class="flex min-h-screen flex-col transition-colors duration-700"
>
    {{-- ======================================================================= --}}
    {{-- ONDE D'ÉCLIPSE HAUTE COUTURE (OBSIDIENNE & BRONZE CHAMPAGNE)            --}}
    {{-- ======================================================================= --}}
    <div
        x-cloak
        x-show="eclipseRunning"
        :class="eclipseExpanded ? 'eclipse-open' : ''"
        class="eclipse-wave fixed inset-0 z-50 flex flex-col items-center justify-center bg-[#070709] px-6 text-center text-[#EAE6DF]"
    >
        <div class="relative flex h-24 w-24 items-center justify-center">
            <span class="absolute inset-0 animate-ping rounded-full border border-[#C5A47E]/30"></span>
            <span class="absolute inset-2 rounded-full border border-[#C5A47E]/40"></span>
            <div class="flex h-16 w-16 items-center justify-center rounded-full border border-[#C5A47E] bg-[#0E0E12] font-serif-luxury text-2xl italic text-[#C5A47E]">
                V
            </div>
        </div>
        <p class="font-mono-tech mt-8 text-[10px] uppercase tracking-[0.45em] text-[#C5A47E]" x-html="eclipseSub"></p>
        <h2 class="font-serif-luxury mt-3 text-5xl font-normal italic tracking-[0.25em] text-[#EAE6DF] sm:text-7xl" x-text="eclipseHeading"></h2>
        <div class="mt-8 h-px w-40 bg-[#C5A47E]/30"></div>
    </div>

    {{-- ======================================================================= --}}
    {{-- HUD ANOMALIE (ACTE 1 : QUAND CTRL + MAJ + S EST ACTIVÉ)                 --}}
    {{-- ======================================================================= --}}
    <div
        x-cloak
        x-show="stepOneArmed"
        x-transition
        class="fixed bottom-6 right-6 z-40 flex items-center gap-4 border border-[#C5A47E]/50 bg-[#0A0A0D]/95 px-5 py-3.5 text-xs text-[#EAE6DF] shadow-2xl backdrop-blur-xl"
    >
        <span class="h-2 w-2 animate-ping rounded-full bg-[#C5A47E]"></span>
        <div>
            <p class="font-mono-tech text-[10px] uppercase tracking-[0.28em] text-[#C5A47E]">SÉQUENCE I/II RECONNUE</p>
            <p class="mt-0.5 text-[11px] text-neutral-300">Exécutez <kbd class="border border-[#C5A47E]/40 bg-[#C5A47E]/10 px-1.5 py-0.5 font-mono-tech text-[10px] text-[#C5A47E]">Ctrl + Maj + E</kbd> pour ouvrir Vesper</p>
        </div>
    </div>

    {{-- ======================================================================= --}}
    {{-- HEADER ARCHITECTURAL SWISS GRID (FAÇADE) vs HAUTE COUTURE NOIR (SECRET) --}}
    {{-- ======================================================================= --}}
    <header
        :class="secretMode
            ? 'border-b border-[#C5A47E]/20 bg-[#08080A]/95 text-[#EAE6DF]'
            : 'border-b border-[#DFDDD4] bg-[#F6F5F0]/95 text-[#111111]'"
        class="sticky top-0 z-30 backdrop-blur-md transition-colors duration-700"
    >
        <div class="mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-4 px-6 py-3.5 sm:flex-row">
            {{-- Logo --}}
            <a class="group flex items-center gap-4" href="{{ url('/') }}">
                <div
                    :class="secretMode
                        ? 'border-[#C5A47E]/60 bg-[#0E0E12] text-[#C5A47E]'
                        : 'border-[#111111] bg-[#111111] text-[#F6F5F0]'"
                    class="flex h-9 w-9 items-center justify-center border text-xs font-bold transition duration-500"
                >
                    <span x-show="!secretMode" class="font-mono-tech tracking-tighter">UB°</span>
                    <span x-cloak x-show="secretMode" class="font-serif-luxury text-lg italic">V</span>
                </div>

                <div>
                    <span
                        data-cipher-facade="UBERBITE / ARCHIVE"
                        data-cipher-secret="MAISON VESPER"
                        :class="secretMode ? 'font-serif-luxury text-2xl italic tracking-[0.12em] text-[#EAE6DF]' : 'font-serif-luxury text-2xl font-bold tracking-tight text-[#111111]'"
                        class="block leading-none"
                        x-text="secretMode ? 'MAISON VESPER' : 'UBERBITE / ARCHIVE'"
                    >UBERBITE / ARCHIVE</span>
                    <span
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                        class="font-mono-tech mt-1 block text-[9px] uppercase tracking-[0.28em]"
                        x-text="secretMode ? 'PRIVATE SOCIETY • N° IV' : 'CURATED OBJECTS & CLASSIFIEDS'"
                    >CURATED OBJECTS & CLASSIFIEDS</span>
                </div>
            </a>

            {{-- Navigation --}}
            <nav class="flex w-full flex-wrap items-center justify-between gap-4 sm:w-auto sm:justify-end sm:gap-8" aria-label="Navigation principale">
                <a
                    :class="secretMode ? 'text-[#EAE6DF]/75 hover:text-[#C5A47E]' : 'text-neutral-700 hover:text-black'"
                    class="text-[11px] font-semibold uppercase tracking-[0.22em] transition"
                    href="{{ url('/accueil') }}"
                >
                    <span class="font-mono-tech mr-1 text-[10px] text-[#C5A47E]" x-text="secretMode ? 'I.' : '01.'">01.</span>
                    <span x-text="secretMode ? 'Salon Privé' : 'Index'">Index</span>
                </a>

                <a
                    :class="secretMode ? 'text-[#EAE6DF]/75 hover:text-[#C5A47E]' : 'text-neutral-700 hover:text-black'"
                    class="text-[11px] font-semibold uppercase tracking-[0.22em] transition"
                    href="{{ url('/annonces') }}"
                >
                    <span class="font-mono-tech mr-1 text-[10px] text-[#C5A47E]" x-text="secretMode ? 'II.' : '02.'">02.</span>
                    <span x-text="secretMode ? 'Archives Codées' : 'Catalogue'">Catalogue</span>
                </a>

                @auth
                    <a
                        :class="secretMode ? 'text-[#EAE6DF]/75 hover:text-[#C5A47E]' : 'text-neutral-700 hover:text-black'"
                        class="text-[11px] font-semibold uppercase tracking-[0.22em] transition"
                        href="{{ route('mesAnnonces', ['user_name' => auth()->user()->name]) }}"
                    >
                        <span class="font-mono-tech mr-1 text-[10px] text-[#C5A47E]" x-text="secretMode ? 'III.' : '03.'">03.</span>
                        <span x-text="secretMode ? 'Mes Signaux' : 'Mes Annonces'">Mes Annonces</span>
                    </a>
                @endauth

                <div class="flex flex-wrap items-center gap-2.5">
                    {{-- Bouton de dissimulation (Retour Façade) --}}
                    <button
                        x-cloak
                        x-show="secretMode"
                        type="button"
                        @click="triggerEclipseTransition(false)"
                        title="Restaurer la façade publique (ou Double Échap)"
                        class="inline-flex items-center gap-2 border border-[#C5A47E]/35 bg-[#121216] px-3.5 py-2 font-mono-tech text-[10px] uppercase tracking-[0.2em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#C5A47E]"></span>
                        <span>Façade</span>
                    </button>

                    @auth
                        <a
                            :class="secretMode
                                ? 'bg-[#C5A47E] text-[#08080A] hover:bg-[#D8BC98]'
                                : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                            class="px-5 py-2 text-[11px] font-bold uppercase tracking-[0.2em] transition"
                            href="{{ route('dashboard') }}"
                            x-text="secretMode ? 'La Loge' : 'Mon Compte'"
                        >Mon Compte</a>

                        <a
                            :class="secretMode
                                ? 'border-[#C5A47E]/40 text-[#EAE6DF] hover:border-[#C5A47E]'
                                : 'border-[#111111] text-[#111111] hover:bg-[#111111] hover:text-[#F6F5F0]'"
                            class="border px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] transition"
                            href="{{ route('listings.create') }}"
                            x-text="secretMode ? '+ Signal' : '+ Déposer'"
                        >+ Déposer</a>
                    @else
                        <a
                            :class="secretMode
                                ? 'border-[#C5A47E]/40 text-[#EAE6DF]'
                                : 'border-[#111111]/30 text-[#111111] hover:border-[#111111]'"
                            class="border px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] transition"
                            href="{{ route('login') }}"
                        >Connexion</a>

                        <a
                            :class="secretMode
                                ? 'bg-[#C5A47E] text-[#08080A]'
                                : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                            class="px-5 py-2 text-[11px] font-bold uppercase tracking-[0.18em] transition"
                            href="{{ route('register') }}"
                        >Inscription</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1">
        @if (session('success'))
            <div class="mx-auto mt-4 max-w-7xl px-6">
                <div
                    :class="secretMode
                        ? 'border-[#C5A47E]/40 bg-[#111115] text-[#C5A47E]'
                        : 'border-[#111111] bg-white text-[#111111]'"
                    class="flex items-center gap-3 border px-5 py-3 text-xs font-bold uppercase tracking-wider"
                >
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-auto mt-4 max-w-7xl px-6">
                <div class="border border-red-500/40 bg-red-950/90 px-5 py-3 text-xs font-bold uppercase tracking-wider text-red-200">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    {{-- FOOTER (Masqué en mode plein écran secret sur l'accueil pour éviter tout scroll vertical) --}}
    <footer
        x-show="!secretMode"
        class="mt-20 border-t border-[#DFDDD4] bg-[#ECEAE2] px-6 py-10 text-neutral-600"
    >
        <div class="mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-6 text-xs sm:flex-row">
            <div class="flex items-center gap-4">
                <span class="font-serif-luxury text-xl font-bold text-[#111111]">UBERBITE / ARCHIVE</span>
                <span>—</span>
                <span>Design, mobilier & objets choisis — Édition {{ date('Y') }}</span>
            </div>

            <div class="font-mono-tech flex items-center gap-3 text-[11px]">
                <span class="inline-flex items-center gap-2 border border-[#DFDDD4] bg-[#F6F5F0] px-3.5 py-1.5 text-neutral-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                    <span>SYSTÈME OPÉRATIONNEL • GRILLE ÉDITORIALE</span>
                </span>
            </div>
        </div>
    </footer>
</body>
</html>
