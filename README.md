# GASTAB - WordPress, páginas organizadas

Origen: `gastab.WordPress.20260910.xml` (exportación WXR), 31 páginas totales.

## Estructura

- `manifest.csv` — listado maestro: slug, título, tipo, parent, url, archivo.
- `paginas/*.html` — 20 páginas de contenido clásico (HTML plano en `content:encoded`,
  se editan pegando el HTML completo en el editor de WordPress).
- `paginas-campos/*.json` — 8 páginas construidas con campos personalizados (ACF) del tema,
  no con el editor de contenido. Cada JSON es `campo: valor` con solo los campos que
  tienen contenido real (se descartaron ~200 campos vacíos de módulos de demo del tema
  sin usar). Los valores que son imágenes se resolvieron a su URL real.
- 3 páginas vacías (`recursos`, `politica-de-privacidad`, `terminos-del-servicio`):
  sin contenido ni campos en el export. Revisar en wp-admin si tienen contenido real
  antes de tocarlas (puede que el export esté incompleto para esas 3).

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

Todo versionado con git en esta carpeta: cada cambio queda como commit con diff.
