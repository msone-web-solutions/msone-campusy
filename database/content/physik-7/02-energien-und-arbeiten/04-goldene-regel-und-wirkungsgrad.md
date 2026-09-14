---
title: "Goldene Regel der Mechanik und Wirkungsgrad"
intro: "Mit einem Flaschenzug hebt ein Kind ein Auto – aber es muss dafür sehr viel Seil ziehen. Kraft sparen geht, Arbeit sparen nicht."
curriculum_ref: "die Nutzung mechanischer Energie in technischen Anlagen beschreiben; Energiebilanzen aufstellen und Wirkungsgrade berechnen; kraftumformende Einrichtungen („Goldene Regel der Mechanik“); Überprüfung der Goldenen Regel der Mechanik; Möglichkeiten zur Erhöhung des Wirkungsgrades besprechen"
estimated_minutes: 35
reflect: "Erkläre einem Freund, warum du mit einer langen Rampe ein schweres Fahrrad leichter in den Keller bekommst als über die Treppe – und warum du trotzdem nicht weniger Arbeit verrichtest."
---
## Erklärung

### Kraft sparen mit Hilfsmitteln

Schon die Ägypter zogen tonnenschwere Steine über Rampen auf ihre Pyramiden, und mit einem Brecheisen hebelt man Steine aus dem Boden, die man mit bloßen Händen nie bewegen könnte. Solche Hilfsmittel nennt man **kraftumformende Einrichtungen**. Die wichtigsten:

| Einrichtung | Beispiel |
|---|---|
| **Hebel** | Brecheisen, Schubkarre, Wippe, Zange, Nussknacker |
| **Feste Rolle** | Fahnenmast, Rolle am Kran (lenkt nur die Kraft um) |
| **Lose Rolle** | Rolle, die mit der Last mithängt – halbiert die Kraft |
| **Flaschenzug** | Kombination aus festen und losen Rollen |
| **Schiefe Ebene** | Rampe, Serpentinenstraße, Schraube |

### Die Goldene Regel der Mechanik

Alle diese Einrichtungen haben eines gemeinsam: Man braucht **weniger Kraft**, muss aber einen **längeren Weg** zurücklegen. Das Produkt aus Kraft und Weg – also die Arbeit – bleibt gleich.

**Merksatz (Goldene Regel der Mechanik):** Was man an Kraft spart, muss man an Weg zulegen. Arbeit kann man mit keiner Maschine sparen.

Diese Regel folgt direkt aus dem Energieerhaltungssatz: Die Lageenergie, die eine Last am Ende hat, muss vorher als Arbeit hineingesteckt worden sein – egal auf welchem Weg.

**Beispiel lose Rolle:** Eine Last mit 200 N soll 1 m hoch gehoben werden. Direktes Heben: *W = 200 N · 1 m = 200 J*. Mit einer losen Rolle braucht man nur 100 N – muss dafür aber 2 m Seil durchziehen: *W = 100 N · 2 m = 200 J*. Gleiche Arbeit!

**Beispiel Flaschenzug mit 4 tragenden Seilstücken:** Die Kraft sinkt auf ein Viertel (50 N), der Seilweg vervierfacht sich (4 m). *50 N · 4 m = 200 J*.

**Beispiel schiefe Ebene:** Ein Wagen (Gewichtskraft 600 N) soll 1 m hoch. Über eine 4 m lange Rampe braucht man nur 150 N Zugkraft: *150 N · 4 m = 600 J* – genau die Hubarbeit *600 N · 1 m = 600 J*.

::: check
type: numeric
prompt: "Mit einer losen Rolle wird eine Last mit 300 N um 2 m gehoben. Welche Kraft in N ist nötig?"
answer: { value: 150, tolerance: 0.5 }
options: { unit: "N" }
explanation: "Die lose Rolle halbiert die Kraft: 300 N : 2 = 150 N. Dafür muss man 4 m Seil ziehen: 150 N · 4 m = 600 J = 300 N · 2 m."
:::

### Der Hebel

Beim Hebel wird die Regel besonders deutlich. Ein Hebel ist ein starrer Körper, der sich um einen Drehpunkt drehen kann. Es gilt das **Hebelgesetz**:

**Formel:** F₁ · l₁ = F₂ · l₂  (Kraft mal Hebelarm auf der einen Seite = Kraft mal Hebelarm auf der anderen)

**Beispiel Wippe:** Ein Kind (300 N) sitzt 2 m vom Drehpunkt entfernt. Wo muss der Vater (900 N) sitzen, damit die Wippe im Gleichgewicht ist? *300 N · 2 m = 900 N · l₂* → *l₂ = 600 Nm : 900 N = 0,67 m*.

Deshalb hat ein Brecheisen einen langen Griff und eine kurze Spitze: kleine Kraft am langen Arm – große Kraft am kurzen Arm. Auch in deinem Körper arbeiten Hebel: Der Unterarm ist ein Hebel mit dem Ellenbogen als Drehpunkt.

### Wirkungsgrad – wie viel kommt an?

In Wirklichkeit ist die Arbeit mit Flaschenzug oder Rampe sogar etwas **größer** als ohne, denn Rollen haben Reibung in den Lagern, und der Wagen auf der Rampe reibt am Boden. Ein Teil der hineingesteckten Energie wird zu Wärme – sie ist entwertet.

Wie gut eine Maschine oder ein Gerät die Energie nutzt, beschreibt der **Wirkungsgrad** (griechischer Buchstabe **η**, sprich „eta“):

**Formel:** η = nutzbare Energie : zugeführte Energie  (oder: Nutzarbeit : aufgewendete Arbeit)

Der Wirkungsgrad ist immer **kleiner als 1** (bzw. kleiner als 100 %), weil bei jedem Vorgang Energie entwertet wird. Ein Wirkungsgrad von 1 wäre eine Maschine ohne jeden Verlust – die gibt es nicht.

**Beispiel:** Beim Flaschenzug muss man 250 J Arbeit aufwenden, um eine Last mit 200 J Lageenergie zu versorgen. *η = 200 J : 250 J = 0,8 = 80 %*. 20 % gingen als Wärme in Reibung verloren.

| Gerät | Wirkungsgrad |
|---|---|
| Elektromotor | 80–95 % |
| Flaschenzug | ca. 80–90 % |
| Wasserkraftwerk | ca. 85–90 % |
| LED-Lampe | 30–40 % |
| Benzinmotor | 25–35 % |
| Glühlampe | ca. 5 % |

::: check
type: numeric
prompt: "Ein Motor nimmt 500 J elektrische Energie auf und gibt 400 J als Bewegungsenergie ab. Wie groß ist der Wirkungsgrad in Prozent?"
answer: { value: 80, tolerance: 0.5 }
options: { unit: "%" }
explanation: "η = 400 J : 500 J = 0,8 = 80 %."
:::

### Wirkungsgrad erhöhen

Ingenieurinnen und Ingenieure versuchen, den Wirkungsgrad zu steigern: Kugellager statt Gleitlager, Schmieröl gegen Reibung, glatte Oberflächen und stromlinienförmige Karosserien gegen Luftwiderstand, LED statt Glühlampe, Wärmedämmung an Häusern. Ein höherer Wirkungsgrad heißt: weniger Brennstoff, weniger Kosten und weniger CO₂. Das ist der Grund, warum man beim Kauf von Geräten auf die Energieeffizienzklasse achtet.

## Hefteintrag

**Goldene Regel der Mechanik und Wirkungsgrad**

**Kraftumformende Einrichtungen:** Hebel, feste Rolle (lenkt nur um), lose Rolle (halbiert Kraft), Flaschenzug, schiefe Ebene.

**Goldene Regel der Mechanik:** Was man an **Kraft** spart, muss man an **Weg** zulegen. Die **Arbeit** bleibt gleich: F₁ · s₁ = F₂ · s₂
Beispiel lose Rolle: 200 N · 1 m = 100 N · 2 m = 200 J

**Hebelgesetz:** F₁ · l₁ = F₂ · l₂ (Kraft · Hebelarm = Kraft · Hebelarm)

**Wirkungsgrad η** („eta“) = nutzbare Energie : zugeführte Energie
- immer kleiner als 1 (100 %), weil Reibung Energie entwertet
- Beispiel: 200 J : 250 J = 0,8 = 80 %
- Elektromotor bis 95 %, Benzinmotor ca. 30 %, Glühlampe 5 %

**Wirkungsgrad erhöhen:** Reibung verringern (Kugellager, Öl), Luftwiderstand senken, sparsame Geräte (LED), Wärmedämmung.
