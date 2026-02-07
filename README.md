# Deoia Reservations Theme

## Overview

- Tema WordPress ultraligero optimizado para Tailwind CSS.
- Autor: Roberto Tejada · Theme URI: https://deoia.com · Versión: 1.1.0.
- Usa variables CSS (`--deoia-*`) y Tailwind como herramienta principal de estilos.
- CSS compilado desde `src/input.css` hacia `assets/css/main.css` (no editar `main.css` a mano).

## Design rules

- **Paleta:** Usar variables `--deoia-primary`, `--deoia-secondary`, `--deoia-accent`, `--deoia-bg-card`, `--deoia-success/warning/error`, `--deoia-muted`, `--deoia-border`; aplicar con `style="color: var(--deoia-primary);"` o equivalentes.
- **Layout:** Contenedor `max-w-7xl mx-auto`; secciones `py-20 px-6` (o `py-12 px-6` compacto); fondo página `bg-slate-50`; grids según brief (ej. `grid grid-cols-1 lg:grid-cols-5 gap-6`).
- **Cards:** Claros `rounded-3xl`, sombra `shadow-xl shadow-slate-200/50`; oscuros con `var(--deoia-bg-card)`; hover con `hover:-translate-y-2 transition-all duration-500`.
- **Botones:** CTA primario con gradiente `var(--deoia-primary)` → `var(--deoia-secondary)`, `rounded-2xl`, `hover:scale-105 transition-all duration-300`; secundarios y pequeños según brief.
- **Tipografía:** H1 hero, H2 sección, H3 card y body/subtítulos con clases y colores indicados en el brief (H1/H2/H3 con `var(--deoia-bg-card)`).
- **Transiciones:** Escala suave `hover:scale-105`, elevación card `hover:-translate-y-2`, iconos en grupo `group-hover:scale-110`.
- **Sombras:** Cards claras `shadow-xl shadow-slate-200/50`; botones con `color-mix(in srgb, var(--deoia-primary) 30%, transparent)`.
- **Border radius:** Cards `rounded-3xl`, botones/inputs `rounded-2xl`, badges/iconos `rounded-full` o `rounded-xl`.
- **color-mix:** Usar para fondos sutiles (15%), sombras (30%), bordes (20%), hovers (50%).

## Key paths

| Ruta | Uso |
|------|-----|
| `src/input.css` | Variables CSS y componentes Tailwind custom |
| `tailwind.config.js` | Content paths y safelist |
| `header.php` | Navbar flotante |
| `footer.php` | Footer oscuro |
| `template-parts/hero.php` | Hero con bento grid |
| `template-parts/after-content.php` | Sección servicios |
| `template-parts/location.php` | Ubicación |
| `assets/css/main.css` | CSS compilado (solo salida de build) |
| `assets/js/` | Adaptadores (calendar, modal, slots) y registro |

## Build / Dev

- **Desarrollo:** `npm run watch` — compila Tailwind en modo watch (`input.css` → `assets/css/main.css`).
- **Producción:** `npm run build` — compilación minificada.

## Docs

- [Design Brief](docs/DESIGN_BRIEF.md) — paleta, layout, cards, botones, tipografía, iconos, navbar, sombras y checklist.
