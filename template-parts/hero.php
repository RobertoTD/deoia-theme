

    <section class="min-h-screen pt-28 pb-16 px-6">
        <div class="max-w-7xl mx-auto">
            
            <!-- Bento Grid Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                
                <!-- ══ CELDA A: Widget de Reservas (primera posición / izquierda en desktop) ══ -->
                <div class="lg:col-span-2">
                    <?php 
                    // Ejecutar el shortcode del plugin de agenda
                    // El adaptador premium (DeoiaCalendarAdapter.js) se encargará de aplicar los estilos
                    echo do_shortcode('[agenda_automatizada]'); 
                    ?>
                </div>

                <!-- ══ CELDA B: Mensaje Principal (segunda posición / derecha en desktop) ══ -->
                <div class="lg:col-span-3 bg-white rounded-3xl p-8 lg:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col justify-center">
                    
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 font-medium text-sm px-4 py-2 rounded-full w-fit mb-6" style="background-color: color-mix(in srgb, var(--deoia-primary) 15%, transparent); color: var(--deoia-primary);">
                        <span class="w-2 h-2 rounded-full animate-pulse" style="background-color: var(--deoia-primary);"></span>
                        <?php echo esc_html( get_theme_mod( 'hero_badge_text', 'Sistema de Reservas #1' ) ); ?>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold leading-tight mb-6" style="color: var(--deoia-bg-card);">
                        <?php echo esc_html( get_theme_mod( 'hero_headline_main', 'Automatiza tu agenda y' ) ); ?> 
                        <span class="bg-clip-text text-transparent" style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary));"><?php echo esc_html( get_theme_mod( 'hero_headline_accent', 'multiplica tus ingresos' ) ); ?></span>
                    </h1>

                    <!-- Subheadline -->
                    <p class="text-lg text-slate-600 mb-8 max-w-xl leading-relaxed">
                        <?php echo esc_html( get_theme_mod( 'hero_subheadline', 'Olvídate de las llamadas perdidas y las citas olvidadas. Deja que tus clientes reserven 24/7 mientras tú te enfocas en lo que mejor haces.' ) ); ?>
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap gap-4">
                        <a href="#demo" class="inline-flex items-center gap-2 text-white font-semibold px-8 py-4 rounded-2xl shadow-xl hover:scale-105 transition-all duration-300" style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                            <?php echo esc_html( get_theme_mod( 'hero_cta_text_1', 'Comenzar Gratis' ) ); ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="#video" class="inline-flex items-center gap-2 font-semibold px-8 py-4 rounded-2xl hover:scale-105 transition-all duration-300" style="background-color: color-mix(in srgb, var(--deoia-bg-card) 10%, white); color: var(--deoia-bg-card);">
                            <svg class="w-5 h-5" style="color: var(--deoia-primary);" fill="currentColor" viewBox="0 0 24 24">
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
            </div>
        </div>
    </section>
