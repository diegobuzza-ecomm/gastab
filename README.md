# GASTAB - WordPress, páginas organizadas

> Para Claude: leé este archivo completo antes de proponer o aplicar
> cualquier cambio en este proyecto. Tiene el contexto que no se repite en
> cada conversación.

Origen: `gastab.WordPress.20260910.xml` (export WXR del 2026-09-10), 31
páginas. Es una **foto de ese momento**, no el estado en vivo del sitio —
si pasó tiempo, confirmar contra wp-admin antes de asumir que algo sigue igual.

Repo: https://github.com/diegobuzza-ecomm/gastab

## Git — comandos básicos

Desde esta carpeta, después de cualquier cambio en `paginas/` o `manifest.csv`:

```
git add -A
git commit -m "Descripción corta del cambio"
git push
```

`git status` muestra qué cambió desde el último commit. `git log --oneline`,
el historial.

## Estructura

- `manifest.csv` — listado maestro: slug, título, tipo, parent, url, archivo.
- `seo-meta.csv` — keyword y meta description por página, columna `estado`
  (listo / pendiente / revisar).
- `paginas/*.html` — HTML plano (`content:encoded`), se edita pegando el
  HTML completo en el editor de WordPress. Las rutas dentro de esta carpeta
  son un **espejo exacto de la URL**: página sin padre → archivo suelto
  (`paginas/diesel-500.html` → `/diesel-500/`); página con padre → una
  subcarpeta por cada nivel (`paginas/combustible/pergamino.html` →
  `/combustible/pergamino/`). Las imágenes ya vienen como URL completa
  dentro del HTML.
- 3 páginas vacías en el export (`recursos`, `politica-de-privacidad`,
  `terminos-del-servicio`) — **pendiente** confirmar en wp-admin si tienen
  contenido real en el sitio en vivo (el export puede haber quedado
  incompleto para ellas).

### `paginas-campos/` — borrada, ya no se usa

Diego decidió no trabajar con páginas ACF desde este repo, para no generar
ruido. Existía para reflejar 8 páginas con campos personalizados del tema
(`inicio`, `contacto`, `quienes-somos`, `combustible`, `grupos-electrogenos`,
`lubricantes`, `urea-32`, `gracias`) — esas páginas **siguen existiendo en
WordPress**, solo que ya no se mantiene acá un espejo de su contenido. Si
hay que tocarlas, es directo en wp-admin, campo por campo (nunca se editaban
pegando HTML). Las filas de `manifest.csv` tipo `campos_acf` quedan
apuntando a un archivo que ya no existe — esperado, no es un error.

**Para el proyecto de zonas (más abajo): `combustible` y `grupos-electrogenos`
se siguen usando como página superior (padre) de las páginas de zona.** Es
la misma página de WordPress — dejar de mantener su contenido ACF acá no
tiene nada que ver con usarla como padre de otras páginas.

## Flujo para cambios que tocan varias páginas

1. Pedís el cambio.
2. Busco el texto/patrón en `paginas/**/*.html`, muestro qué páginas
   matchean y el diff propuesto.
3. Con tu ok, te doy el HTML completo de cada página lista para pegar.
4. Vos commiteás y pusheás con los comandos de arriba.

## Estado del trabajo de SEO (actualizado 2026-09-10)

### Hecho
- Keyword + meta description (≤144 caracteres) para 28 de las 31 páginas
  (`seo-meta.csv`).
- `euro-diesel.html` reescrito (tenía pegado por error el contenido de
  `transporte-de-combustible.html`, duplicado). Falta definirle keyword/meta.

### Pendiente / hallazgos abiertos

1. **Contenido de otro rubro en Inicio y Quiénes somos** — antes de borrar
   `paginas-campos/` se vio que el módulo de stats de `inicio` tenía
   contenido sobre "Hormigón Celular" (otro rubro, sin relación), FAQs lorem
   ipsum, tabs genéricos; en `quienes-somos`, equipo/testimonios con
   "Full name"/"Job title" y logos de `mati.agency`. Contenido demo del
   tema sin reemplazar. **Confirmar en wp-admin si esos módulos están
   activos en el sitio en vivo** — si se ven, es prioridad número uno. Como
   ya no hay archivo local, esto se revisa directo ahí.

2. **Páginas delgadas que compiten por la misma keyword** (posible
   canibalización): `proveedor-de-combustible` vs
   `abastecimiento-de-combustible-para-empresas`; `gasoil-para-obra` vs
   `recarga-en-obra-in-situ`; `recarga-de-combustible` (su título real es
   "Recarga de grupos electrógenos") vs `recarga-de-grupos-electrogenos`.
   Estas 3 + `mantenimiento-grupos-electrogenos` comparten los mismos
   bloques genéricos y son las únicas sin `alt` en sus imágenes — parecen
   versiones viejas sin actualizar.

3. **Teléfono/WhatsApp inconsistente**: `wa.me/5491153017642` en la mayoría
   de páginas, `wa.me/1153017642` en `gasoil-a-granel`, `0810 222 9754` y
   `11 5263 5929` en contacto. Afecta el NAP para SEO local. **Para páginas
   nuevas se usa solo `0810 222 9754` + link a `/contacto/`, sin WhatsApp**,
   hasta que esto se resuelva de fondo.

4. **Falta `alt`** en imágenes de `gasoil-a-granel` (4/9), `gasoil-para-obra`
   (0/5), `mantenimiento-grupos-electrogenos` (0/6), `proveedor-de-combustible`
   (0/5), `recarga-de-combustible` (0/5).

5. **3 páginas vacías del export** — ver arriba.

6. **`gracias`** (página post-formulario) sin contenido propio — sugerido
   `noindex` en el plugin SEO en vez de definirle metadatos.

## Proyecto: páginas zonificadas por zona de cobertura (iniciado 2026-09-12)

Páginas nuevas segmentadas por zona geográfica, keyword "servicio + zona",
para no competir con la keyword general de las páginas existentes.

### Los 2 servicios

1. **Combustible para agro e industria, desde 1000 litros.** Umbral más
   bajo que `gasoil-a-granel` (5000L+) — ofertas distintas, no se pisan.
   **No usar "a granel"** para este servicio (excluye implícitamente los
   pedidos chicos): decir "combustible para agro e industria" o el volumen
   directo. "A granel" sigue siendo correcto solo para `gasoil-a-granel`.
2. **Mantenimiento y reparación de grupos electrógenos**, incluyendo
   servicio de tanque (vaciado, limpieza, reposición de combustible).

Alcance: hasta 700 km desde la base de Gastab en La Tablada (real,
confirmado por Diego — no aspiracional).

### Las 10 zonas

| # | Zona | Slug |
|---|------|------|
| 1 | Campana – Zárate | `campana-zarate` |
| 2 | Rosario – San Lorenzo | `rosario-san-lorenzo` |
| 3 | San Nicolás – Ramallo | `san-nicolas-ramallo` |
| 4 | Pergamino | `pergamino` |
| 5 | Junín | `junin` |
| 6 | Chivilcoy – Bragado | `chivilcoy-bragado` |
| 7 | 9 de Julio | `9-de-julio` |
| 8 | Rafaela | `rafaela` |
| 9 | Santa Fe – Sauce Viejo | `santa-fe-sauce-viejo` |
| 10 | La Plata – Berisso – Ensenada | `la-plata-berisso-ensenada` |

Varias caen en Santa Fe, no solo Buenos Aires. Una sola página por zona
(no se abre por ciudad individual dentro de zonas combinadas).

### Jerarquía y URLs

Todo (páginas de zona + índice de zonas) cuelga de la página de categoría
principal del menú, no de una página específica de servicio:

| | Padre (página superior en WP) | URL de zona | Índice de zonas |
|---|---|---|---|
| Combustible | `Combustible` (`/combustible/`) | `/combustible/<zona>/` | `/combustible/zonas-de-cobertura/` |
| Grupos electrógenos | `Grupos electrógenos` (`/grupos-electrogenos/`) | `/grupos-electrogenos/<zona>/` | `/grupos-electrogenos/zonas-de-cobertura/` |

Páginas relacionadas que deben sumar (pendiente) un link hacia el índice de
zonas correspondiente — no son el padre de URL, solo cruzan link:
- Combustible: `abastecimiento-de-combustible-para-empresas` (hub anterior),
  `gasoil-a-granel`, `diesel-500`, `euro-diesel`, `transporte-de-combustible`.
- Grupos electrógenos: `mantenimiento-grupos-electrogenos`,
  `reparacion-de-grupos-electrogenos`, `limpieza-de-tanques`,
  `recarga-de-grupos-electrogenos`.

Total previsto: 20 páginas de zona + 2 índices = 22 páginas nuevas. No van
al menú principal, solo enlazadas internamente (madre relacionada ↔ índice
↔ zona).

Archivos (ver regla de espejo en "Estructura" arriba):
- `paginas/combustible/pergamino.html` y
  `paginas/combustible/zonas-de-cobertura.html`
- `paginas/grupos-electrogenos/pergamino.html` y
  `paginas/grupos-electrogenos/zonas-de-cobertura.html`

(el slug real terminó siendo `zonas-de-cobertura` para el índice, no
`zona-de-combustible`/`zona-de-grupos-electrogenos` como se nombraba acá
al planear el proyecto — corregido 2026-09-28, son las mismas 2 páginas)

### Cómo se evita el contenido duplicado entre zonas

Nada de bloques genéricos tipo "por qué esta zona" (no aporta valor a quien
ya vive ahí). En cambio, cada página nombra las **localidades reales del
partido/departamento** que también cubre (fuente oficial/Wikipedia) — útil
de verdad (confirma cobertura de pueblos chicos) y distinto en cada zona
por naturaleza. La zona también queda marcada en JSON-LD (`Service` +
`areaServed` tipo `City`, con `containedInPlace` a la provincia). Cada
página además linkea, en tarjetas, a las páginas generales relacionadas de
su servicio.

### Imágenes

3 placeholders por página (estilo `.img-placeholder`, ya usado en
`limpieza-de-tanques.html`), con el nombre de archivo esperado escrito
adentro para que Diego suba la imagen con ese nombre exacto:
`<servicio>-<zona>-mapa.jpg`, `-01.jpg`, `-02.jpg`.

### Contacto en páginas nuevas

Solo botón a `/contacto/` + `0810-222-9754` (`tel:08102229754`). Sin
WhatsApp — ver hallazgo 3 de SEO arriba.

### Estado actual (actualizado 2026-09-19)

**Las 22 páginas nuevas están generadas y versionadas:**
- 20 páginas de zona (10 zonas × 2 servicios), formato validado con el
  piloto de Pergamino: hero (texto izq. / imagen der.), localidades reales
  cubiertas (fuente Wikipedia/oficial), features con ícono + borde rojo,
  tarjetas a servicios relacionados, FAQ propia de la zona, CTA con
  contacto + teléfono (botones parejos en alto/ancho, ícono SVG blanco),
  JSON-LD con `areaServed` (`City` única o array de `City` para zonas que
  combinan más de un partido/departamento).
- 2 índices de zona (`zonas-de-cobertura`, uno por servicio),
  con tarjetas a las 10 zonas y JSON-LD `ItemList`.
- Las páginas relacionadas (5 de combustible + 4 de grupos electrógenos)
  ya tienen el link al índice correspondiente agregado antes del CTA final
  — **excepto `reparacion-de-grupos-electrogenos`**: tenía el link agregado
  en local pero WordPress no lo tiene; corregido 2026-09-28 sacándolo del
  local (ver sección de abajo). Si se quiere ese link ahí, hay que
  agregarlo primero en WordPress.
- `manifest.csv` y `seo-meta.csv` actualizados con las 22 filas nuevas
  (`seo-meta.csv` usa `combustible/<slug>` y `grupos-electrogenos/<slug>`
  como clave, ya que el slug de WordPress se repite entre servicios).

**Formato de Pergamino aprobado por Diego** (incluye el ajuste final del
botón de contacto: texto "Contacto", ícono de teléfono en SVG blanco,
"Atención 24/7", botones parejos en alto y ancho). Confirmado 2026-09-28:
sí está cargado y publicado en WordPress (ver estado de publicación abajo).

**Pendiente:**
- Subir las imágenes de cada zona (nombre de archivo esperado, dentro del
  placeholder de cada página) y reemplazar los `.img-placeholder`.

**Limpieza pendiente en el proyecto local** (Claude no puede borrar/mover
archivos en la compu de Diego, solo escribir — lo hace él a mano):
carpeta `paginas-zonas/`, y las carpetas `combustible/` y
`grupos-electrogenos/` sueltas en la raíz del proyecto (no confundir con
`paginas/combustible/` y `paginas/grupos-electrogenos/`, esas quedan).

### Estado actual (actualizado 2026-09-28)

**Regla de sincronización local vs WordPress: WordPress gana.** Si hay
diferencia entre un archivo de `paginas/` y el contenido real en WordPress,
se corrige el LOCAL para que quede igual a WP — no al revés — salvo que
Diego pida explícitamente lo contrario para un caso puntual.

**Publicación en WordPress** (confirmado contra export WXR
`gastab.WordPress.2026-09-28 (3).xml`, pubDate 23:18 GMT): de las 20
páginas de zona + `zonas-de-cobertura` (combustible y grupos-electrogenos),
**solo Pergamino (ambos servicios) está en estado `publish`**. Las 9 zonas
restantes + `zonas-de-cobertura` están en `draft` — cargadas en WordPress
pero no publicadas. **Diego confirmó que esto está bien así por ahora, no
es un pendiente** (no se va a publicar todavía).

**Diff completo local vs WordPress (2026-09-28), único hallazgo real:**
- `reparacion-de-grupos-electrogenos.html` tenía de más el bloque cross-link
  "¿Estás fuera del AMBA? Conocé nuestra cobertura de grupos electrógenos
  por zona" que WordPress no tiene. Corregido: se sacó del local (WP gana).
- Resto de páginas de zona y páginas top-level: contenido idéntico
  local/WordPress (incluida la pregunta de FAQ "¿...o solo en el AMBA?" en
  `grupos-electrogenos/pergamino.html` y
  `grupos-electrogenos/la-plata-berisso-ensenada.html`, que está en ambos
  lados — no es un bug, no se toca).

**Bug ya resuelto (no acá, directo en WordPress):** entre el export
`(2)` (22:58 GMT) y el `(3)` (23:18 GMT) del 2026-09-28, la página en vivo
`https://gastab.com.ar/limpieza-de-tanques/` tenía cargado por error el
contenido de "Reparación de Grupos Electrógenos 24/7" en vez del propio.
Se corrigió directo en WordPress; el archivo local nunca tuvo el problema.

**Corrección de compliance (no negociable, verificar en cualquier
contenido nuevo):** no se hace análisis in-situ del combustible. Se toma
muestra y contramuestra, que se analizan solo si se requiere después. El
sitio no debe decir "análisis en el momento/in-situ".
