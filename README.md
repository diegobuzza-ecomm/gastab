# GASTAB - WordPress, páginas organizadas

> Para Claude: leé este archivo completo antes de proponer o aplicar
> cualquier cambio en este proyecto. Tiene el contexto que no se repite en
> cada conversación.

Origen: `gastab.WordPress.20260910.xml` (export WXR del 2026-09-10), 31
páginas. Export más reciente en la carpeta: `gastab.WordPress.2026-10-07.xml`
(54 páginas, incluye las 22 de zonas y `que-resolvemos`). Cada export es una
**foto de ese momento**, no el estado en vivo del sitio — si pasó tiempo,
confirmar contra wp-admin antes de asumir que algo sigue igual.

Repo: https://github.com/diegobuzza-ecomm/gastab

## Git — comandos básicos

Desde esta carpeta, después de cualquier cambio en `paginas/`, `manifest.csv`
o el tema (`wp-content/wp-content/themes/gastab/`):

```
git add -A
git commit -m "Descripción corta del cambio"
git push
```

`git status` muestra qué cambió desde el último commit. `git log --oneline`,
el historial.

## Estructura

- `wp-content/` — copia de `wp-content` del servidor (bajada con el file
  manager el 2026-10-07; queda anidada: `wp-content/wp-content/`). **Solo se
  versiona el tema `themes/gastab/`**; el resto (plugins, uploads, cache,
  `debug.log`) está excluido en `.gitignore`. Los cambios al tema se suben
  al servidor a mano con el file manager, en la misma ruta.
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
- `que-resolvemos` (`/que-resolvemos/`, publicada en WP el 2026-09-10):
  página índice "¿Qué necesitás?" con tarjetas por situación que linkean a
  los servicios. Agregada a los CSV el 2026-10-07 (faltaba); keyword y meta
  description pendientes.
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

3. **Teléfono/WhatsApp inconsistente** — *resuelto en los HTML (2026-09-28)*.
   Único teléfono válido: `0810-222-9754` (`tel:08102229754`). No hay
   WhatsApp oficial: se reemplazaron todos los `wa.me/...`,
   `+54 9 11 5301-7642` y `11 5263 5929`. **Pendiente en WordPress**:
   `contacto` (campos `contact_whatsapp` / teléfono con `11 5263 5929`) y
   `quienes-somos` (link `wa.me/1153017642`).

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

**Imágenes — resuelto (verificado 2026-10-07):** las 20 páginas de zona ya
no tienen `.img-placeholder`. Cada una usa 3 imágenes reales: el mapa propio
de la zona (`<zona>-mapa.jpg`; en 9 de Julio, `mapa-9-de-julio.jpg`) y 2
imágenes compartidas por las 20 páginas (`camion-gastab-opaco2-1.jpg` y
`generador-con-operador-opaco-1.jpg`), no las `-01`/`-02` por zona que se
planearon.

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

**Publicación en WordPress** (actualizado 2026-10-07, contra export
`gastab.WordPress.2026-10-07.xml`): **las 20 páginas de zona y los 2
`zonas-de-cobertura` están en `publish`** (publicadas el 2026-10-06).
Hasta el 2026-09-28 solo Pergamino estaba publicada y el resto en `draft`.

**Diff local vs WordPress (2026-10-07, último export 13:24):** las 43 páginas de `paginas/`
(21 sueltas + 11 `combustible/` + 11 `grupos-electrogenos/`)
coinciden con WordPress (3 difieren solo en espacios/saltos de línea:
`mantenimiento-grupos-electrogenos`, `proveedor-de-combustible`,
`gasoil-para-obra`).

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
contenido nuevo):** Gastab no hace análisis del combustible en destino. Se
toma muestra y contramuestra en cada entrega. **El sitio no debe mencionar
"análisis" del combustible en ningún formato** (ni "análisis de calidad", ni
"disponibles para análisis", ni "analizada/analizado"). Al revisar, buscar
todas las variantes (`anali`, `análi`), no solo "análisis".

Aplicado 2026-10-07, pegado en WordPress y verificado contra export:
- Tanda 1 (17 páginas): `diesel-500`, `euro-diesel`,
  `abastecimiento-de-combustible-para-empresas`,
  `abastecimiento-de-emergencia-24hs`, `transporte-de-combustible`,
  `gasoil-a-granel`, `que-resolvemos` y las 10 `combustible/<zona>`.
- Tanda 2 (7 páginas, "Cada gota es analizada y registrada" y variantes →
  "Cada entrega queda registrada, con muestra y contramuestra"):
  `gasoil-a-granel`, `gasoil-para-obra`, `mantenimiento-grupos-electrogenos`,
  `proveedor-de-combustible`, `recarga-de-combustible`,
  `recarga-en-obra-in-situ`, `recarga-nautica`.

**Pendiente — "análisis" en páginas ACF** (no están en este repo, se editan
campo por campo en wp-admin):
- `quienes-somos`: ítem de lista "Análisis de calidad de productos."
- `quienes-somos`: campo `benefits_items_2_description` ("Cada gota es
  analizada y registrada.").
- `combustible`: campo `delivery_items_1_title` ("Calidad garantizada:
  Análisis de calidad de productos y trazabilidad.").
- `combustible`: campo `manuals_items_7_title` "Análisis térmico" (link a
  `Analisis-Termico.pdf`) — parece un manual descargable, no una promesa de
  servicio; Diego decide si queda.

## Landings de campaña: combustible para generadores (2026-10-07)

3 landings para campañas pagas, pensadas para cortes de luz y generadores
inundados. Clientes: empresas y consorcios de vivienda. Foco: emergencia y
llegada rápida. Cobertura: desde CABA hasta 300 km (dato de Diego).

| Slug | Enfoque | Keyword Yoast |
|---|---|---|
| `corte-de-luz-combustible-generador` | urgencia directa ("¿Se cortó la luz?") | combustible para generadores eléctricos |
| `diesel-para-generadores` | por cliente (empresas / consorcios) | diesel para generadores eléctricos |
| `combustible-generador-emergencia` | por situación (corte / inundado / tanque vacío) | combustible para generadores eléctricos |

- Publicadas el 2026-10-07, sin página padre y fuera del menú.
- **Las 3 van con `noindex`** (Yoast → Avanzado), porque comparten keyword
  y casi todo el contenido: indexadas competirían entre sí. Sirven como
  destino de anuncios (un grupo de anuncios por landing) para medir cuál
  convierte mejor. Si alguna pasa a indexable, revisar canibalización con
  `recarga-de-grupos-electrogenos` y `abastecimiento-de-emergencia-24hs`.
- JSON-LD `Service` con `areaServed` `GeoCircle` (centro CABA, radio 300 km)
  y `url` propia de cada página.
- Solo usan datos que ya están en el sitio: 24/7, emergencia en menos de 8
  horas, desde 200 litros por surtidor con ticket, Diesel 500 para
  generadores estacionarios, reparación multimarca, extracción/filtrado de
  combustible, equipos de respaldo en alquiler.
- **Pendiente confirmar:** que la entrega en menos de 8 horas valga para
  todo el radio de 300 km.
- El HTML fuente de las 3 opciones también está en `Claude outputs/`
  (`combustible-para-generadores-opcion-1/2/3.html` + previews).
- **Pendiente:** verificar contra el próximo export que el contenido en WP
  coincide con `paginas/` y que las 3 tienen `_yoast_wpseo_meta-robots-noindex`.

## Formulario de contacto (home y Contacto) — 2026-10-07

- El formulario al pie de la home (sección `#contacto`) y el de la página
  Contacto salen del tema, no del contenido de la página:
  `page-home.php` → `module_contact()` (`templates/modules/module-contact.php`)
  → `contactFormExternal()` (`inc/functions/contactFormExternal.php`).
  `page-contact.php` llama a la misma función.
- El título y la descripción sobre el formulario salen del campo ACF
  `contact` de la página Contacto (se editan en wp-admin).
- **Cambio aplicado y probado en el sitio:** `contactFormExternal.php` ahora
  muestra el formulario de **Zoho Forms** "Contacto" (iframe
  `forms.zohopublic.com/gastab1/form/Contacto/...`) en lugar del script del
  Web Form de Zoho CRM. Los campos se editan en forms.zoho.com.
- Se eliminó del archivo el código muerto (form PHP viejo, después de un
  `return`), que incluía la clave secreta de reCAPTCHA en texto plano.
  **Pendiente:** rotar esa clave en Google reCAPTCHA si sigue en uso.
- Si en wp-admin → Site options → Forms se activa "Enable external code" y
  se carga código, ese código reemplaza al iframe (sin duplicar).
- El iframe tiene `height:500px` (valor de Zoho); ajustar si se corta.
- Aparte: 5 páginas (`gasoil-a-granel`, `mantenimiento-grupos-electrogenos`,
  `proveedor-de-combustible`, `gasoil-para-obra`, `recarga-de-combustible`)
  tienen el script **viejo** de Zoho CRM pegado en su contenido —
  **pendiente** decidir si se reemplaza por el de Zoho Forms.
