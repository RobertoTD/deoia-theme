# DEOIA Theme - Design Brief

> Referencia concisa de diseño para mantener consistencia visual. Usar Tailwind CSS como herramienta principal.

---

## Paleta de Colores (CSS Variables)

```css
--deoia-primary: #8b5cf6; /* Violeta - Acciones principales */
--deoia-secondary: #6366f1; /* Índigo - Gradientes, complemento */
--deoia-accent: #f472b6; /* Rosa - Acentos, detalles */
--deoia-bg-card: #0f172a; /* Slate-900 - Fondos oscuros premium */
--deoia-bg-card-alt: #1e293b; /* Slate-800 - Fondos alternos */
--deoia-success: #10b981; /* Emerald - Confirmaciones, checks */
--deoia-warning: #f59e0b; /* Amber - Alertas */
--deoia-error: #ef4444; /* Red - Errores */
--deoia-muted: #94a3b8; /* Slate-400 - Texto secundario */
--deoia-muted-dark: #64748b; /* Slate-500 - Texto terciario */
--deoia-border: #334155; /* Slate-700 - Bordes oscuros */
```

**Uso:** Aplicar con `style="color: var(--deoia-primary);"` o `style="background-color: var(--deoia-bg-card);"`.

---

## Layout Base

| Elemento       | Clases Tailwind                                        |
| -------------- | ------------------------------------------------------ |
| Contenedor     | `max-w-7xl mx-auto`                                    |
| Sección        | `py-20 px-6` (vertical), `py-12 px-6` (compacto)       |
| Fondo página   | `bg-slate-50`                                          |
| Grid principal | `grid grid-cols-1 lg:grid-cols-5 gap-6`                |
| Grid cards     | `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6` |

---

## Tarjetas (Cards)

**Card clara (hero, contenido):**

```html
<div
  class="bg-white rounded-3xl p-8 lg:p-12 shadow-xl shadow-slate-200/50 border border-slate-100"
></div>
```

**Card hover (servicios):**

```html
<div
  class="group bg-white rounded-3xl p-8 shadow-xl border hover:-translate-y-2 transition-all duration-500"
  style="border-color: color-mix(in srgb, var(--deoia-border) 20%, transparent);"
></div>
```

**Card oscura (footer, widget premium):**

```html
<div style="background-color: var(--deoia-bg-card); color: var(--deoia-muted);"></div>
```

---

## Botones

**CTA Primario (gradiente):**

```html
<a
  class="inline-flex items-center gap-2 text-white font-semibold px-8 py-4 rounded-2xl shadow-xl hover:scale-105 transition-all duration-300"
  style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary));
          box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);"
></a>
```

**CTA Secundario (sutil):**

```html
<a
  class="inline-flex items-center gap-2 font-semibold px-8 py-4 rounded-2xl hover:scale-105 transition-all duration-300"
  style="background-color: color-mix(in srgb, var(--deoia-bg-card) 10%, white); color: var(--deoia-bg-card);"
></a>
```

**Botón pequeño (navbar):**

```html
<a
  class="inline-flex items-center gap-2 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg hover:scale-105 transition-all duration-300"
  style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary));"
></a>
```

---

## Badges

```html
<span
  class="inline-flex items-center gap-2 font-medium text-sm px-4 py-2 rounded-full"
  style="background-color: color-mix(in srgb, var(--deoia-primary) 15%, transparent); color: var(--deoia-primary);"
>
  <span
    class="w-2 h-2 rounded-full animate-pulse"
    style="background-color: var(--deoia-primary);"
  ></span>
  Texto del badge
</span>
```

---

## Tipografía

| Uso           | Clases                                                          | Color                  |
| ------------- | --------------------------------------------------------------- | ---------------------- |
| H1 Hero       | `text-4xl lg:text-5xl xl:text-6xl font-extrabold leading-tight` | `var(--deoia-bg-card)` |
| H2 Sección    | `text-3xl lg:text-4xl font-bold`                                | `var(--deoia-bg-card)` |
| H3 Card       | `text-xl font-bold`                                             | `var(--deoia-bg-card)` |
| Subtítulo     | `text-lg leading-relaxed`                                       | `text-slate-600`       |
| Body muted    | `text-sm`                                                       | `var(--deoia-muted)`   |
| Label pequeño | `text-xs font-medium uppercase tracking-wider`                  | `var(--deoia-muted)`   |

**Texto con gradiente:**

```html
<span
  class="bg-clip-text text-transparent"
  style="background-image: linear-gradient(to right, var(--deoia-primary), var(--deoia-secondary));"
></span>
```

---

## Iconos

- **Tamaños:** `w-4 h-4` (inline), `w-5 h-5` (botones), `w-7 h-7` (cards)
- **Contenedor icono card:**

```html
<div
  class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300"
  style="background-image: linear-gradient(to bottom right, var(--deoia-primary), var(--deoia-secondary));
            box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent);"
>
  <svg class="w-7 h-7 text-white">...</svg>
</div>
```

---

## Transiciones y Hover

| Efecto         | Clases                                                    |
| -------------- | --------------------------------------------------------- |
| Escala suave   | `hover:scale-105 transition-all duration-300`             |
| Elevación card | `hover:-translate-y-2 transition-all duration-500`        |
| Icono en grupo | `group-hover:scale-110 transition-transform duration-300` |
| Escala redes   | `hover:scale-110 transition-all duration-300`             |

---

## Navbar Flotante

```html
<nav class="fixed top-0 left-0 right-0 z-50 px-6 py-4">
  <div
    class="max-w-7xl mx-auto flex items-center justify-between bg-white/70 backdrop-blur-xl rounded-2xl px-6 py-3 shadow-lg shadow-slate-200/50 border border-white/50"
  ></div>
</nav>
```

---

## Sombras Recurrentes

| Uso               | Estilo                                                                                   |
| ----------------- | ---------------------------------------------------------------------------------------- |
| Cards claras      | `shadow-xl shadow-slate-200/50`                                                          |
| Botones primarios | `box-shadow: 0 10px 15px -3px color-mix(in srgb, var(--deoia-primary) 30%, transparent)` |
| Navbar            | `shadow-lg shadow-slate-200/50`                                                          |

---

## Border Radius

| Elemento       | Clase                         |
| -------------- | ----------------------------- |
| Cards grandes  | `rounded-3xl`                 |
| Botones/inputs | `rounded-2xl`                 |
| Badges/iconos  | `rounded-full` o `rounded-xl` |
| Logo container | `rounded-xl`                  |

---

## Patrones de color-mix()

Usar `color-mix(in srgb, VAR PORCENTAJE, transparent)` para:

- Fondos sutiles de badges: `15%`
- Sombras de botones: `30%`
- Bordes sutiles: `20%`
- Hovers: `50%`

---

## Archivos Clave

| Archivo                            | Propósito                                   |
| ---------------------------------- | ------------------------------------------- |
| `src/input.css`                    | Variables CSS + componentes Tailwind custom |
| `tailwind.config.js`               | Content paths, safelist                     |
| `header.php`                       | Navbar flotante                             |
| `template-parts/hero.php`          | Hero con bento grid                         |
| `template-parts/after-content.php` | Sección servicios                           |
| `footer.php`                       | Footer oscuro                               |
| `assets/css/main.css`              | CSS compilado (NO editar)                   |

---

## Compilación Tailwind

```bash
npm run watch   # Desarrollo (auto-compila)
npm run build   # Producción (minificado)
```

---

## Checklist Rápido

- [ ] Usar `max-w-7xl mx-auto` para contenedores
- [ ] Cards con `rounded-3xl`, botones `rounded-2xl`
- [ ] Colores vía CSS variables `--deoia-*`
- [ ] Gradientes: `var(--deoia-primary)` → `var(--deoia-secondary)`
- [ ] Transiciones: `transition-all duration-300`
- [ ] Hover: `hover:scale-105` o `hover:-translate-y-2`
- [ ] Sombras con `color-mix()` usando primary
- [ ] Textos oscuros: `var(--deoia-bg-card)`, claros: `slate-600`
