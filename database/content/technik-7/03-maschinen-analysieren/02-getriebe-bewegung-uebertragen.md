---
title: "Getriebe: Bewegungen übertragen und verändern"
intro: "Zahnräder, Ketten und Riemen übertragen Drehbewegungen – und verändern dabei Drehzahl, Drehrichtung oder sogar die Bewegungsform."
curriculum_ref: "Übertragungselemente: Drehzahl-, Drehrichtungs- und Bewegungsformänderung; Getriebearten (Zugmittelgetriebe, Zahnradgetriebe); technische Parameter berechnen"
estimated_minutes: 30
reflect: "Erkläre mit dem Fahrrad als Beispiel, warum du bei einem kleinen Ritzel hinten schneller fährst, aber stärker treten musst."
---
## Erklärung

### Wozu braucht man ein Getriebe?

Ein Elektromotor dreht sich oft mit 3 000 Umdrehungen pro Minute – viel zu schnell für einen Rührbesen oder die Trommel einer Waschmaschine. Und die Pedale eines Fahrrads drehen sich viel langsamer, als das Hinterrad sich drehen soll. Zwischen Antrieb und Arbeitselement sitzt deshalb ein **Getriebe**. Es überträgt die Bewegung und kann dabei dreierlei verändern:

1. die **Drehzahl** (wie schnell sich etwas dreht, gemessen in Umdrehungen pro Minute, U/min),
2. die **Drehrichtung** (im oder gegen den Uhrzeigersinn),
3. die **Bewegungsform** (Drehbewegung ↔ geradlinige Bewegung).

Das treibende Rad heißt **Antriebsrad**, das getriebene Rad **Abtriebsrad**.

### Zahnradgetriebe

Bei einem **Zahnradgetriebe** greifen die Zähne zweier Räder direkt ineinander. Zwei wichtige Regeln:

- **Drehrichtung**: Zwei direkt ineinandergreifende Zahnräder drehen sich **gegenläufig**. Soll das Abtriebsrad in dieselbe Richtung drehen wie das Antriebsrad, schaltet man ein **Zwischenrad** dazwischen.
- **Drehzahl**: Das kleinere Rad dreht sich schneller als das größere. Ein Rad mit 10 Zähnen muss sich zweimal drehen, bis ein Rad mit 20 Zähnen einmal herum ist.

Das Verhältnis der Zähnezahlen nennt man **Übersetzungsverhältnis i**:

**i = Zähnezahl Abtriebsrad : Zähnezahl Antriebsrad**

Beispiel: Antriebsrad 10 Zähne, Abtriebsrad 30 Zähne → i = 30 : 10 = **3 : 1**. Das Abtriebsrad dreht sich dreimal langsamer, aber mit dreimal größerer Kraft (Drehmoment). Das ist eine Übersetzung „ins Langsame“. Ist das Abtriebsrad kleiner, wird „ins Schnelle“ übersetzt – schneller, aber mit weniger Kraft.

Auch die Drehzahl lässt sich berechnen: **Drehzahl Abtrieb = Drehzahl Antrieb : i**. Bei 3 000 U/min am Motor und i = 3 : 1 dreht der Abtrieb mit 1 000 U/min.

::: check
type: numeric
prompt: "Das Antriebsrad hat 12 Zähne, das Abtriebsrad 48 Zähne. Wie groß ist das Übersetzungsverhältnis i (Zahl vor dem Doppelpunkt bei „i : 1“)?"
answer: { value: 4 }
explanation: "48 : 12 = 4, also i = 4 : 1 – das Abtriebsrad dreht sich viermal langsamer."
:::

Zahnradgetriebe sind robust, übertragen große Kräfte und laufen ohne Schlupf – aber die Räder müssen dicht beieinander sitzen. Sonderformen: **Kegelradgetriebe** (Wellen stehen im rechten Winkel, z. B. im Handrührgerät) und **Schneckengetriebe** (sehr große Übersetzung auf kleinem Raum, z. B. Stimmwirbel der Gitarre).

### Zugmittelgetriebe

Liegen Antrieb und Abtrieb weit auseinander, hilft ein **Zugmittelgetriebe**: Ein biegsames Zugmittel – **Kette** oder **Riemen** – verbindet zwei Räder.

- **Kettengetriebe**: Kette auf Zahnkränzen (Kettenblatt und Ritzel). Kein Schlupf, große Kräfte, muss geölt werden. Beispiel: Fahrrad, Motorrad.
- **Riemengetriebe**: Flach- oder Keilriemen auf glatten Scheiben; Zahnriemen auf gezahnten Scheiben. Leise, günstig, dämpft Stöße; Flachriemen können durchrutschen (**Schlupf**). Beispiel: Waschmaschine (Motor → Trommel), Bohrmaschine mit Riemenscheiben, Autoantrieb der Lichtmaschine.

Bei Ketten- und Riemengetrieben drehen sich beide Räder in **dieselbe Richtung**. Wird ein Riemen gekreuzt aufgelegt, kehrt sich die Drehrichtung um. Das Übersetzungsverhältnis berechnet man bei Ketten über die Zähnezahlen, bei Riemen über die Durchmesser der Scheiben.

Beispiel Fahrrad: Kettenblatt vorn 48 Zähne, Ritzel hinten 16 Zähne → i = 16 : 48 = 1 : 3. Eine Pedalumdrehung ergibt drei Radumdrehungen – Übersetzung ins Schnelle. Beim Bergauffahren wählt man ein größeres Ritzel: weniger Radumdrehungen pro Tritt, aber mehr Kraft.

::: check
type: single_choice
prompt: "Bei welchem Getriebe drehen sich Antriebs- und Abtriebsrad in dieselbe Richtung?"
options: ["Zwei direkt ineinandergreifende Zahnräder", "Kettengetriebe", "Zahnradgetriebe ohne Zwischenrad"]
answer: { index: 1 }
explanation: "Kette und Riemen (nicht gekreuzt) übertragen die Drehrichtung unverändert. Zwei Zahnräder drehen sich gegenläufig."
:::

### Bewegungsform ändern

Manche Maschinen brauchen statt einer Drehung eine Hin-und-her-Bewegung – oder umgekehrt:

- **Kurbeltrieb**: Eine Kurbel mit Pleuelstange wandelt Drehen in geradliniges Hin und Her (Stichsäge, Nähmaschine) oder umgekehrt (Kolben im Motor → Kurbelwelle).
- **Zahnstange und Ritzel**: Ein Zahnrad läuft auf einer geraden Zahnstange – Drehen wird zu Schieben (Lenkung im Auto, Bohrmaschinenständer).
- **Schraube**: Drehen wird zu Vorschub (Schraubstock, Wagenheber).
- **Nocken**: Ein unrundes Rad hebt und senkt einen Stößel (Ventile im Motor).

## Hefteintrag

**Getriebe: Bewegungen übertragen und verändern**

Ein **Getriebe** sitzt zwischen Antrieb und Arbeitselement und verändert **Drehzahl** (U/min), **Drehrichtung** oder **Bewegungsform**. Treibendes Rad = **Antriebsrad**, getriebenes Rad = **Abtriebsrad**.

**Zahnradgetriebe:** Zähne greifen direkt ineinander
- zwei Räder drehen **gegenläufig**; **Zwischenrad** → gleiche Richtung
- kleines Rad dreht schneller als großes
- **Übersetzungsverhältnis i = Zähne Abtrieb : Zähne Antrieb** (10 → 30 Zähne: i = 3 : 1, dreimal langsamer, dreimal mehr Kraft)
- Drehzahl Abtrieb = Drehzahl Antrieb : i

**Zugmittelgetriebe:** Kette oder Riemen verbindet weit entfernte Räder
- **Kette** (Fahrrad): kein Schlupf, große Kräfte, ölen
- **Riemen** (Waschmaschine): leise, günstig, Flachriemen kann rutschen (**Schlupf**)
- gleiche Drehrichtung; gekreuzter Riemen kehrt sie um

**Bewegungsform ändern:** **Kurbeltrieb** (Drehen ↔ Hin und her), **Zahnstange und Ritzel** (Drehen → Schieben), Schraube, Nocken

**Merke:** Übersetzung ins Langsame = mehr Kraft, weniger Drehzahl. Ins Schnelle = mehr Drehzahl, weniger Kraft.
