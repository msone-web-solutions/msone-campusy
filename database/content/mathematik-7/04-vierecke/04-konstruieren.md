---
title: "Vierecke konstruieren"
intro: "Mit Zirkel, Lineal und Geodreieck Vierecke aus gegebenen Stücken zeichnen – mit Planfigur und Konstruktionsbeschreibung."
curriculum_ref: "Vierecke mit Zirkel, Lineal und Geodreieck sowie digitalem Mathematikwerkzeug konstruieren; Viereckskonstruktionen planen und Konstruktionsschritte beschreiben"
estimated_minutes: 35
reflect: "Erkläre, warum man ein Viereck meist als zwei Dreiecke konstruiert, und was dabei eine Planfigur ist."
---
## Erklärung

### Die Grundidee: Ein Viereck aus zwei Dreiecken

Ein Viereck wird durch eine Diagonale in zwei Dreiecke zerlegt. Und Dreiecke kannst du schon konstruieren (SSS, SWS, WSW aus Klasse 6). Deshalb: **Ein Viereck konstruiert man meist als zwei Dreiecke nacheinander.**

Für ein allgemeines Viereck braucht man **fünf Stücke** (z. B. vier Seiten und eine Diagonale, oder drei Seiten und zwei Winkel). Bei besonderen Vierecken reichen weniger, weil die Eigenschaften den Rest festlegen: Ein Rechteck ist mit zwei Seiten fertig bestimmt, ein Quadrat mit einer.

### So gehst du immer vor

1. **Planfigur:** Skizziere das Viereck frei Hand, beschrifte alle Ecken, trage die gegebenen Stücke farbig ein. Überlege: Welches Dreieck kann ich zuerst zeichnen?
2. **Konstruktion:** Mit Lineal, Geodreieck und Zirkel sauber zeichnen. Hilfslinien dünn lassen.
3. **Konstruktionsbeschreibung:** Jeden Schritt in einer Zeile notieren.

::: check
type: single_choice
prompt: "Was zeichnest du bei einer Konstruktionsaufgabe zuerst?"
options: ["Die Planfigur", "Die Konstruktionsbeschreibung", "Den letzten Punkt"]
answer: { index: 0 }
explanation: "Erst die Planfigur – sie zeigt, welches Dreieck zuerst geht."
:::

### Beispiel 1: Viereck aus vier Seiten und einer Diagonale

Gegeben: a = 5 cm, b = 3 cm, c = 4 cm, d = 4,5 cm, e = AC = 6 cm.

Planfigur: Diagonale e zerlegt in Dreieck ABC (mit a, b, e) und Dreieck ACD (mit c, d, e). Beide sind SSS-Dreiecke.

**Konstruktionsbeschreibung:**
1. Zeichne die Strecke AB = 5 cm.
2. Kreis um A mit Radius e = 6 cm.
3. Kreis um B mit Radius b = 3 cm. Schnittpunkt (oberhalb von AB) ist C.
4. Kreis um A mit Radius d = 4,5 cm.
5. Kreis um C mit Radius c = 4 cm. Schnittpunkt (auf der von B abgewandten Seite von AC) ist D.
6. Verbinde A–B–C–D–A.

### Beispiel 2: Parallelogramm aus zwei Seiten und einem Winkel

Gegeben: a = 6 cm, b = 3,5 cm, α = 60°.

Beim Parallelogramm reicht das, weil gegenüberliegende Seiten parallel und gleich lang sind.

1. Zeichne AB = 6 cm.
2. Trage in A den Winkel α = 60° an (Geodreieck).
3. Auf dem freien Schenkel: AD = b = 3,5 cm abtragen → D.
4. Kreis um D mit Radius a = 6 cm und Kreis um B mit Radius b = 3,5 cm → Schnittpunkt C.
   (Oder: Parallele zu AB durch D und Parallele zu AD durch B mit dem Geodreieck – Schnittpunkt C.)
5. Verbinde.

::: check
type: single_choice
prompt: "Gegeben AB = 6 cm, AC = 5 cm, BC = 4 cm. Wo liegt C?"
options: ["Schnittpunkt der Kreise um A (r = 5) und um B (r = 4)", "Schnittpunkt der Kreise um A (r = 4) und um B (r = 5)"]
answer: { index: 0 }
explanation: "C ist 5 cm von A und 4 cm von B entfernt."
:::

### Beispiel 3: Raute aus Seite und Diagonale

Gegeben: a = 4 cm, e = AC = 6 cm.

Alle Seiten sind 4 cm. Dreieck ABC hat die Seiten 4, 4, 6 (SSS), Dreieck ACD genauso.

1. Zeichne AC = 6 cm.
2. Kreise um A und C mit Radius 4 cm. Die beiden Schnittpunkte sind B (unten) und D (oben).
3. Verbinde A–B–C–D–A.

### Beispiel 4: Drachen aus den Diagonalen

Gegeben: e = AC = 7 cm (Symmetrieachse), f = BD = 4 cm, wobei f die Diagonale e im Abstand 2 cm von A schneidet.

1. Zeichne AC = 7 cm.
2. Markiere auf AC den Punkt M mit AM = 2 cm.
3. Zeichne in M die Senkrechte zu AC (Geodreieck).
4. Trage auf der Senkrechten nach beiden Seiten 2 cm (die Hälfte von f) ab → B und D.
5. Verbinde.

### Beispiel 5: Trapez aus Grundseiten, Höhe und Winkel

Gegeben: a = 7 cm, c = 4 cm (a ∥ c), Höhe h = 3 cm, α = 70°.

1. Zeichne AB = 7 cm.
2. Zeichne eine Parallele zu AB im Abstand 3 cm (Geodreieck: Mittellinie auf AB, bei 3 cm die Parallele zeichnen).
3. Trage in A den Winkel 70° an. Der Schenkel schneidet die Parallele in D.
4. Von D aus 4 cm auf der Parallelen in Richtung B abtragen → C.
5. Verbinde.

::: check
type: true_false
prompt: "Mit AB = 3 cm, BC = 4 cm und AC = 9 cm lässt sich das Dreieck ABC konstruieren."
answer: { value: false }
explanation: "3 + 4 = 7 < 9 – Dreiecksungleichung verletzt, die Kreise schneiden sich nicht."
:::

### Wann geht es nicht?

Nicht jede Vorgabe ergibt ein Viereck. Bei Beispiel 1 müssen beide Dreiecke die **Dreiecksungleichung** erfüllen (jede Seite kürzer als die Summe der beiden anderen). Mit a = 2, b = 3, e = 6 gäbe es kein Dreieck ABC – die Kreise schneiden sich nicht.

## Hefteintrag

**Vierecke konstruieren**

**Grundidee:** Eine Diagonale zerlegt das Viereck in zwei Dreiecke → nacheinander konstruieren (SSS, SWS, WSW).

**Immer so:** 1. Planfigur (Skizze, Gegebenes farbig) · 2. Konstruktion · 3. Konstruktionsbeschreibung

**Beispiel: Viereck mit a = 5 cm, b = 3 cm, c = 4 cm, d = 4,5 cm, e = 6 cm**
1. AB = 5 cm zeichnen
2. Kreis um A mit r = 6 cm, Kreis um B mit r = 3 cm → C
3. Kreis um A mit r = 4,5 cm, Kreis um C mit r = 4 cm → D
4. A–B–C–D–A verbinden

**Parallelogramm:** 2 Seiten + 1 Winkel reichen (Gegenseiten parallel und gleich lang).
**Raute:** Seite + Diagonale reichen (alle Seiten gleich).
**Drachen:** Diagonalen stehen senkrecht, die Symmetriediagonale halbiert die andere.

Nicht jede Vorgabe ergibt ein Viereck: In jedem Teildreieck muss die Dreiecksungleichung gelten.
