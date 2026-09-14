---
title: "Fehler finden, Programme verbessern und dokumentieren"
intro: "Jedes Programm hat Fehler – die Frage ist, wie man sie findet. Strategien der Fehlersuche, Optimieren und warum eine Dokumentation dazugehört."
curriculum_ref: "in Code-Strukturen Fehlerquellen identifizieren und Optimierungsmöglichkeiten anwenden; Strategien zur Fehleranalyse: Trial-and-Error, Zwischenschritte ausgeben; eigene und fremde algorithmische Lösungen beurteilen; Bedeutung von Dokumentationen und Präsentationen erklären; kleines Programmierprojekt dokumentieren und präsentieren"
estimated_minutes: 30
reflect: "Beschreibe zwei Strategien, mit denen du einen Fehler in einem Programm findest, und erkläre, warum eine Dokumentation auch für dich selbst nützlich ist."
---
## Erklärung

### Bugs gehören dazu

Der Begriff **Bug** (Käfer) für Programmfehler ist alt: 1947 fand man in einem frühen Computer (Harvard Mark II) tatsächlich eine Motte, die ein Relais blockierte. Seitdem heißt Fehlersuche **Debugging**. Auch Profis machen Fehler – der Unterschied ist, dass sie systematisch suchen.

### Drei Arten von Fehlern

1. **Syntaxfehler**: Das Programm ist „falsch geschrieben“ – in Textsprachen etwa eine fehlende Klammer. Blocksprachen verhindern das meist, weil unpassende Bausteine nicht zusammenstecken.
2. **Laufzeitfehler**: Das Programm startet, stürzt aber ab – zum Beispiel Division durch null oder ein Zugriff auf ein Listenelement, das es nicht gibt.
3. **Logikfehler**: Das Programm läuft, tut aber das Falsche. Die Figur dreht sich in die falsche Richtung, die Punkte werden doppelt gezählt, die Grenze ist um eins daneben (`<` statt `<=`). Das sind die häufigsten und die schwersten – der Computer meldet nichts, er macht genau, was du gesagt hast, nur nicht, was du wolltest.

::: check
type: single_choice
prompt: "Das Spiel läuft, aber die Punkte werden doppelt gezählt. Welche Fehlerart ist das?"
options: ["Syntaxfehler", "Laufzeitfehler", "Logikfehler"]
answer: { index: 2 }
explanation: "Das Programm läuft, tut aber das Falsche – ein Logikfehler."
:::

### Strategien der Fehlersuche

**Zwischenschritte ausgeben.** Die wichtigste Strategie. Lass das Programm an verschiedenen Stellen Werte anzeigen: `sage punkte`, `sage i`. So siehst du, wo der Wert zum ersten Mal falsch ist. Manche Umgebungen zeigen Variablen live an (Scratch: Häkchen an der Variable).

**Schrittweise ausführen.** Programm langsam laufen lassen (Scratch: Turbo aus, „warte“-Blöcke einbauen) und beobachten, was bei jedem Schritt passiert.

**Eingrenzen.** Hälfte des Programms abklemmen (Blöcke abtrennen): Ist der Fehler noch da? Dann steckt er in der anderen Hälfte. Wieder halbieren. So findet man den Fehler in wenigen Schritten.

**Trial-and-Error (Versuch und Irrtum).** Etwas ändern, testen, beobachten. Sinnvoll, wenn man eine Vermutung hat – aber immer **eine Änderung auf einmal**, sonst weiß man nicht, was geholfen hat.

**Mit Grenzwerten testen.** 0, 1, negative Zahlen, sehr große Zahlen, leere Eingabe. Dort verstecken sich die meisten Logikfehler.

**Erklären.** Erkläre dein Programm Zeile für Zeile jemand anderem – oder einer Gummiente auf dem Schreibtisch („Rubber Duck Debugging“). Beim lauten Erklären fällt einem der Fehler oft selbst auf.

::: check
type: single_choice
prompt: "Du weißt nicht, an welcher Stelle die Variable punkte falsch wird. Was hilft am besten?"
options: ["Das Programm löschen und neu schreiben", "Zwischenschritte ausgeben: an mehreren Stellen „sage punkte“ einbauen", "Alles auf einmal ändern"]
answer: { index: 1 }
explanation: "So siehst du, wo der Wert zum ersten Mal falsch ist."
:::

### Optimieren: Besser statt nur richtig

Ein Programm, das funktioniert, ist nicht automatisch gut. Optimieren heißt: kürzer, lesbarer, schneller.

- Vier gleiche Befehle → eine Schleife
- Mehrfach der gleiche Block → ein Unterprogramm
- `x = x + 1` mit dem Namen `x` → `punkte` heißt, was es ist
- Verschachtelte Verzweigungen mit denselben Bedingungen → vereinfachen
- Feste Zahlen im Code („magische Zahlen“) → benannte Variable: `maxLeben = 3`

### Fremde Lösungen beurteilen

Zwei Programme lösen dieselbe Aufgabe. Welches ist besser? Fragen dafür: Ist es **richtig** (auch bei Grenzwerten)? Ist es **verständlich** (gute Namen, Unterprogramme)? Ist es **kurz** (keine Wiederholungen)? Ist es **änderbar** (kann man leicht eine Frage hinzufügen)? Meist ist das lesbarere Programm das bessere, auch wenn es zwei Zeilen länger ist.

### Dokumentieren: Für andere und für dich

Eine **Dokumentation** erklärt, was ein Programm tut und wie. Sie besteht aus:

- **Kommentaren im Code**: kurze Notizen an schwierigen Stellen („hier wird geprüft, ob der Rand erreicht ist“). In Scratch: Rechtsklick → Kommentar.
- **Einer Beschreibung**: Was macht das Programm? Wie bedient man es? Welche Unterprogramme gibt es, was tut jedes? Was funktioniert noch nicht?
- **Sprechenden Namen** für Variablen und Unterprogramme – die beste Dokumentation ist Code, der sich selbst erklärt.

Warum? Wer dein Programm nach drei Monaten öffnet, versteht es sonst nicht – und dieser Jemand bist oft **du selbst**. Im Team ist Dokumentation Pflicht.

::: check
type: true_false
prompt: "Eine Dokumentation ist nur für andere nützlich, nicht für den, der das Programm geschrieben hat."
answer: { value: false }
explanation: "Nach drei Monaten versteht man sein eigenes Programm oft nicht mehr – die Dokumentation hilft auch dir."
:::

### Präsentieren

Ein Projekt ist erst fertig, wenn andere es verstehen. Eine gute Präsentation: 1. Was war die Aufgabe? 2. Wie habe ich sie zerlegt (Unterprogramme)? 3. Vorführung. 4. Welche Fehler gab es und wie habe ich sie gefunden? 5. Was würde ich verbessern? Punkt 4 ist kein Makel – er zeigt, dass du systematisch gearbeitet hast.

## Hefteintrag

**Fehler finden, verbessern, dokumentieren**

**Fehlerarten:** Syntaxfehler (falsch geschrieben) · Laufzeitfehler (Absturz, z. B. Division durch 0) · **Logikfehler** (läuft, tut aber das Falsche – am häufigsten)

**Strategien der Fehlersuche (Debugging):**
1. **Zwischenschritte ausgeben** (`sage punkte`) – wo wird der Wert zuerst falsch?
2. Schrittweise ausführen und beobachten
3. Eingrenzen: Hälfte abklemmen, testen, wieder halbieren
4. **Trial-and-Error**: eine Änderung auf einmal, dann testen
5. Grenzwerte testen: 0, 1, negativ, sehr groß
6. Programm laut erklären

**Optimieren:** Wiederholungen → Schleife · gleiche Blöcke → Unterprogramm · gute Namen · feste Zahlen → benannte Variablen

**Lösungen beurteilen:** richtig? verständlich? kurz? änderbar?

**Dokumentation:** Kommentare im Code + Beschreibung (was, wie bedienen, welche Unterprogramme, was fehlt noch) + sprechende Namen. Für andere – und für dich in drei Monaten.

**Präsentation:** Aufgabe → Zerlegung → Vorführung → Fehler und ihre Lösung → Verbesserungsideen
