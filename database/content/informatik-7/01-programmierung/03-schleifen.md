---
title: "Schleifen: Wiederholungen im Programm"
intro: "Statt zehnmal dasselbe zu schreiben: Zählschleifen und bedingte Schleifen, Schleifenvariablen und die Gefahr der Endlosschleife."
curriculum_ref: "einfache Programme mit Schleifen in einer blockbasierten Sprache entwickeln; Programmstrukturen: Schleifen (for, while); Fachbegriff: Schleife"
estimated_minutes: 30
reflect: "Erkläre den Unterschied zwischen einer Zählschleife und einer bedingten Schleife und nenne für jede ein Beispiel."
---
## Erklärung

### Wiederholen statt kopieren

Ein Quadrat zeichnen: gehe 100 Schritte, drehe dich um 90°, gehe 100, drehe 90°, gehe 100, drehe 90°, gehe 100, drehe 90°. Vier Mal dasselbe. Bei einem 100-Eck wären es 200 Bausteine. Dafür gibt es **Schleifen**: Ein Block von Anweisungen wird **mehrfach ausgeführt**.

```
wiederhole 4 mal
    gehe 100 Schritte
    drehe dich um 90 Grad
```

Die Anweisungen in der Schleife heißen **Schleifenkörper**. Jeder Durchlauf heißt **Iteration**.

### Die Zählschleife (for)

Wenn du **vorher weißt, wie oft** wiederholt werden soll, nimmst du die **Zählschleife**: „wiederhole n mal“. In Textsprachen heißt sie `for`.

Oft braucht man dabei eine **Zählvariable**, die mitzählt: Beim ersten Durchlauf 1, dann 2, dann 3 …

```
setze i auf 1
wiederhole 10 mal
    sage (i * 7)
    ändere i um 1
```

Das gibt das 7er-Einmaleins aus. In Textsprachen gibt es dafür die Kurzform `for i in 1..10`.

::: check
type: numeric
prompt: "„wiederhole 8 mal: gehe 50 Schritte, drehe dich um 45 Grad“ – wie viele Ecken hat die gezeichnete Figur?"
answer: { value: 8 }
explanation: "8 Durchläufe, 8 Drehungen um 45° (= 360°) → ein Achteck."
:::

### Die bedingte Schleife (while)

Wenn du **nicht weißt, wie oft**, sondern nur, **solange** oder **bis** etwas gilt, nimmst du die **bedingte Schleife**. In Scratch: „wiederhole bis Bedingung“. In Textsprachen: `while` („solange“).

```
wiederhole bis tipp = geheimzahl
    frage "Dein Tipp?" und warte
    setze tipp auf Antwort
sage "Richtig!"
```

Die Schleife läuft, solange der Tipp falsch ist – das können 1 oder 50 Durchläufe sein. Vor jedem Durchlauf wird die Bedingung geprüft.

Achtung beim Übersetzen: Scratch sagt „wiederhole **bis** X“, Textsprachen sagen „**solange** nicht X“. Gleiche Idee, umgekehrte Formulierung.

### Die Endlosschleife

„wiederhole fortlaufend“ läuft ohne Ende – in Spielen genau richtig (die Figur soll ständig auf Tasten reagieren). Aber bei einer bedingten Schleife ist eine Endlosschleife oft ein **Fehler**: Wenn die Bedingung nie wahr wird, hängt das Programm.

```
setze i auf 1
wiederhole bis i > 10
    sage i
```

Hier fehlt `ändere i um 1` – i bleibt 1, die Schleife endet nie. Merke: In einer bedingten Schleife muss sich **im Körper etwas ändern**, das die Bedingung beeinflusst.

::: check
type: single_choice
prompt: "„setze i auf 1 · wiederhole bis i > 10 · sage i“ – ohne „ändere i um 1“. Was passiert?"
options: ["Das Programm gibt 1 bis 10 aus", "Endlosschleife – i bleibt immer 1", "Das Programm gibt nur 10 aus"]
answer: { index: 1 }
explanation: "Im Körper ändert sich nichts, die Bedingung i > 10 wird nie wahr."
:::

### Schleifen verschachteln

Eine Schleife in einer Schleife: Für jede Zeile (äußere Schleife) alle Spalten (innere Schleife).

```
wiederhole 3 mal          ← Zeilen
    wiederhole 5 mal      ← Spalten
        stemple Stern
        gehe 20 nach rechts
    gehe zum Zeilenanfang, 20 nach unten
```

Ergebnis: 3 · 5 = 15 Sterne in einem Raster. Die innere Schleife läuft bei jedem äußeren Durchlauf komplett durch.

### Schleifen und Variablen zusammen: Summe bilden

```
setze summe auf 0
setze i auf 1
wiederhole 100 mal
    ändere summe um i
    ändere i um 1
sage summe
```

Ergebnis: 5050 (die Summe von 1 bis 100). Die Variable `summe` sammelt, `i` zählt. Dieses Muster – **Akkumulator** – brauchst du ständig: Punkte zählen, Preise addieren, Mittelwert bilden.

::: check
type: numeric
prompt: "„wiederhole 4 mal (wiederhole 6 mal: stemple)“ – wie viele Stempel entstehen?"
answer: { value: 24 }
explanation: "4 · 6 = 24."
:::

### Welche Schleife wann?

- Anzahl bekannt („10 Fragen stellen“, „100-Eck zeichnen“) → **Zählschleife**
- Anzahl unbekannt („bis der Tipp stimmt“, „solange Leben > 0“) → **bedingte Schleife**
- Für immer („Spielfigur steuern“) → **Endlosschleife** (absichtlich)

## Hefteintrag

**Schleifen**

Eine **Schleife** führt einen Block von Anweisungen (den **Schleifenkörper**) mehrfach aus. Ein Durchlauf = **Iteration**.

**Zählschleife (for):** Anzahl vorher bekannt.
```
wiederhole 4 mal
    gehe 100 Schritte
    drehe dich um 90 Grad
```
Mit **Zählvariable**: `setze i auf 1` … `ändere i um 1`

**Bedingte Schleife (while):** läuft, solange / bis eine Bedingung gilt. Anzahl unbekannt.
```
wiederhole bis tipp = geheimzahl
    frage "Dein Tipp?" und warte
    setze tipp auf Antwort
```
Scratch „wiederhole bis X“ = Textsprache „solange nicht X“.

**Endlosschleife:** `wiederhole fortlaufend` – in Spielen gewollt. Als Fehler, wenn sich im Körper nichts ändert und die Bedingung nie wahr wird.

**Verschachtelte Schleifen:** innere Schleife läuft bei jedem äußeren Durchlauf komplett (3 Zeilen × 5 Spalten = 15).

**Akkumulator-Muster:** `setze summe auf 0`, in der Schleife `ändere summe um i` → Summe 1 bis 100 = 5050.
