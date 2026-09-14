---
title: "Unterprogramme: Teilprobleme lösen"
intro: "Große Aufgaben in kleine zerlegen, eigene Bausteine definieren und mit Parametern flexibel machen."
curriculum_ref: "Unterprogramme zur Lösung von Teilproblemen nutzen; Lösungsmöglichkeiten für Problemstellungen in Gruppen planen; Fachbegriff: Unterprogramm"
estimated_minutes: 25
reflect: "Erkläre, was ein Unterprogramm ist und warum es besser ist, ein Haus aus den Unterprogrammen „Wand“, „Dach“ und „Fenster“ zu zeichnen statt aus einer langen Liste von Befehlen."
---
## Erklärung

### Zerlegen: Das Geheimnis großer Programme

Ein Spiel wie Minecraft hat Millionen Zeilen Code. Niemand kann das als eine lange Liste überblicken. Der Trick heißt **Zerlegen**: Man teilt das große Problem in kleine **Teilprobleme**, löst jedes für sich und setzt die Lösungen zusammen.

Beispiel: Ein Haus zeichnen. Teilprobleme: eine Wand (Rechteck), ein Dach (Dreieck), ein Fenster (kleines Quadrat), eine Tür. Jedes Teilproblem bekommt ein eigenes **Unterprogramm**.

### Was ist ein Unterprogramm?

Ein **Unterprogramm** ist ein benannter Block von Anweisungen, den man **definiert** (einmal aufschreibt) und dann beliebig oft **aufruft** (benutzt). In Scratch heißt das „Neuer Block“ („Meine Blöcke“), in Textsprachen **Funktion** oder **Prozedur** (`def`).

```
definiere Quadrat
    wiederhole 4 mal
        gehe 50 Schritte
        drehe dich um 90 Grad
```

Danach gibt es einen neuen Baustein `Quadrat`, den du überall einsetzen kannst – wie einen eigenen Befehl. Das Hauptprogramm wird kurz und lesbar:

```
Wand
Dach
Fenster
Fenster
Tür
```

::: check
type: gap_text
prompt: "Ein Unterprogramm wird einmal ___ und kann dann beliebig oft ___ werden."
answer:
  gaps:
    - ["definiert"]
    - ["aufgerufen"]
explanation: "Definieren = aufschreiben, Aufrufen = benutzen."
:::

### Warum Unterprogramme?

1. **Keine Wiederholung**: Fenster einmal definieren, viermal aufrufen. Ändert sich das Fenster, änderst du es an einer Stelle.
2. **Lesbarkeit**: `Dach` sagt mehr als zwölf Zeilen „gehe, drehe, gehe“.
3. **Fehlersuche**: Zeichnet das Dach falsch, weißt du, wo du suchen musst.
4. **Teamarbeit**: Jeder im Team baut ein Unterprogramm, am Ende werden sie zusammengesteckt. Deshalb plant man Programme in der Gruppe zuerst als Liste von Teilproblemen.

### Parameter: Unterprogramme flexibel machen

Ein Quadrat mit fester Seite 50 ist unpraktisch. Besser: Das Unterprogramm bekommt beim Aufruf einen Wert mit – einen **Parameter**.

```
definiere Quadrat (seite)
    wiederhole 4 mal
        gehe (seite) Schritte
        drehe dich um 90 Grad
```

Aufruf: `Quadrat (30)` zeichnet ein kleines, `Quadrat (120)` ein großes Quadrat. Der Parameter ist eine Variable, die beim Aufruf ihren Wert bekommt. Mehrere Parameter gehen auch: `Rechteck (breite) (höhe)`.

::: check
type: single_choice
prompt: "Was ist bei „Quadrat (seite)“ das Wort „seite“?"
options: ["Ein Fehler", "Ein Parameter – ein Wert, den man beim Aufruf mitgibt", "Der Name des Unterprogramms"]
answer: { index: 1 }
explanation: "Der Parameter macht das Unterprogramm flexibel: Quadrat (30), Quadrat (120)."
:::

### Rückgabewerte

Manche Unterprogramme geben ein Ergebnis zurück, zum Beispiel `Mittelwert (a) (b)` liefert (a + b) / 2. In Scratch macht man das über eine Variable, die das Unterprogramm setzt; in Textsprachen mit `return`. So kann das Hauptprogramm mit dem Ergebnis weiterrechnen.

### Ein Beispiel: Quiz-Spiel zerlegen

Aufgabe: Ein Quiz mit 5 Fragen, Punktezählung und Ergebnisanzeige.

Teilprobleme → Unterprogramme:
- `FrageStellen (fragetext) (richtigeAntwort)`: fragt, prüft, erhöht bei Treffer `punkte`
- `ErgebnisAnzeigen`: sagt „Du hast … von 5“ und je nach Punktzahl einen Kommentar

Hauptprogramm:
```
setze punkte auf 0
FrageStellen ("Hauptstadt von Sachsen-Anhalt?") ("Magdeburg")
FrageStellen ("7 mal 8?") ("56")
… (drei weitere)
ErgebnisAnzeigen
```

Fünf Fragen, sechs Zeilen Hauptprogramm. Und eine sechste Frage ist eine Zeile mehr.

### Bausteine, die es schon gibt

Viele Unterprogramme musst du gar nicht selbst schreiben: `Zufallszahl von 1 bis 6`, `Länge von (text)`, `runde (zahl)` – das sind fertige Unterprogramme der Programmiersprache. Programmieren heißt oft, die richtigen vorhandenen Bausteine zu kennen und geschickt zu kombinieren.

## Hefteintrag

**Unterprogramme**

Große Probleme **zerlegen** in Teilprobleme → jedes Teilproblem wird ein **Unterprogramm**.

Ein **Unterprogramm** ist ein benannter Anweisungsblock: einmal **definieren**, beliebig oft **aufrufen**. (Scratch: „Neuer Block“; Textsprachen: Funktion, `def`)

```
definiere Quadrat (seite)
    wiederhole 4 mal
        gehe (seite) Schritte
        drehe dich um 90 Grad
```
Aufruf: `Quadrat (30)`, `Quadrat (120)`

**Parameter** = Wert, den man beim Aufruf mitgibt (hier `seite`). Macht das Unterprogramm flexibel.
**Rückgabewert** = Ergebnis, das das Unterprogramm zurückliefert (z. B. `Mittelwert (a) (b)`).

**Vorteile:** keine Wiederholung · lesbar · leichter Fehler finden · Teamarbeit (jeder ein Teil)

Hauptprogramm wird kurz: `Wand · Dach · Fenster · Fenster · Tür`
