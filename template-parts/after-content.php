    <!-- ═══════════════════════════════════════════════════════════════════════
         SECCIÓN "PARA QUIÉN ES" - BENTO GRID SECUNDARIO
    ════════════════════════════════════════════════════════════════════════ -->
    <section class="py-20 px-6" id="para-quien">
        <div class="max-w-7xl mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block bg-violet-100 text-violet-700 font-medium text-sm px-4 py-2 rounded-full mb-4">
                    Soluciones por Industria
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">
                    Perfecto para tu tipo de negocio
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Deoia se adapta a las necesidades específicas de cada industria de servicios
                </p>
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
                
                <div class="group bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:shadow-violet-500/10 hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 bg-gradient-to-br <?php echo esc_attr( $icono_clases ); ?> rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-<?php echo esc_attr( $shadow_color ); ?>/30 group-hover:scale-110 transition-transform duration-300">
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
                    <h3 class="text-xl font-bold text-slate-900 mb-3"><?php the_title(); ?></h3>
                    <div class="text-slate-600 mb-4 leading-relaxed">
                        <?php the_content(); ?>
                    </div>
                    <?php if ( ! empty( $caracteristicas ) ) : ?>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <?php foreach ( $caracteristicas as $caracteristica ) : ?>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
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
                    <p class="text-slate-500">No hay servicios configurados. Añade servicios desde el panel de administración.</p>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
