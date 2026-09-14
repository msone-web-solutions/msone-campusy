---
title: Umfang und Flächeninhalt von Vierecken
intro: Flächenformeln für Parallelogramm, Raute, Trapez und Drachen – hergeleitet aus dem Rechteck und angewendet in Sachaufgaben.
curriculum_ref: "Umfang und Flächeninhalt von speziellen Vierecken berechnen; Formeln für Flächeninhalt von Parallelogramm, Rhombus, Trapez, Drachenviereck; Anwendungsaufgaben lösen"
estimated_minutes: 35
reflect: "Erkläre mit dem Zerschneiden-und-Umlegen-Trick, warum für das Parallelogramm A = a · h gilt."
---
## Erklärung

### Umfang

Der **Umfang** ist die Länge des Randes – einfach **alle vier Seiten addieren**.

- Allgemein: U = a + b + c + d
- Parallelogramm/Rechteck: U = 2a + 2b = 2 · (a + b)
- Raute/Quadrat: U = 4a
- Drachen: U = 2a + 2b

### Flächeninhalt: Alles kommt vom Rechteck

Rechteck: **A = a · b**. Quadrat: **A = a²**. Das kennst du. Alle anderen Formeln entstehen durch **Zerschneiden und Umlegen**.

### Parallelogramm

Schneide links ein Dreieck ab und setze es rechts wieder an – es entsteht ein Rechteck mit der Grundseite a und der **Höhe h**:

```
     ┌────────────┐        ┌────────────┐
    /│           /│  →     │            │ h
   / │          / │        │            │
  └──┴─────────┘  ┘        └────────────┘
     ←── a ──→                 ←── a ──→
```

**A = a · h** (Grundseite mal Höhe)

**Wichtig:** Die Höhe h ist der **senkrechte Abstand** zwischen den parallelen Seiten – **nicht** die schräge Seite b!

Beispiel: a = 8 cm, h = 5 cm, b = 6 cm → A = 8 · 5 = **40 cm²**. (Die 6 cm braucht man nur für den Umfang: U = 28 cm.)

::: check
type: numeric
prompt: "Parallelogramm mit a = 9 cm und h = 4 cm. Flächeninhalt?"
options: { unit: "cm²" }
answer: { value: 36 }
explanation: "A = a · h = 9 · 4 = 36 cm²."
:::

### Raute

Eine Raute ist ein Parallelogramm, also gilt A = a · h. Oft kennt man aber die **Diagonalen** e und f. Die Diagonalen stehen senkrecht und zerlegen die Raute in vier rechtwinklige Dreiecke, die zusammen ein halbes Rechteck e · f ergeben:

**A = (e · f) / 2**

Beispiel: e = 10 cm, f = 6 cm → A = 10 · 6 : 2 = **30 cm²**.

### Drachen

Auch beim Drachen stehen die Diagonalen senkrecht – dieselbe Formel:

**A = (e · f) / 2**

Beispiel: e = 12 cm, f = 7 cm → A = 12 · 7 : 2 = **42 cm²**.

::: check
type: numeric
prompt: "Raute mit den Diagonalen e = 10 cm und f = 8 cm. Flächeninhalt?"
options: { unit: "cm²" }
answer: { value: 40 }
explanation: "A = e · f / 2 = 10 · 8 : 2 = 40 cm²."
:::

### Trapez

Beim Trapez mit den parallelen Seiten a und c und der Höhe h: Zwei gleiche Trapeze, eines umgedreht aneinandergelegt, ergeben ein Parallelogramm mit der Grundseite (a + c) und der Höhe h. Das Trapez ist die Hälfte davon:

**A = (a + c) / 2 · h** – „Mittelwert der parallelen Seiten mal Höhe“

Beispiel: a = 9 cm, c = 5 cm, h = 4 cm → A = (9 + 5) : 2 · 4 = 7 · 4 = **28 cm²**.

### Alle Formeln

| Viereck | Flächeninhalt | Umfang |
|---|---|---|
| Rechteck | A = a · b | U = 2 · (a + b) |
| Quadrat | A = a² | U = 4a |
| Parallelogramm | A = a · h | U = 2 · (a + b) |
| Raute | A = a · h oder A = e · f / 2 | U = 4a |
| Drachen | A = e · f / 2 | U = 2 · (a + b) |
| Trapez | A = (a + c) / 2 · h | U = a + b + c + d |

::: check
type: numeric
prompt: "Trapez mit a = 8 cm, c = 4 cm, h = 5 cm. Flächeninhalt?"
options: { unit: "cm²" }
answer: { value: 30 }
explanation: "A = (8 + 4) : 2 · 5 = 6 · 5 = 30 cm²."
:::

### Rückwärts rechnen

Ein Parallelogramm hat A = 54 cm² und a = 9 cm. Wie hoch ist es?
A = a · h → h = A : a = 54 : 9 = **6 cm**.

Ein Trapez hat A = 40 cm², h = 5 cm, a = 10 cm. Wie lang ist c?
(a + c) : 2 · 5 = 40 → (a + c) : 2 = 8 → a + c = 16 → c = **6 cm**.

### Einheiten umrechnen

1 m² = 100 dm² = 10 000 cm². 1 cm² = 100 mm². 1 ha = 10 000 m². 1 a = 100 m².
Achtung: Bei Flächen ist der Umrechnungsfaktor 100, nicht 10!

### Beispiel: Sachaufgabe

Ein Grundstück hat die Form eines Trapezes: Die parallelen Seiten sind 40 m und 28 m lang, der Abstand beträgt 25 m. Ein Quadratmeter kostet 80 €. Was kostet das Grundstück?
A = (40 + 28) : 2 · 25 = 34 · 25 = 850 m². Preis: 850 · 80 = **68 000 €**.

## Hefteintrag

**Umfang und Flächeninhalt von Vierecken**

**Umfang** = alle Seiten addieren. Parallelogramm: U = 2 · (a + b), Raute: U = 4a

**Flächeninhalt:**

| Viereck | Formel |
|---|---|
| Rechteck | A = a · b |
| Quadrat | A = a² |
| Parallelogramm | A = a · h |
| Raute | A = e · f / 2 (oder a · h) |
| Drachen | A = e · f / 2 |
| Trapez | A = (a + c) / 2 · h |

h = **Höhe** = senkrechter Abstand der parallelen Seiten (nicht die schräge Seite!)
e, f = Diagonalen · a, c = parallele Seiten des Trapezes

**Beispiele:**
Parallelogramm a = 8 cm, h = 5 cm: A = 40 cm²
Raute e = 10 cm, f = 6 cm: A = 30 cm²
Trapez a = 9 cm, c = 5 cm, h = 4 cm: A = (9 + 5) : 2 · 4 = 28 cm²

**Einheiten:** 1 m² = 100 dm² = 10 000 cm² · 1 cm² = 100 mm² · 1 ha = 10 000 m²
