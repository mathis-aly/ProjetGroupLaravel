{{-- resources/views/components/layouts/public.blade.php --}}
@props(['title' => 'UBERBITE — Archive & Objects'])
@php
    $authUser = auth()->user();
    $serverSecretProfile = $authUser ? $authUser->secretProfile() : null;
@endphp
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

        .film-grain {
            background-image: radial-gradient(rgba(197, 164, 126, 0.07) 1px, transparent 0);
            background-size: 24px 24px;
        }

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

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

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

        .eclipse-wave {
            clip-path: circle(0% at 50% 50%);
            transition: clip-path 0.95s cubic-bezier(0.77, 0, 0.175, 1);
        }
        .eclipse-wave.eclipse-open {
            clip-path: circle(150% at 50% 50%);
        }

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

        @keyframes sealShake {
            0%, 100% { transform: scale(1.04) rotate(0deg); }
            25% { transform: scale(1.07) rotate(-2deg); }
            50% { transform: scale(1.09) rotate(2deg); }
            75% { transform: scale(1.07) rotate(-1.5deg); }
        }
        .seal-holding {
            animation: sealShake 0.14s infinite;
        }

        @keyframes vaultSpinLock {
            0% { transform: scale(0.4) rotate(-540deg); opacity: 0; }
            65% { transform: scale(1.18) rotate(30deg); opacity: 1; }
            85% { transform: scale(0.95) rotate(-8deg); }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        .vault-hub-spin {
            animation: vaultSpinLock 0.95s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes shockwaveRing {
            0% { transform: scale(0.8); opacity: 0.9; }
            100% { transform: scale(2.8); opacity: 0; }
        }
        .vault-shockwave {
            animation: shockwaveRing 0.9s ease-out forwards;
        }

        @keyframes bioScanLaser {
            0% { top: 0%; opacity: 0.9; }
            50% { top: 96%; opacity: 1; }
            100% { top: 0%; opacity: 0.9; }
        }
        .bio-laser {
            animation: bioScanLaser 1.4s ease-in-out infinite;
        }

        .line-draw-x {
            transform-origin: left center;
            transition: transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .line-draw-y {
            transform-origin: top center;
            transition: transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
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

        // Modale des Règles (Fight Club) & Chorégraphie d'Assemblage
        showRulesModal: false,
        rulesVisibleCount: 0,
        rulesTimer: null,
        assemblyStage: 5,

        // Questionnaire d'Initiation (Genre, Orientation, Localisation, Vérification du profil)
        showOnboardingModal: false,
        onboardingStep: 1, // 1: Genre & Orientation, 2: Localisation & Type de RDV, 3: Vérification Biométrique
        userPrefs: JSON.parse(localStorage.getItem('vesper_user_prefs') || 'null') || {
            gender: {{ Js::from($serverSecretProfile['gender'] ?? 'homme') }},
            seeking: {{ Js::from($serverSecretProfile['seeking'] ?? 'femmes') }},
            district: {{ Js::from($serverSecretProfile['district'] ?? 'Toulouse — Saint-Étienne') }},
            rdvType: {{ Js::from($serverSecretProfile['rdv_type'] ?? 'Bar Clandestin & Grands Crus') }},
            isVerified: {{ Js::from((bool) ($serverSecretProfile['is_verified'] ?? false)) }},
            completed: {{ Js::from((bool) ($serverSecretProfile['questionnaire_completed'] ?? false)) }}
        },
        bioScanRunning: false,
        bioScanProgress: 0,

        // Système 1er RDV Gratuit + Abonnement (Fake Subscription)
        showSubscriptionModal: false,
        freeRdvUsed: localStorage.getItem('vesper_free_rdv_used') === 'true',
        subscriptionTier: localStorage.getItem('vesper_subscription_tier') || 'free', // 'free' | 'bronze' | 'or_noir'
        subscribingInProgress: false,
        rdvToastMessage: '',

        // Filtre un partenaire selon l'orientation répondue dans le questionnaire
        matchesUserSeeking(partnerGender) {
            if (!partnerGender) return true;
            const s = this.userPrefs.seeking || 'tous';
            if (s === 'tous') return true;
            if (s === 'femmes') return partnerGender === 'femme';
            if (s === 'hommes') return partnerGender === 'homme';
            return true;
        },

        seekingLabel() {
            const s = this.userPrefs.seeking || 'tous';
            if (s === 'femmes') return 'FEMMES';
            if (s === 'hommes') return 'HOMMES';
            return 'TOUS LES GENRES';
        },

        startBiometricVerification() {
            if (this.bioScanRunning) return;
            this.bioScanRunning = true;
            this.bioScanProgress = 0;
            const interval = setInterval(() => {
                this.bioScanProgress += 5;
                if (this.bioScanProgress >= 100) {
                    clearInterval(interval);
                    this.bioScanRunning = false;
                    this.userPrefs.isVerified = true;
                    this.saveUserPrefs();
                }
            }, 70);
        },

        saveUserPrefs() {
            localStorage.setItem('vesper_user_prefs', JSON.stringify(this.userPrefs));
        },

        completeOnboarding() {
            this.userPrefs.completed = true;
            this.userPrefs.isVerified = true;
            this.saveUserPrefs();
            this.showOnboardingModal = false;
            this.startAssemblyChoreography();
        },

        // Gestion du 1er RDV Gratuit puis Modale d'Abonnement
        attemptRendezVous(partnerName, targetUrl = null) {
            // Si abonné Bronze ou Or Noir -> Accès illimité
            if (this.subscriptionTier !== 'free') {
                this.rdvToastMessage = '✦ Accès Privilège (' + (this.subscriptionTier === 'or_noir' ? 'Sceau d\'Or Noir' : 'Clé de Bronze') + ') : Invitation transmise à ' + partnerName + '.';
                setTimeout(() => { this.rdvToastMessage = ''; }, 3800);
                if (targetUrl) setTimeout(() => { window.location.href = targetUrl; }, 700);
                return true;
            }

            // Si le 1er RDV gratuit n'a pas encore été utilisé -> On l'utilise gratuitement !
            if (!this.freeRdvUsed) {
                this.freeRdvUsed = true;
                localStorage.setItem('vesper_free_rdv_used', 'true');
                this.rdvToastMessage = '🎁 Votre 1er Rendez-vous Offert vient d\'être utilisé pour inviter ' + partnerName + ' !';
                setTimeout(() => { this.rdvToastMessage = ''; }, 4500);
                if (targetUrl) setTimeout(() => { window.location.href = targetUrl; }, 900);
                return true;
            }

            // Sinon -> Le 1er RDV gratuit est épuisé, on ouvre la Modale d'Abonnement !
            this.showSubscriptionModal = true;
            return false;
        },

        activateFakeSubscription(tier) {
            this.subscribingInProgress = true;
            setTimeout(() => {
                this.subscribingInProgress = false;
                this.subscriptionTier = tier;
                localStorage.setItem('vesper_subscription_tier', tier);
                this.showSubscriptionModal = false;
                this.rdvToastMessage = '✦ Félicitations : Votre abonnement ' + (tier === 'or_noir' ? 'Sceau d\'Or Noir (VIP)' : 'Clé de Bronze') + ' est actif. Rendez-vous illimités débloqués !';
                setTimeout(() => { this.rdvToastMessage = ''; }, 4500);
            }, 1000);
        },

        resetFreeRdvForDemo() {
            this.freeRdvUsed = false;
            this.subscriptionTier = 'free';
            localStorage.setItem('vesper_free_rdv_used', 'false');
            localStorage.setItem('vesper_subscription_tier', 'free');
            this.showSubscriptionModal = false;
            this.rdvToastMessage = '↺ Démo réinitialisée : Votre 1er Rendez-vous Offert est à nouveau disponible.';
            setTimeout(() => { this.rdvToastMessage = ''; }, 3500);
        },

        vesperRules: [
            {
                num: 'RÈGLE N° I',
                title: 'Vous ne parlez jamais de Maison Vesper.',
                desc: 'En public, ce site n’est qu’une archive éditoriale de montres anciennes, de luminaires et de fauteuils.'
            },
            {
                num: 'RÈGLE N° II',
                title: 'Vous ne parlez JAMAIS de Maison Vesper.',
                desc: 'Si un regard extérieur s’approche de votre écran : pressez deux fois la touche Échap. La façade reprendra ses droits instantanément.'
            },
            {
                num: 'RÈGLE N° III',
                title: 'On n’achète jamais l’objet.',
                desc: 'Le chronographe, le vinyle ou le miroir vénitien n’est qu’un prétexte. C’est le mot de passe à glisser lors du premier verre.'
            },
            {
                num: 'RÈGLE N° IV',
                title: 'Aucun visage n’est dû.',
                desc: 'Pour contempler un membre en couleur, vous devez maintenir son Sceau de Bronze pendant 1,2 seconde et lui laisser votre empreinte.'
            },
            {
                num: 'RÈGLE N° V',
                title: 'Ce qui se noue après minuit s’efface à l’aube.',
                desc: 'Aucune capture, aucune indiscrétion. Les correspondances de La Loge demeurent strictement entre initiés.'
            },
            {
                num: 'RÈGLE N° VI',
                title: 'Si c’est votre première nuit à Maison Vesper...',
                desc: 'Vous devez remplir le Questionnaire d’Initiation, faire vérifier votre profil et profiter de votre 1er Rendez-vous Offert.'
            }
        ],

        openRulesModal() {
            this.showRulesModal = true;
            this.rulesVisibleCount = 0;
            if (this.rulesTimer) clearInterval(this.rulesTimer);
            this.rulesTimer = setInterval(() => {
                if (this.rulesVisibleCount < this.vesperRules.length) {
                    this.rulesVisibleCount++;
                } else {
                    clearInterval(this.rulesTimer);
                }
            }, 160);
        },

        acceptRulesAndAssemble() {
            if (this.rulesTimer) clearInterval(this.rulesTimer);
            this.showRulesModal = false;

            // Si le questionnaire d'initiation n'a pas encore été rempli, on l'ouvre automatiquement !
            if (!this.userPrefs.completed) {
                this.onboardingStep = 1;
                this.showOnboardingModal = true;
            } else {
                this.startAssemblyChoreography();
            }
        },

        startAssemblyChoreography() {
            this.assemblyStage = 0;
            setTimeout(() => { this.assemblyStage = 1; }, 60);
            setTimeout(() => { this.assemblyStage = 2; }, 750);
            setTimeout(() => { this.assemblyStage = 3; }, 1350);
            setTimeout(() => {
                this.assemblyStage = 4;
                this.runCipherDecryption();
            }, 2200);
            setTimeout(() => { this.assemblyStage = 5; }, 2850);
        },

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
            const duration = 1200;

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

            if (this.showRulesModal && (e.key === 'Enter' || e.key === ' ')) {
                e.preventDefault();
                this.acceptRulesAndAssemble();
                return;
            }

            if (isMod && e.shiftKey && (e.key === 'S' || e.key === 's')) {
                e.preventDefault();
                this.stepOneArmed = true;
                if (this.stepOneTimer) clearTimeout(this.stepOneTimer);
                this.stepOneTimer = setTimeout(() => {
                    this.stepOneArmed = false;
                }, 5000);
                return;
            }

            if (isMod && e.shiftKey && (e.key === 'E' || e.key === 'e')) {
                if (this.stepOneArmed) {
                    e.preventDefault();
                    this.stepOneArmed = false;
                    if (this.stepOneTimer) clearTimeout(this.stepOneTimer);
                    this.triggerEclipseTransition(!this.secretMode);
                }
                return;
            }

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
                if (targetMode) {
                    this.assemblyStage = 0;
                    this.openRulesModal();
                } else {
                    this.showRulesModal = false;
                    this.showOnboardingModal = false;
                    this.showSubscriptionModal = false;
                    this.assemblyStage = 5;
                    this.runCipherDecryption();
                }
            }, 580);

            setTimeout(() => {
                this.eclipseExpanded = false;
            }, 1250);

            setTimeout(() => {
                this.eclipseRunning = false;
            }, 1950);
        },

        lockSecretMode() {
            this.showRulesModal = false;
            this.showOnboardingModal = false;
            this.showSubscriptionModal = false;
            this.secretMode = false;
            this.assemblyStage = 5;
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
    {{-- TOAST NOTIFICATION (1ER RDV OFFERT / ABONNEMENT ACTIVÉ)                 --}}
    {{-- ======================================================================= --}}
    <div
        x-cloak
        x-show="rdvToastMessage"
        x-transition
        class="fixed bottom-6 left-1/2 z-50 -translate-x-1/2 border border-[#C5A47E] bg-[#0B0B0F]/95 px-6 py-4 text-center font-mono-tech text-xs text-[#C5A47E] shadow-2xl backdrop-blur-xl"
    >
        <span x-text="rdvToastMessage"></span>
    </div>

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
    {{-- MODALE 1 : LES 6 RÈGLES DE MAISON VESPER (STYLE FIGHT CLUB)             --}}
    {{-- ======================================================================= --}}
    <div
        x-cloak
        x-show="showRulesModal"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-400"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 flex items-center justify-center overflow-y-auto bg-[#050507]/95 p-6 backdrop-blur-2xl"
    >
        <div class="relative w-full max-w-3xl border border-[#C5A47E]/35 bg-[#0A0A0E] p-8 shadow-2xl sm:p-12">
            <span class="pointer-events-none absolute left-0 top-0 h-4 w-4 border-l-2 border-t-2 border-[#C5A47E]"></span>
            <span class="pointer-events-none absolute right-0 top-0 h-4 w-4 border-r-2 border-t-2 border-[#C5A47E]"></span>
            <span class="pointer-events-none absolute bottom-0 left-0 h-4 w-4 border-b-2 border-l-2 border-[#C5A47E]"></span>
            <span class="pointer-events-none absolute bottom-0 right-0 h-4 w-4 border-b-2 border-r-2 border-[#C5A47E]"></span>

            <div class="flex items-center justify-between border-b border-[#C5A47E]/20 pb-5">
                <div>
                    <p class="font-mono-tech text-[10px] font-bold uppercase tracking-[0.38em] text-[#C5A47E]">
                        PROTOCOLE D'INITIATION • CODE D'OMERTÀ
                    </p>
                    <h2 class="font-serif-luxury mt-1 text-4xl font-normal italic text-[#EAE6DF] sm:text-5xl">
                        Les Six Lois de Maison Vesper
                    </h2>
                </div>
                <div class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-full border border-[#C5A47E]/50 bg-[#070709] font-serif-luxury text-2xl italic text-[#C5A47E] sm:flex">
                    V
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <template x-for="(rule, index) in vesperRules" :key="rule.num">
                    <div
                        :class="index < rulesVisibleCount
                            ? 'opacity-100 translate-y-0'
                            : 'opacity-0 translate-y-4 pointer-events-none'"
                        class="border border-[#C5A47E]/20 bg-[#070709] p-4 transition-all duration-500"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-mono-tech text-[10px] font-bold uppercase tracking-[0.25em] text-[#C5A47E]" x-text="rule.num"></span>
                            <span class="h-1 w-1 rounded-full bg-[#C5A47E]/60"></span>
                        </div>
                        <h3 class="font-serif-luxury mt-1.5 text-xl font-bold italic text-white" x-text="rule.title"></h3>
                        <p class="mt-1 text-xs leading-relaxed text-neutral-400" x-text="rule.desc"></p>
                    </div>
                </template>
            </div>

            <div class="mt-8 flex flex-col items-center justify-between gap-4 border-t border-[#C5A47E]/20 pt-6 sm:flex-row">
                <p class="font-mono-tech text-[10px] uppercase tracking-[0.22em] text-neutral-500">
                    EN FRANCHISSANT CE SEUIL, VOUS ACCEPTEZ LE SILENCE
                </p>

                <button
                    type="button"
                    @click="acceptRulesAndAssemble()"
                    class="w-full bg-[#C5A47E] px-8 py-4 font-mono-tech text-xs font-bold uppercase tracking-[0.25em] text-[#08080A] shadow-xl transition hover:bg-[#D8BC98] sm:w-auto"
                    x-text="userPrefs.completed ? 'Prêter Serment & Assembler le Cadran →' : 'Prêter Serment & Remplir le Questionnaire →'"
                >
                </button>
            </div>
        </div>
    </div>

    {{-- ======================================================================= --}}
    {{-- MODALE 2 : QUESTIONNAIRE D'INITIATION & VÉRIFICATION DU PROFIL          --}}
    {{-- ======================================================================= --}}
    <div
        x-cloak
        x-show="showOnboardingModal"
        x-transition:enter="transition ease-out duration-400"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-40 flex items-center justify-center overflow-y-auto bg-[#050507]/95 p-6 backdrop-blur-2xl"
    >
        <div class="relative w-full max-w-2xl border border-[#C5A47E]/40 bg-[#0A0A0E] p-8 shadow-2xl sm:p-10">
            <span class="pointer-events-none absolute left-0 top-0 h-4 w-4 border-l-2 border-t-2 border-[#C5A47E]"></span>
            <span class="pointer-events-none absolute right-0 top-0 h-4 w-4 border-r-2 border-t-2 border-[#C5A47E]"></span>
            <span class="pointer-events-none absolute bottom-0 left-0 h-4 w-4 border-b-2 border-l-2 border-[#C5A47E]"></span>
            <span class="pointer-events-none absolute bottom-0 right-0 h-4 w-4 border-b-2 border-r-2 border-[#C5A47E]"></span>

            {{-- En-tête de progression --}}
            <div class="flex items-center justify-between border-b border-[#C5A47E]/20 pb-4">
                <div>
                    <p class="font-mono-tech text-[10px] font-bold uppercase tracking-[0.32em] text-[#C5A47E]">
                        QUESTIONNAIRE D'INITIATION • ÉTAPE <span x-text="onboardingStep"></span> / 3
                    </p>
                    <h2 class="font-serif-luxury mt-1 text-3xl font-normal italic text-[#EAE6DF] sm:text-4xl">
                        <span x-show="onboardingStep === 1">Identité & Orientation Nocturne</span>
                        <span x-show="onboardingStep === 2">Localisation & Type de Rendez-vous</span>
                        <span x-show="onboardingStep === 3">Vérification d’Authenticité du Profil</span>
                    </h2>
                </div>
                <span class="border border-[#C5A47E]/40 bg-[#C5A47E]/10 px-3 py-1 font-mono-tech text-[10px] font-bold text-[#C5A47E]">
                    🎁 1ER RDV OFFERT
                </span>
            </div>

            {{-- ÉTAPE 1 : GENRE & ORIENTATION SEXUELLE --}}
            <div x-show="onboardingStep === 1" class="mt-6 space-y-6">
                <div>
                    <label class="font-mono-tech block text-[11px] font-bold uppercase tracking-[0.22em] text-[#C5A47E]">
                        I / VOUS ÊTES :
                    </label>
                    <div class="mt-3 grid grid-cols-3 gap-3">
                        <button
                            type="button"
                            @click="userPrefs.gender = 'homme'; saveUserPrefs()"
                            :class="userPrefs.gender === 'homme' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-[#EAE6DF] hover:border-[#C5A47E]'"
                            class="border py-3.5 text-center font-mono-tech text-xs font-bold uppercase tracking-widest transition"
                        >Un Homme</button>
                        <button
                            type="button"
                            @click="userPrefs.gender = 'femme'; saveUserPrefs()"
                            :class="userPrefs.gender === 'femme' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-[#EAE6DF] hover:border-[#C5A47E]'"
                            class="border py-3.5 text-center font-mono-tech text-xs font-bold uppercase tracking-widest transition"
                        >Une Femme</button>
                        <button
                            type="button"
                            @click="userPrefs.gender = 'non_binaire'; saveUserPrefs()"
                            :class="userPrefs.gender === 'non_binaire' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-[#EAE6DF] hover:border-[#C5A47E]'"
                            class="border py-3.5 text-center font-mono-tech text-xs font-bold uppercase tracking-widest transition"
                        >Non-Binaire</button>
                    </div>
                </div>

                <div>
                    <label class="font-mono-tech block text-[11px] font-bold uppercase tracking-[0.22em] text-[#C5A47E]">
                        II / ORIENTATION & PARTENAIRES RECHERCHÉS :
                    </label>
                    <p class="mt-1 text-xs text-neutral-400">
                        La Roue Horlogère et le Catalogue seront filtrés pour vous présenter exclusivement les profils qui correspondent à votre choix.
                    </p>
                    <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <button
                            type="button"
                            @click="userPrefs.seeking = 'femmes'; saveUserPrefs()"
                            :class="userPrefs.seeking === 'femmes' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-[#EAE6DF] hover:border-[#C5A47E]'"
                            class="border p-4 text-left transition"
                        >
                            <span class="font-mono-tech block text-xs font-bold uppercase tracking-wider">Des Femmes</span>
                            <span class="mt-1 block text-[11px] opacity-75">Afficher uniquement les courtisanes</span>
                        </button>

                        <button
                            type="button"
                            @click="userPrefs.seeking = 'hommes'; saveUserPrefs()"
                            :class="userPrefs.seeking === 'hommes' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-[#EAE6DF] hover:border-[#C5A47E]'"
                            class="border p-4 text-left transition"
                        >
                            <span class="font-mono-tech block text-xs font-bold uppercase tracking-wider">Des Hommes</span>
                            <span class="mt-1 block text-[11px] opacity-75">Afficher uniquement les courtisans</span>
                        </button>

                        <button
                            type="button"
                            @click="userPrefs.seeking = 'tous'; saveUserPrefs()"
                            :class="userPrefs.seeking === 'tous' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-[#EAE6DF] hover:border-[#C5A47E]'"
                            class="border p-4 text-left transition"
                        >
                            <span class="font-mono-tech block text-xs font-bold uppercase tracking-wider">Tous les Genres</span>
                            <span class="mt-1 block text-[11px] opacity-75">Sans restriction (Bi / Pan / Libre)</span>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end border-t border-[#C5A47E]/20 pt-5">
                    <button
                        type="button"
                        @click="onboardingStep = 2"
                        class="bg-[#C5A47E] px-8 py-3.5 font-mono-tech text-xs font-bold uppercase tracking-[0.22em] text-[#08080A] transition hover:bg-[#D8BC98]"
                    >
                        Étape Suivante : Localisation →
                    </button>
                </div>
            </div>

            {{-- ÉTAPE 2 : LOCALISATION & TYPE DE RENDEZ-VOUS --}}
            <div x-show="onboardingStep === 2" class="mt-6 space-y-6">
                <div>
                    <label class="font-mono-tech block text-[11px] font-bold uppercase tracking-[0.22em] text-[#C5A47E]">
                        III / VOTRE LOCALISATION & QUARTIER DE RENDEZ-VOUS :
                    </label>
                    <div class="mt-3 grid grid-cols-2 gap-2.5 sm:grid-cols-3">
                        <template x-for="loc in ['Toulouse — Saint-Étienne', 'Toulouse — Les Carmes', 'Toulouse — Capitole', 'Toulouse — Saint-Cyprien', 'Toulouse — Jardin Royal', 'Blagnac & Alentours']" :key="loc">
                            <button
                                type="button"
                                @click="userPrefs.district = loc; saveUserPrefs()"
                                :class="userPrefs.district === loc ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-[#EAE6DF] hover:border-[#C5A47E]'"
                                class="border px-3 py-2.5 font-mono-tech text-[10px] font-bold uppercase tracking-wider transition"
                                x-text="loc"
                            ></button>
                        </template>
                    </div>
                    <input
                        type="text"
                        x-model="userPrefs.district"
                        @input="saveUserPrefs()"
                        placeholder="Ou saisissez votre ville / quartier..."
                        class="mt-3 block w-full border border-[#C5A47E]/30 bg-[#070709] px-4 py-3 text-sm text-[#EAE6DF] focus:border-[#C5A47E] focus:outline-none"
                    >
                </div>

                <div>
                    <label class="font-mono-tech block text-[11px] font-bold uppercase tracking-[0.22em] text-[#C5A47E]">
                        IV / TYPE DE RENDEZ-VOUS RECHERCHÉ EN PRIORITÉ :
                    </label>
                    <select
                        x-model="userPrefs.rdvType"
                        @change="saveUserPrefs()"
                        class="mt-2 block w-full border border-[#C5A47E]/30 bg-[#070709] px-4 py-3 text-sm text-[#EAE6DF] focus:border-[#C5A47E] focus:outline-none"
                    >
                        <option value="Bar Clandestin & Grands Crus">Bar Clandestin & Grands Crus</option>
                        <option value="Souper Clandestin à Huis Clos">Souper Clandestin à Huis Clos</option>
                        <option value="Suite Privée & Hôtel Particulier">Suite Privée & Hôtel Particulier</option>
                        <option value="Virée Nocturne & Évasion">Virée Nocturne & Évasion</option>
                        <option value="Club de Jazz & Nuit Électrique">Club de Jazz & Nuit Électrique</option>
                        <option value="Gala, Opéra & Soirée Habillée">Gala, Opéra & Soirée Habillée</option>
                        <option value="Salon Littéraire & Heure Tardive">Salon Littéraire & Heure Tardive</option>
                        <option value="Alchimie Intense & Sans Filtre">Alchimie Intense & Sans Filtre</option>
                    </select>
                </div>

                <div class="flex items-center justify-between border-t border-[#C5A47E]/20 pt-5">
                    <button
                        type="button"
                        @click="onboardingStep = 1"
                        class="border border-[#C5A47E]/30 px-5 py-3 font-mono-tech text-xs uppercase tracking-widest text-neutral-400 hover:text-white"
                    >← Retour</button>

                    <button
                        type="button"
                        @click="onboardingStep = 3"
                        class="bg-[#C5A47E] px-8 py-3.5 font-mono-tech text-xs font-bold uppercase tracking-[0.22em] text-[#08080A] transition hover:bg-[#D8BC98]"
                    >
                        Étape Suivante : Vérification →
                    </button>
                </div>
            </div>

            {{-- ÉTAPE 3 : VÉRIFICATION BIOMÉTRIQUE DU PROFIL --}}
            <div x-show="onboardingStep === 3" class="mt-6 space-y-6">
                <div class="border border-[#C5A47E]/25 bg-[#070709] p-6 text-center">
                    <div class="relative mx-auto flex h-32 w-32 items-center justify-center overflow-hidden rounded-full border-2 border-[#C5A47E]/60 bg-[#0D0D12]">
                        {{-- Laser de scan biométrique --}}
                        <div x-show="bioScanRunning" class="bio-laser absolute inset-x-0 h-1 bg-[#C5A47E] shadow-lg shadow-[#C5A47E]"></div>

                        <div class="flex flex-col items-center">
                            <span class="font-serif-luxury text-4xl italic text-[#C5A47E]" x-text="userPrefs.isVerified ? '✓' : 'V'"></span>
                            <span
                                class="font-mono-tech mt-1 text-[9px] uppercase tracking-widest text-[#EAE6DF]"
                                x-text="bioScanRunning ? bioScanProgress + '%' : (userPrefs.isVerified ? 'CERTIFIÉ' : 'SCANNER')"
                            ></span>
                        </div>
                    </div>

                    <h3 class="font-serif-luxury mt-4 text-2xl italic text-white">
                        <span x-show="!userPrefs.isVerified">Vérification d’Authenticité & Majorité (18+)</span>
                        <span x-show="userPrefs.isVerified" class="text-[#C5A47E]">✦ Profil Authentifié & Certifié Vesper</span>
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-xs leading-relaxed text-neutral-400">
                        Maison Vesper exige la vérification de chaque membre afin de garantir des rencontres réelles, sûres et confidentielles.
                    </p>

                    <div class="mt-5 flex flex-wrap items-center justify-center gap-3">
                        <button
                            type="button"
                            x-show="!userPrefs.isVerified"
                            @click="startBiometricVerification()"
                            class="border border-[#C5A47E] bg-[#C5A47E]/15 px-6 py-3 font-mono-tech text-xs font-bold uppercase tracking-[0.2em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                        >
                            <span x-text="bioScanRunning ? 'Analyse Biométrique en cours...' : '◎ Lancer la Vérification du Profil'"></span>
                        </button>

                        <span
                            x-show="userPrefs.isVerified"
                            class="inline-flex items-center gap-2 border border-emerald-500/40 bg-emerald-950/40 px-4 py-2 font-mono-tech text-xs font-bold uppercase tracking-widest text-emerald-300"
                        >
                            ✓ Sceau d’Authenticité Accordé • 1er Rendez-vous Offert Débloqué
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-[#C5A47E]/20 pt-5">
                    <button
                        type="button"
                        @click="onboardingStep = 2"
                        class="border border-[#C5A47E]/30 px-5 py-3 font-mono-tech text-xs uppercase tracking-widest text-neutral-400 hover:text-white"
                    >← Retour</button>

                    <button
                        type="button"
                        @click="completeOnboarding()"
                        class="bg-[#C5A47E] px-8 py-4 font-mono-tech text-xs font-bold uppercase tracking-[0.25em] text-[#08080A] shadow-xl transition hover:bg-[#D8BC98]"
                    >
                        Entrer dans le Sanctuaire (1er RDV Offert) →
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================================= --}}
    {{-- MODALE 3 : FORMULES D'ABONNEMENT « LES CLÉS DE MAISON VESPER » (FAKE)   --}}
    {{-- ======================================================================= --}}
    <div
        x-cloak
        x-show="showSubscriptionModal"
        x-transition:enter="transition ease-out duration-400"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-[#050507]/95 p-6 backdrop-blur-2xl"
    >
        <div class="relative w-full max-w-4xl border border-[#C5A47E]/40 bg-[#0A0A0E] p-8 shadow-2xl sm:p-10">
            <button
                type="button"
                @click="showSubscriptionModal = false"
                class="absolute right-5 top-5 border border-[#C5A47E]/30 px-3 py-1 font-mono-tech text-xs text-neutral-400 hover:border-[#C5A47E] hover:text-white"
            >✕ FERMER</button>

            <div class="border-b border-[#C5A47E]/20 pb-5">
                <p class="font-mono-tech text-[10px] font-bold uppercase tracking-[0.35em] text-[#C5A47E]">
                    PRIVILÈGES & ADHÉSION • MAISON VESPER
                </p>
                <h2 class="font-serif-luxury mt-1 text-4xl font-normal italic text-[#EAE6DF] sm:text-5xl">
                    Votre 1er Rendez-vous Offert a été consommé.
                </h2>
                <p class="mt-2 text-xs text-neutral-400">
                    Pour continuer à initier des rencontres nocturnes et déverrouiller tous les dossiers sans limite, choisissez votre Clé d’Initié.
                </p>
            </div>

            <div class="mt-7 grid gap-6 lg:grid-cols-3">
                {{-- Formule 1 : Pass Éclipse (1er RDV Offert) --}}
                <div class="flex flex-col justify-between border border-white/15 bg-[#070709] p-6 opacity-75">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="font-mono-tech text-[10px] uppercase tracking-widest text-neutral-400">NIVEAU I</span>
                            <span
                                class="border px-2.5 py-0.5 font-mono-tech text-[9px] uppercase"
                                :class="freeRdvUsed ? 'border-neutral-600 text-neutral-500' : 'border-emerald-500/40 text-emerald-300'"
                                x-text="freeRdvUsed ? 'ÉPUISÉ' : 'ACTIF'"
                            ></span>
                        </div>
                        <h3 class="font-serif-luxury mt-3 text-3xl italic text-white">Pass Éclipse</h3>
                        <p class="font-mono-tech mt-2 text-2xl font-bold text-[#C5A47E]">Offert</p>
                        <ul class="mt-5 space-y-2.5 text-xs text-neutral-400">
                            <li>✓ <strong class="text-white">1er Rendez-vous Offert</strong> à l’inscription</li>
                            <li>✓ Accès au Cadran Horloger 360°</li>
                            <li>✓ Profil Vérifié par Sceau Biométrique</li>
                        </ul>
                    </div>

                    <button
                        type="button"
                        @click="resetFreeRdvForDemo()"
                        class="mt-6 w-full border border-[#C5A47E]/30 py-3 font-mono-tech text-[10px] uppercase tracking-widest text-[#C5A47E] transition hover:bg-[#C5A47E]/10"
                    >
                        ↺ Réinitialiser le 1er RDV gratuit (Démo)
                    </button>
                </div>

                {{-- Formule 2 : Clé de Bronze (Recommandée) --}}
                <div class="relative flex flex-col justify-between border-2 border-[#C5A47E] bg-[#0E0E13] p-6 shadow-2xl">
                    <span class="absolute -top-3 left-6 bg-[#C5A47E] px-3 py-0.5 font-mono-tech text-[9px] font-bold uppercase tracking-widest text-[#08080A]">
                        RECOMMANDÉ
                    </span>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="font-mono-tech text-[10px] uppercase tracking-widest text-[#C5A47E]">NIVEAU II</span>
                            <span x-show="subscriptionTier === 'bronze'" class="font-mono-tech text-[10px] font-bold text-emerald-400">● VOTRE CLÉ</span>
                        </div>
                        <h3 class="font-serif-luxury mt-3 text-3xl italic text-white">Clé de Bronze</h3>
                        <p class="font-mono-tech mt-2 text-2xl font-bold text-[#C5A47E]">49 € <span class="text-xs font-normal text-neutral-400">/ mois</span></p>
                        <ul class="mt-5 space-y-2.5 text-xs text-neutral-300">
                            <li>✦ <strong class="text-white">Rendez-vous nocturnes illimités</strong></li>
                            <li>✦ Descellement illimité des portraits en couleur</li>
                            <li>✦ Messagerie privée directe dans La Loge</li>
                            <li>✦ Filtre d’affinité prioritaire sur la Roue</li>
                        </ul>
                    </div>

                    <button
                        type="button"
                        @click="activateFakeSubscription('bronze')"
                        class="mt-6 w-full bg-[#C5A47E] py-3.5 font-mono-tech text-xs font-bold uppercase tracking-[0.2em] text-[#08080A] transition hover:bg-[#D8BC98]"
                        x-text="subscribingInProgress ? 'Activation en cours...' : (subscriptionTier === 'bronze' ? '✓ Clé de Bronze Active' : 'Activer la Clé de Bronze →')"
                    ></button>
                </div>

                {{-- Formule 3 : Sceau d'Or Noir (VIP Souverain) --}}
                <div class="flex flex-col justify-between border border-[#C5A47E]/40 bg-[#08080B] p-6">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="font-mono-tech text-[10px] uppercase tracking-widest text-[#C5A47E]">NIVEAU III • VIP</span>
                            <span x-show="subscriptionTier === 'or_noir'" class="font-mono-tech text-[10px] font-bold text-emerald-400">● VOTRE SCEAU</span>
                        </div>
                        <h3 class="font-serif-luxury mt-3 text-3xl italic text-white">Sceau d’Or Noir</h3>
                        <p class="font-mono-tech mt-2 text-2xl font-bold text-[#C5A47E]">140 € <span class="text-xs font-normal text-neutral-400">/ mois</span></p>
                        <ul class="mt-5 space-y-2.5 text-xs text-neutral-300">
                            <li>👑 <strong class="text-white">Tous les privilèges Clé de Bronze</strong></li>
                            <li>👑 Accès aux Suites Privées & Hôtels Particuliers</li>
                            <li>👑 Conciergerie de réservation secrète</li>
                            <li>👑 Mise en avant à 12h sur le Cadran Vesper</li>
                        </ul>
                    </div>

                    <button
                        type="button"
                        @click="activateFakeSubscription('or_noir')"
                        class="mt-6 w-full border border-[#C5A47E] bg-[#C5A47E]/15 py-3.5 font-mono-tech text-xs font-bold uppercase tracking-[0.2em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                        x-text="subscribingInProgress ? 'Activation en cours...' : (subscriptionTier === 'or_noir' ? '✓ Sceau d\'Or Noir Actif' : 'Activer le Sceau d\'Or Noir →')"
                    ></button>
                </div>
            </div>
        </div>
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
        :class="[
            secretMode
                ? 'border-b border-[#C5A47E]/20 bg-[#08080A]/95 text-[#EAE6DF]'
                : 'border-b border-[#DFDDD4] bg-[#F6F5F0]/95 text-[#111111]',
            (secretMode && assemblyStage < 4) ? '-translate-y-full opacity-0' : 'translate-y-0 opacity-100'
        ]"
        class="sticky top-0 z-30 backdrop-blur-md transition-all duration-700"
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
                    <div class="flex items-center gap-2">
                        <span
                            data-cipher-facade="UBERBITE / ARCHIVE"
                            data-cipher-secret="MAISON VESPER"
                            :class="secretMode ? 'font-serif-luxury text-2xl italic tracking-[0.12em] text-[#EAE6DF]' : 'font-serif-luxury text-2xl font-bold tracking-tight text-[#111111]'"
                            class="block leading-none"
                            x-text="secretMode ? 'MAISON VESPER' : 'UBERBITE / ARCHIVE'"
                        >UBERBITE / ARCHIVE</span>

                        {{-- Badge Profil Vérifié en Mode Secret --}}
                        <span
                            x-cloak
                            x-show="secretMode && userPrefs.isVerified"
                            title="Profil vérifié par Sceau Biométrique"
                            class="border border-[#C5A47E]/40 bg-[#C5A47E]/15 px-1.5 py-0.5 font-mono-tech text-[8px] font-bold uppercase tracking-widest text-[#C5A47E]"
                        >✓ VÉRIFIÉ</span>
                    </div>
                    <span
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                        class="font-mono-tech mt-1 block text-[9px] uppercase tracking-[0.28em]"
                        x-text="secretMode ? 'RECHERCHE : ' + seekingLabel() + ' • ' + userPrefs.district : 'CURATED OBJECTS & CLASSIFIEDS'"
                    >CURATED OBJECTS & CLASSIFIEDS</span>
                </div>
            </a>

            {{-- Navigation --}}
            <nav class="flex w-full flex-wrap items-center justify-between gap-3 sm:w-auto sm:justify-end sm:gap-5" aria-label="Navigation principale">
                <a
                    :class="secretMode ? 'text-[#EAE6DF]/75 hover:text-[#C5A47E]' : 'text-neutral-700 hover:text-black'"
                    class="text-[11px] font-semibold uppercase tracking-[0.2em] transition"
                    href="{{ url('/accueil') }}"
                >
                    <span class="font-mono-tech mr-1 text-[10px] text-[#C5A47E]" x-text="secretMode ? 'I.' : '01.'">01.</span>
                    <span x-text="secretMode ? 'Le Cadran' : 'Index'">Index</span>
                </a>

                <a
                    :class="secretMode ? 'text-[#EAE6DF]/75 hover:text-[#C5A47E]' : 'text-neutral-700 hover:text-black'"
                    class="text-[11px] font-semibold uppercase tracking-[0.2em] transition"
                    href="{{ url('/annonces') }}"
                >
                    <span class="font-mono-tech mr-1 text-[10px] text-[#C5A47E]" x-text="secretMode ? 'II.' : '02.'">02.</span>
                    <span x-text="secretMode ? 'Archives Codées' : 'Catalogue'">Catalogue</span>
                </a>

                @auth
                    <a
                        :class="secretMode ? 'text-[#EAE6DF]/75 hover:text-[#C5A47E]' : 'text-neutral-700 hover:text-black'"
                        class="text-[11px] font-semibold uppercase tracking-[0.2em] transition"
                        href="{{ route('mesAnnonces', ['user_name' => auth()->user()->name]) }}"
                    >
                        <span class="font-mono-tech mr-1 text-[10px] text-[#C5A47E]" x-text="secretMode ? 'III.' : '03.'">03.</span>
                        <span x-text="secretMode ? 'Mes Signaux' : 'Mes Annonces'">Mes Annonces</span>
                    </a>
                @endauth

                <div class="flex flex-wrap items-center gap-2">
                    {{-- Bouton Questionnaire d'Orientation & Vérification --}}
                    <button
                        x-cloak
                        x-show="secretMode"
                        type="button"
                        @click="onboardingStep = 1; showOnboardingModal = true"
                        title="Modifier mon orientation, ma localisation et ma vérification"
                        class="inline-flex items-center gap-1.5 border border-[#C5A47E]/35 bg-[#0E0E12] px-2.5 py-2 font-mono-tech text-[10px] uppercase tracking-[0.16em] text-[#EAE6DF] transition hover:border-[#C5A47E] hover:text-[#C5A47E]"
                    >
                        <span class="text-[#C5A47E]">◎</span>
                        <span x-text="'Cible : ' + seekingLabel()"></span>
                    </button>

                    {{-- Bouton 1er RDV Offert / Abonnement Vesper --}}
                    <button
                        x-cloak
                        x-show="secretMode"
                        type="button"
                        @click="showSubscriptionModal = true"
                        class="inline-flex items-center gap-1.5 border border-[#C5A47E]/50 bg-[#C5A47E]/15 px-2.5 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.15em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                    >
                        <span x-text="subscriptionTier !== 'free'
                            ? '👑 ' + (subscriptionTier === 'or_noir' ? 'OR NOIR' : 'CLÉ BRONZE')
                            : (!freeRdvUsed ? '🎁 1ER RDV OFFERT' : '🗝️ PASS VESPER')"></span>
                    </button>

                    {{-- Bouton Les 6 Lois --}}
                    <button
                        x-cloak
                        x-show="secretMode"
                        type="button"
                        @click="openRulesModal()"
                        class="inline-flex items-center gap-1 border border-[#C5A47E]/35 bg-[#0E0E12] px-2.5 py-2 font-mono-tech text-[10px] uppercase tracking-[0.16em] text-[#EAE6DF] transition hover:border-[#C5A47E] hover:text-[#C5A47E]"
                    >
                        <span class="text-[#C5A47E]">§</span>
                        <span>Lois</span>
                    </button>

                    {{-- Bouton Façade --}}
                    <button
                        x-cloak
                        x-show="secretMode"
                        type="button"
                        @click="triggerEclipseTransition(false)"
                        title="Restaurer la façade publique (ou Double Échap)"
                        class="inline-flex items-center gap-1.5 border border-[#C5A47E]/35 bg-[#121216] px-2.5 py-2 font-mono-tech text-[10px] uppercase tracking-[0.16em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                    >
                        <span>Façade</span>
                    </button>

                    @auth
                        <a
                            :class="secretMode
                                ? 'bg-[#C5A47E] text-[#08080A] hover:bg-[#D8BC98]'
                                : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                            class="px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em] transition"
                            href="{{ route('dashboard') }}"
                            x-text="secretMode ? 'La Loge' : 'Mon Compte'"
                        >Mon Compte</a>

                        <a
                            :class="secretMode
                                ? 'border-[#C5A47E]/40 text-[#EAE6DF] hover:border-[#C5A47E]'
                                : 'border-[#111111] text-[#111111] hover:bg-[#111111] hover:text-[#F6F5F0]'"
                            class="border px-3.5 py-2 text-[11px] font-bold uppercase tracking-[0.16em] transition"
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

    {{-- FOOTER (Uniquement en mode façade) --}}
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
