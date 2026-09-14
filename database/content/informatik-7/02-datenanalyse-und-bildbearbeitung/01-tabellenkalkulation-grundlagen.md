---
title: "Tabellenkalkulation: Zeilen, Spalten, Zellen und Datenformate"
intro: "Wie eine Tabellenkalkulation aufgebaut ist, wie man Zellen anspricht, Daten richtig eingibt und formatiert – Währung, Datum, Zahl."
curriculum_ref: "Datensätze in einem Tabellenkalkulationsprogramm erstellen und bearbeiten; Aufbau von Tabellen: Zeile, Spalte, Zelle; Datenformate: Währung, Datum; Tastenkombinationen für effizientes Arbeiten anwenden"
estimated_minutes: 25
reflect: "Erkläre, wie eine Zelle in einer Tabellenkalkulation benannt wird, und warum es einen Unterschied macht, ob eine Zelle als Zahl, Text oder Datum formatiert ist."
---
## Erklärung

### Was ist eine Tabellenkalkulation?

Eine **Tabellenkalkulation** (Excel, LibreOffice Calc, Google Tabellen, Numbers) ist ein Programm für Tabellen, die **rechnen** können. Du trägst Daten ein – Noten, Taschengeld, Messwerte einer Umfrage – und das Programm berechnet Summen, Durchschnitte und zeichnet Diagramme. Ändert sich eine Zahl, rechnet es automatisch alles neu.

### Der Aufbau: Zeilen, Spalten, Zellen

- **Spalten** laufen senkrecht und heißen A, B, C, … (nach Z kommt AA, AB, …).
- **Zeilen** laufen waagerecht und sind nummeriert: 1, 2, 3, …
- Das Kästchen, in dem sich Spalte und Zeile treffen, ist eine **Zelle**. Sie heißt nach Spalte und Zeile: **B3** ist die Zelle in Spalte B, Zeile 3. Immer erst der Buchstabe, dann die Zahl.
- Mehrere Zellen zusammen sind ein **Bereich**: **A1:A10** sind die Zellen A1 bis A10 (die Spalte A von Zeile 1 bis 10), **B2:D5** ein Rechteck von B2 bis D5.
- Ein Dokument hat mehrere **Tabellenblätter** (Reiter unten).

Die Zelle, die gerade ausgewählt ist, heißt **aktive Zelle**; ihre Adresse steht links oben im **Namensfeld**, ihr Inhalt in der **Eingabezeile** (Bearbeitungsleiste).

::: check
type: single_choice
prompt: "Wie heißt die Zelle in Spalte D, Zeile 7?"
options: ["7D", "D7", "D:7"]
answer: { index: 1 }
explanation: "Erst der Spaltenbuchstabe, dann die Zeilennummer: D7."
:::

### Ein Datensatz: Jede Zeile ein Eintrag

Daten ordnet man so: **Erste Zeile = Überschriften** (Name, Klasse, Note …), **jede weitere Zeile = ein Datensatz** (ein Schüler, eine Messung, ein Einkauf). Jede Spalte enthält immer dieselbe Art von Angabe. Das ist die Grundregel für alles, was später kommt: Sortieren, Filtern, Diagramme.

| | A | B | C | D |
|---|---|---|---|---|
| 1 | Artikel | Anzahl | Einzelpreis | Datum |
| 2 | Heft | 3 | 0,85 € | 02.09.2026 |
| 3 | Stift | 2 | 1,20 € | 02.09.2026 |
| 4 | Zirkel | 1 | 6,90 € | 05.09.2026 |

### Datenformate: Zahl, Text, Währung, Datum, Prozent

Eine Zelle kann verschieden **formatiert** sein. Das Format bestimmt, wie der Inhalt angezeigt wird und ob man damit rechnen kann:

- **Zahl**: 12 · 3,5 · mit einstellbaren Dezimalstellen. Zahlen stehen **rechtsbündig**.
- **Text**: „Heft“, „7b“. Text steht **linksbündig**. Mit Text kann man nicht rechnen. Achtung: Eine Postleitzahl 06108 muss als Text formatiert sein, sonst wird daraus 6108.
- **Währung**: 0,85 € – eine Zahl mit Währungszeichen und zwei Dezimalstellen. Man kann damit rechnen.
- **Datum**: 02.09.2026 – intern eine Zahl (Tage seit 1900), deshalb kann man Daten voneinander abziehen: „Wie viele Tage bis zu den Ferien?“
- **Prozent**: 0,25 wird als 25 % angezeigt.
- **Uhrzeit**: 14:30.

Das Format änderst du über Rechtsklick → Zellen formatieren (oder die Symbolleiste: €, %, Dezimalstellen).

**Häufiger Fehler:** Du tippst „0,85 €“ mit Leerzeichen und Eurozeichen als Text ein – dann rechnet das Programm nicht damit. Richtig: nur 0,85 eintippen und die Zelle als Währung formatieren.

::: check
type: single_choice
prompt: "Du tippst in eine Zelle „3,50 Euro“ als Text. Was passiert bei =A1*2?"
options: ["7 Euro", "Fehler oder 0 – mit Text kann das Programm nicht rechnen", "3,50 Euro"]
answer: { index: 1 }
explanation: "Nur die Zahl 3,5 eingeben und die Zelle als Währung formatieren."
:::

### Daten eingeben und bearbeiten

- Zelle anklicken, tippen, **Enter** (eine Zeile nach unten) oder **Tab** (eine Zelle nach rechts).
- Zelleninhalt ändern: Doppelklick oder **F2**.
- Zeile oder Spalte einfügen/löschen: Rechtsklick auf Zeilennummer bzw. Spaltenbuchstaben.
- Spaltenbreite: Doppelklick auf die Linie zwischen zwei Spaltenbuchstaben passt sie automatisch an.
- Sortieren: Daten markieren → Daten → Sortieren nach Spalte (aufsteigend/absteigend). Immer die ganze Tabelle markieren, sonst werden die Zeilen auseinandergerissen!

::: check
type: single_choice
prompt: "Was musst du beim Sortieren beachten?"
options: ["Nur eine Spalte markieren", "Die ganze Tabelle markieren, damit die Zeilen zusammenbleiben", "Vorher alles löschen"]
answer: { index: 1 }
explanation: "Sonst werden Namen und Noten auseinandergerissen."
:::

### Tastenkombinationen, die Zeit sparen

| Tasten | Wirkung |
|---|---|
| Strg + C / Strg + V | kopieren / einfügen |
| Strg + X | ausschneiden |
| Strg + Z | rückgängig |
| Strg + S | speichern |
| Strg + A | alles markieren |
| Strg + Pfeil | zum Ende des Datenbereichs springen |
| Strg + Pos1 | zu A1 springen |
| Shift + Pfeil | Markierung erweitern |
| F2 | Zelle bearbeiten |
| Enter / Tab | nach unten / nach rechts |

Auf dem Mac steht Cmd statt Strg.

## Hefteintrag

**Tabellenkalkulation – Grundlagen**

Eine **Tabellenkalkulation** ist ein Programm für Tabellen, die rechnen können (Excel, Calc, Google Tabellen).

**Aufbau:** Spalten A, B, C … (senkrecht) · Zeilen 1, 2, 3 … (waagerecht) · **Zelle** = Kreuzung, z. B. **B3** (Spalte B, Zeile 3) · **Bereich** z. B. **A1:A10**

**Datensatz:** 1. Zeile = Überschriften, jede weitere Zeile = ein Eintrag, jede Spalte = eine Angabe.

**Datenformate:**
- Zahl (rechtsbündig, rechenbar) · Text (linksbündig, nicht rechenbar; PLZ als Text!)
- Währung: 0,85 € · Datum: 02.09.2026 (intern eine Zahl → Tage berechenbar) · Prozent: 25 %
Format: Rechtsklick → Zellen formatieren. Nur die Zahl eintippen, dann formatieren.

**Tasten:** Strg+C/V kopieren/einfügen · Strg+Z rückgängig · Strg+S speichern · Strg+A alles · F2 bearbeiten · Enter nach unten, Tab nach rechts

**Sortieren:** ganze Tabelle markieren, sonst werden Zeilen auseinandergerissen.
