---
title: "Bedingte Anweisungen und Verzweigungen"
intro: "Wenn … dann … sonst: Wie ein Programm Entscheidungen trifft – mit Vergleichen, Wahrheitswerten und verschachtelten Bedingungen."
curriculum_ref: "einfache Programme mit Bedingungen in einer blockbasierten Sprache entwickeln; Programmstrukturen: bedingte Anweisungen und Verzweigungen (if, if-else); Fachbegriffe: bedingte Anweisung, Verzweigung"
estimated_minutes: 30
reflect: "Erkläre den Unterschied zwischen „falls … dann“ und „falls … dann … sonst“ an einem Beispiel aus deinem Alltag."
---
## Erklärung

### Programme müssen entscheiden

„Wenn es regnet, nimm den Schirm mit.“ Das ist eine Entscheidung mit einer **Bedingung** (es regnet) und einer **Anweisung** (Schirm mitnehmen). Programme treffen ständig solche Entscheidungen: Ist das Passwort richtig? Hat der Spieler noch Leben? Ist die Zahl größer als 10?

### Die bedingte Anweisung: falls … dann

Der einfachste Baustein: **falls** Bedingung **dann** Anweisungen. Die Anweisungen werden nur ausgeführt, wenn die Bedingung **wahr** ist. Ist sie falsch, passiert nichts, und das Programm macht danach weiter.

```
falls punkte > 100 dann
    sage "Neuer Rekord!"
```

In Textsprachen heißt das `if`. Man nennt es **bedingte Anweisung**.

### Die Verzweigung: falls … dann … sonst

Oft soll auch etwas passieren, wenn die Bedingung **nicht** zutrifft. Dafür gibt es den **sonst**-Zweig (`else`):

```
falls alter >= 18 dann
    sage "Du darfst wählen."
sonst
    sage "Du darfst noch nicht wählen."
```

Genau **einer** der beiden Zweige wird ausgeführt – nie beide, nie keiner. Das ist eine **Verzweigung** (`if-else`), weil sich der Programmweg gabelt.

::: check
type: single_choice
prompt: "Bei „falls … dann … sonst“ – wie viele der beiden Zweige werden ausgeführt?"
options: ["Immer beide", "Genau einer", "Keiner oder beide"]
answer: { index: 1 }
explanation: "Ist die Bedingung wahr, der dann-Zweig, sonst der sonst-Zweig – nie beide."
:::

### Bedingungen: Vergleiche mit Wahrheitswert

Eine Bedingung ist immer ein Ausdruck, der **wahr** oder **falsch** ergibt – ein boolean. Meist ein **Vergleich**:

| Vergleich | Bedeutung | Beispiel (x = 7) |
|---|---|---|
| `x = 7` | gleich | wahr |
| `x > 5` | größer als | wahr |
| `x < 5` | kleiner als | falsch |
| `x >= 7` | größer oder gleich | wahr |
| `x <= 6` | kleiner oder gleich | falsch |
| `nicht (x = 7)` | ungleich | falsch |

Auch Texte kann man vergleichen: `antwort = "ja"`.

### Bedingungen verknüpfen: und, oder, nicht

- **und**: beide Teile müssen wahr sein. `alter >= 12 und alter <= 16` – wahr für 12 bis 16.
- **oder**: mindestens ein Teil muss wahr sein. `taste = "a" oder taste = "A"`.
- **nicht**: kehrt den Wahrheitswert um. `nicht (leben = 0)` – wahr, solange noch Leben da sind.

Beispiel: Freibad-Eintritt. `falls (alter < 6) oder (alter > 70) dann sage "Eintritt frei" sonst sage "Eintritt 3 Euro"`.

::: check
type: single_choice
prompt: "x = 10. Ist die Bedingung „x >= 5 und x < 10“ wahr oder falsch?"
options: ["wahr", "falsch"]
answer: { index: 1 }
explanation: "10 >= 5 ist wahr, aber 10 < 10 ist falsch – bei „und“ müssen beide wahr sein."
:::

### Mehrere Fälle: Verzweigungen verschachteln

Manchmal gibt es mehr als zwei Möglichkeiten. Dann steckt man eine Verzweigung in den **sonst**-Zweig der vorherigen:

```
falls temperatur > 25 dann
    sage "Heiß – ab ins Freibad!"
sonst
    falls temperatur > 15 dann
        sage "Angenehm."
    sonst
        sage "Kalt – Jacke anziehen."
```

Das Programm prüft von oben nach unten und nimmt den **ersten** zutreffenden Fall. Bei 20 °C: erste Bedingung falsch (20 > 25?), zweite wahr (20 > 15?) → „Angenehm.“ Manche Sprachen haben dafür ein Kürzel: `elif` oder `else if`.

### Ein typischer Fehler: Grenzen

`falls note < 4 dann sage "bestanden"` – ist die Note 4 dann bestanden? Nein! Für 4 ist `4 < 4` falsch. Richtig wäre `note <= 4`. Prüfe Bedingungen immer an der **Grenze**: Was passiert genau beim Grenzwert?

::: check
type: single_choice
prompt: "Temperatur 20 °C. Welche Ausgabe liefert das Beispielprogramm oben?"
options: ["Heiß – ab ins Freibad!", "Angenehm.", "Kalt – Jacke anziehen."]
answer: { index: 1 }
explanation: "20 > 25 ist falsch, 20 > 15 ist wahr → „Angenehm.“"
:::

### Beispiel: Ein Zahlenratespiel entscheiden

```
frage "Rate meine Zahl (1–10)" und warte
setze tipp auf Antwort
falls tipp = geheimzahl dann
    sage "Richtig!"
sonst
    falls tipp < geheimzahl dann
        sage "Zu klein."
    sonst
        sage "Zu groß."
```

Drei Fälle, klar getrennt. Mit einer Schleife (nächstes Thema) wird daraus ein echtes Spiel.

## Hefteintrag

**Bedingte Anweisungen und Verzweigungen**

**Bedingte Anweisung (if):** `falls Bedingung dann Anweisungen` – wird nur ausgeführt, wenn die Bedingung **wahr** ist.

**Verzweigung (if-else):** `falls Bedingung dann … sonst …` – genau **ein** Zweig wird ausgeführt.

```
falls alter >= 18 dann
    sage "Du darfst wählen."
sonst
    sage "Noch nicht."
```

**Bedingungen** sind Vergleiche mit Wahrheitswert (boolean): `=`, `>`, `<`, `>=`, `<=`, `nicht`
**Verknüpfen:** `und` (beide wahr), `oder` (mindestens eins wahr), `nicht` (umkehren)

**Mehrere Fälle:** Verzweigung im sonst-Zweig verschachteln; das Programm nimmt den ersten zutreffenden Fall.

**Merke:** Bedingungen an der Grenze prüfen! `note <= 4` statt `note < 4`, wenn 4 noch bestanden ist.
