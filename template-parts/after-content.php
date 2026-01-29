    <!-- ═══════════════════════════════════════════════════════════════════════
         SECCIÓN "PARA QUIÉN ES" - BENTO GRID SECUNDARIO
    ════════════════════════════════════════════════════════════════════════ -->
    <section class="py-20 px-6" id="para-quien">
        <div class="max-w-7xl mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block font-medium text-sm px-4 py-2 rounded-full mb-4" style="background-color: color-mix(in srgb, var(--deoia-primary) 15%, transparent); color: var(--deoia-primary);">
                    Tus Servicios
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold mb-4" style="color: var(--deoia-bg-card);">
                    Perfecto para tu tipo de negocio
                </h2>
            </div>

            <!-- Bento Grid Secundario -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <?php
                $servicios_query = new WP_Query( array(
                    'post_type'      => 'deoia_servicio',
                    'posts_per_page' => -1,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ) );

                if ( $servicios_query->have_posts() ) :
                    while ( $servicios_query->have_posts() ) : $servicios_query->the_post();
                        
                        // Obtener meta fields
                        $icono_clases = get_post_meta( get_the_ID(), 'servicio_icono_clases', true );
                        $icono_svg = get_post_meta( get_the_ID(), 'servicio_icono_svg', true );
                        $caracteristicas_raw = get_post_meta( get_the_ID(), 'servicio_caracteristicas', true );
                        
                        // Procesar características (una por línea)
                        $caracteristicas = array_filter( array_map( 'trim', explode( "\n", $caracteristicas_raw ) ) );
                        
                        // Clases por defecto si no hay configuradas
                        if ( empty( $icono_clases ) ) {
                            $icono_clases = 'from-violet-500 to-indigo-500';
                        }
                        
                        // Extraer el primer color para la sombra
                        preg_match( '/from-([a-z]+-\d+)/', $icono_clases, $matches );
                        $shadow_color = isset( $matches[1] ) ? $matches[1] : 'violet-500';
                ?>
                
                <div class="group bg-white rounded-3xl p-8 shadow-xl border hover:-translate-y-2 transition-all duration-500" style="border-color: color-mix(in srgb, var(--deoia-border) 20%, transparent); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300" style="background-image: linear-gradient(to bottom right, var(--deoia-primary), var(--deoia-secondary)); box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);">
                        <?php if ( ! empty( $icono_svg ) ) : ?>
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php echo $icono_svg; ?>
                        </svg>
                        <?php else : ?>
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xl font-bold mb-3" style="color: var(--deoia-bg-card);"><?php the_title(); ?></h3>
                    <div class="mb-4 leading-relaxed" style="color: var(--deoia-muted-dark);">
                        <?php the_content(); ?>
                    </div>
                    <?php if ( ! empty( $caracteristicas ) ) : ?>
                    <ul class="space-y-2 text-sm" style="color: var(--deoia-muted);">
                        <?php foreach ( $caracteristicas as $caracteristica ) : ?>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" style="color: var(--deoia-success);" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo esc_html( $caracteristica ); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>

                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <!-- Mensaje cuando no hay servicios -->
                <div class="lg:col-span-4 text-center py-12">
                    <p style="color: var(--deoia-muted);">No hay servicios configurados. Añade servicios desde el panel de administración.</p>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
