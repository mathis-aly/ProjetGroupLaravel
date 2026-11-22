<x-layouts.public title="Inscription | UBERBITE / ARCHIVE">
    <section
        x-data="{
            regGender: 'homme',
            regSeeking: 'femmes',
            regDistrict: 'Toulouse — Saint-Étienne',
            regRdvType: 'Bar Clandestin & Grands Crus',
            regVerified: false,
            regScanning: false,
            regScanPct: 0,

            runRegBioScan() {
                if (this.regScanning) return;
                this.regScanning = true;
                this.regScanPct = 0;
                const iv = setInterval(() => {
                    this.regScanPct += 10;
                    if (this.regScanPct >= 100) {
                        clearInterval(iv);
                        this.regScanning = false;
                        this.regVerified = true;
                    }
                }, 80);
            },

            saveRegPrefs() {
                const prefs = {
                    gender: this.regGender,
                    seeking: this.regSeeking,
                    district: this.regDistrict,
                    rdvType: this.regRdvType,
                    isVerified: true,
                    completed: true
                };
                localStorage.setItem('vesper_user_prefs', JSON.stringify(prefs));
                localStorage.setItem('vesper_free_rdv_used', 'false');
            }
        }"
        class="mx-auto flex min-h-[calc(100vh-10rem)] w-full max-w-7xl items-center justify-center px-6 py-12"
    >
        <div
            :class="secretMode
                ? 'max-w-2xl border border-[#C5A47E]/35 bg-[#0C0C0F] text-[#EAE6DF] shadow-2xl'
                : 'max-w-lg border border-[#DFDDD4] bg-white text-[#111111]'"
            class="w-full p-8 sm:p-10 transition-all duration-700"
        >
            <div class="flex items-center justify-between">
                <p
                    :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                    class="font-mono-tech mb-2 text-xs font-bold uppercase tracking-[0.25em]"
                    x-text="secretMode ? 'INITIATION AU CERCLE VESPER' : 'ADHÉSION ARCHIVE'"
                >ADHÉSION ARCHIVE</p>

                <span
                    x-cloak
                    x-show="secretMode"
                    class="border border-[#C5A47E]/40 bg-[#C5A47E]/10 px-3 py-1 font-mono-tech text-[10px] font-bold text-[#C5A47E]"
                >🎁 1ER RENDEZ-VOUS OFFERT</span>
            </div>

            <h1
                :class="secretMode ? 'text-[#EAE6DF] font-normal italic' : 'text-[#111111]'"
                class="font-serif-luxury text-4xl font-bold"
                x-text="secretMode ? 'Questionnaire d’Initiation & Passeport' : 'Créer un Compte'"
            >Créer un Compte</h1>

            <form method="POST" action="{{ route('register') }}" @submit="saveRegPrefs()" class="mt-7 space-y-5">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label
                            for="name"
                            :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                            class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                            x-text="secretMode ? '01 / PSEUDONYME D\'INITIÉ' : '01 / NOM OU PSEUDONYME'"
                        >01 / NOM OU PSEUDONYME</label>
                        <input
                            id="name"
                            :class="secretMode
                                ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                                : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                            class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                        >
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-500" />
                    </div>

                    <div>
                        <label
                            for="email"
                            :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                            class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        >02 / ADRESSE E-MAIL</label>
                        <input
                            id="email"
                            :class="secretMode
                                ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                                : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                            class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
                    </div>
                </div>

                {{-- QUESTIONNAIRE D'INITIATION (Affiché en Mode Secret lors de l'inscription) --}}
                <div x-cloak x-show="secretMode" class="space-y-5 border-y border-[#C5A47E]/20 py-5">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider text-[#C5A47E]">
                                03 / VOUS ÊTES :
                            </label>
                            <select
                                x-model="regGender"
                                class="mt-1.5 block w-full border border-[#C5A47E]/30 bg-[#08080A] px-4 py-3 text-sm text-[#EAE6DF] focus:border-[#C5A47E] focus:outline-none"
                            >
                                <option value="homme">Un Homme</option>
                                <option value="femme">Une Femme</option>
                                <option value="non_binaire">Non-Binaire / Esprit Libre</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider text-[#C5A47E]">
                                04 / ORIENTATION (VOUS RECHERCHEZ) :
                            </label>
                            <select
                                x-model="regSeeking"
                                class="mt-1.5 block w-full border border-[#C5A47E]/30 bg-[#08080A] px-4 py-3 text-sm text-[#EAE6DF] focus:border-[#C5A47E] focus:outline-none"
                            >
                                <option value="femmes">Des Femmes</option>
                                <option value="hommes">Des Hommes</option>
                                <option value="tous">Tous les Genres</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider text-[#C5A47E]">
                                05 / LOCALISATION & QUARTIER :
                            </label>
                            <input
                                type="text"
                                x-model="regDistrict"
                                class="mt-1.5 block w-full border border-[#C5A47E]/30 bg-[#08080A] px-4 py-3 text-sm text-[#EAE6DF] focus:border-[#C5A47E] focus:outline-none"
                            >
                        </div>

                        <div>
                            <label class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider text-[#C5A47E]">
                                06 / TYPE DE RENDEZ-VOUS PRIVILÉGIÉ :
                            </label>
                            <select
                                x-model="regRdvType"
                                class="mt-1.5 block w-full border border-[#C5A47E]/30 bg-[#08080A] px-4 py-3 text-sm text-[#EAE6DF] focus:border-[#C5A47E] focus:outline-none"
                            >
                                <option value="Bar Clandestin & Grands Crus">Bar Clandestin & Grands Crus</option>
                                <option value="Souper Clandestin à Huis Clos">Souper Clandestin à Huis Clos</option>
                                <option value="Suite Privée & Hôtel Particulier">Suite Privée & Hôtel Particulier</option>
                                <option value="Virée Nocturne & Évasion">Virée Nocturne & Évasion</option>
                                <option value="Club de Jazz & Nuit Électrique">Club de Jazz & Nuit Électrique</option>
                            </select>
                        </div>
                    </div>

                    {{-- Vérification du profil à l'inscription --}}
                    <div class="flex flex-col items-center justify-between gap-4 border border-[#C5A47E]/25 bg-[#08080A] p-4 sm:flex-row">
                        <div>
                            <p class="font-mono-tech text-[10px] font-bold uppercase tracking-widest text-[#C5A47E]">
                                VÉRIFICATION DU PROFIL (18+ & AUTHENTICITÉ)
                            </p>
                            <p class="mt-0.5 text-xs text-neutral-400">
                                Débloque votre badge <strong class="text-white">✓ Membre Vérifié</strong> et votre <strong class="text-[#C5A47E]">1er Rendez-vous Offert</strong>.
                            </p>
                        </div>
                        <button
                            type="button"
                            @click="runRegBioScan()"
                            :class="regVerified ? 'border-emerald-500/40 bg-emerald-950/50 text-emerald-300' : 'border-[#C5A47E] bg-[#C5A47E]/15 text-[#C5A47E] hover:bg-[#C5A47E] hover:text-[#08080A]'"
                            class="shrink-0 border px-4 py-2.5 font-mono-tech text-[10px] font-bold uppercase tracking-widest transition"
                            x-text="regScanning ? 'Scan... ' + regScanPct + '%' : (regVerified ? '✓ Profil Vérifié' : '◎ Vérifier mon Profil')"
                        ></button>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label
                            for="password"
                            :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                            class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        >MOT DE PASSE</label>
                        <input
                            id="password"
                            :class="secretMode
                                ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                                : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                            class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                        >
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                            class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        >CONFIRMER LE MOT DE PASSE</label>
                        <input
                            id="password_confirmation"
                            :class="secretMode
                                ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                                : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                            class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        >
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
                    </div>
                </div>

                <div
                    :class="secretMode ? 'border-[#C5A47E]/20' : 'border-[#DFDDD4]'"
                    class="flex flex-wrap items-center justify-between gap-4 border-t pt-5"
                >
                    <a class="text-xs font-semibold underline underline-offset-4" href="{{ route('login') }}">
                        Déjà inscrit ?
                    </a>
                    <button
                        type="submit"
                        :class="secretMode
                            ? 'bg-[#C5A47E] text-[#08080A] hover:bg-[#D8BC98]'
                            : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                        class="px-7 py-3.5 font-mono-tech text-xs font-bold uppercase tracking-[0.2em] transition"
                        x-text="secretMode ? 'Valider l\'Initiation (1er RDV Offert) →' : 'Créer mon compte'"
                    >
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.public>
