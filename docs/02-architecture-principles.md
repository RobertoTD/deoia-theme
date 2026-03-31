<!-- Última actualización del documento: 2026-03-30 -->

Architecture Principles (Summary)

THEME ROOT
│
├── assets/
│   ├── css/
│   │   ├── editor.css
│   │   ├── main.css
│   │   └── blocks/
│   │       ├── deoia-badge-editor.css
│   │       └── deoia-badge-frontend.css
│   ├── js/
│   │   ├── DeoiaRegisterAdapters.js
│   │   ├── adapters/
│   │   │   ├── DeoiaCalendarAdapter.js
│   │   │   ├── DeoiaModalAdapter.js
│   │   │   └── DeoiaSlotsAdapter.js
│   │   └── blocks/
│   │       └── deoia-badge-block.js
│   └── svg/
│       └── patterns/
│           └── patronDeoiaSVG.svg
│
├── docs/
│   ├── 02-architecture-principles.md
│   └── DESIGN_BRIEF.md
│
├── includes/
│   └── blocks/
│       └── deoia-badge-block.php
│
├── plugin-update-checker/
│   └── ... vendor library ...
│
├── src/
│   └── input.css
│
├── template-parts/
│   ├── after-content.php
│   ├── content-none.php
│   ├── content-page.php
│   ├── content.php
│   ├── hero.php
│   └── location.php
│
├── footer.php
├── front-page.php
├── functions.php
├── header.php
├── index.php
├── style.css
└── tailwind.config.js

## Theme Layers

- **`functions.php`**  
  Bootstrap central del tema.  
  Aquí viven hoy: `theme_supports`, menús, customizer, CPTs, shortcodes, hooks de render y enqueue.  
  Regla: `functions.php` debe quedarse como punto de entrada y wiring general, no como hogar permanente de features complejos.

- **`template-parts/`**  
  Fragmentos de presentación reutilizables del frontend.  
  `hero.php`, `location.php`, `content*.php`, `after-content.php`.  
  Regla: aquí vive markup de secciones, no registro de bloques ni lógica de editor.

- **`src/input.css`**  
  Fuente principal de estilos del tema.  
  Tailwind compila desde aquí hacia `assets/css/main.css`.  
  Regla: estilos fuente del frontend se editan aquí; `main.css` es artefacto compilado.

- **`assets/css/editor.css`**  
  Estilos del editor Gutenberg.  
  Su objetivo es dar paridad visual razonable con el frontend, sin duplicar toda la capa de presentación del tema.

- **`assets/js/adapters/`**  
  Adaptadores de integración con el plugin y sus componentes visuales.  
  No son bloques Gutenberg; son capa de integración frontend.

- **`assets/svg/`**  
  Assets SVG versionados dentro del tema.  
  `patterns/` almacena patrones decorativos del sistema visual del theme.

- **`docs/`**  
  Documentación viva del tema: brief, principios de arquitectura y decisiones de estructura.

- **`plugin-update-checker/`**  
  Dependencia de terceros para actualizaciones del tema.  
  Tratar como librería vendor: evitar mezclar lógica propia aquí.

## Planned Gutenberg Block Layer

Para el bloque futuro **Etiqueta Deoia**, la arquitectura planeada es:

- **`includes/blocks/deoia-badge-block.php`**  
  Registro PHP del bloque, hooks, render callback y enqueue del bloque.  
  Regla: la responsabilidad PHP del bloque sale de `functions.php` y vive aquí.

- **`assets/js/blocks/deoia-badge-block.js`**  
  Registro del bloque en Gutenberg, definición del editor, toolbar/controles y markup del bloque en el editor.

- **`assets/css/blocks/deoia-badge-editor.css`**  
  Estilos exclusivos del bloque dentro del editor.

- **`assets/css/blocks/deoia-badge-frontend.css`**  
  Estilos exclusivos del bloque en el frontend.

## Responsibility Rules

- **Theme bootstrap:** `functions.php`
- **Frontend section markup:** `template-parts/`
- **Frontend style source:** `src/input.css`
- **Compiled frontend CSS:** `assets/css/main.css`
- **Editor parity styles:** `assets/css/editor.css`
- **Block-specific PHP:** `includes/blocks/`
- **Block-specific JS/CSS:** `assets/js/blocks/` y `assets/css/blocks/`
- **Static SVG assets:** `assets/svg/`
- **Documentation:** `docs/`

## Gutenberg Block Principle

Si un feature necesita:

- markup propio,
- comportamiento propio en el editor,
- controles propios,
- y separación clara entre alineación / contenedor / elemento visual,

entonces debe ser un **bloque Gutenberg propio**, no una variante cosmética sobre `Paragraph`.

## Regla Global

**Cada feature debe vivir en la capa que coincide con su responsabilidad.**  
No mezclar:

- bootstrap con features complejos,
- template-parts con lógica de editor,
- estilos globales con estilos específicos de bloque,
- vendor code con código del tema.

Flujo recomendado para features nuevas del tema:

**functions.php → includes/feature-or-block → assets/js|css feature-specific → template-parts solo si hay sección frontend reutilizable**
