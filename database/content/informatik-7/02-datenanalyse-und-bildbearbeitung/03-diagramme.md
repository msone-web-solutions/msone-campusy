---
title: "Daten mit Diagrammen visualisieren"
intro: "Aus Zahlenkolonnen werden Bilder: Säulen-, Balken- und Kreisdiagramme in der Tabellenkalkulation erstellen, beschriften und richtig auswählen."
curriculum_ref: "Daten in einem Tabellenkalkulationsprogramm visualisieren; Erstellen von Diagrammen: Kreisdiagramm, Säulen- oder Balkendiagramm; Auswahl und Eignung von Datensätzen für Analysezwecke beurteilen"
estimated_minutes: 25
reflect: "Erkläre, wann du ein Kreisdiagramm und wann ein Säulendiagramm wählst, und was ein Diagramm mindestens braucht, damit andere es verstehen."
---
## Erklärung

### Warum Diagramme?

Eine Tabelle mit 30 Zahlen liest niemand gern. Ein Diagramm zeigt auf einen Blick: Was ist am größten? Wie ist die Entwicklung? Wie verteilt sich das Ganze? Aus dem Mathe-Themenfeld Prozentrechnung kennst du die Diagrammarten – hier lernst du, sie mit dem Computer aus echten Daten zu erzeugen.

### Die Diagrammarten und wann sie passen

**Säulendiagramm** (senkrecht) und **Balkendiagramm** (waagerecht): vergleichen Werte verschiedener Kategorien. Lieblingssport in der Klasse, Umsatz pro Monat, Einwohner pro Stadt. Balken sind praktisch, wenn die Kategorienamen lang sind.

**Kreisdiagramm**: zeigt, wie sich ein **Ganzes** in Anteile aufteilt. Wahlergebnis, Zusammensetzung der Luft, Ausgaben des Taschengelds. Nur sinnvoll, wenn die Teile zusammen 100 % ergeben – und höchstens 5–6 Teile, sonst wird es unlesbar.

**Liniendiagramm**: Entwicklung über die Zeit. Temperatur im Jahresverlauf, Gewicht eines Haustiers, Punktestand pro Spieltag.

Falsche Wahl: Ein Kreisdiagramm für die Monatstemperaturen (die ergeben kein Ganzes) oder ein Liniendiagramm für Lieblingssportarten (keine zeitliche Reihenfolge).

::: check
type: single_choice
prompt: "Welches Diagramm passt für „Wie verteilen sich die 25 Stimmen bei der Klassensprecherwahl auf 3 Kandidaten?“"
options: ["Liniendiagramm", "Kreisdiagramm", "Keins"]
answer: { index: 1 }
explanation: "Anteile an einem Ganzen → Kreisdiagramm."
:::

### So erstellst du ein Diagramm

1. **Daten vorbereiten**: Kategorien in einer Spalte, Werte daneben, Überschriften in der ersten Zeile. Keine leeren Zeilen dazwischen.
2. **Markieren**: den Bereich mit Überschriften und Werten, z. B. A1:B6.
3. **Einfügen → Diagramm** und den Typ wählen. Das Programm zeichnet einen Vorschlag.
4. **Beschriften**: Diagrammtitel, Achsentitel (mit Einheit!), gegebenenfalls Legende und Datenbeschriftung (Werte an den Säulen bzw. Prozent an den Kreissektoren).
5. **Prüfen**: Beginnt die y-Achse bei 0? Sind die Farben unterscheidbar? Ist alles lesbar?

Das Diagramm ist mit den Daten **verknüpft**: Änderst du eine Zahl in der Tabelle, ändert sich das Diagramm.

### Ein Diagramm gut beschriften

Ein Diagramm ohne Titel und Achsenbeschriftung ist wertlos – niemand weiß, was gezeigt wird. Pflicht:

- **Titel**: „Lieblingssport der Klasse 7b (n = 25)“
- **Achsentitel mit Einheit**: „Anzahl Schüler“, „Temperatur in °C“
- **Legende**, wenn mehrere Datenreihen (z. B. Jungen und Mädchen als zwei Säulen nebeneinander)
- **Quelle und Datum**, wenn die Daten von woanders stammen

::: check
type: multiple_choice
prompt: "Was gehört zu jedem Diagramm?"
options: ["Titel", "Achsentitel mit Einheit", "3D-Effekt", "Legende bei mehreren Datenreihen"]
answer: { indexes: [0, 1, 3] }
explanation: "Titel, Achsen mit Einheit, Legende – 3D verzerrt nur."
:::

### Welche Daten eignen sich?

Nicht jede Tabelle taugt für jede Auswertung. Fragen vor dem Diagramm:

- Sind die Daten **vollständig**? (Fehlen Antworten?)
- Sind sie **vergleichbar**? (Gleiche Einheit, gleicher Zeitraum?)
- Reicht die **Menge**? Bei 4 Befragten sagt „50 % mögen Fußball“ wenig.
- Passen die Daten zur **Frage**? Wer wissen will, ob der Schulweg länger geworden ist, braucht Daten aus zwei Jahren, nicht aus einem.

### Beispiel: Umfrage auswerten

Klasse 7b, Frage „Wie kommst du zur Schule?“, 25 Antworten. Tabelle: A = Verkehrsmittel (zu Fuß, Rad, Bus, Auto), B = Anzahl (7, 10, 5, 3). Markieren A1:B5, Kreisdiagramm mit Prozent-Datenbeschriftung: Rad 40 %, zu Fuß 28 %, Bus 20 %, Auto 12 %. Titel: „Schulweg der 7b (n = 25)“. Fertig – und wenn morgen jemand vom Auto aufs Rad wechselt, änderst du nur die Zahl.

### Diagramme lesen – und misstrauen

Auch selbst gemachte Diagramme können täuschen: Eine y-Achse, die bei 20 statt 0 beginnt, macht aus einem kleinen Unterschied einen großen. 3D-Diagramme verzerren. Prüfe deine Diagramme so kritisch wie fremde (Mathe-Thema 6.2).

## Hefteintrag

**Diagramme in der Tabellenkalkulation**

| Diagramm | Wofür |
|---|---|
| **Säulen / Balken** | Kategorien vergleichen (Lieblingssport, Umsatz pro Monat) |
| **Kreis** | Anteile am Ganzen (Wahlergebnis, Luft); Teile ergeben 100 %, max. 5–6 Teile |
| **Linie** | Entwicklung über die Zeit (Temperatur, Punktestand) |

**Erstellen:** 1. Daten vorbereiten (Kategorien + Werte, Überschriften) · 2. Bereich markieren · 3. Einfügen → Diagramm → Typ · 4. beschriften · 5. prüfen
Das Diagramm ist mit den Daten verknüpft – ändert sich die Zahl, ändert sich das Bild.

**Pflicht-Beschriftung:** Titel (mit n) · Achsentitel mit Einheit · Legende bei mehreren Reihen · Quelle

**Daten prüfen:** vollständig? vergleichbar? genug? passend zur Frage?

**Kritisch bleiben:** y-Achse ab 0, keine 3D-Verzerrung.
