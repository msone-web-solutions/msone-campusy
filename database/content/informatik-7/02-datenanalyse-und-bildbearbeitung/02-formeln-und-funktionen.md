---
title: "Formeln, Funktionen, Autoausfüllen und bedingte Formatierung"
intro: "Mit = beginnt das Rechnen: Formeln mit Zellbezügen, SUMME und MITTELWERT, das Ausfüllkästchen und Zellen, die sich automatisch einfärben."
curriculum_ref: "einfache Berechnungen mit Datensätzen planen und durchführen; einfache Berechnungen in Tabellen: Summe, Mittelwert; Autoausfüllen; einfache bedingte Formatierung"
estimated_minutes: 30
reflect: "Erkläre, warum man in einer Formel Zellbezüge wie B2 statt der Zahl selbst schreibt, und wie das Autoausfüllen die Bezüge anpasst."
---
## Erklärung

### Formeln beginnen mit =

Tippst du in eine Zelle `3+4`, steht dort der Text „3+4“. Tippst du **`=3+4`**, rechnet das Programm und zeigt **7**. Das Gleichheitszeichen sagt: „Das ist eine Formel, rechne!“

Rechenzeichen: `+` `-` `*` (mal) `/` (geteilt). Punkt vor Strich gilt, Klammern auch: `=(2+3)*4` ergibt 20.

### Zellbezüge statt Zahlen

Die eigentliche Stärke: In Formeln schreibt man nicht die Zahlen, sondern die **Adressen der Zellen**, in denen sie stehen.

| | A | B | C | D |
|---|---|---|---|---|
| 1 | Artikel | Anzahl | Einzelpreis | Gesamt |
| 2 | Heft | 3 | 0,85 € | **=B2*C2** |

In D2 erscheint 2,55 €. Änderst du die Anzahl in B2 auf 5, wird D2 sofort 4,25 €. Die Formel bleibt gültig, die Tabelle rechnet neu. Das ist ein **Zellbezug**.

::: check
type: single_choice
prompt: "In B2 steht 4, in C2 steht 5. Was zeigt eine Zelle mit „=B2*C2“?"
options: ["B2*C2", "20", "45"]
answer: { index: 1 }
explanation: "Die Formel rechnet mit den Zellinhalten: 4 · 5 = 20."
:::

### Funktionen: SUMME, MITTELWERT und mehr

Für häufige Berechnungen gibt es fertige **Funktionen**. Sie haben einen Namen und in Klammern die Zellen, mit denen sie arbeiten:

- **=SUMME(B2:B10)** addiert alle Zellen von B2 bis B10.
- **=MITTELWERT(C2:C10)** berechnet den Durchschnitt.
- **=MIN(C2:C10)** und **=MAX(C2:C10)**: kleinster und größter Wert.
- **=ANZAHL(B2:B10)**: wie viele Zahlen stehen im Bereich?
- **=RUNDEN(D2;2)**: rundet auf 2 Dezimalstellen.

Statt `=B2+B3+B4+B5+B6` schreibst du `=SUMME(B2:B6)`. Das Summensymbol Σ in der Symbolleiste fügt SUMME automatisch ein und schlägt den Bereich vor – prüfe, ob er stimmt!

Beispiel Notendurchschnitt: Noten in B2 bis B8, in B9 steht `=MITTELWERT(B2:B8)`. Ergebnis 2,43 – mit RUNDEN auf 2,4.

### Autoausfüllen: Formeln kopieren

Du hast in D2 die Formel `=B2*C2`. Für die Zeilen 3 bis 20 musst du sie nicht neu tippen: Klicke D2 an, fasse das kleine **Ausfüllkästchen** rechts unten in der Zellecke und ziehe es nach unten. Das Programm kopiert die Formel und **passt die Bezüge an**: In D3 steht `=B3*C3`, in D4 `=B4*C4` …

Das nennt man **relative Bezüge**: Die Formel merkt sich nicht „B2“, sondern „zwei Zellen links von mir“.

Autoausfüllen funktioniert auch mit Reihen: Tippst du 1 und 2 in zwei Zellen, markierst beide und ziehst, entsteht 3, 4, 5 … Aus „Montag“ wird Dienstag, Mittwoch …; aus „Jan“ wird Feb, Mär …; aus 02.09.2026 wird 03.09., 04.09. …

::: check
type: single_choice
prompt: "In D2 steht „=B2+C2“. Du ziehst die Formel mit dem Ausfüllkästchen nach D5. Was steht in D5?"
options: ["=B2+C2", "=B5+C5", "=D2+D5"]
answer: { index: 1 }
explanation: "Relative Bezüge verschieben sich mit: Zeile 5 → B5+C5."
:::

### Absolute Bezüge mit $

Manchmal soll sich ein Bezug **nicht** verschieben. Beispiel: In B1 steht der Mehrwertsteuersatz 19 %. Die Formel für den Bruttopreis in D2: `=C2*(1+B1)`. Zieht man sie nach unten, wird daraus `=C3*(1+B2)` – falsch, B2 ist kein Steuersatz. Lösung: `=C2*(1+$B$1)`. Das Dollarzeichen fixiert Spalte und Zeile. Beim Ausfüllen bleibt $B$1 stehen, C2 wird zu C3, C4 … Taste **F4** setzt die Dollarzeichen.

### Bedingte Formatierung: Zellen, die reagieren

Mit **bedingter Formatierung** färbt sich eine Zelle automatisch je nach Inhalt:

- Noten schlechter als 4 → rot hinterlegt
- Umsatz über 1000 € → grün
- Der größte Wert im Bereich → fett

Menü: Format → Bedingte Formatierung → Regel („Zellwert größer als …“) → Formatierung wählen. Es gibt auch **Farbskalen** (von grün über gelb nach rot) und **Datenbalken** (ein Balken in der Zelle, dessen Länge dem Wert entspricht). Ändert sich der Wert, ändert sich die Farbe sofort.

::: check
type: single_choice
prompt: "Welche Funktion berechnet den Notendurchschnitt der Zellen B2 bis B8?"
options: ["=SUMME(B2:B8)", "=MITTELWERT(B2:B8)", "=MAX(B2:B8)"]
answer: { index: 1 }
explanation: "MITTELWERT = Durchschnitt."
:::

### Eine Auswertung planen

Bevor du losklickst: Was soll herauskommen? Beispiel Klassenumfrage „Schulweg-Minuten“: 1. Daten in eine Spalte (ein Wert pro Zeile), 2. darunter MITTELWERT, MIN, MAX, 3. bedingte Formatierung: über 30 Minuten rot, 4. Diagramm (nächstes Thema). Erst planen, dann bauen – wie beim Programmieren.

## Hefteintrag

**Formeln und Funktionen**

Eine **Formel** beginnt mit **=**. Rechenzeichen: + − * /  Klammern erlaubt.
`=3+4` → 7 · `=(2+3)*4` → 20

**Zellbezug:** in Formeln Adressen statt Zahlen. `=B2*C2` – ändert sich B2, wird neu gerechnet.

**Funktionen:**
`=SUMME(B2:B10)` addiert · `=MITTELWERT(B2:B10)` Durchschnitt · `=MIN(…)` · `=MAX(…)` · `=ANZAHL(…)` · `=RUNDEN(D2;2)`

**Autoausfüllen:** Ausfüllkästchen (rechts unten an der Zelle) ziehen → Formel wird kopiert, Bezüge werden angepasst (**relativer Bezug**): aus `=B2*C2` wird `=B3*C3`. Auch für Reihen: 1, 2 → 3, 4 …; Montag → Dienstag …

**Absoluter Bezug:** `$B$1` bleibt beim Ausfüllen fest (Taste F4). Z. B. Steuersatz in B1: `=C2*(1+$B$1)`

**Bedingte Formatierung:** Zelle färbt sich je nach Wert (Format → Bedingte Formatierung). Note > 4 rot, Farbskalen, Datenbalken.
