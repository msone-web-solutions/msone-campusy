---
title: "Digitale Bilder: Pixel, Vektor, Auflösung und Binärcode"
intro: "Wie ein Computer ein Bild speichert – aus Nullen und Einsen, Pixel für Pixel oder als Formel – und was Auflösung bedeutet."
curriculum_ref: "Grafiken bezüglich der Bildauflösung vergleichen; Fachbegriffe: Pixelgrafik, Vektorgrafik, Bildauflösung, Binärcode; Grafiken: Binärcode als Schwarz-Weiß-Darstellung"
estimated_minutes: 30
reflect: "Erkläre den Unterschied zwischen Pixel- und Vektorgrafik und wann welche Art besser ist."
---
## Erklärung

### Der Computer kennt nur 0 und 1

Alles im Computer – Texte, Zahlen, Bilder, Musik – wird als Folge von **Nullen und Einsen** gespeichert: dem **Binärcode**. Ein einzelnes 0 oder 1 heißt **Bit**, acht Bits sind ein **Byte**. Warum nur zwei Zeichen? Weil ein Schalter zwei Zustände hat: Strom an oder aus. Milliarden solcher Schalter stecken in jedem Chip.

### Das einfachste Bild: Schwarz-Weiß im Binärcode

Stell dir ein Raster aus 8 × 8 Kästchen vor. Jedes Kästchen ist entweder schwarz (1) oder weiß (0). Zeile für Zeile aufgeschrieben ergibt das 64 Bits – und das ist schon ein Bild:

```
00111100        ░░████░░
01000010        ░█░░░░█░
10100101        █░█░░█░█
10000001        █░░░░░░█
10100101        █░█░░█░█
10011001        █░░██░░█
01000010        ░█░░░░█░
00111100        ░░████░░
```

Ein Smiley aus 64 Bits (8 Byte). Jedes Kästchen ist ein **Pixel** (picture element, Bildpunkt). So funktionieren im Prinzip alle Fotos und Bildschirme – nur mit viel mehr Pixeln und mehr Farben.

::: check
type: numeric
prompt: "Ein Schwarz-Weiß-Bild hat 16 × 16 Pixel. Wie viele Bit braucht es?"
answer: { value: 256 }
explanation: "16 · 16 = 256 Pixel, je 1 Bit."
:::

### Farben brauchen mehr Bits

Mit 1 Bit pro Pixel gibt es nur schwarz oder weiß. Mit 8 Bit (1 Byte) pro Pixel: 256 Graustufen. Für Farbe speichert man pro Pixel drei Werte – **Rot, Grün, Blau (RGB)**, je 0 bis 255. Das sind 3 Byte pro Pixel und 256 · 256 · 256 = 16,7 Millionen mögliche Farben. Rot ist (255, 0, 0), Weiß (255, 255, 255), Schwarz (0, 0, 0), Gelb (255, 255, 0).

### Pixelgrafik (Rastergrafik)

Ein Foto ist eine **Pixelgrafik**: ein Raster aus Millionen farbiger Punkte. Vorteile: fotorealistisch, jedes Detail speicherbar. Nachteile: Beim **Vergrößern** werden die Pixel als Klötzchen sichtbar (das Bild „verpixelt“), und die Datei ist groß. Formate: JPG, PNG, GIF, BMP. Programme: GIMP, Photoshop, Paint, die Foto-App.

### Vektorgrafik

Eine **Vektorgrafik** speichert keine Pixel, sondern **Formen mit Formeln**: „Kreis mit Mittelpunkt (50|50), Radius 20, Füllfarbe rot“; „Linie von A nach B, 2 Pixel breit“. Der Computer zeichnet das Bild jedes Mal neu. Vorteile: **beliebig vergrößerbar ohne Qualitätsverlust**, kleine Dateien, leicht änderbar (Farbe ändern = ein Wert). Nachteile: für Fotos ungeeignet – ein Gesicht lässt sich nicht aus Kreisen und Linien beschreiben. Formate: SVG, PDF (teilweise), Schriften. Programme: Inkscape, Illustrator.

Logos, Icons, Schriften, Landkarten, Diagramme → Vektor. Fotos, Scans, Screenshots → Pixel.

::: check
type: single_choice
prompt: "Ein Schullogo soll auf Visitenkarte und Plakat gleich scharf sein. Welche Grafikart?"
options: ["Pixelgrafik", "Vektorgrafik"]
answer: { index: 1 }
explanation: "Vektorgrafiken lassen sich beliebig vergrößern."
:::

### Auflösung

Die **Bildauflösung** sagt, aus wie vielen Pixeln ein Bild besteht: Breite × Höhe. 1920 × 1080 Pixel (Full HD) sind gut 2 Millionen Pixel = 2 **Megapixel**. Ein Handyfoto hat 12 Megapixel (4000 × 3000). 4K sind 3840 × 2160.

Bei Druck und Bildschirm spricht man von **Pixeldichte**: dpi (dots per inch) oder ppi (pixels per inch) – wie viele Pixel auf 2,54 cm. Für Druck braucht man etwa 300 dpi, Bildschirme haben 100 bis 450 ppi.

Höhere Auflösung = mehr Details, aber auch mehr Speicherplatz. Ein Bild mit 12 Megapixeln in RGB braucht unkomprimiert 12 000 000 · 3 Byte = 36 Megabyte! Deshalb komprimiert man Bilder (nächstes Thema).

::: check
type: numeric
prompt: "Ein Bild hat 1000 × 1000 Pixel in RGB (3 Byte pro Pixel). Wie viele Megabyte unkomprimiert? (1 MB = 1 000 000 Byte)"
options: { unit: "MB" }
answer: { value: 3 }
explanation: "1 000 000 Pixel · 3 Byte = 3 000 000 Byte = 3 MB."
:::

### Auflösung vergleichen

Ein 100 × 100-Pixel-Bild als Profilbild sieht scharf aus. Auf ein Plakat gedruckt wird jedes Pixel 1 cm groß – ein Klötzchenbild. Umgekehrt ist ein 4000 × 3000-Foto als Icon Verschwendung: Es wird auf 32 × 32 verkleinert, der Rest weggeworfen. Regel: **Auflösung passend zum Verwendungszweck** wählen.

## Hefteintrag

**Digitale Bilder**

Der Computer speichert alles als **Binärcode** (0 und 1). 1 **Bit** = 0 oder 1, 8 Bit = 1 **Byte**.

**Schwarz-Weiß-Bild:** Raster aus Kästchen, 1 = schwarz, 0 = weiß. Jedes Kästchen ist ein **Pixel** (Bildpunkt). 8 × 8 Pixel = 64 Bit = 8 Byte.

**Farbe:** pro Pixel 3 Werte **RGB** (Rot, Grün, Blau, je 0–255) = 3 Byte → 16,7 Mio. Farben.
Rot (255,0,0) · Weiß (255,255,255) · Schwarz (0,0,0)

| | Pixelgrafik | Vektorgrafik |
|---|---|---|
| speichert | Raster aus Farbpunkten | Formen als Formeln (Kreis, Linie …) |
| vergrößern | verpixelt | ohne Qualitätsverlust |
| Dateigröße | groß | klein |
| geeignet für | Fotos, Scans | Logos, Icons, Schriften, Karten |
| Formate | JPG, PNG, GIF | SVG |

**Auflösung** = Breite × Höhe in Pixeln. Full HD 1920 × 1080 ≈ 2 Megapixel; Handyfoto 12 MP.
**Pixeldichte** dpi/ppi: Druck ca. 300 dpi.
Speicher unkomprimiert: Pixelzahl · 3 Byte (12 MP → 36 MB).
Auflösung passend zum Zweck wählen.
