    <!-- ═══════════════════════════════════════════════════════════════════════
         HERO SECTION - BENTO GRID MAIN
    ════════════════════════════════════════════════════════════════════════ -->
    <section class="min-h-screen pt-28 pb-16 px-6">
        <div class="max-w-7xl mx-auto">
            
            <!-- Bento Grid Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                
                <!-- ══ CELDA A: Mensaje Principal (Ocupa 3 columnas) ══ -->
                <div class="lg:col-span-3 bg-white rounded-3xl p-8 lg:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col justify-center">
                    
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-violet-100 text-violet-700 font-medium text-sm px-4 py-2 rounded-full w-fit mb-6">
                        <span class="w-2 h-2 bg-violet-500 rounded-full animate-pulse"></span>
                        <?php echo esc_html( get_theme_mod( 'hero_badge_text', 'Sistema de Reservas #1' ) ); ?>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                        <?php echo esc_html( get_theme_mod( 'hero_headline_main', 'Automatiza tu agenda y' ) ); ?> 
                        <span class="bg-gradient-to-r from-violet-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent"><?php echo esc_html( get_theme_mod( 'hero_headline_accent', 'multiplica tus ingresos' ) ); ?></span>
                    </h1>

                    <!-- Subheadline -->
                    <p class="text-lg text-slate-600 mb-8 max-w-xl leading-relaxed">
                        <?php echo esc_html( get_theme_mod( 'hero_subheadline', 'Olvídate de las llamadas perdidas y las citas olvidadas. Deja que tus clientes reserven 24/7 mientras tú te enfocas en lo que mejor haces.' ) ); ?>
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap gap-4">
                        <a href="#demo" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-2xl shadow-xl shadow-violet-500/30 hover:shadow-violet-500/50 hover:scale-105 transition-all duration-300">
                            <?php echo esc_html( get_theme_mod( 'hero_cta_text_1', 'Comenzar Gratis' ) ); ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="#video" class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 font-semibold px-8 py-4 rounded-2xl hover:bg-slate-200 hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 text-violet-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            Ver Demo
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="mt-10 pt-8 border-t border-slate-100 flex flex-wrap items-center gap-8">
                        <div class="flex items-center gap-2">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-rose-500 rounded-full border-2 border-white"></div>
                                <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full border-2 border-white"></div>
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full border-2 border-white"></div>
                            </div>
                            <span class="text-sm text-slate-600"><strong class="text-slate-800">+<?php echo esc_html( get_theme_mod( 'hero_trust_count', '2,500' ) ); ?></strong> negocios activos</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="flex">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm text-slate-600 ml-1"><strong class="text-slate-800">4.9</strong> (<?php echo esc_html( get_theme_mod( 'hero_review_count', '850' ) ); ?>+ reseñas)</span>
                        </div>
                    </div>
                </div>

                <!-- ══ CELDA B: Widget de Reservas (Ocupa 2 columnas) ══ -->
                <div class="lg:col-span-2 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 lg:p-8 shadow-2xl shadow-slate-900/30 border border-slate-700/50 relative overflow-hidden">
                    
                    <!-- Decorative Glow -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-violet-500/20 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl"></div>
                    
                    <!-- Widget Content -->
                    <div class="relative z-10">
                        <!-- Widget Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">Reservar Cita</h3>
                                    <p class="text-slate-400 text-sm">Selecciona fecha y hora</p>
                                </div>
                            </div>
                            <span class="text-xs bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full font-medium">En línea</span>
                        </div>

                        <!-- Calendar Preview -->
                        <div class="bg-slate-800/50 rounded-2xl p-4 mb-4 backdrop-blur-sm border border-slate-700/50">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-white font-medium">Diciembre 2025</span>
                                <div class="flex gap-1">
                                    <button class="p-1 hover:bg-slate-700 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    <button class="p-1 hover:bg-slate-700 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center text-xs">
                                <?php 
                                $days = ['Lu','Ma','Mi','Ju','Vi','Sa','Do'];
                                foreach($days as $d): ?>
                                <span class="text-slate-500 py-1"><?php echo $d; ?></span>
                                <?php endforeach; ?>
                                
                                <?php for($i = 1; $i <= 31; $i++): 
                                    $isSelected = $i === 15;
                                    $isToday = $i === 1;
                                ?>
                                <button class="py-2 rounded-lg text-sm transition-all duration-200 <?php 
                                    echo $isSelected 
                                        ? 'bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold shadow-lg' 
                                        : ($isToday ? 'bg-slate-700 text-white' : 'text-slate-400 hover:bg-slate-700/50'); 
                                ?>">
                                    <?php echo $i; ?>
                                </button>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- Time Slots -->
                        <div class="mb-4">
                            <p class="text-slate-400 text-sm mb-3">Horarios disponibles</p>
                            <div class="grid grid-cols-3 gap-2">
                                <?php 
                                $times = ['09:00', '10:30', '12:00', '14:00', '16:30', '18:00'];
                                foreach($times as $idx => $time): 
                                    $selected = $idx === 3;
                                ?>
                                <button class="py-2 px-3 rounded-xl text-sm font-medium transition-all duration-200 <?php 
                                    echo $selected 
                                        ? 'bg-gradient-to-r from-violet-600 to-indigo-600 text-white shadow-lg shadow-violet-500/30' 
                                        : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700 border border-slate-700/50'; 
                                ?>">
                                    <?php echo $time; ?>
                                </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Book Button -->
                        <button class="w-full bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold py-4 rounded-2xl shadow-xl shadow-violet-500/30 hover:shadow-violet-500/50 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                            Confirmar Reserva
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>

                        <!-- Widget Badge -->
                        <p class="text-center text-slate-500 text-xs mt-4">
                            Potenciado por <span class="text-violet-400 font-medium">Deoia</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
