---
title: "Lageenergie und Bewegungsenergie berechnen"
intro: "Je höher, desto mehr Lageenergie – je schneller, desto mehr Bewegungsenergie. Und bei doppelter Geschwindigkeit steckt sogar viermal so viel Energie im Auto."
curriculum_ref: "die potentielle Energie gehobener Körper berechnen; den Zusammenhang zwischen der Geschwindigkeit und der kinetischen Energie eines Körpers erläutern; Bestimmung der potentiellen Energie eines Körpers; Sicherheitsmaßnahmen im Alltag unter Nutzung physikalischen Wissens bewerten"
estimated_minutes: 30
reflect: "Erkläre mit der Bewegungsenergie, warum der Bremsweg eines Autos bei doppelter Geschwindigkeit nicht doppelt, sondern viermal so lang ist."
---
## Erklärung

### Lageenergie berechnen

Ein Körper, der angehoben wurde, kann beim Herunterfallen Arbeit verrichten – zum Beispiel einen Pfahl in den Boden rammen. Er besitzt **Lageenergie** (auch **potentielle Energie**, Formelzeichen *Eₚₒₜ*).

Wie groß ist sie? Genau so groß wie die Hubarbeit, die man verrichtet hat, um ihn hochzuheben. Die Hubkraft ist die Gewichtskraft *F = m · g*, der Weg ist die Höhe *h*. Also:

**Formel:** Eₚₒₜ = m · g · h  (Masse · Ortsfaktor · Höhe)

Mit *m* in kg, *g* = 10 N/kg und *h* in m ergibt sich *Eₚₒₜ* in Joule.

**Beispiel 1:** Ein Buch (1,5 kg) liegt auf einem 2 m hohen Regal.
*Eₚₒₜ = 1,5 kg · 10 N/kg · 2 m = 30 J*

**Beispiel 2:** Ein Turmspringer (60 kg) steht auf dem 10-m-Turm.
*Eₚₒₜ = 60 kg · 10 N/kg · 10 m = 6000 J = 6 kJ*

Die Lageenergie wird immer **von einem Bezugsniveau** aus gerechnet – meist vom Boden oder der Wasseroberfläche. Ein Buch auf dem Tisch hat gegenüber dem Tisch keine Lageenergie, gegenüber dem Fußboden aber schon. Man muss also immer sagen, worauf man sich bezieht.

::: check
type: numeric
prompt: "Ein Koffer (20 kg) wird 1,2 m hoch in den Kofferraum gehoben. Berechne seine Lageenergie in J (g = 10 N/kg)."
answer: { value: 240, tolerance: 1 }
options: { unit: "J" }
explanation: "Eₚₒₜ = m · g · h = 20 kg · 10 N/kg · 1,2 m = 240 J."
:::

### Bewegungsenergie

Ein fahrendes Auto, ein fliegender Ball, strömendes Wasser: Bewegte Körper besitzen **Bewegungsenergie** (auch **kinetische Energie**, Formelzeichen *Eₖᵢₙ*). Sie hängt von zwei Größen ab:

- von der **Masse**: Ein Lkw hat bei gleicher Geschwindigkeit viel mehr Bewegungsenergie als ein Fahrrad.
- von der **Geschwindigkeit** – und zwar besonders stark.

**Formel:** Eₖᵢₙ = ½ · m · v²  (halbe Masse mal Geschwindigkeit zum Quadrat)

Mit *m* in kg und *v* in m/s ergibt sich *Eₖᵢₙ* in Joule.

**Beispiel:** Ein Radfahrer (Masse mit Rad 80 kg) fährt 5 m/s (18 km/h).
*Eₖᵢₙ = ½ · 80 kg · (5 m/s)² = ½ · 80 · 25 J = 1000 J*

### Das Quadrat macht den Unterschied

Weil die Geschwindigkeit **quadratisch** in die Formel eingeht, gilt:

| Geschwindigkeit | Bewegungsenergie |
|---|---|
| einfach (v) | einfach |
| doppelt (2v) | **vierfach** (2² = 4) |
| dreifach (3v) | **neunfach** (3² = 9) |

Fährt der Radfahrer statt 5 m/s nun 10 m/s, hat er nicht 2000 J, sondern *½ · 80 · 100 J = 4000 J* Bewegungsenergie.

Das ist der Grund für viele Sicherheitsregeln im Straßenverkehr: Beim Bremsen muss die gesamte Bewegungsenergie durch Reibung in Wärme umgewandelt werden. Bei doppelter Geschwindigkeit ist deshalb der **Bremsweg viermal so lang**. Aus 50 km/h steht ein Auto nach etwa 12,5 m Bremsweg, aus 100 km/h erst nach 50 m. Und bei einem Aufprall muss die Knautschzone viermal so viel Energie aufnehmen. Darum gilt in Städten Tempo 30 oder 50 – und darum sind Fahrradhelm und Anschnallgurt so wichtig.

::: check
type: single_choice
prompt: "Ein Auto verdreifacht seine Geschwindigkeit. Wie verändert sich seine Bewegungsenergie?"
options: ["Sie verdreifacht sich", "Sie wird sechsmal so groß", "Sie wird neunmal so groß"]
answer: { index: 2 }
explanation: "Die Geschwindigkeit geht quadratisch ein: 3² = 9. Die Bewegungsenergie wird neunmal so groß."
:::

### Umwandlung ineinander

Lageenergie und Bewegungsenergie wandeln sich ständig ineinander um – und ohne Reibung bleibt ihre Summe gleich (Energieerhaltungssatz der Mechanik):

**Turmspringer:** Oben 6000 J Lageenergie, 0 J Bewegungsenergie. Beim Eintauchen: 0 J Lageenergie, 6000 J Bewegungsenergie. Daraus kann man sogar die Geschwindigkeit berechnen: *½ · 60 kg · v² = 6000 J* → *v² = 200* → *v ≈ 14 m/s* (rund 50 km/h!).

**Achterbahn:** Der erste Hügel ist der höchste. Von dort wird Lageenergie in Bewegungsenergie umgewandelt, im Tal ist der Wagen am schnellsten, beim nächsten Hügel wird er wieder langsamer. Wegen Reibung und Luftwiderstand kommt er aber nie mehr ganz so hoch wie beim Start.

**Pendel und Schaukel:** Am Umkehrpunkt nur Lageenergie, ganz unten nur Bewegungsenergie.

### Experiment: Lageenergie bestimmen

Im Unterricht kannst du die Lageenergie eines Körpers bestimmen, indem du seine Masse wiegst und die Höhe misst. Oder du misst die Hubarbeit direkt: Körper am Federkraftmesser gleichmäßig hochziehen, Kraft und Weg ablesen, multiplizieren. Beide Wege müssen dasselbe Ergebnis liefern – kleine Abweichungen kommen vom Ablesen und vom Wackeln beim Ziehen.

## Hefteintrag

**Lageenergie und Bewegungsenergie**

**Lageenergie (potentielle Energie) Eₚₒₜ:** Energie eines gehobenen Körpers.

**Formel:** Eₚₒₜ = m · g · h  (m in kg, g = 10 N/kg, h in m → E in J)

Beispiel: 60 kg auf 10 m Höhe → Eₚₒₜ = 60 · 10 · 10 J = 6000 J. Immer ein **Bezugsniveau** angeben (Boden, Tisch …).

**Bewegungsenergie (kinetische Energie) Eₖᵢₙ:** Energie eines bewegten Körpers.

**Formel:** Eₖᵢₙ = ½ · m · v²  (m in kg, v in m/s → E in J)

Beispiel: 80 kg mit 5 m/s → Eₖᵢₙ = ½ · 80 · 25 J = 1000 J

**Merke:** Doppelte Geschwindigkeit → **vierfache** Bewegungsenergie → **vierfacher Bremsweg**. Dreifache Geschwindigkeit → neunfache Energie.

**Energieerhaltung:** Eₚₒₜ ⇄ Eₖᵢₙ (Turmspringer, Achterbahn, Pendel). Ohne Reibung bleibt die Summe gleich; mit Reibung wird ein Teil in thermische Energie entwertet.
