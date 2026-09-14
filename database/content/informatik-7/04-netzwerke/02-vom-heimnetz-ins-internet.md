---
title: "Vom Heimnetz ins Internet: Router, Server, Protokolle"
intro: "Was passiert, wenn du eine Webseite aufrufst: der Weg deiner Anfrage über Router, Provider und Server – und warum https wichtig ist."
curriculum_ref: "Übertragungsweg vom Heim- oder Schulnetzwerk ins Internet beschreiben; grundlegende Struktur des Internets anhand von Netzwerkknoten und deren Verbindungen beschreiben; Aufbau von Schul- und Heimnetzwerken visualisieren; Fachbegriffe: World Wide Web, Router, Protokoll; https-Protokoll"
estimated_minutes: 30
reflect: "Beschreibe den Weg einer Anfrage von deinem Handy bis zum Server einer Webseite und zurück, und erkläre, was https dabei schützt."
---
## Erklärung

### Das Heimnetzwerk

Zu Hause hängen Handy, Laptop, Fernseher, Drucker und Konsole am **Router**. Der Router ist das Herz des Heimnetzes: Er verbindet die Geräte untereinander (per WLAN und LAN) **und** er verbindet das ganze Heimnetz mit dem Internet – über die Telefon- oder Glasfaserleitung zum **Internetanbieter** (Provider, z. B. Telekom, Vodafone, 1&1).

Jedes Gerät im Netz hat eine **IP-Adresse** – eine Nummer, unter der es erreichbar ist, wie eine Hausnummer. Im Heimnetz vergibt der Router sie (z. B. 192.168.0.23). Nach außen hat das ganze Heimnetz eine gemeinsame öffentliche IP-Adresse vom Provider.

Ein Schulnetzwerk ist genauso aufgebaut, nur größer: viele Switches, mehrere WLAN-Zugangspunkte, ein eigener **Server** für Dateien und Anmeldung, eine **Firewall** und ein **Filter**, der bestimmte Seiten sperrt.

### Der Weg einer Anfrage

Du tippst `www.campusy.test` ins Handy. Was passiert?

1. **Handy → Router** (WLAN): „Ich will die Seite campusy.test.“
2. **Router → Provider**: Der Router leitet die Anfrage über die Leitung an den Provider weiter.
3. **Namensauflösung (DNS)**: Computer arbeiten mit IP-Adressen, nicht mit Namen. Ein **DNS-Server** (Domain Name System – das Telefonbuch des Internets) übersetzt `campusy.test` in eine IP-Adresse wie 49.13.218.218.
4. **Über das Internet**: Die Anfrage springt von Router zu Router (**Netzwerkknoten**) durch das Netz des Providers, über Internetknoten wie den DE-CIX in Frankfurt, bis zum Rechenzentrum, in dem der Server steht. Jeder Knoten schaut auf die Zieladresse und reicht weiter – wie ein Paket bei der Post. Oft sind es 10 bis 20 Stationen, in Millisekunden.
5. **Server antwortet**: Der **Server** (ein Computer, der Dienste anbietet) schickt die Webseite in Datenpaketen zurück – denselben Weg oder einen anderen.
6. **Router → Handy**: Der Router erkennt, welches Gerät gefragt hatte, und liefert die Antwort dorthin. Der Browser setzt die Pakete zur Seite zusammen.

Das Internet hat kein Zentrum: Fällt ein Knoten aus, nehmen die Pakete einen anderen Weg. Das war die Grundidee bei seiner Entwicklung.

::: check
type: single_choice
prompt: "Welche Aufgabe hat der DNS-Server?"
options: ["Er speichert Webseiten", "Er übersetzt Namen wie campusy.test in IP-Adressen", "Er verschlüsselt Daten"]
answer: { index: 1 }
explanation: "Das Telefonbuch des Internets."
:::

### Internet und World Wide Web sind nicht dasselbe

Das **Internet** ist die technische Infrastruktur: Kabel, Router, Server, Protokolle. Das **World Wide Web (WWW)** ist **ein** Dienst darauf – die Webseiten, die man mit dem Browser aufruft. Andere Dienste im Internet: E-Mail, Messenger, Online-Spiele, Videostreaming, Cloud-Speicher.

### Protokolle: Die Regeln der Verständigung

Damit ein Handy in Magdeburg mit einem Server in Kalifornien reden kann, brauchen beide dieselben Regeln: Wie sieht eine Anfrage aus, wie eine Antwort, wie werden Daten in Pakete zerlegt, wie bestätigt man den Empfang? Solche Regelwerke heißen **Protokolle**.

- **IP** (Internet Protocol): Adressierung und Weiterleitung der Pakete.
- **TCP**: sorgt dafür, dass alle Pakete ankommen und in der richtigen Reihenfolge zusammengesetzt werden.
- **HTTP** (HyperText Transfer Protocol): das Protokoll des WWW – so fragt der Browser Seiten an.
- **HTTPS** = HTTP **Secure**: dasselbe, aber **verschlüsselt**.
- Weitere: SMTP/IMAP für E-Mail, FTP für Dateien.

::: check
type: single_choice
prompt: "Was ist ein Protokoll im Netzwerk?"
options: ["Ein Mitschrieb der Sitzung", "Ein Regelwerk, wie Geräte Daten austauschen", "Ein Passwort"]
answer: { index: 1 }
explanation: "Ohne gemeinsame Regeln verstehen sich die Geräte nicht."
:::

### Warum https wichtig ist

Bei **http** wandern die Daten im Klartext durch alle Knoten. Wer im selben WLAN sitzt (Café, Bahnhof) oder an einem Knoten mitliest, sieht alles: Passwörter, Nachrichten, Kreditkartennummern. Bei **https** werden die Daten zwischen deinem Browser und dem Server **verschlüsselt** – Mitleser sehen nur Zeichensalat. Außerdem beweist ein **Zertifikat**, dass der Server wirklich der ist, für den er sich ausgibt.

Erkennbar am **Schloss-Symbol** in der Adresszeile und am `https://` am Anfang. Regel: **Nie Passwörter oder Zahlungsdaten auf einer Seite ohne https eingeben.** Moderne Browser warnen davor.

::: check
type: single_choice
prompt: "Eine Login-Seite beginnt mit http:// ohne Schloss. Was tust du?"
options: ["Passwort eingeben, ist ja nur ein Login", "Kein Passwort eingeben – die Daten wären unverschlüsselt mitlesbar", "Die Seite neu laden"]
answer: { index: 1 }
explanation: "Ohne https wandern Passwörter im Klartext durch alle Knoten."
:::

### Das Heimnetz zeichnen

Eine Skizze macht alles klar: In der Mitte der Router. Links das Internet (Wolke), verbunden über die Leitung zum Provider. Rechts die Geräte: Laptop und Konsole per Kabel (durchgezogene Linie), Handy, Tablet und Fernseher per WLAN (gestrichelt), der Drucker per WLAN. Beim Schulnetz kommen Switch, Server, Firewall und Filter zwischen Router und Geräte.

## Hefteintrag

**Vom Heimnetz ins Internet**

**Router** = Herz des Heimnetzes: verbindet die Geräte (LAN/WLAN) untereinander und mit dem Internet (über den **Provider**). Vergibt **IP-Adressen** (Nummern wie Hausnummern, z. B. 192.168.0.23).

**Weg einer Anfrage:**
1. Handy → Router → Provider
2. **DNS-Server** übersetzt den Namen (campusy.test) in eine IP-Adresse
3. Über viele **Netzwerkknoten** (Router) durchs Internet zum **Server**
4. Server schickt die Seite in Datenpaketen zurück → Router → Handy
Das Internet hat kein Zentrum – fällt ein Knoten aus, geht es anders herum.

**Internet** = Infrastruktur (Kabel, Router, Server). **World Wide Web** = ein Dienst darauf (Webseiten). Andere Dienste: E-Mail, Messenger, Streaming.

**Protokoll** = Regelwerk für die Verständigung. IP (Adressen), TCP (vollständig, richtige Reihenfolge), **HTTP** (Webseiten), **HTTPS** = HTTP verschlüsselt.

**https:** Daten verschlüsselt, Zertifikat beweist Echtheit des Servers. Schloss in der Adresszeile. Nie Passwörter ohne https eingeben!

**Schulnetz:** Router + Switches + WLAN-Zugangspunkte + Server + Firewall + Filter
