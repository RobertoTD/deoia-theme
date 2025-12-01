<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deoia - Sistema de Reservas Inteligente</title>
    
    <?php wp_head(); ?> 
</head>
<body <?php body_class( 'bg-slate-50 antialiased' ); ?>>

    <!-- ═══════════════════════════════════════════════════════════════════════
         NAVBAR FLOTANTE
    ════════════════════════════════════════════════════════════════════════ -->
    <nav class="fixed top-0 left-0 right-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between bg-white/70 backdrop-blur-xl rounded-2xl px-6 py-3 shadow-lg shadow-slate-200/50 border border-white/50">
            <!-- Logo -->
            <a href="<?php echo home_url(); ?>" class="flex items-center gap-2 group">
                <div class="w-9 h-9 bg-gradient-to-br from-violet-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-violet-500/30 group-hover:shadow-violet-500/50 transition-all duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Deoia</span>
            </a>

            <!-- CTA Button -->
            <a href="#reservar" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-violet-500/30 hover:shadow-violet-500/50 hover:scale-105 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Agendar Cita
            </a>
        </div>
    </nav>

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
                        Sistema de Reservas #1
                    </div>

                    <!-- Headline -->
                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                        Automatiza tu agenda y 
                        <span class="bg-gradient-to-r from-violet-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">multiplica tus ingresos</span>
                    </h1>

                    <!-- Subheadline -->
                    <p class="text-lg text-slate-600 mb-8 max-w-xl leading-relaxed">
                        Olvídate de las llamadas perdidas y las citas olvidadas. Deja que tus clientes reserven 24/7 mientras tú te enfocas en lo que mejor haces.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap gap-4">
                        <a href="#demo" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-2xl shadow-xl shadow-violet-500/30 hover:shadow-violet-500/50 hover:scale-105 transition-all duration-300">
                            Comenzar Gratis
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
                            <span class="text-sm text-slate-600"><strong class="text-slate-800">+2,500</strong> negocios activos</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="flex">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm text-slate-600 ml-1"><strong class="text-slate-800">4.9</strong> (850+ reseñas)</span>
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
                
                <!-- Card 1: Estéticas / Spas -->
                <div class="group bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:shadow-violet-500/10 hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-pink-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Estéticas & Spas</h3>
                    <p class="text-slate-600 mb-4 leading-relaxed">
                        Gestiona cortes, tratamientos faciales, masajes y más. Asigna estilistas específicos automáticamente.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Multi-empleados
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Catálogo de servicios
                        </li>
                    </ul>
                </div>

                <!-- Card 2: Consultorios Médicos -->
                <div class="group bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:shadow-violet-500/10 hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-sky-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Consultorios Médicos</h3>
                    <p class="text-slate-600 mb-4 leading-relaxed">
                        Optimiza la agenda de doctores y especialistas. Reduce ausencias con recordatorios SMS/Email.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Recordatorios automáticos
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Historial de pacientes
                        </li>
                    </ul>
                </div>

                <!-- Card 3: Gimnasios / Coaching -->
                <div class="group bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:shadow-violet-500/10 hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Gimnasios & Coaching</h3>
                    <p class="text-slate-600 mb-4 leading-relaxed">
                        Clases grupales, sesiones personales y entrenamientos. Controla aforo y capacidad fácilmente.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Clases grupales
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Control de aforo
                        </li>
                    </ul>
                </div>

                <!-- Card 4: Servicios Profesionales -->
                <div class="group bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:shadow-violet-500/10 hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Servicios Profesionales</h3>
                    <p class="text-slate-600 mb-4 leading-relaxed">
                        Consultorías, asesorías legales, contables y más. Agenda reuniones virtuales o presenciales.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Integración Zoom/Meet
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Pagos anticipados
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════════
         FOOTER
    ════════════════════════════════════════════════════════════════════════ -->
    <footer class="bg-slate-900 text-slate-400 py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Logo & Copyright -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-violet-600 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-white font-bold">Deoia</span>
                    </div>
                    <span class="text-sm">© <?php echo date('Y'); ?> Todos los derechos reservados.</span>
                </div>

                <!-- Social Links -->
                <div class="flex items-center gap-4">
                    <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-violet-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-violet-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-violet-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>