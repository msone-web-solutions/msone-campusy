---
title: Gegenereignis, Schätzen und Deuten von Wahrscheinlichkeiten
intro: Mit dem Gegenereignis schneller rechnen, Wahrscheinlichkeiten aus vielen Versuchen schätzen und Aussagen wie „30 % Regenwahrscheinlichkeit“ richtig verstehen.
curriculum_ref: "Wahrscheinlichkeiten schätzen und interpretieren; Gegenereignis; P(A) + P(Ā) = 1; inner- und außermathematische Anwendungsaufgaben lösen"
estimated_minutes: 25
reflect: "Erkläre, warum der Würfel „kein Gedächtnis“ hat, und was das Gesetz der großen Zahlen bedeutet."
---
## Erklärung

### Das Gegenereignis

Zu jedem Ereignis A gibt es das **Gegenereignis** Ā (sprich: „A quer“ oder „nicht A“): Es tritt genau dann ein, wenn A **nicht** eintritt.

- A: „eine 6 würfeln“ → Ā: „keine 6 würfeln“ = {1; 2; 3; 4; 5}
- A: „rot beim Glücksrad“ → Ā: „nicht rot“
- A: „mindestens eine Frage richtig“ → Ā: „keine Frage richtig“

Da entweder A oder Ā eintritt, gilt:

**P(A) + P(Ā) = 1** also **P(Ā) = 1 − P(A)**

P(keine 6) = 1 − 1/6 = **5/6**.

::: check
type: numeric
prompt: "P(A) = 0,25. Wie groß ist P(Ā)?"
answer: { value: 0.75 }
explanation: "1 − 0,25 = 0,75."
:::

### Warum das Gegenereignis so nützlich ist

Manchmal ist das Gegenereignis viel leichter zu zählen.

**Beispiel:** Würfel. P(„nicht die 1 und nicht die 2“)? Gegenereignis: „1 oder 2“, P = 2/6. Also P = 1 − 2/6 = **4/6 = 2/3**.

**Beispiel:** Glücksrad mit 12 Feldern, 1 davon ist der Hauptgewinn. P(kein Hauptgewinn) = 1 − 1/12 = **11/12**.

**Beispiel:** In einer Klasse mit 25 Kindern haben 7 Geschwister. Ein Kind wird ausgelost. P(keine Geschwister) = 1 − 7/25 = 18/25 = **72 %**.

### Wahrscheinlichkeiten schätzen: Das Gesetz der großen Zahlen

Bei einer Reißzwecke oder einem verbeulten Würfel kann man P nicht ausrechnen. Dann macht man den Versuch **sehr oft** und nimmt die **relative Häufigkeit** als Schätzwert.

Eine Klasse wirft eine Reißzwecke 200-mal, 128-mal landet sie auf der Seite. Schätzung: P(Seite) ≈ 128/200 = **0,64 = 64 %**.

Wichtig: **Je öfter man den Versuch macht, desto besser wird die Schätzung.** Nach 10 Würfen kann die relative Häufigkeit noch stark schwanken, nach 1000 Würfen pendelt sie sich ein. Das nennt man das **Gesetz der großen Zahlen**.

Umgekehrt gilt beim fairen Würfel: Auf lange Sicht kommt jede Zahl in etwa **1/6** der Fälle – nach 600 Würfen also ungefähr 100-mal die Sechs. Aber eben nur *ungefähr*: 92-mal oder 107-mal ist völlig normal.

::: check
type: numeric
prompt: "Eine Reißzwecke landet bei 200 Würfen 140-mal auf der Seite. Schätze P(Seite) als Dezimalzahl."
answer: { value: 0.7 }
explanation: "140/200 = 0,7."
:::

### Wahrscheinlichkeiten deuten

„Die Regenwahrscheinlichkeit beträgt 30 %“ heißt: An Tagen mit dieser Wetterlage hat es in **etwa 3 von 10 Fällen** geregnet. Es heißt **nicht**, dass es 30 % des Tages regnet.

„Die Gewinnchance beträgt 1 : 1000“ heißt: Etwa **eins von 1000** Losen gewinnt. P = 1/1000 = 0,1 %.

**Häufige Denkfehler:**
- „Ich habe 5-mal keine 6 gewürfelt, jetzt *muss* die 6 kommen.“ Falsch! Der Würfel hat kein Gedächtnis. P(6) ist bei jedem Wurf 1/6.
- „Bei 50 % Chance gewinne ich von 2 Spielen genau eins.“ Falsch! 50 % gilt auf lange Sicht, nicht für jedes Paar.

### Erwartete Anzahl

Wenn man P kennt, kann man vorhersagen, wie oft ein Ereignis **ungefähr** eintritt:

**erwartete Anzahl ≈ P(A) · Anzahl der Versuche**

Ein Glücksrad mit P(Gewinn) = 1/4 wird 80-mal gedreht. Erwartete Gewinne: 1/4 · 80 = **20**.

::: check
type: numeric
prompt: "Ein Würfel wird 120-mal geworfen. Wie oft ist ungefähr mit einer 6 zu rechnen?"
answer: { value: 20 }
explanation: "1/6 · 120 = 20."
:::

### Beispiel: Alles zusammen

Ein Los-Stand hat 500 Lose, davon 20 Gewinne.
- P(Gewinn) = 20/500 = 4 %
- P(Niete) = 1 − 4 % = 96 %
- Lisa kauft 25 Lose. Erwartete Gewinne: 0,04 · 25 = 1. Garantiert ist das nicht – sie kann auch 0 oder 3 Gewinne haben.

## Hefteintrag

**Gegenereignis, Schätzen und Deuten**

**Gegenereignis Ā** („nicht A“) tritt ein, wenn A nicht eintritt.
**P(A) + P(Ā) = 1**  →  **P(Ā) = 1 − P(A)**
P(keine 6) = 1 − 1/6 = 5/6

**Schätzen:** Wenn man P nicht berechnen kann (Reißzwecke), macht man viele Versuche:
**P(A) ≈ relative Häufigkeit h(A)** bei vielen Wiederholungen
200 Würfe, 128-mal Seite → P(Seite) ≈ 128/200 = 64 %

**Gesetz der großen Zahlen:** Je mehr Versuche, desto besser die Schätzung.

**Erwartete Anzahl ≈ P(A) · Anzahl der Versuche**
P(Gewinn) = 1/4, 80 Drehungen → etwa 20 Gewinne

**Deuten:** „30 % Regenwahrscheinlichkeit“ = in etwa 3 von 10 solchen Fällen regnet es.
Der Würfel hat kein Gedächtnis: P(6) ist bei jedem Wurf 1/6.
