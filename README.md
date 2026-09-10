# GASTAB - WordPress, páginas organizadas

> Para Claude: si arrancás una sesión nueva en este proyecto, leé este archivo
> completo antes de proponer o aplicar cualquier cambio. Tiene el contexto que
> no se repite en cada conversación.

Origen: `gastab.WordPress.20260910.xml` (exportación WXR del 2026-09-10), 31 páginas
totales. Todo lo que hay acá es una **foto de ese momento**, no el estado en vivo
del sitio — si pasó tiempo desde el export, conviene confirmar contra wp-admin
antes de asumir que algo sigue igual.

Repo: https://github.com/diegobuzza-ecomm/gastab

## Git — comandos básicos

Desde esta carpeta, después de cualquier cambio en `paginas/`, `paginas-campos/`
o `manifest.csv`:

```
git add -A
git commit -m "Descripción corta del cambio"
git push
```

`git status` en cualquier momento te muestra qué archivos cambiaron desde el
último commit. `git log --oneline` muestra el historial.

## Estructura

- `manifest.csv` — listado maestro: slug, título, tipo, parent, url, archivo.
- `paginas/*.html` — 20 páginas de contenido clásico (HTML plano en `content:encoded`,
  se editan pegando el HTML completo en el editor de WordPress). Las imágenes ya
  vienen como URL completa dentro del HTML, no hace falta resolver nada.
- `paginas-campos/*.json` — 8 páginas construidas con campos personalizados (ACF) del tema,
  no con el editor de contenido. Cada JSON es `campo: valor` con solo los campos que
  tienen contenido real (se descartaron ~200 campos vacíos de módulos de demo del tema
  sin usar). Acá sí hubo que resolver: los valores que eran ID de imagen se
  reemplazaron por `[imagen] título -> URL real`.
- 3 páginas vacías (`recursos`, `politica-de-privacidad`, `terminos-del-servicio`):
  sin contenido ni campos en el export.

  **Pendiente**: confirmar en wp-admin si estas 3 tienen contenido real en el sitio
  en vivo. Es posible que el export haya quedado incompleto para ellas — no asumir
  que están vacías de verdad hasta chequearlo.

### Cómo se clasificó cada página (classic_html / campos_acf / vacía)

Fue una clasificación heurística mía a partir del XML, no un dato que WordPress
exporte directamente: miré si `content:encoded` tenía texto real (y no el
placeholder de ejemplo que trae WordPress por default) y si había campos ACF
con valor. Si en algún momento una página no encaja bien en su categoría (por
ejemplo, contenido mezclado entre HTML y campos), puede ser un caso límite de
esta heurística — avisame y lo reviso puntual.

## Tipo `campos_acf` — importante

Estas páginas (`inicio`, `contacto`, `quienes-somos`, `combustible`,
`grupos-electrogenos`, `lubricantes`, `urea-32`, `gracias`) NO se editan pegando HTML:
cada campo del JSON corresponde a un cuadro de texto/imagen distinto en el editor
de WordPress (metabox de campos personalizados). Un cambio ahí implica editar
campo por campo, no un solo bloque de texto.

## Flujo para cambios que tocan varias páginas

1. Pedís el cambio.
2. Busco el texto/patrón en `paginas/*.html` y `paginas-campos/*.json`, muestro qué
   páginas matchean y el diff propuesto.
3. Con tu ok, aplico el cambio y te doy, página por página, el contenido final
   listo para pegar (HTML completo para `paginas/`, o el listado de campos a
   actualizar para `paginas-campos/`).
4. Vos commiteás y pusheás con los comandos de arriba.

Todo versionado con git en esta carpeta: cada cambio queda como commit con diff.