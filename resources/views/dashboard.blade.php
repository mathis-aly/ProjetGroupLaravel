@php
    $user = $user ?? auth()->user();
    $listingsCount = $user?->listings()->count() ?? 0;
@endphp

<x-layouts.public title="Mon compte | UberBite(Coin)">
    <div class="bg-amber-100 text-teal-900">
        {{-- En-tête Hero style du site --}}
        <div class="relative mx-auto mt-8 w-[calc(100%-2rem)] max-w-7xl overflow-hidden rounded-3xl bg-teal-900 px-6 py-10 text-white shadow-xl shadow-teal-900/10 sm:mt-12 sm:px-10 sm:py-14">
            <div class="relative z-10 flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-center">
                <div class="flex flex-col sm:flex-row sm:items-center gap-5">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl border-2 border-amber-400/40 bg-amber-400 text-3xl font-extrabold text-teal-950 shadow-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <span class="mb-3 inline-flex items-center gap-2 rounded-full border border-amber-100/20 bg-white/5 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-amber-100">
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                            Espace Mon Compte
                        </span>
                        <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-5xl">
                            Bonjour, <span class="text-amber-400">{{ $user->name }}</span>
                        </h1>
                        <p class="mt-2 max-w-xl text-sm leading-6 text-amber-100/80 sm:text-base">
                            Consultez vos statistiques de vente, échangez avec vos acheteurs et gérez vos informations personnelles et votre sécurité.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('mesAnnonces', ['user_name' => $user->name]) }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-4 py-2.5 text-sm font-bold text-white transition hover:border-amber-400 hover:text-amber-400">
                        Mes annonces ({{ $listingsCount }})
                    </a>
                    <a href="{{ route('listings.create') }}" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-4 py-2.5 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300">
                        + Déposer une annonce
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-red-300/30 bg-red-500/10 px-4 py-2.5 text-sm font-bold text-red-200 transition hover:bg-red-500/20 hover:text-white">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>

            <span class="pointer-events-none absolute -right-10 -top-14 h-40 w-40 rounded-full border border-white/10" aria-hidden="true"></span>
            <span class="pointer-events-none absolute -bottom-24 -left-8 h-48 w-48 rounded-full border border-amber-400/20" aria-hidden="true"></span>
        </div>

        <div class="mx-auto max-w-7xl space-y-12 px-6 py-10">

            {{-- SECTION 1 : STATISTIQUES FICTIVES --}}
            <section aria-labelledby="stats-title">
                <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Performances vendeur</p>
                        <h2 id="stats-title" class="mt-1 text-2xl font-extrabold tracking-tight text-teal-950 sm:text-3xl">
                            Vos statistiques du mois
                        </h2>
                    </div>
                    <span class="inline-flex w-fit items-center gap-2 rounded-full border border-teal-900/15 bg-white px-3.5 py-1.5 text-xs font-bold text-teal-900 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Activité en hausse de +24% sur 30 jours
                    </span>
                </div>

                {{-- Cartes KPI --}}
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Vues cumulées</span>
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-100 text-teal-900 font-bold">👁️</span>
                        </div>
                        <p class="mt-4 text-3xl font-extrabold text-teal-950">1 284</p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-emerald-700">
                            <span class="rounded-md bg-emerald-100 px-1.5 py-0.5 font-bold">+18%</span>
                            <span>vs le mois dernier (1 088)</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Ventes conclues</span>
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-100 text-teal-900 font-bold">🤝</span>
                        </div>
                        <p class="mt-4 text-3xl font-extrabold text-teal-950">14</p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-teal-800/80">
                            <span class="rounded-md bg-amber-100 px-1.5 py-0.5 font-bold text-teal-950">3 en cours</span>
                            <span>de négociation</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Gains générés</span>
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-100 text-teal-900 font-bold">💶</span>
                        </div>
                        <p class="mt-4 text-3xl font-extrabold text-teal-950">485,00 €</p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-emerald-700">
                            <span class="rounded-md bg-emerald-100 px-1.5 py-0.5 font-bold">+120,00 €</span>
                            <span>sur les 7 derniers jours</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Note vendeur</span>
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-100 text-teal-900 font-bold">⭐</span>
                        </div>
                        <p class="mt-4 text-3xl font-extrabold text-teal-950">4,9 <span class="text-lg font-bold text-teal-900/50">/ 5</span></p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-teal-800/80">
                            <span class="rounded-md bg-amber-400/30 px-1.5 py-0.5 font-bold text-teal-950">12 avis</span>
                            <span>• 98% de satisfaction</span>
                        </p>
                    </div>
                </div>

                {{-- Graphique d'activité fictif & indicateurs secondaires --}}
                <div class="mt-5 grid gap-5 lg:grid-cols-3">
                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 lg:col-span-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <h3 class="text-base font-extrabold text-teal-950">Fréquentation de vos annonces (7 derniers jours)</h3>
                                <p class="text-xs text-teal-900/65">Nombre de visites quotidiennes sur vos articles publiés</p>
                            </div>
                            <span class="rounded-lg bg-teal-900 px-3 py-1 text-xs font-bold text-amber-400">Moyenne : 42 vues / jour</span>
                        </div>

                        <div class="mt-6 grid grid-cols-7 items-end gap-3 pt-4 h-44 border-b border-teal-900/10">
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
                                    <span class="text-[11px] font-bold text-teal-900/70">{{ $day['views'] }}</span>
                                    <div class="w-full max-w-[2.5rem] rounded-t-xl {{ $day['label'] === 'Sam' ? 'bg-amber-400' : 'bg-teal-900 hover:bg-teal-800' }} {{ $day['height'] }} transition"></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-2 grid grid-cols-7 text-center">
                            @foreach ($days as $day)
                                <span class="text-xs font-bold text-teal-900/70">{{ $day['label'] }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col justify-between rounded-2xl border border-teal-900/10 bg-teal-900 p-6 text-white shadow-lg shadow-teal-900/5">
                        <div>
                            <span class="inline-block rounded-full bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-400">
                                Bilan d'engagement
                            </span>
                            <h3 class="mt-3 text-xl font-extrabold">Réactivité exemplaire</h3>
                            <p class="mt-1 text-sm text-amber-100/75">
                                Les acheteurs du quartier apprécient votre rapidité de réponse.
                            </p>
                        </div>

                        <div class="my-6 space-y-4">
                            <div>
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-amber-100">Taux de réponse messagerie</span>
                                    <span class="text-amber-400">96%</span>
                                </div>
                                <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full w-[96%] rounded-full bg-amber-400"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-amber-100">Annonces ajoutées en favoris</span>
                                    <span class="text-amber-400">37 ❤️</span>
                                </div>
                                <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full w-[78%] rounded-full bg-emerald-400"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-amber-100">Temps de réponse moyen</span>
                                    <span class="text-amber-400">~12 min</span>
                                </div>
                                <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full w-[88%] rounded-full bg-amber-400"></div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-3.5 text-xs text-amber-100/90">
                            💡 <strong class="text-white">Astuce :</strong> Répondre en moins de 15 minutes multiplie par 3 vos chances de conclure une vente.
                        </div>
                    </div>
                </div>
            </section>

            {{-- SECTION 2 : FAUSSE MESSAGERIE VENDEUR <-> ACHETEUR --}}
            <section
                aria-labelledby="messagerie-title"
                x-data="{
                    activeConvId: 1,
                    newMessage: '',
                    isTyping: false,
                    conversations: [
                        {
                            id: 1,
                            buyerName: 'Lucas Martin',
                            buyerInitials: 'LM',
                            buyerStatus: 'En ligne',
                            buyerCity: 'Toulouse (à 1,2 km)',
                            articleTitle: 'Vélo de course 54 cm',
                            articlePrice: '180,00 €',
                            offerStatus: 'Offre à 165,00 €',
                            unread: 1,
                            messages: [
                                { id: 1, sender: 'buyer', text: 'Bonjour ! Votre vélo de course est-il toujours disponible ?', time: 'Hier, 18:14' },
                                { id: 2, sender: 'seller', text: 'Bonjour Lucas, oui tout à fait ! Il est visible dans le quartier des Carmes.', time: 'Hier, 18:22' },
                                { id: 3, sender: 'buyer', text: 'Super ! Est-ce que vous accepteriez une offre à 165 € si je viens le chercher dès ce soir ?', time: 'Aujourd\'hui, 10:05' }
                            ],
                            autoReplies: [
                                'Parfait, ça me va très bien ! Vous êtes disponible vers 18h30 ?',
                                'Entendu, je vous règle en espèces sur place. À tout à l\'heure !',
                                'Merci beaucoup pour votre réactivité !'
                            ],
                            replyIndex: 0
                        },
                        {
                            id: 2,
                            buyerName: 'Camille Dubois',
                            buyerInitials: 'CD',
                            buyerStatus: 'En ligne il y a 15 min',
                            buyerCity: 'Blagnac (à 4,5 km)',
                            articleTitle: 'Machine à expresso Delonghi',
                            articlePrice: '95,00 €',
                            offerStatus: 'Intéressée',
                            unread: 0,
                            messages: [
                                { id: 1, sender: 'buyer', text: 'Bonsoir, la buse vapeur fonctionne-t-elle toujours bien sur la machine ?', time: 'Hier, 20:40' },
                                { id: 2, sender: 'seller', text: 'Bonsoir Camille ! Oui, elle fonctionne parfaitement et le détartrage vient d\'être fait.', time: 'Hier, 20:55' },
                                { id: 3, sender: 'buyer', text: 'Génial, merci ! Je peux passer samedi matin pour la récupérer ?', time: 'Hier, 21:02' }
                            ],
                            autoReplies: [
                                'Samedi à 10h30 c\'est noté ! Pouvez-vous m\'envoyer l\'adresse exacte ?',
                                'Super, merci beaucoup et à samedi !'
                            ],
                            replyIndex: 0
                        },
                        {
                            id: 3,
                            buyerName: 'Thomas Bernard',
                            buyerInitials: 'TB',
                            buyerStatus: 'Hors ligne',
                            buyerCity: 'Toulouse Centre',
                            articleTitle: 'Lot de 4 chaises scandinaves',
                            articlePrice: '120,00 €',
                            offerStatus: 'Rendez-vous fixé',
                            unread: 0,
                            messages: [
                                { id: 1, sender: 'buyer', text: 'Bonjour, vendez-vous uniquement le lot de 4 ou est-il possible d\'en prendre 2 ?', time: 'Lun, 14:10' },
                                { id: 2, sender: 'seller', text: 'Bonjour Thomas, je préfère vendre le lot complet de 4 chaises.', time: 'Lun, 14:25' },
                                { id: 3, sender: 'buyer', text: 'Je comprends, je prends les 4 alors ! On se retrouve demain à 17h ?', time: 'Lun, 15:00' }
                            ],
                            autoReplies: [
                                'Parfait, je suis en route, j\'arrive dans 10 minutes !',
                                'Merci encore pour les chaises, elles sont impeccables !'
                            ],
                            replyIndex: 0
                        }
                    ],
                    get activeConv() {
                        return this.conversations.find(c => c.id === this.activeConvId);
                    },
                    selectConv(id) {
                        this.activeConvId = id;
                        const conv = this.conversations.find(c => c.id === id);
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
                        const timeStr = 'Aujourd\'hui, ' + String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

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
                            }, 1200);
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
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Discussions en direct</p>
                        <h2 id="messagerie-title" class="mt-1 text-2xl font-extrabold tracking-tight text-teal-950 sm:text-3xl">
                            Messagerie Vendeur & Acheteurs
                        </h2>
                    </div>
                    <span class="inline-flex w-fit items-center gap-2 rounded-full bg-teal-900 px-3.5 py-1.5 text-xs font-bold text-amber-400">
                        💬 3 conversations actives
                    </span>
                </div>

                <div class="grid overflow-hidden rounded-3xl border border-teal-900/10 bg-white shadow-xl shadow-teal-900/5 lg:grid-cols-[340px_1fr]">
                    {{-- Liste des conversations (gauche) --}}
                    <div class="border-b border-teal-900/10 bg-amber-50/40 lg:border-b-0 lg:border-r">
                        <div class="border-b border-teal-900/10 bg-white px-5 py-4">
                            <p class="text-xs font-extrabold uppercase tracking-wider text-teal-900">Boîte de réception acheteurs</p>
                        </div>

                        <div class="divide-y divide-teal-900/10">
                            <template x-for="conv in conversations" :key="conv.id">
                                <button
                                    type="button"
                                    @click="selectConv(conv.id)"
                                    class="flex w-full items-start gap-3.5 p-4 text-left transition"
                                    :class="activeConvId === conv.id ? 'bg-teal-900 text-white' : 'bg-white/70 hover:bg-amber-100/50 text-teal-950'"
                                >
                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl font-extrabold text-sm"
                                        :class="activeConvId === conv.id ? 'bg-amber-400 text-teal-950' : 'bg-teal-900 text-amber-400'"
                                        x-text="conv.buyerInitials"
                                    ></div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="truncate text-sm font-extrabold" x-text="conv.buyerName"></p>
                                            <template x-if="conv.unread > 0">
                                                <span class="inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-amber-400 px-1.5 text-[11px] font-extrabold text-teal-950" x-text="conv.unread"></span>
                                            </template>
                                        </div>

                                        <p
                                            class="mt-0.5 truncate text-xs font-bold"
                                            :class="activeConvId === conv.id ? 'text-amber-300' : 'text-teal-700'"
                                            x-text="conv.articleTitle + ' • ' + conv.articlePrice"
                                        ></p>

                                        <p
                                            class="mt-1.5 line-clamp-1 text-xs"
                                            :class="activeConvId === conv.id ? 'text-amber-100/80' : 'text-teal-900/65'"
                                            x-text="conv.messages[conv.messages.length - 1].text"
                                        ></p>
                                    </div>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Fenêtre de discussion active (droite) --}}
                    <div class="flex flex-col justify-between bg-white">
                        {{-- En-tête de la conversation --}}
                        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-teal-900/10 bg-white px-6 py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-900 text-sm font-extrabold text-amber-400" x-text="activeConv.buyerInitials"></div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-base font-extrabold text-teal-950" x-text="activeConv.buyerName"></h3>
                                        <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-bold text-emerald-800" x-text="activeConv.buyerStatus"></span>
                                    </div>
                                    <p class="text-xs font-medium text-teal-900/65">
                                        Acheteur • <span x-text="activeConv.buyerCity"></span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 rounded-2xl border border-teal-900/10 bg-amber-100/60 px-4 py-2">
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-teal-700">Annonce concernée</p>
                                    <p class="text-xs font-extrabold text-teal-950">
                                        <span x-text="activeConv.articleTitle"></span> — <span class="text-teal-800" x-text="activeConv.articlePrice"></span>
                                    </p>
                                </div>
                                <span class="ml-2 rounded-lg bg-amber-400 px-2.5 py-1 text-xs font-extrabold text-teal-950" x-text="activeConv.offerStatus"></span>
                            </div>
                        </div>

                        {{-- Fil des messages --}}
                        <div
                            x-ref="messagesContainer"
                            class="h-80 space-y-4 overflow-y-auto bg-amber-50/30 p-6"
                        >
                            <template x-for="msg in activeConv.messages" :key="msg.id">
                                <div
                                    class="flex flex-col"
                                    :class="msg.sender === 'seller' ? 'items-end' : 'items-start'"
                                >
                                    <div class="flex items-center gap-2 mb-1 px-1">
                                        <span
                                            class="text-[11px] font-bold"
                                            :class="msg.sender === 'seller' ? 'text-teal-800' : 'text-teal-950'"
                                            x-text="msg.sender === 'seller' ? 'Vous (Vendeur)' : activeConv.buyerName + ' (Acheteur)'"
                                        ></span>
                                        <span class="text-[11px] text-teal-900/50" x-text="msg.time"></span>
                                    </div>

                                    <div
                                        class="max-w-md rounded-2xl px-4 py-3 text-sm leading-relaxed shadow-sm"
                                        :class="msg.sender === 'seller'
                                            ? 'rounded-br-none bg-teal-900 text-white'
                                            : 'rounded-bl-none border border-teal-900/10 bg-white text-teal-950'"
                                        x-text="msg.text"
                                    ></div>
                                </div>
                            </template>

                            {{-- Indicateur de frappe de l'acheteur --}}
                            <div x-show="isTyping" x-transition class="flex items-center gap-2 text-xs font-semibold text-teal-800">
                                <span class="inline-flex h-2 w-2 animate-ping rounded-full bg-teal-700"></span>
                                <span x-text="activeConv.buyerName + ' est en train d\'écrire...'"></span>
                            </div>
                        </div>

                        {{-- Réponses rapides + Zone de saisie --}}
                        <div class="border-t border-teal-900/10 bg-white p-4 sm:px-6">
                            <div class="mb-3 flex flex-wrap items-center gap-2">
                                <span class="text-xs font-bold text-teal-900/60">Réponses rapides :</span>
                                <button
                                    type="button"
                                    @click="sendQuickReply('Oui, l\'article est toujours disponible !')"
                                    class="rounded-full border border-teal-900/15 bg-amber-50 px-3 py-1 text-xs font-bold text-teal-900 transition hover:bg-amber-400 hover:text-teal-950"
                                >
                                    Toujours disponible 👍
                                </button>
                                <button
                                    type="button"
                                    @click="sendQuickReply('D\'accord pour votre offre, quand souhaitez-vous passer ?')"
                                    class="rounded-full border border-teal-900/15 bg-amber-50 px-3 py-1 text-xs font-bold text-teal-900 transition hover:bg-amber-400 hover:text-teal-950"
                                >
                                    Accepter l'offre 🤝
                                </button>
                                <button
                                    type="button"
                                    @click="sendQuickReply('Je suis disponible ce soir à partir de 18h.')"
                                    class="rounded-full border border-teal-900/15 bg-amber-50 px-3 py-1 text-xs font-bold text-teal-900 transition hover:bg-amber-400 hover:text-teal-950"
                                >
                                    Dispo ce soir 18h 🕕
                                </button>
                            </div>

                            <form @submit.prevent="sendMessage()" class="flex items-center gap-3">
                                <input
                                    type="text"
                                    x-model="newMessage"
                                    placeholder="Écrivez votre message à l'acheteur..."
                                    class="block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 placeholder-teal-900/40 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
                                >
                                <button
                                    type="submit"
                                    class="inline-flex shrink-0 items-center justify-center rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300"
                                >
                                    Envoyer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            {{-- SECTION 3 : MES INFORMATIONS & SÉCURITÉ DU COMPTE --}}
            <section aria-labelledby="compte-infos-title">
                <div class="mb-6">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Paramètres personnels</p>
                    <h2 id="compte-infos-title" class="mt-1 text-2xl font-extrabold tracking-tight text-teal-950 sm:text-3xl">
                        Mes informations & Sécurité
                    </h2>
                </div>

                {{-- Récapitulatif visuel des informations de l'utilisateur --}}
                <div class="mb-6 rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 sm:p-8">
                    <div class="flex flex-col justify-between gap-4 border-b border-teal-900/10 pb-5 sm:flex-row sm:items-center">
                        <div>
                            <h3 class="text-lg font-extrabold text-teal-950">Aperçu de votre profil</h3>
                            <p class="text-sm text-teal-900/65">Informations publiques et état actuel de votre compte UberBite(Coin).</p>
                        </div>
                        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-100 px-3.5 py-1 text-xs font-bold text-emerald-800">
                            ✓ Compte membre actif
                        </span>
                    </div>

                    <dl class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-xl bg-amber-50/70 p-4 border border-teal-900/5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-700">Nom d'utilisateur</dt>
                            <dd class="mt-1 text-base font-extrabold text-teal-950">{{ $user->name }}</dd>
                        </div>

                        <div class="rounded-xl bg-amber-50/70 p-4 border border-teal-900/5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-700">Adresse e-mail</dt>
                            <dd class="mt-1 truncate text-base font-extrabold text-teal-950" title="{{ $user->email }}">{{ $user->email }}</dd>
                        </div>

                        <div class="rounded-xl bg-amber-50/70 p-4 border border-teal-900/5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-700">Membre depuis</dt>
                            <dd class="mt-1 text-base font-extrabold text-teal-950">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Récemment' }}
                            </dd>
                        </div>

                        <div class="rounded-xl bg-amber-50/70 p-4 border border-teal-900/5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-700">Annonces publiées</dt>
                            <dd class="mt-1 text-base font-extrabold text-teal-950">
                                {{ $listingsCount }} annonce{{ $listingsCount > 1 ? 's' : '' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Formulaires : Informations du profil + Mot de passe + Suppression --}}
                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 sm:p-8">
                        @include('profile.partials.update-profile-information-form', ['user' => $user])
                    </div>

                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="rounded-2xl border border-red-900/15 bg-white p-6 shadow-lg shadow-teal-900/5 sm:p-8 lg:col-span-2">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-layouts.public>
