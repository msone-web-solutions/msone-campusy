---
title: "Variablen, Datentypen, Ein- und Ausgabe"
intro: "Wie ein Programm sich Dinge merkt: Variablen als beschriftete Schachteln, die vier wichtigsten Datentypen und der Weg von der Eingabe zur Ausgabe."
curriculum_ref: "Alltagsinformationen auf grundlegende informatische Datentypen übertragen; Variablen und Datentypen verknüpfen; Fachbegriffe: Variable, Ein-/Ausgabe, Datentyp; grundlegende Datentypen: int, string, float, boolean"
estimated_minutes: 25
reflect: "Erkläre, was eine Variable ist, und ordne drei Angaben aus deinem Alltag (z. B. Alter, Name, Körpergröße) den passenden Datentypen zu."
---
## Erklärung

### Ein Programm ist eine Anleitung

Ein **Programm** ist eine Folge von Anweisungen, die der Computer Schritt für Schritt ausführt – wie ein Rezept. In Klasse 5/6 hast du erste Programme in einer **blockbasierten Sprache** wie Scratch gebaut: Man steckt Bausteine zusammen, statt Text zu tippen. Damit arbeiten wir weiter. Die Ideen sind in jeder Programmiersprache dieselben.

Jedes Programm hat drei Teile: **Eingabe** (Daten kommen hinein – Tastatur, Maus, Sensor), **Verarbeitung** (das Programm rechnet, vergleicht, entscheidet) und **Ausgabe** (das Ergebnis kommt heraus – Bildschirm, Ton, Motor). Das nennt man das **EVA-Prinzip**.

### Variablen: beschriftete Schachteln

Damit ein Programm rechnen kann, muss es sich Werte merken. Dafür gibt es **Variablen**. Stell dir eine Variable als **Schachtel mit Beschriftung** vor: Auf der Schachtel steht der **Name** (z. B. `punkte`), in der Schachtel liegt der **Wert** (z. B. 12). Man kann den Wert jederzeit **auslesen** oder durch einen neuen **ersetzen**.

In Scratch: Baustein „setze `punkte` auf 0“, später „ändere `punkte` um 1“. Nach drei Treffern steht in der Schachtel 3.

Gute Variablennamen sagen, was drin ist: `punkte`, `name`, `alter`, `geschwindigkeit` – nicht `a`, `x1` oder `ding`. Namen ohne Leerzeichen und Umlaute, klein geschrieben.

::: check
type: single_choice
prompt: "Welcher Variablenname ist gut gewählt für die Anzahl der Leben in einem Spiel?"
options: ["x", "leben", "ding1"]
answer: { index: 1 }
explanation: "Ein Name soll sagen, was in der Schachtel liegt."
:::

### Datentypen: Was für eine Sorte Wert?

Nicht jeder Wert ist gleich. Ein Programm muss wissen, ob es mit einer Zahl rechnen oder einen Text anzeigen soll. Die Sorte eines Werts heißt **Datentyp**. Die vier wichtigsten:

| Datentyp | Fachname | Beispiele | Was man damit macht |
|---|---|---|---|
| **Ganze Zahl** | `int` (integer) | 0, 7, −3, 2026 | zählen, rechnen |
| **Kommazahl** | `float` | 1,75 · 3,14 · −0,5 | messen, rechnen |
| **Text** | `string` (Zeichenkette) | "Alexa", "Hallo!", "7b" | anzeigen, vergleichen, zusammensetzen |
| **Wahrheitswert** | `boolean` | wahr / falsch (true / false) | Bedingungen prüfen |

Texte stehen in **Anführungszeichen**. `"7"` ist ein Text (man kann ihn nicht mal 2 nehmen), `7` ist eine Zahl.

**Alltag in Datentypen übersetzen:**
- Alter: 13 → int
- Körpergröße: 1,62 m → float
- Vorname: "Mia" → string
- Hat einen Bibliotheksausweis: ja → boolean (true)
- Postleitzahl: "06108" → string! (führende Null, man rechnet nicht damit)
- Note: 2 → int; Durchschnitt: 2,3 → float

::: check
type: single_choice
prompt: "Welcher Datentyp passt zur Körpergröße 1,62 m?"
options: ["int", "float", "string", "boolean"]
answer: { index: 1 }
explanation: "Eine Kommazahl ist ein float."
:::

### Ein- und Ausgabe

**Eingabe:** In Scratch fragt der Baustein „frage `Wie heißt du?` und warte“ den Nutzer; die Antwort landet in der Variable `Antwort`. In Textsprachen heißt das oft `input()`.

**Ausgabe:** „sage `Hallo!` für 2 Sekunden“ zeigt Text an. In Textsprachen `print()`.

Ein erstes vollständiges Programm:

```
frage "Wie heißt du?" und warte
setze name auf Antwort
frage "Wie alt bist du?" und warte
setze alter auf Antwort
sage (verbinde "Hallo " name "! Nächstes Jahr bist du " (alter + 1))
```

Eingabe (zwei Fragen) → Verarbeitung (alter + 1, Text zusammensetzen) → Ausgabe (sage).

### Rechnen und Texte verbinden

Mit Zahlen rechnet man: `punkte + 1`, `preis * anzahl`, `summe / 2`. Texte setzt man zusammen, das heißt **verketten**: `verbinde "Hallo " name`. Aus 3 und "3" wird beim Verketten "33", beim Rechnen 6 – der Datentyp entscheidet.

::: check
type: single_choice
prompt: "Was kommt heraus, wenn man die Texte \"3\" und \"3\" verkettet?"
options: ["6", "\"33\"", "9"]
answer: { index: 1 }
explanation: "Texte werden aneinandergehängt, nicht addiert."
:::

### Zuweisung ist kein Gleichheitszeichen

`setze punkte auf punkte + 1` heißt nicht „punkte ist gleich punkte plus 1“ (das wäre in Mathe unmöglich). Es heißt: **Nimm den alten Wert, rechne 1 dazu, lege das Ergebnis wieder in die Schachtel.** Das ist eine **Zuweisung**.

## Hefteintrag

**Variablen, Datentypen, Ein- und Ausgabe**

**Programm** = Folge von Anweisungen. **EVA-Prinzip:** Eingabe → Verarbeitung → Ausgabe.

**Variable** = beschriftete Schachtel: **Name** (z. B. `punkte`) und **Wert** (z. B. 12). Der Wert kann gelesen und ersetzt werden.
`setze punkte auf 0` · `ändere punkte um 1`
**Zuweisung:** `setze punkte auf punkte + 1` = alten Wert nehmen, 1 dazu, zurücklegen.

**Datentypen:**
| Typ | Fachname | Beispiel |
|---|---|---|
| ganze Zahl | int | 13, −3 |
| Kommazahl | float | 1,62 |
| Text | string | "Mia" (in Anführungszeichen) |
| Wahrheitswert | boolean | wahr / falsch |

`"7"` ist Text, `7` ist Zahl. Postleitzahl "06108" → string.

**Eingabe:** `frage … und warte` → Antwort · **Ausgabe:** `sage …`
Zahlen: rechnen (+ − · :) · Texte: **verketten** (`verbinde "Hallo " name`)
