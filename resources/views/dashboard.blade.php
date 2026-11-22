@php
    $user = $user ?? auth()->user();
    $listingsCount = $user?->listings()->count() ?? 0;
@endphp

<x-layouts.public title="Mon Compte | UBERBITE / ARCHIVE">
    <div
        x-data="{
            activeLogeTab: 'correspondance' // 'correspondance' | 'aura' | 'passeport'
        }"
        class="mx-auto max-w-7xl px-6 py-8"
    >

        {{-- ======================================================================= --}}
        {{-- EN-TÊTE : COMPTE ÉDITORIAL SWISS GRID (FAÇADE) vs LA LOGE (SECRET)      --}}
        {{-- ======================================================================= --}}
        <div
            :class="secretMode
                ? 'border border-[#C5A47E]/30 bg-[#0C0C0F] text-[#EAE6DF]'
                : 'border border-[#DFDDD4] bg-white text-[#111111]'"
            class="relative overflow-hidden px-6 py-8 sm:px-10 sm:py-9 transition-all duration-700"
        >
            <div class="relative z-10 flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-center">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div
                        :class="secretMode
                            ? 'border border-[#C5A47E] bg-[#08080A] text-[#C5A47E]'
                            : 'border border-[#111111] bg-[#111111] text-[#F6F5F0]'"
                        class="font-serif-luxury flex h-16 w-16 shrink-0 items-center justify-center text-3xl italic"
                    >
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <span
                            :class="secretMode
                                ? 'border-[#C5A47E]/40 text-[#C5A47E]'
                                : 'border-[#111111] text-[#111111]'"
                            class="font-mono-tech mb-2 inline-flex items-center gap-2 border px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-[0.28em]"
                        >
                            <span class="h-1.5 w-1.5 rounded-full" :class="secretMode ? 'bg-[#C5A47E]' : 'bg-emerald-600'"></span>
                            <span x-text="secretMode ? 'LA LOGE PRIVÉE • MAISON VESPER' : 'ESPACE MEMBRE • ARCHIVE N° ' + {{ $user->id }}"></span>
                        </span>

                        <h1 class="font-serif-luxury text-3xl font-bold tracking-tight sm:text-5xl">
                            <span x-text="secretMode ? 'Bonsoir,' : 'Bonjour,'">Bonjour,</span>
                            <span :class="secretMode ? 'text-[#C5A47E] font-normal italic' : 'text-[#111111]'">{{ $user->name }}</span>
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    {{-- Navigation par Loges en mode secret (évite le scroll vertical) --}}
                    <template x-if="secretMode">
                        <div class="flex flex-wrap items-center border border-[#C5A47E]/30 bg-[#08080A] p-1">
                            <button
                                type="button"
                                @click="activeLogeTab = 'correspondance'"
                                :class="activeLogeTab === 'correspondance' ? 'bg-[#C5A47E] text-[#08080A]' : 'text-[#EAE6DF]/75 hover:text-[#C5A47E]'"
                                class="px-3.5 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.2em] transition"
                            >
                                I. Correspondances (3)
                            </button>
                            <button
                                type="button"
                                @click="activeLogeTab = 'aura'"
                                :class="activeLogeTab === 'aura' ? 'bg-[#C5A47E] text-[#08080A]' : 'text-[#EAE6DF]/75 hover:text-[#C5A47E]'"
                                class="px-3.5 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.2em] transition"
                            >
                                II. Aura & Métriques
                            </button>
                            <button
                                type="button"
                                @click="activeLogeTab = 'passeport'"
                                :class="activeLogeTab === 'passeport' ? 'bg-[#C5A47E] text-[#08080A]' : 'text-[#EAE6DF]/75 hover:text-[#C5A47E]'"
                                class="px-3.5 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.2em] transition"
                            >
                                III. Passeport & Sécurité
                            </button>
                        </div>
                    </template>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button
                            type="submit"
                            :class="secretMode ? 'border-[#C5A47E]/30 text-neutral-400 hover:border-red-500 hover:text-red-300' : 'border-red-600/40 text-red-700 hover:bg-red-600 hover:text-white'"
                            class="inline-flex items-center justify-center border px-4 py-2.5 font-mono-tech text-[10px] font-bold uppercase tracking-widest transition"
                        >
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ======================================================================= --}}
        {{-- SECTION 1 : STATISTIQUES FICTIVES (Affiché en Façade ou Loge II)        --}}
        {{-- ======================================================================= --}}
        <section
            x-show="!secretMode || activeLogeTab === 'aura'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="mt-10"
            aria-labelledby="stats-title"
        >
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                        class="font-mono-tech text-xs font-bold uppercase tracking-[0.25em]"
                        x-text="secretMode ? 'LOGE II / AURA & MAGNÉTISME NOCTURNE' : '01 / MÉTRIQUES VENDEUR'"
                    >01 / MÉTRIQUES VENDEUR</p>
                    <h2
                        id="stats-title"
                        :class="secretMode ? 'text-[#EAE6DF] font-normal italic' : 'text-[#111111]'"
                        class="font-serif-luxury mt-1 text-3xl font-bold sm:text-4xl"
                        x-text="secretMode ? 'Influence & Présence Nocturne' : 'Statistiques de votre Activité'"
                    >
                        Statistiques de votre Activité
                    </h2>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div :class="secretMode ? 'border-[#C5A47E]/25 bg-[#0C0C0F] text-[#EAE6DF]' : 'border-[#DFDDD4] bg-white text-[#111111]'" class="border p-6">
                    <span class="font-mono-tech text-[10px] font-bold uppercase tracking-widest opacity-60" x-text="secretMode ? 'I / REGARDS NOCTURNES' : '01 / VUES CUMULÉES'"></span>
                    <p class="font-serif-luxury mt-4 text-4xl font-bold" x-text="secretMode ? '342' : '1 284'">1 284</p>
                    <p class="mt-2 font-mono-tech text-[11px] text-[#C5A47E]">
                        <strong x-text="secretMode ? '+38%' : '+18%'">+18%</strong>
                        <span class="opacity-75" x-text="secretMode ? 'cette semaine' : 'vs mois dernier'"></span>
                    </p>
                </div>

                <div :class="secretMode ? 'border-[#C5A47E]/25 bg-[#0C0C0F] text-[#EAE6DF]' : 'border-[#DFDDD4] bg-white text-[#111111]'" class="border p-6">
                    <span class="font-mono-tech text-[10px] font-bold uppercase tracking-widest opacity-60" x-text="secretMode ? 'II / RENDEZ-VOUS CONCLUS' : '02 / VENTES CONCLUES'"></span>
                    <p class="font-serif-luxury mt-4 text-4xl font-bold" x-text="secretMode ? '9' : '14'">14</p>
                    <p class="mt-2 font-mono-tech text-[11px] opacity-75">
                        <span x-text="secretMode ? '3 invitations pour ce soir' : '3 négociations en cours'"></span>
                    </p>
                </div>

                <div :class="secretMode ? 'border-[#C5A47E]/25 bg-[#0C0C0F] text-[#EAE6DF]' : 'border-[#DFDDD4] bg-white text-[#111111]'" class="border p-6">
                    <span class="font-mono-tech text-[10px] font-bold uppercase tracking-widest opacity-60" x-text="secretMode ? 'III / INDICE D\'AFFINITÉ' : '03 / REVENUS GÉNÉRÉS'"></span>
                    <p class="font-serif-luxury mt-4 text-4xl font-bold glitch-target" x-text="secretMode ? '94 %' : '485,00 €'">485,00 €</p>
                    <p class="mt-2 font-mono-tech text-[11px] text-[#C5A47E]">
                        <span x-text="secretMode ? 'Cercle Restreint Vesper' : '+120,00 € sur 7 jours'"></span>
                    </p>
                </div>

                <div :class="secretMode ? 'border-[#C5A47E]/25 bg-[#0C0C0F] text-[#EAE6DF]' : 'border-[#DFDDD4] bg-white text-[#111111]'" class="border p-6">
                    <span class="font-mono-tech text-[10px] font-bold uppercase tracking-widest opacity-60" x-text="secretMode ? 'IV / RÉPUTATION SECRÈTE' : '04 / NOTE VENDEUR'"></span>
                    <p class="font-serif-luxury mt-4 text-4xl font-bold">4,9 <span class="text-lg font-normal opacity-50">/ 5</span></p>
                    <p class="mt-2 font-mono-tech text-[11px] opacity-75">
                        <span x-text="secretMode ? '18 témoignages confidentiels' : '12 avis vérifiés • 98% positif'"></span>
                    </p>
                </div>
            </div>

            <div class="mt-5 grid gap-5 lg:grid-cols-3">
                <div :class="secretMode ? 'border-[#C5A47E]/25 bg-[#0C0C0F] text-[#EAE6DF]' : 'border-[#DFDDD4] bg-white text-[#111111]'" class="border p-6 lg:col-span-2">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <h3 class="font-serif-luxury text-2xl font-bold" x-text="secretMode ? 'Présences Nocturnes sur vos Signaux (7 nuits)' : 'Fréquentation de vos Annonces (7 derniers jours)'"></h3>
                            <p class="text-xs opacity-65" x-text="secretMode ? 'Ouvertures de vos dossiers après 21h' : 'Consultations quotidiennes de vos pièces'"></p>
                        </div>
                        <span :class="secretMode ? 'border border-[#C5A47E]/40 text-[#C5A47E]' : 'bg-[#F6F5F0] text-[#111111]'" class="font-mono-tech px-3 py-1 text-xs font-bold" x-text="secretMode ? 'PIC : SAMEDI MINUIT' : 'MOYENNE : 42 VUES / JOUR'"></span>
                    </div>

                    <div :class="secretMode ? 'border-[#C5A47E]/20' : 'border-[#DFDDD4]'" class="mt-6 grid h-44 grid-cols-7 items-end gap-3 border-b pt-4">
                        @php
                            $days = [
                                ['label' => 'Lun', 'views' => 28, 'height' => 'h-20'],
                                ['label' => 'Mar', 'views' => 35, 'height' => 'h-24'],
                                ['label' => 'Mer', 'views' => 52, 'height' => 'h-32'],
                                ['label' => 'Jeu', 'views' => 41, 'height' => 'h-28'],
                                ['label' => 'Ven', 'views' => 64, 'height' => 'h-36'],
                                ['label' => 'Sam', 'views' => 78, 'height' => 'h-40'],
                                ['label' => 'Dim', 'views' => 59, 'height' => 'h-32'],
                            ];
                        @endphp
                        @foreach ($days as $day)
                            <div class="flex flex-col items-center gap-2">
                                <span class="font-mono-tech text-[11px] font-bold opacity-70">{{ $day['views'] }}</span>
                                <div
                                    :class="secretMode
                                        ? '{{ $day['label'] === 'Sam' ? 'bg-[#C5A47E]' : 'bg-[#1D1C22] border border-[#C5A47E]/30' }}'
                                        : '{{ $day['label'] === 'Sam' ? 'bg-[#111111]' : 'bg-[#DFDDD4] hover:bg-neutral-400' }}'"
                                    class="w-full max-w-[2.5rem] {{ $day['height'] }} transition"
                                ></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2 grid grid-cols-7 text-center font-mono-tech text-xs opacity-70">
                        @foreach ($days as $day)
                            <span>{{ $day['label'] }}</span>
                        @endforeach
                    </div>
                </div>

                <div
                    :class="secretMode
                        ? 'border border-[#C5A47E]/30 bg-[#0A0A0D] text-[#EAE6DF]'
                        : 'border border-[#111111] bg-[#111111] text-[#F6F5F0]'"
                    class="flex flex-col justify-between p-6"
                >
                    <div>
                        <span class="font-mono-tech text-[10px] font-bold uppercase tracking-widest text-[#C5A47E]" x-text="secretMode ? 'INDICE DE DISCRÉTION' : 'BILAN D\'ENGAGEMENT'"></span>
                        <h3 class="font-serif-luxury mt-2 text-2xl font-bold" x-text="secretMode ? 'Élégance & Mystère' : 'Réactivité Exemplaire'"></h3>
                        <p class="mt-1 text-xs opacity-75" x-text="secretMode ? 'Vos signaux codés attirent les profils les plus exigeants.' : 'Les acheteurs apprécient votre rapidité de réponse.'"></p>
                    </div>

                    <div class="my-6 space-y-4">
                        <div>
                            <div class="flex justify-between font-mono-tech text-xs font-bold">
                                <span x-text="secretMode ? 'Taux de réponse' : 'Taux de réponse'"></span>
                                <span>96%</span>
                            </div>
                            <div class="mt-1.5 h-1 w-full bg-white/15">
                                <div :class="secretMode ? 'bg-[#C5A47E]' : 'bg-white'" class="h-full w-[96%]"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between font-mono-tech text-xs font-bold">
                                <span x-text="secretMode ? 'Dossiers retenus' : 'Ajouts en favoris'"></span>
                                <span>37</span>
                            </div>
                            <div class="mt-1.5 h-1 w-full bg-white/15">
                                <div class="h-full w-[80%] bg-[#C5A47E]"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between font-mono-tech text-xs font-bold">
                                <span>Délai moyen</span>
                                <span>~12 MIN</span>
                            </div>
                            <div class="mt-1.5 h-1 w-full bg-white/15">
                                <div :class="secretMode ? 'bg-[#C5A47E]' : 'bg-white'" class="h-full w-[88%]"></div>
                            </div>
                        </div>
                    </div>

                    <div class="border border-white/15 bg-white/5 p-3.5 text-xs">
                        <span x-text="secretMode
                            ? 'Protocole Vesper : Maintenez le sceau de bronze sur un portrait pour lever son anonymat.'
                            : 'Astuce : Répondre en moins de 15 minutes triple vos chances de conclure une vente.'"></span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================================= --}}
        {{-- SECTION 2 : MESSAGERIE VENDEUR <-> ACHETEUR (Façade ou Loge I)          --}}
        {{-- ======================================================================= --}}
        <section
            x-show="!secretMode || activeLogeTab === 'correspondance'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="mt-10"
            aria-labelledby="messagerie-title"
            x-data="{
                activeFacadeId: 1,
                activeSecretId: 101,
                newMessage: '',
                isTyping: false,

                facadeConversations: [
                    {
                        id: 1,
                        buyerName: 'Lucas Martin',
                        buyerAvatar: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=300&q=80',
                        buyerStatus: 'En ligne',
                        buyerCity: 'Toulouse (à 1,2 km)',
                        articleTitle: 'Chronographe Vintage 1968',
                        articlePrice: '180,00 €',
                        offerStatus: 'Offre à 165,00 €',
                        unread: 1,
                        messages: [
                            { id: 1, sender: 'buyer', text: 'Bonjour ! Votre chronographe est-il toujours disponible ?', time: 'Hier, 18:14' },
                            { id: 2, sender: 'seller', text: 'Bonjour Lucas, oui tout à fait ! Il est visible dans le quartier des Carmes.', time: 'Hier, 18:22' },
                            { id: 3, sender: 'buyer', text: 'Super ! Est-ce que vous accepteriez une offre à 165 € si je viens le chercher dès ce soir ?', time: 'Aujourd\'hui, 10:05' }
                        ],
                        autoReplies: [
                            'Parfait, ça me va très bien ! Vous êtes disponible vers 18h30 ?',
                            'Entendu, je vous règle sur place. À tout à l\'heure !'
                        ],
                        replyIndex: 0
                    },
                    {
                        id: 2,
                        buyerName: 'Camille Dubois',
                        buyerAvatar: 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=300&q=80',
                        buyerStatus: 'En ligne il y a 15 min',
                        buyerCity: 'Blagnac (à 4,5 km)',
                        articleTitle: 'Machine à expresso Delonghi',
                        articlePrice: '95,00 €',
                        offerStatus: 'Intéressée',
                        unread: 0,
                        messages: [
                            { id: 1, sender: 'buyer', text: 'Bonsoir, la buse vapeur fonctionne-t-elle toujours bien sur la machine ?', time: 'Hier, 20:40' },
                            { id: 2, sender: 'seller', text: 'Bonsoir Camille ! Oui, elle fonctionne parfaitement et la révision vient d\'être faite.', time: 'Hier, 20:55' },
                            { id: 3, sender: 'buyer', text: 'Génial, merci ! Je peux passer samedi matin pour la récupérer ?', time: 'Hier, 21:02' }
                        ],
                        autoReplies: [
                            'Samedi à 10h30 c\'est noté ! Pouvez-vous m\'envoyer l\'adresse exacte ?'
                        ],
                        replyIndex: 0
                    },
                    {
                        id: 3,
                        buyerName: 'Thomas Bernard',
                        buyerAvatar: 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&w=300&q=80',
                        buyerStatus: 'Hors ligne',
                        buyerCity: 'Toulouse Centre',
                        articleTitle: 'Lot de 4 chaises scandinaves',
                        articlePrice: '120,00 €',
                        offerStatus: 'Rendez-vous fixé',
                        unread: 0,
                        messages: [
                            { id: 1, sender: 'buyer', text: 'Bonjour, vendez-vous uniquement le lot de 4 ou est-il possible d\'en prendre 2 ?', time: 'Lun, 14:10' },
                            { id: 2, sender: 'seller', text: 'Bonjour Thomas, je préfère céder le lot complet de 4 chaises.', time: 'Lun, 14:25' },
                            { id: 3, sender: 'buyer', text: 'Je comprends, je prends les 4 alors ! On se retrouve demain à 17h ?', time: 'Lun, 15:00' }
                        ],
                        autoReplies: [
                            'Parfait, je suis en route, j\'arrive dans 10 minutes !'
                        ],
                        replyIndex: 0
                    }
                ],

                secretConversations: [
                    {
                        id: 101,
                        buyerName: 'Éléonore V., 28',
                        buyerAvatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                        buyerStatus: 'Portrait Descellé',
                        buyerCity: 'Saint-Étienne • 98% d\'affinité',
                        articleTitle: 'Code : « Chronographe 1968 »',
                        articlePrice: 'Souper Clandestin',
                        offerStatus: 'Table Réservée',
                        unread: 1,
                        messages: [
                            { id: 1, sender: 'buyer', text: 'Vous avez levé mon sceau... Votre annonce pour ce « Chronographe 1968 » trahit un goût certain pour les heures tardives.', time: 'Hier, 22:14' },
                            { id: 2, sender: 'seller', text: 'Bonsoir Éléonore. Votre portrait méritait que l’on s’y attarde.', time: 'Hier, 22:20' },
                            { id: 3, sender: 'buyer', text: 'J’ai retenu une table à l’écart rue des Filatiers ce soir à 21h30. Viendrez-vous me donner l’heure exacte ?', time: 'Aujourd\'hui, 19:45' }
                        ],
                        autoReplies: [
                            'Parfait. Mot de passe à l’entrée : Vesper. Je vous attends autour d’un verre.',
                            'Cette soirée restera entre nous. À tout de suite.'
                        ],
                        replyIndex: 0
                    },
                    {
                        id: 102,
                        buyerName: 'Gabriel M., 32',
                        buyerAvatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                        buyerStatus: 'Présent',
                        buyerCity: 'Les Carmes • 95% d\'affinité',
                        articleTitle: 'Code : « Vinyle Miles Davis »',
                        articlePrice: 'Heure Tardive',
                        offerStatus: 'Invitation Reçue',
                        unread: 1,
                        messages: [
                            { id: 1, sender: 'buyer', text: 'Ceux qui cherchent ce pressage de Miles Davis préfèrent généralement écouter la nuit tomber autour d’un whisky japonais...', time: 'Hier, 23:10' },
                            { id: 2, sender: 'seller', text: 'C’est exactement l’atmosphère que je recherchais ce soir.', time: 'Hier, 23:18' },
                            { id: 3, sender: 'buyer', text: 'Que diriez-vous d’une marche sur les quais à minuit suivie d’un dernier verre ?', time: 'Hier, 23:30' }
                        ],
                        autoReplies: [
                            'Minuit sur le pont Neuf. J’apporte le disque.'
                        ],
                        replyIndex: 0
                    },
                    {
                        id: 103,
                        buyerName: 'Soline D., 26',
                        buyerAvatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80',
                        buyerStatus: 'Il y a 5 min',
                        buyerCity: 'Capitole • 93% d\'affinité',
                        articleTitle: 'Code : « Miroir Vénitien »',
                        articlePrice: 'Complicité Suivie',
                        offerStatus: 'Affinité Rare',
                        unread: 0,
                        messages: [
                            { id: 1, sender: 'buyer', text: 'Votre dossier m’intrigue depuis trois soirs. Ce « Miroir Vénitien » cherche-t-il toujours son reflet ?', time: 'Mar, 21:15' },
                            { id: 2, sender: 'seller', text: 'Il n’attendait qu’un regard aussi averti que le vôtre, Soline.', time: 'Mar, 21:25' },
                            { id: 3, sender: 'buyer', text: 'Retrouvons-nous vendredi soir au salon feutré de l’Hôtel de la Couronne.', time: 'Mar, 21:40' }
                        ],
                        autoReplies: [
                            'Vendredi 21h, c’est entendu.'
                        ],
                        replyIndex: 0
                    }
                ],

                get currentList() {
                    return this.secretMode ? this.secretConversations : this.facadeConversations;
                },
                get activeConv() {
                    const id = this.secretMode ? this.activeSecretId : this.activeFacadeId;
                    return this.currentList.find(c => c.id === id) || this.currentList[0];
                },
                selectConv(id) {
                    if (this.secretMode) {
                        this.activeSecretId = id;
                    } else {
                        this.activeFacadeId = id;
                    }
                    const conv = this.currentList.find(c => c.id === id);
                    if (conv) conv.unread = 0;
                    this.$nextTick(() => this.scrollToBottom());
                },
                sendQuickReply(text) {
                    this.newMessage = text;
                    this.sendMessage();
                },
                sendMessage() {
                    const trimmed = this.newMessage.trim();
                    if (!trimmed) return;
                    const conv = this.activeConv;
                    const now = new Date();
                    const timeStr = 'À l\'instant, ' + String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

                    conv.messages.push({
                        id: Date.now(),
                        sender: 'seller',
                        text: trimmed,
                        time: timeStr
                    });
                    this.newMessage = '';
                    this.$nextTick(() => this.scrollToBottom());

                    if (conv.replyIndex < conv.autoReplies.length) {
                        this.isTyping = true;
                        const replyText = conv.autoReplies[conv.replyIndex];
                        conv.replyIndex++;
                        setTimeout(() => {
                            this.isTyping = false;
                            conv.messages.push({
                                id: Date.now() + 1,
                                sender: 'buyer',
                                text: replyText,
                                time: timeStr
                            });
                            this.$nextTick(() => this.scrollToBottom());
                        }, 1250);
                    }
                },
                scrollToBottom() {
                    const container = this.$refs.messagesContainer;
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }
            }"
        >
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                        class="font-mono-tech text-xs font-bold uppercase tracking-[0.25em]"
                        x-text="secretMode ? 'LOGE I / CORRESPONDANCES CONFIDENTIELLES' : '02 / ÉCHANGES & NÉGOCIATIONS'"
                    >02 / ÉCHANGES & NÉGOCIATIONS</p>
                    <h2
                        id="messagerie-title"
                        :class="secretMode ? 'text-[#EAE6DF] font-normal italic' : 'text-[#111111]'"
                        class="font-serif-luxury mt-1 text-3xl font-bold sm:text-4xl"
                        x-text="secretMode ? 'Correspondances & Rendez-vous' : 'Messagerie Vendeur & Acheteurs'"
                    >
                        Messagerie Vendeur & Acheteurs
                    </h2>
                </div>
            </div>

            <div
                :class="secretMode
                    ? 'border-[#C5A47E]/30 bg-[#0B0B0E]'
                    : 'border-[#DFDDD4] bg-white'"
                class="grid overflow-hidden border lg:grid-cols-[350px_1fr]"
            >
                {{-- Liste des conversations (gauche) --}}
                <div
                    :class="secretMode ? 'border-[#C5A47E]/20 bg-[#08080A]' : 'border-[#DFDDD4] bg-[#F6F5F0]'"
                    class="border-b lg:border-b-0 lg:border-r"
                >
                    <div
                        :class="secretMode ? 'border-[#C5A47E]/20' : 'border-[#DFDDD4] bg-white'"
                        class="border-b px-5 py-4"
                    >
                        <p
                            :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                            class="font-mono-tech text-[10px] font-bold uppercase tracking-[0.25em]"
                            x-text="secretMode ? 'MEMBRES DU CERCLE (03)' : 'BOÎTE DE RÉCEPTION ACHETEURS'"
                        ></p>
                    </div>

                    <div :class="secretMode ? 'divide-[#C5A47E]/15' : 'divide-[#DFDDD4]'" class="divide-y">
                        <template x-for="conv in currentList" :key="conv.id">
                            <button
                                type="button"
                                @click="selectConv(conv.id)"
                                class="flex w-full items-start gap-3.5 p-4 text-left transition"
                                :class="activeConv.id === conv.id
                                    ? (secretMode ? 'bg-[#16151B] text-[#EAE6DF]' : 'bg-[#111111] text-[#F6F5F0]')
                                    : (secretMode ? 'hover:bg-white/5 text-neutral-400' : 'bg-white hover:bg-[#F6F5F0] text-[#111111]')"
                            >
                                <img
                                    :src="conv.buyerAvatar"
                                    :alt="conv.buyerName"
                                    :class="secretMode ? 'grayscale contrast-125' : ''"
                                    class="h-12 w-12 shrink-0 object-cover border border-[#C5A47E]/30"
                                >

                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-serif-luxury truncate text-lg font-bold" x-text="conv.buyerName"></p>
                                        <template x-if="conv.unread > 0">
                                            <span
                                                :class="secretMode ? 'bg-[#C5A47E] text-[#08080A]' : 'bg-emerald-600 text-white'"
                                                class="inline-flex h-5 min-w-[1.25rem] items-center justify-center px-1.5 font-mono-tech text-[10px] font-bold"
                                                x-text="conv.unread"
                                            ></span>
                                        </template>
                                    </div>

                                    <p
                                        class="font-mono-tech mt-0.5 truncate text-[10px] uppercase tracking-wider"
                                        :class="secretMode ? 'text-[#C5A47E]' : 'opacity-80'"
                                        x-text="conv.articleTitle"
                                    ></p>

                                    <p
                                        class="mt-1.5 line-clamp-1 text-xs opacity-60"
                                        x-text="conv.messages[conv.messages.length - 1].text"
                                    ></p>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Fenêtre de discussion active (droite) --}}
                <div class="flex flex-col justify-between">
                    <div
                        :class="secretMode ? 'border-[#C5A47E]/20 bg-[#0E0E12]' : 'border-[#DFDDD4] bg-white'"
                        class="flex flex-wrap items-center justify-between gap-4 border-b px-6 py-4"
                    >
                        <div class="flex items-center gap-3.5">
                            <img
                                :src="activeConv.buyerAvatar"
                                :alt="activeConv.buyerName"
                                class="h-12 w-12 object-cover border border-[#C5A47E]/40"
                            >
                            <div>
                                <div class="flex items-center gap-2.5">
                                    <h3 class="font-serif-luxury text-2xl font-bold" x-text="activeConv.buyerName"></h3>
                                    <span
                                        :class="secretMode ? 'border border-[#C5A47E]/40 text-[#C5A47E]' : 'bg-emerald-100 text-emerald-800'"
                                        class="px-2.5 py-0.5 font-mono-tech text-[10px] font-bold uppercase"
                                        x-text="activeConv.buyerStatus"
                                    ></span>
                                </div>
                                <p class="font-mono-tech text-[10px] uppercase tracking-widest opacity-60" x-text="activeConv.buyerCity"></p>
                            </div>
                        </div>

                        <div
                            :class="secretMode ? 'border-[#C5A47E]/25 bg-[#08080A]' : 'border-[#DFDDD4] bg-[#F6F5F0]'"
                            class="flex flex-wrap items-center gap-3 border px-4 py-2"
                        >
                            <div>
                                <p class="font-mono-tech text-[9px] font-bold uppercase tracking-widest opacity-60" x-text="secretMode ? 'CODE DE COUVERTURE' : 'ANNONCE CONCERNÉE'"></p>
                                <p class="text-xs font-bold">
                                    <span x-text="activeConv.articleTitle"></span> — <span class="text-[#C5A47E]" x-text="activeConv.articlePrice"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Fil des messages --}}
                    <div
                        x-ref="messagesContainer"
                        :class="secretMode ? 'bg-[#070709]' : 'bg-[#F6F5F0]'"
                        class="h-80 space-y-4 overflow-y-auto p-6"
                    >
                        <template x-for="msg in activeConv.messages" :key="msg.id">
                            <div
                                class="flex flex-col"
                                :class="msg.sender === 'seller' ? 'items-end' : 'items-start'"
                            >
                                <div class="mb-1 flex items-center gap-2 px-1">
                                    <span
                                        class="font-mono-tech text-[10px] font-bold uppercase"
                                        :class="secretMode ? 'text-[#C5A47E]' : ''"
                                        x-text="msg.sender === 'seller' ? 'Vous' : activeConv.buyerName"
                                    ></span>
                                    <span class="text-[11px] opacity-50" x-text="msg.time"></span>
                                </div>

                                <div
                                    class="max-w-md px-4 py-3 text-sm leading-relaxed"
                                    :class="msg.sender === 'seller'
                                        ? (secretMode
                                            ? 'bg-[#C5A47E] text-[#08080A] font-medium'
                                            : 'bg-[#111111] text-[#F6F5F0]')
                                        : (secretMode
                                            ? 'border border-[#C5A47E]/25 bg-[#121217] text-[#EAE6DF]'
                                            : 'border border-[#DFDDD4] bg-white text-[#111111]')"
                                    x-text="msg.text"
                                ></div>
                            </div>
                        </template>

                        <div x-show="isTyping" x-transition class="flex items-center gap-2 text-xs font-semibold opacity-75">
                            <span class="inline-flex h-2 w-2 animate-ping rounded-full" :class="secretMode ? 'bg-[#C5A47E]' : 'bg-[#111111]'"></span>
                            <span x-text="activeConv.buyerName + ' rédige une réponse...'"></span>
                        </div>
                    </div>

                    {{-- Réponses rapides + Zone de saisie --}}
                    <div
                        :class="secretMode ? 'border-[#C5A47E]/20 bg-[#0B0B0E]' : 'border-[#DFDDD4] bg-white'"
                        class="border-t p-4 sm:px-6"
                    >
                        <div x-show="!secretMode" class="mb-3 flex flex-wrap items-center gap-2">
                            <span class="font-mono-tech text-[10px] font-bold uppercase opacity-60">RÉPONSES RAPIDES :</span>
                            <button
                                type="button"
                                @click="sendQuickReply('Oui, l\'article est toujours disponible !')"
                                class="border border-[#DFDDD4] bg-[#F6F5F0] px-3 py-1 text-xs font-semibold text-[#111111] transition hover:border-[#111111]"
                            >Toujours disponible</button>
                            <button
                                type="button"
                                @click="sendQuickReply('D\'accord pour votre offre, quand souhaitez-vous passer ?')"
                                class="border border-[#DFDDD4] bg-[#F6F5F0] px-3 py-1 text-xs font-semibold text-[#111111] transition hover:border-[#111111]"
                            >Accepter l'offre</button>
                            <button
                                type="button"
                                @click="sendQuickReply('Je suis disponible ce soir à partir de 18h.')"
                                class="border border-[#DFDDD4] bg-[#F6F5F0] px-3 py-1 text-xs font-semibold text-[#111111] transition hover:border-[#111111]"
                            >Dispo ce soir 18h</button>
                        </div>

                        <div x-cloak x-show="secretMode" class="mb-3 flex flex-wrap items-center gap-2">
                            <span class="font-mono-tech text-[10px] font-bold uppercase text-[#C5A47E]">BILLETS RAPIDES :</span>
                            <button
                                type="button"
                                @click="sendQuickReply('Votre invitation est acceptée. Je vous rejoins à 21h30.')"
                                class="border border-[#C5A47E]/30 bg-[#08080A] px-3 py-1 font-mono-tech text-[10px] uppercase tracking-wider text-[#EAE6DF] transition hover:border-[#C5A47E] hover:text-[#C5A47E]"
                            >I. Accepter 21h30</button>
                            <button
                                type="button"
                                @click="sendQuickReply('Votre mot-code m\'a intrigué. Gardez-moi votre soirée.')"
                                class="border border-[#C5A47E]/30 bg-[#08080A] px-3 py-1 font-mono-tech text-[10px] uppercase tracking-wider text-[#EAE6DF] transition hover:border-[#C5A47E] hover:text-[#C5A47E]"
                            >II. Réserver la soirée</button>
                            <button
                                type="button"
                                @click="sendQuickReply('Retrouvons-nous au salon privé, table du fond.')"
                                class="border border-[#C5A47E]/30 bg-[#08080A] px-3 py-1 font-mono-tech text-[10px] uppercase tracking-wider text-[#EAE6DF] transition hover:border-[#C5A47E] hover:text-[#C5A47E]"
                            >III. Table du fond</button>
                        </div>

                        <form @submit.prevent="sendMessage()" class="flex items-center gap-3">
                            <input
                                type="text"
                                x-model="newMessage"
                                :placeholder="secretMode ? 'Écrire à ' + activeConv.buyerName + '...' : 'Écrivez votre message à l\'acheteur...'"
                                :class="secretMode
                                    ? 'border-[#C5A47E]/30 bg-[#070709] text-[#EAE6DF] placeholder:text-neutral-600 focus:border-[#C5A47E]'
                                    : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] placeholder:text-neutral-400 focus:border-[#111111]'"
                                class="block w-full border px-4 py-3 text-sm focus:outline-none"
                            >
                            <button
                                type="submit"
                                :class="secretMode
                                    ? 'bg-[#C5A47E] text-[#08080A] hover:bg-[#D8BC98]'
                                    : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                                class="inline-flex shrink-0 items-center justify-center px-6 py-3 font-mono-tech text-xs font-bold uppercase tracking-[0.2em] transition"
                            >
                                Envoyer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================================================================= --}}
        {{-- SECTION 3 : MES INFORMATIONS & SÉCURITÉ (Façade ou Loge III)            --}}
        {{-- ======================================================================= --}}
        <section
            x-show="!secretMode || activeLogeTab === 'passeport'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="mt-10"
            aria-labelledby="compte-infos-title"
        >
            <div class="mb-6">
                <p
                    :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                    class="font-mono-tech text-xs font-bold uppercase tracking-[0.25em]"
                    x-text="secretMode ? 'LOGE III / SCEAU & IDENTITÉ' : '03 / PARAMÈTRES PERSONNELS'"
                >03 / PARAMÈTRES PERSONNELS</p>
                <h2
                    id="compte-infos-title"
                    :class="secretMode ? 'text-[#EAE6DF] font-normal italic' : 'text-[#111111]'"
                    class="font-serif-luxury mt-1 text-3xl font-bold sm:text-4xl"
                    x-text="secretMode ? 'Passeport Vesper & Confidentialité' : 'Mes Informations & Sécurité'"
                >
                    Mes Informations & Sécurité
                </h2>
            </div>

            <div
                :class="secretMode ? 'border-[#C5A47E]/25 bg-[#0C0C0F] text-[#EAE6DF]' : 'border-[#DFDDD4] bg-white text-[#111111]'"
                class="mb-6 border p-6 sm:p-8"
            >
                <dl class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div :class="secretMode ? 'border-[#C5A47E]/20 bg-[#08080A]' : 'border-[#DFDDD4] bg-[#F6F5F0]'" class="border p-4">
                        <dt class="font-mono-tech text-[10px] font-bold uppercase tracking-widest opacity-60">Nom / Pseudonyme</dt>
                        <dd class="mt-1 text-base font-extrabold">{{ $user->name }}</dd>
                    </div>

                    <div :class="secretMode ? 'border-[#C5A47E]/20 bg-[#08080A]' : 'border-[#DFDDD4] bg-[#F6F5F0]'" class="border p-4">
                        <dt class="font-mono-tech text-[10px] font-bold uppercase tracking-widest opacity-60">Adresse e-mail</dt>
                        <dd class="mt-1 truncate text-base font-extrabold" title="{{ $user->email }}">{{ $user->email }}</dd>
                    </div>

                    <div :class="secretMode ? 'border-[#C5A47E]/20 bg-[#08080A]' : 'border-[#DFDDD4] bg-[#F6F5F0]'" class="border p-4">
                        <dt class="font-mono-tech text-[10px] font-bold uppercase tracking-widest opacity-60">Membre depuis</dt>
                        <dd class="mt-1 text-base font-extrabold">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Récemment' }}
                        </dd>
                    </div>

                    <div :class="secretMode ? 'border-[#C5A47E]/20 bg-[#08080A]' : 'border-[#DFDDD4] bg-[#F6F5F0]'" class="border p-4">
                        <dt class="font-mono-tech text-[10px] font-bold uppercase tracking-widest opacity-60" x-text="secretMode ? 'Portraits Descellés' : 'Annonces Publiées'"></dt>
                        <dd class="mt-1 text-base font-extrabold">
                            <span x-show="!secretMode">{{ $listingsCount }} annonce{{ $listingsCount > 1 ? 's' : '' }}</span>
                            <span x-cloak x-show="secretMode" x-text="unsealedIds.length + ' dossier(s)'"></span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div :class="secretMode ? 'border-[#C5A47E]/25 bg-[#0C0C0F]' : 'border-[#DFDDD4] bg-white'" class="border p-6 sm:p-8">
                    @include('profile.partials.update-profile-information-form', ['user' => $user])
                </div>

                <div :class="secretMode ? 'border-[#C5A47E]/25 bg-[#0C0C0F]' : 'border-[#DFDDD4] bg-white'" class="border p-6 sm:p-8">
                    @include('profile.partials.update-password-form')
                </div>

                <div :class="secretMode ? 'border-red-500/30 bg-[#0C0A0C]' : 'border-red-300 bg-white'" class="border p-6 sm:p-8 lg:col-span-2">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </section>

    </div>
</x-layouts.public>
