---
title: Zufallsversuche und Wahrscheinlichkeit
intro: Würfel, Münze, Glücksrad – Zufallsversuche beschreiben, Ergebnisse und Ereignisse unterscheiden und Wahrscheinlichkeiten berechnen.
curriculum_ref: "Zufallsversuche durch Angabe der Elementarereignisse beschreiben; Wahrscheinlichkeiten von einstufigen Zufallsversuchen berechnen; Zufallsversuch, Elementarereignis, Ereignis, Mengenschreibweise; gleichwahrscheinliche Elementarereignisse; Begriff Wahrscheinlichkeit P(A)"
estimated_minutes: 30
reflect: "Erkläre, wie man beim Würfeln die Wahrscheinlichkeit für „gerade Zahl“ berechnet, und was „günstig“ und „möglich“ bedeuten."
---
## Erklärung

### Was ist ein Zufallsversuch?

Ein **Zufallsversuch** ist ein Vorgang, bei dem man **vorher nicht weiß, was herauskommt**, aber alle **möglichen Ergebnisse kennt** – und den man beliebig oft wiederholen kann.

- Würfeln: mögliche Ergebnisse 1, 2, 3, 4, 5, 6
- Münzwurf: Kopf, Zahl
- Glücksrad mit 4 Farben: rot, blau, grün, gelb
- Eine Kugel aus einer Urne ziehen

Die einzelnen möglichen Ergebnisse heißen **Elementarereignisse**. Alle zusammen bilden die **Ergebnismenge** Ω (sprich: Omega). Beim Würfel: **Ω = {1; 2; 3; 4; 5; 6}**.

### Ereignisse

Ein **Ereignis** ist eine Zusammenfassung von Ergebnissen – eine Frage, die mit „ja“ oder „nein“ beantwortet wird. Man schreibt es als Menge:

- A: „gerade Zahl“ → A = {2; 4; 6}
- B: „mindestens 5“ → B = {5; 6}
- C: „Zahl kleiner als 3“ → C = {1; 2}
- D: „eine 7“ → D = { } (**unmögliches Ereignis** – kann nie eintreten)
- E: „Zahl kleiner als 7“ → E = {1; 2; 3; 4; 5; 6} = Ω (**sicheres Ereignis** – tritt immer ein)

::: check
type: single_choice
prompt: "Welche Menge beschreibt beim Würfeln „mindestens 5“?"
options: ["{5}", "{5; 6}", "{1; 2; 3; 4}"]
answer: { index: 1 }
explanation: "Mindestens 5 heißt 5 oder 6."
:::

### Die Wahrscheinlichkeit

Wenn alle Ergebnisse **gleich wahrscheinlich** sind (Würfel ist nicht gezinkt, Münze ist fair), heißt der Versuch **Laplace-Versuch**. Dann berechnet man die Wahrscheinlichkeit eines Ereignisses A so:

**P(A) = Anzahl der günstigen Ergebnisse / Anzahl der möglichen Ergebnisse**

„Günstig“ sind die Ergebnisse, bei denen A eintritt. P steht für *probability* (Wahrscheinlichkeit).

**Beispiele beim Würfel** (6 mögliche Ergebnisse):
- P(gerade Zahl) = 3/6 = 1/2 = 0,5 = 50 %
- P(mindestens 5) = 2/6 = 1/3 ≈ 33 %
- P(eine 6) = 1/6 ≈ 17 %
- P(eine 7) = 0/6 = 0 (unmöglich)
- P(Zahl kleiner als 7) = 6/6 = 1 (sicher)

Die Wahrscheinlichkeit ist immer eine Zahl **zwischen 0 und 1** (bzw. 0 % und 100 %). Man gibt sie als Bruch, Dezimalzahl oder Prozent an.

::: check
type: numeric
prompt: "Wie groß ist P(gerade Zahl) beim Würfeln? (als Bruch)"
answer: { value: "1/2" }
explanation: "3 günstige (2, 4, 6) von 6 möglichen: 3/6 = 1/2."
:::

### Glücksrad und Urne

**Glücksrad** mit 8 gleich großen Feldern: 3 rot, 2 blau, 2 grün, 1 gelb.
P(rot) = 3/8, P(gelb) = 1/8, P(blau oder grün) = 4/8 = 1/2.

**Urne** mit 5 roten und 3 schwarzen Kugeln (8 Kugeln). Eine Kugel wird blind gezogen.
P(rot) = 5/8, P(schwarz) = 3/8. Zusammen: 8/8 = 1 ✓

**Zwei Würfel, Augensumme:** Hier sind die Ergebnisse nicht gleich wahrscheinlich! Es gibt 36 Kombinationen (1|1, 1|2 … 6|6). Augensumme 7 kommt 6-mal vor (1|6, 2|5, 3|4, 4|3, 5|2, 6|1) → P = 6/36 = 1/6. Augensumme 2 nur einmal (1|1) → P = 1/36. **Zähle immer die gleich wahrscheinlichen Grundergebnisse!**

::: check
type: numeric
prompt: "Urne mit 3 roten und 7 blauen Kugeln. Wie groß ist P(rot) als Dezimalzahl?"
answer: { value: 0.3 }
explanation: "3/10 = 0,3."
:::

### Nicht gleichwahrscheinliche Ergebnisse

Bei einer Reißzwecke (landet auf dem Kopf oder auf der Seite) oder einem gezinkten Würfel sind die Ergebnisse **nicht gleich wahrscheinlich**. Dann kann man die Wahrscheinlichkeit nicht ausrechnen, sondern muss sie **schätzen** – durch viele Versuche (nächstes Thema).

### Beispiel: Wahrscheinlichkeiten vergleichen

Welches ist wahrscheinlicher: beim Würfeln eine 6 (P = 1/6) oder beim Glücksrad oben gelb (P = 1/8)?
1/6 ≈ 0,167 > 1/8 = 0,125 → die **6 beim Würfeln** ist wahrscheinlicher.

## Hefteintrag

**Zufallsversuche und Wahrscheinlichkeit**

**Zufallsversuch:** Ergebnis vorher unbekannt, alle möglichen Ergebnisse bekannt, wiederholbar.
**Elementarereignisse** = die einzelnen Ergebnisse. **Ergebnismenge** Ω. Würfel: Ω = {1; 2; 3; 4; 5; 6}

**Ereignis** = Zusammenfassung von Ergebnissen als Menge:
A: „gerade Zahl“ → A = {2; 4; 6}
**Unmögliches Ereignis:** { } (z. B. „eine 7“) · **Sicheres Ereignis:** Ω (z. B. „Zahl kleiner als 7“)

**Laplace-Versuch:** alle Ergebnisse gleich wahrscheinlich. Dann gilt:

**P(A) = Anzahl der günstigen Ergebnisse : Anzahl der möglichen Ergebnisse**

P(gerade Zahl) = 3/6 = 1/2 = 50 %        P(eine 6) = 1/6
Urne mit 5 roten und 3 schwarzen Kugeln: P(rot) = 5/8

**0 ≤ P(A) ≤ 1** · P(unmöglich) = 0 · P(sicher) = 1

Zwei Würfel: 36 gleich wahrscheinliche Kombinationen zählen! P(Summe 7) = 6/36 = 1/6
