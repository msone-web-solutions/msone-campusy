---
title: "Kompression, Bildbearbeitung und Echtheit von Bildern"
intro: "Warum ein JPG kleiner ist als ein PNG, welches Format wofür passt, wie man Bilder bearbeitet – und warum man Bildern nicht blind trauen darf."
curriculum_ref: "Formate von Grafiken bezüglich ihrer Kompression vergleichen; unterschiedliche Grafikformate geeigneten Anwendungszwecken zuordnen; Grafiken bearbeiten: Farbfilter, zuschneiden, drehen; digitale Bilder auf ihre Authentizität hinterfragen; Ergebnisse von Bildbearbeitungen analysieren und bewerten"
estimated_minutes: 30
reflect: "Erkläre den Unterschied zwischen verlustfreier und verlustbehafteter Kompression und nenne je ein Bildformat und einen passenden Einsatz."
---
## Erklärung

### Warum komprimieren?

Ein 12-Megapixel-Foto braucht unkomprimiert 36 Megabyte. Ein Handy mit 1000 Fotos wäre voll. Deshalb werden Bilder **komprimiert** – verkleinert, indem man überflüssige Information weglässt oder geschickter speichert. Es gibt zwei grundlegend verschiedene Arten.

### Verlustfreie Kompression

Bei der **verlustfreien Kompression** wird nichts weggeworfen – die Daten werden nur cleverer aufgeschrieben. Beispiel: Statt „weiß weiß weiß weiß weiß weiß weiß weiß“ speichert man „8 × weiß“. Das nennt man Lauflängenkodierung. Beim Öffnen entsteht das Bild **exakt** wieder – jedes Pixel wie vorher.

Funktioniert gut bei Bildern mit großen einfarbigen Flächen (Logos, Screenshots, Zeichnungen), schlecht bei Fotos (jedes Pixel ist etwas anders). Formate: **PNG**, **GIF** (nur 256 Farben), BMP (unkomprimiert), ZIP für alles.

### Verlustbehaftete Kompression

Bei der **verlustbehafteten Kompression** wird Information **weggelassen**, die das Auge kaum wahrnimmt: feine Farbunterschiede in einer Himmelsfläche, winzige Details. Das Bild wird viel kleiner – aus 36 MB werden 3 MB – aber es ist **nicht mehr exakt** das Original. Bei starker Kompression sieht man **Artefakte**: Klötzchen, Farbstufen, unscharfe Kanten.

Format: **JPG** (JPEG). Die Stärke der Kompression stellt man beim Speichern ein („Qualität 90 %“). Jedes erneute Speichern verschlechtert das Bild weiter – deshalb Originale aufheben. Auch MP3 (Musik) und MP4 (Video) sind verlustbehaftet.

::: check
type: single_choice
prompt: "Ein JPG wird zehnmal geöffnet, leicht bearbeitet und wieder als JPG gespeichert. Was passiert?"
options: ["Nichts, JPG ist verlustfrei", "Die Qualität sinkt bei jedem Speichern weiter", "Die Datei wird zum PNG"]
answer: { index: 1 }
explanation: "JPG komprimiert verlustbehaftet – jedes Speichern wirft Information weg."
:::

### Welches Format wofür?

| Format | Kompression | Besonderheit | Einsatz |
|---|---|---|---|
| **JPG** | verlustbehaftet | klein, 16,7 Mio. Farben | Fotos, Webseiten, Social Media |
| **PNG** | verlustfrei | Transparenz möglich | Logos, Screenshots, Grafiken mit Text |
| **GIF** | verlustfrei | nur 256 Farben, Animation | kurze Animationen, einfache Grafiken |
| **SVG** | Vektor | beliebig skalierbar | Logos, Icons |
| **BMP / TIFF** | keine / verlustfrei | sehr groß | Druckvorlagen, Archiv |
| **HEIC / WebP** | verlustbehaftet, effizienter als JPG | neuer | Handyfotos, Web |

Faustregel: **Foto → JPG. Grafik mit Text oder Transparenz → PNG. Logo → SVG.**

::: check
type: single_choice
prompt: "Ein Screenshot mit viel Text soll gespeichert werden. Welches Format?"
options: ["JPG", "PNG", "MP3"]
answer: { index: 1 }
explanation: "PNG ist verlustfrei – Text bleibt scharf, keine Artefakte."
:::

### Bilder bearbeiten: die Grundwerkzeuge

Jedes Bildprogramm (GIMP, Paint.NET, Foto-App, Photopea im Browser) hat diese Werkzeuge:

- **Zuschneiden** (Crop): Ränder wegschneiden, Bildausschnitt wählen, Störendes entfernen. Ändert die Auflösung.
- **Drehen und Spiegeln**: um 90° oder frei, z. B. schiefer Horizont.
- **Größe ändern** (Skalieren): Pixelzahl verringern (verkleinern geht immer) oder erhöhen (vergrößern erfindet Pixel – wird unscharf).
- **Farbfilter und Korrekturen**: Helligkeit, Kontrast, Sättigung, Schwarz-Weiß, Sepia, Weichzeichnen, Schärfen. Filter in Social-Media-Apps sind nichts anderes als vorgefertigte Kombinationen davon.
- **Ebenen**: Bildteile übereinanderlegen, Text einfügen.
- **Retusche**: Störendes wegstempeln, Hautunreinheiten entfernen, Objekte löschen oder einfügen – heute oft per **KI** mit einem Klick („Objekt entfernen“, „Hintergrund ersetzen“).

Beim Speichern: Original behalten, Bearbeitung unter neuem Namen speichern, Format passend wählen.

### Wann ist ein Bild noch echt?

Ein bisschen Helligkeit korrigieren – kein Problem. Aber wo ist die Grenze? Zuschneiden kann den Zusammenhang verfälschen (die Person, die daneben stand, ist weg). Retusche kann Körper verändern. KI kann Personen an Orte setzen, an denen sie nie waren, oder komplett neue „Fotos“ erzeugen (**Deepfakes**).

So prüfst du die **Authentizität** eines Bildes:

1. **Quelle**: Wer hat es veröffentlicht? Seriöses Medium oder anonymer Account?
2. **Rückwärtssuche** (Google Bilder, TinEye): Wo taucht das Bild sonst auf? Ist es älter, aus einem anderen Zusammenhang?
3. **Details**: Schatten in verschiedene Richtungen? Sechs Finger? Unleserlicher Text im Hintergrund? Verschwommene Übergänge? Typische KI-Fehler.
4. **Plausibilität**: Passt das Bild zu dem, was man sonst weiß?
5. **Metadaten**: Kamera, Datum, Ort stecken oft in der Datei (EXIF) – können aber auch entfernt oder gefälscht sein.

Merke: Ein Bild ist ein **Beleg, kein Beweis**. Und: Was du an fremden Bildern kritisierst, gilt auch für deine eigenen Profilbilder (Thema Medienethik).

::: check
type: multiple_choice
prompt: "Welche Hinweise sprechen dafür, dass ein Bild KI-generiert oder manipuliert ist?"
options: ["Schatten in verschiedene Richtungen", "Eine Hand mit sechs Fingern", "Das Bild ist bunt", "Unleserlicher Text im Hintergrund"]
answer: { indexes: [0, 1, 3] }
explanation: "Typische KI-Fehler: Schatten, Finger, Text. Farbigkeit sagt nichts."
:::

### Bearbeitung bewerten

Beurteile ein bearbeitetes Bild nach der Absicht: Wurde es **verbessert** (Helligkeit, Zuschnitt) oder **verfälscht** (Inhalt verändert, Aussage gedreht)? Ist die Bearbeitung **gekennzeichnet**? Würde die abgebildete Person zustimmen? In Nachrichtenmedien gilt: Inhalt darf nicht verändert werden – sonst ist es Manipulation.

## Hefteintrag

**Kompression, Bildbearbeitung, Echtheit**

**Kompression** verkleinert Bilddateien.
- **verlustfrei**: nichts geht verloren, nur geschickter gespeichert („8 × weiß“). PNG, GIF. Gut für Logos, Screenshots.
- **verlustbehaftet**: unauffällige Details werden weggelassen, Bild viel kleiner, aber nicht mehr exakt. Bei starker Kompression **Artefakte**. JPG (auch MP3, MP4). Gut für Fotos.

**Formate:** Foto → **JPG** · Grafik mit Text/Transparenz → **PNG** · Animation → GIF · Logo/Icon → **SVG**

**Bearbeiten:** Zuschneiden · Drehen/Spiegeln · Größe ändern (vergrößern wird unscharf) · Farbfilter (Helligkeit, Kontrast, Sättigung, S/W) · Ebenen · Retusche (heute oft KI)
Original behalten, Bearbeitung unter neuem Namen speichern.

**Echtheit prüfen:** 1. Quelle · 2. Rückwärtssuche · 3. Details (Schatten, Finger, Text) · 4. Plausibilität · 5. Metadaten
Ein Bild ist ein Beleg, kein Beweis. **Deepfake** = KI-gefälschtes Bild/Video.

**Bewerten:** verbessert oder verfälscht? gekennzeichnet? Zustimmung der Person?
