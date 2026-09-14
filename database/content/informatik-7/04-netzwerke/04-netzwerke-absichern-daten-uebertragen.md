---
title: "Netzwerke absichern und Daten sicher übertragen"
intro: "Firewall, Filter, Passwörter, Gast-WLAN – wie man ein Netzwerk schützt – und wie man Dateien richtig weitergibt: Formate, Scans, Zugriffsschutz."
curriculum_ref: "einfache Maßnahmen zur Absicherung von Netzwerken im Schulnetzwerk erarbeiten und deren Bedeutung diskutieren; Daten mithilfe geeigneter Geräte organisieren und übertragen; Maßnahmen: Firewall, Filter, Passwort, Gast-WLAN; Datenübertragung: Dateiformate, gescannte Dokumente, Schutzmaßnahmen (Sperrung zur Bearbeitung, Zugriffsschutz); Fachbegriffe: Firewall, Repeater"
estimated_minutes: 30
reflect: "Nenne vier Maßnahmen, mit denen ein Schulnetzwerk abgesichert wird, und erkläre bei jeder, wovor sie schützt."
---
## Erklärung

### Warum Netzwerke Schutz brauchen

Ein Netzwerk ist eine Tür nach draußen – und drinnen liegen Fotos, Dokumente, Passwörter, Zeugnisse. Gefahren: Fremde, die sich ins WLAN hängen; Schadsoftware, die von einem Gerät auf alle anderen springt; Angreifer aus dem Internet; und ganz banal: Mitschüler, die auf dem Schulserver in fremden Ordnern stöbern. Schutz besteht aus mehreren Schichten.

### Die Firewall

Eine **Firewall** („Brandmauer“) steht zwischen dem Netzwerk und dem Internet und prüft jeden Datenverkehr: Was darf rein, was darf raus? Sie blockiert unerwünschte Verbindungen – etwa Angriffe von außen oder Programme, die heimlich Daten nach Hause funken. Im Router ist eine einfache Firewall eingebaut; in Schulen und Firmen steht oft ein eigenes Gerät. Auch Windows und macOS haben eine Firewall auf jedem Rechner. Sie sollte immer an sein.

### Der Filter

Ein **Filter** (Inhaltsfilter, Webfilter) sperrt bestimmte Webseiten oder Inhalte: Gewalt, Pornografie, Glücksspiel, bekannte Betrugsseiten – und in Schulen oft auch Spiele und Social Media während des Unterrichts. Er arbeitet mit Listen und Kategorien. Ein Filter ist kein perfekter Schutz, aber er hält das Gröbste fern und ist in Schulnetzen Pflicht (Jugendschutz).

::: check
type: single_choice
prompt: "Was macht eine Firewall?"
options: ["Sie löscht Viren auf dem Rechner", "Sie prüft den Datenverkehr zwischen Netzwerk und Internet und blockiert Unerwünschtes", "Sie verlängert das WLAN"]
answer: { index: 1 }
explanation: "Die Brandmauer zwischen drinnen und draußen."
:::

### Passwörter

Das WLAN-Passwort, das Router-Passwort, das Anmeldepasswort am Schulserver – Passwörter sind die Schlüssel des Netzwerks. Regeln für gute Passwörter:

- **Lang**: mindestens 12 Zeichen. Länge schlägt Komplexität.
- **Nicht erratbar**: kein Name, Geburtsdatum, „Passwort123“, „qwertz“.
- **Merksatz-Methode**: „Mein Hund Bello frisst 3 Knochen am Tag!“ → `MHBf3KaT!` – oder gleich den ganzen Satz als **Passphrase**.
- **Für jeden Dienst ein anderes** – sonst öffnet ein geklautes Passwort alle Türen. Ein **Passwort-Manager** merkt sie sich.
- **Nie weitergeben**, auch nicht an Freunde. Nie auf Zettel am Monitor.
- **Zwei-Faktor-Authentifizierung** (2FA), wo möglich: Passwort plus Code vom Handy.
- **Router-Standardpasswort ändern** – „admin/admin“ kennt jeder.

### Das Gast-WLAN

Besucher und Gäste bekommen ein eigenes **Gast-WLAN**: Es führt ins Internet, aber **nicht ins Heimnetz**. Gäste sehen weder Drucker noch Server noch andere Geräte. So bleibt das Hauptnetz geschützt, selbst wenn ein Gastgerät verseucht ist. Auch Smart-Home-Geräte (Steckdosen, Lampen) gehören besser ins Gastnetz. In der Schule: ein Netz für Verwaltung, eines für Unterricht, eines für Gäste – streng getrennt.

::: check
type: single_choice
prompt: "Warum bekommen Besucher ein Gast-WLAN?"
options: ["Weil es schneller ist", "Weil Gäste dann ins Internet kommen, aber nicht auf Drucker, Server und andere Geräte im Heimnetz", "Weil es kostenlos ist"]
answer: { index: 1 }
explanation: "Das Hauptnetz bleibt abgeschottet."
:::

### Weitere Maßnahmen

- **Updates** für Router, Computer, Handys – schließen Sicherheitslücken.
- **Virenschutz** auf den Rechnern.
- **WLAN-Verschlüsselung** WPA2/WPA3, WPS abschalten.
- **Zugriffsrechte** auf dem Server: Jeder sieht nur seine eigenen Ordner und die seiner Klasse. Lehrer-Ordner sind für Schüler unsichtbar.
- **Backups**: Wenn doch etwas passiert, sind die Daten nicht weg.
- **Aufklärung**: Die meisten Einbrüche passieren durch Menschen – Phishing, weitergegebene Passwörter, USB-Sticks vom Parkplatz. Wissen ist die beste Firewall.

### Daten übertragen: Geräte und Wege

Dateien wandern per **USB-Stick** oder externe Festplatte (schnell, offline, aber Verlustgefahr und Virenrisiko), per **E-Mail-Anhang** (bis ca. 10 MB), per **Cloud** (Nextcloud, iServ, OneDrive, Google Drive – Link teilen, große Dateien, gemeinsames Arbeiten), per **Bluetooth/AirDrop/Nearby Share** zwischen Geräten in der Nähe, oder per **Netzwerkfreigabe** auf dem Schulserver (Tauschordner).

### Dateiformate: Was der Empfänger öffnen kann

Ein Format, das der Empfänger nicht öffnen kann, ist nutzlos. Faustregeln:

- **Texte, Referate, Bewerbungen**: als **PDF** – sieht überall gleich aus, lässt sich nicht versehentlich ändern, jedes Gerät kann es öffnen. Nur zum gemeinsamen Bearbeiten das Originalformat (DOCX, ODT).
- **Bilder**: JPG oder PNG (Thema 2.5).
- **Tabellen**: XLSX/ODS zum Bearbeiten, PDF zum Vorzeigen.
- **Präsentationen**: PPTX/ODP oder PDF.
- **Mehrere Dateien**: als **ZIP** zusammenpacken.
- Dateiendung immer anzeigen lassen – `Rechnung.pdf.exe` ist ein Trick.

### Gescannte Dokumente

Ein Zeugnis, ein Formular, eine Unterschrift: **Scannen** mit dem Scanner oder der Handy-App (Notizen-App, Adobe Scan, Office Lens). Tipps: gerade und gut beleuchtet, als **PDF** speichern (mehrere Seiten in einer Datei), Texterkennung (**OCR**) einschalten, damit der Text durchsuchbar wird, Auflösung 200–300 dpi. Sinnvoller Dateiname mit Datum: `2026-09-14_Zeugnis_Klasse6.pdf`.

::: check
type: single_choice
prompt: "Du schickst dein Referat an den Lehrer. Welches Format ist am sichersten, dass es überall gleich aussieht und niemand versehentlich etwas ändert?"
options: ["DOCX", "PDF", "TXT"]
answer: { index: 1 }
explanation: "PDF sieht überall gleich aus und ist nicht versehentlich änderbar."
:::

### Schutz beim Weitergeben

- **Schreibschutz / Sperrung zur Bearbeitung**: Ein PDF oder Dokument als „nur lesen“ freigeben – der Empfänger kann es sehen, aber nicht ändern. In Word: Dokument schützen; in der Cloud: Link „Nur ansehen“ statt „Bearbeiten“.
- **Zugriffsschutz mit Passwort**: PDF oder ZIP mit Passwort versehen; das Passwort auf einem anderen Weg (Telefon, Chat) mitteilen, nie in derselben Mail.
- **Freigabe-Links mit Ablaufdatum** und nur an bestimmte Personen statt „jeder mit dem Link“.
- **Metadaten prüfen**: Dokumente speichern Autor, Änderungen, Kommentare – vor dem Versenden entfernen.
- **Nur, was nötig ist**: Personenbezogene Daten (Adressen, Noten, Gesundheit) so wenig wie möglich weitergeben.

## Hefteintrag

**Netzwerke absichern und Daten übertragen**

**Schutz in Schichten:**
- **Firewall**: prüft den Datenverkehr zwischen Netz und Internet, blockiert Angriffe und heimliche Verbindungen
- **Filter**: sperrt Webseiten/Inhalte (Jugendschutz, Betrugsseiten; in der Schule Pflicht)
- **Passwörter**: lang (12+), nicht erratbar, Merksatz-Methode, für jeden Dienst anders, nie weitergeben, 2FA, Router-Standardpasswort ändern
- **Gast-WLAN**: Internet ja, Heimnetz nein – Gäste und Smart-Home-Geräte hinein
- außerdem: Updates, Virenschutz, WPA2/WPA3, Zugriffsrechte auf dem Server, Backups, Aufklärung

**Daten übertragen:** USB-Stick · E-Mail (< 10 MB) · Cloud (Link) · AirDrop/Bluetooth · Netzwerkfreigabe

**Dateiformate:** Texte zum Vorzeigen als **PDF**, zum Bearbeiten DOCX/ODT · Bilder JPG/PNG · mehrere Dateien als ZIP · Endungen anzeigen (`.pdf.exe` = Trick)

**Scannen:** gerade, gut beleuchtet, als PDF, mit OCR, 200–300 dpi, Dateiname mit Datum

**Schutz beim Weitergeben:** Schreibschutz („nur ansehen“) · Passwort für PDF/ZIP (Passwort auf anderem Weg) · Links mit Ablaufdatum · Metadaten entfernen · so wenig persönliche Daten wie möglich
