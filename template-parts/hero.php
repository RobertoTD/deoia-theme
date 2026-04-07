<?php
$deoia_show_calendar   = get_theme_mod( 'deoia_show_calendar_in_hero', true );
$deoia_video_url       = get_theme_mod( 'hero_cta_url_2', '#video' );
$deoia_video_embed_url = deoia_get_youtube_embed_url( $deoia_video_url );
$deoia_has_video_url   = '' !== trim( (string) $deoia_video_url ) && '#video' !== trim( (string) $deoia_video_url );
$deoia_invalid_video   = $deoia_has_video_url && '' === $deoia_video_embed_url;
?>

    <section class="pt-24 pb-6 px-6 sm:pt-28 sm:pb-8">
            <!-- Bento Grid Principal -->
            <div class="grid grid-cols-1 <?php echo $deoia_show_calendar ? 'lg:grid-cols-5' : ''; ?> gap-6">
                
                <?php if ( $deoia_show_calendar ) : ?>
                <!-- ══ CELDA A: Widget de Reservas (primera posición / izquierda en desktop) ══ -->
                <div id="reservar" class="lg:col-span-2">
                    <?php echo do_shortcode('[agenda_automatizada]'); ?>
                </div>
                <?php endif; ?>

                <!-- ══ CELDA B: Mensaje Principal (segunda posición / derecha en desktop) ══ -->
                <div class="<?php echo $deoia_show_calendar ? 'lg:col-span-3' : ''; ?> bg-white rounded-3xl p-8 lg:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col justify-center">
                    
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 font-medium text-sm px-4 py-2 rounded-full w-fit mb-6" style="background-color: color-mix(in srgb, var(--deoia-primary) 15%, transparent); color: var(--deoia-primary);">
                        <span class="w-2 h-2 rounded-full animate-pulse" style="background-color: var(--deoia-primary);"></span>
                        <?php echo esc_html( get_theme_mod( 'hero_badge_text', 'Sistema de Reservas #1' ) ); ?>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold leading-tight mb-6">
                        <span class="bg-clip-text text-transparent" style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary));"><?php echo esc_html( get_theme_mod( 'hero_headline_main', 'Automatiza tu agenda y' ) ); ?> <?php echo esc_html( get_theme_mod( 'hero_headline_accent', 'multiplica tus ingresos' ) ); ?></span>
                    </h1>

                    <!-- Subheadline -->
                    <p class="text-lg mb-8 max-w-xl lg:max-w-4xl leading-relaxed" style="color: var(--deoia-muted-dark);">
                        <?php echo esc_html( get_theme_mod( 'hero_subheadline', 'Olvídate de las llamadas perdidas y las citas olvidadas. Deja que tus clientes reserven 24/7 mientras tú te enfocas en lo que mejor haces.' ) ); ?>
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap gap-4">
                        <a href="<?php echo esc_url( get_theme_mod( 'hero_cta_url_1', '#demo' ) ); ?>" class="inline-flex items-center gap-2 font-semibold px-8 py-4 rounded-2xl shadow-xl hover:scale-105 transition-all duration-300" style="color: var(--deoia-text-inverse); background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                            <?php echo esc_html( get_theme_mod( 'hero_cta_text_1', 'Comenzar Gratis' ) ); ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a
                            href="<?php echo esc_url( $deoia_video_url ); ?>"
                            <?php if ( '' !== $deoia_video_embed_url ) : ?>
                                data-deoia-video-trigger
                                data-video-embed="<?php echo esc_attr( $deoia_video_embed_url ); ?>"
                                aria-controls="deoia-video-modal"
                                aria-haspopup="dialog"
                            <?php endif; ?>
                            class="inline-flex items-center gap-2 font-semibold px-8 py-4 rounded-2xl hover:scale-105 transition-all duration-300"
                            style="background-color: color-mix(in srgb, var(--deoia-bg-card) 10%, white); color: var(--deoia-bg-card);"
                        >
                            <svg class="w-5 h-5" style="color: var(--deoia-primary);" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <?php echo esc_html( get_theme_mod( 'hero_cta_text_2', 'Ver Demo' ) ); ?>
                        </a>
                    </div>

                    <?php if ( $deoia_invalid_video ) : ?>
                    <p class="mt-4 text-sm" style="color: #b45309;">
                        <?php esc_html_e( 'La URL configurada para el video demo no es una URL válida de YouTube. Pega un enlace de YouTube para abrirlo dentro del sitio.', 'deoia' ); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Trust Indicators -->
                    <?php
                    $trust_count = trim( (string) get_theme_mod( 'hero_trust_count', '2,500' ) );
                    $trust_show_plus = (bool) get_theme_mod( 'hero_trust_show_plus', true );
                    $trust_suffix = trim( (string) get_theme_mod( 'hero_trust_suffix', 'negocios activos' ) );
                    $review_count = trim( (string) get_theme_mod( 'hero_review_count', '850' ) );
                    ?>
                    <div class="mt-10 pt-8 border-t border-slate-100 flex flex-wrap items-center gap-8">
                        <?php if ( $trust_count !== '' ) : ?>
                        <div class="flex items-center gap-2">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-rose-500 rounded-full border-2 border-white"></div>
                                <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full border-2 border-white"></div>
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full border-2 border-white"></div>
                            </div>
                            <span class="text-sm" style="color: var(--deoia-muted-dark);"><strong style="color: var(--deoia-bg-card);"><?php echo $trust_show_plus ? '+' : ''; ?><?php echo esc_html( $trust_count ); ?></strong><?php if ( $trust_suffix !== '' ) : ?> <?php echo esc_html( $trust_suffix ); ?><?php endif; ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ( $review_count !== '' ) : ?>
                        <div class="flex items-center gap-1">
                            <div class="flex">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm ml-1" style="color: var(--deoia-muted-dark);"><strong style="color: var(--deoia-bg-card);">4.9</strong> (<?php echo esc_html( $review_count ); ?>+ reseñas)</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ( '' !== $deoia_video_embed_url ) : ?>
            <div
                id="deoia-video-modal"
                class="hidden fixed inset-0 z-50 items-center justify-center bg-black/70 p-4"
                role="dialog"
                aria-modal="true"
                aria-hidden="true"
                aria-label="<?php esc_attr_e( 'Video de demostración', 'deoia' ); ?>"
            >
                <div class="relative w-full max-w-4xl overflow-hidden rounded-3xl border border-white/10 bg-black shadow-2xl">
                    <button
                        type="button"
                        data-deoia-video-close
                        class="absolute right-3 top-3 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full bg-black/60 text-white transition hover:bg-black/80"
                        aria-label="<?php esc_attr_e( 'Cerrar video', 'deoia' ); ?>"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <iframe
                        data-deoia-video-frame
                        class="aspect-video w-full"
                        src=""
                        title="<?php esc_attr_e( 'Video de demostración de Deoia', 'deoia' ); ?>"
                        frameborder="0"
                        allow="autoplay; encrypted-media; picture-in-picture; fullscreen"
                        allowfullscreen
                        referrerpolicy="strict-origin-when-cross-origin"
                    ></iframe>
                </div>
            </div>
            <?php endif; ?>
    </section>
