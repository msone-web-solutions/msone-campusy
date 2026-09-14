<?php

namespace App\Schedule;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

/**
 * Bewegungs-, Dehn- und Entspannungsübungen für die Pausen zu Hause.
 * Jede Übung hat einen Animations-Schlüssel (`anim`) für die Strichfigur im Frontend.
 *
 * @phpstan-type Exercise array{key: string, name: string, category: string, seconds: int, anim: string, how: string, tip: string}
 */
class ExerciseLibrary
{
    public const string STRETCH = 'dehnen';

    public const string MOBILITY = 'mobil';

    public const string STRENGTH = 'kraft';

    public const string CARDIO = 'ausdauer';

    public const string CALM = 'ruhe';

    /**
     * @return Collection<int, Exercise>
     */
    public function all(): Collection
    {
        return collect([
            ['key' => 'nacken', 'name' => 'Nacken kreisen', 'category' => self::MOBILITY, 'seconds' => 30, 'anim' => 'neck',
                'how' => 'Kopf langsam zur Seite neigen, nach vorn rollen, zur anderen Seite – nie nach hinten überstrecken.',
                'tip' => 'Schultern bleiben unten. Nach 15 Sekunden Richtung wechseln.'],
            ['key' => 'schultern', 'name' => 'Schultern kreisen', 'category' => self::MOBILITY, 'seconds' => 30, 'anim' => 'shoulders',
                'how' => 'Beide Schultern groß nach hinten kreisen: hoch zu den Ohren, nach hinten, unten, vorn.',
                'tip' => 'Löst die Schreibtisch-Verspannung. Erst rückwärts, dann vorwärts.'],
            ['key' => 'armkreisen', 'name' => 'Armkreisen', 'category' => self::MOBILITY, 'seconds' => 30, 'anim' => 'armcircles',
                'how' => 'Arme gestreckt seitlich ausstrecken und große Kreise malen, erst klein, dann immer größer.',
                'tip' => 'Nach 15 Sekunden Richtung wechseln.'],
            ['key' => 'seitneigen', 'name' => 'Seitneigen', 'category' => self::STRETCH, 'seconds' => 40, 'anim' => 'sidebend',
                'how' => 'Einen Arm über den Kopf strecken und den Oberkörper zur Gegenseite neigen. Kurz halten, Seite wechseln.',
                'tip' => 'Beide Füße bleiben fest am Boden, Hüfte bleibt gerade.'],
            ['key' => 'vorbeuge', 'name' => 'Vorbeuge', 'category' => self::STRETCH, 'seconds' => 30, 'anim' => 'forwardfold',
                'how' => 'Knie leicht gebeugt, Oberkörper locker nach vorn hängen lassen, Arme baumeln.',
                'tip' => 'Kopf schwer werden lassen und ruhig weiteratmen – nicht wippen.'],
            ['key' => 'huefte', 'name' => 'Hüfte kreisen', 'category' => self::MOBILITY, 'seconds' => 30, 'anim' => 'hips',
                'how' => 'Hände in die Hüften, Füße hüftbreit, mit dem Becken große Kreise ziehen.',
                'tip' => 'Wie Hula-Hoop ohne Reifen. Beide Richtungen.'],
            ['key' => 'rumpfdrehen', 'name' => 'Rumpfdrehen', 'category' => self::MOBILITY, 'seconds' => 30, 'anim' => 'twist',
                'how' => 'Arme auf Schulterhöhe anwinkeln und den Oberkörper locker nach links und rechts drehen.',
                'tip' => 'Der Blick folgt den Händen, die Füße bleiben stehen.'],
            ['key' => 'hampelmann', 'name' => 'Hampelmann', 'category' => self::CARDIO, 'seconds' => 40, 'anim' => 'jumpingjack',
                'how' => 'Beine grätschen und gleichzeitig Arme über den Kopf klatschen, zurück in die Ausgangsposition.',
                'tip' => 'Leise auf dem Ballen landen. Zu laut für die Nachbarn? Dann ohne Sprung nur die Arme.'],
            ['key' => 'kniebeugen', 'name' => 'Kniebeugen', 'category' => self::STRENGTH, 'seconds' => 40, 'anim' => 'squat',
                'how' => 'Füße schulterbreit, Po nach hinten wie beim Hinsetzen, Knie zeigen über die Zehen, wieder hochdrücken.',
                'tip' => 'Rücken gerade, Fersen bleiben am Boden. Ziel: 12 bis 15 Wiederholungen.'],
            ['key' => 'ausfallschritte', 'name' => 'Ausfallschritte', 'category' => self::STRENGTH, 'seconds' => 40, 'anim' => 'lunge',
                'how' => 'Großer Schritt nach vorn, hinteres Knie Richtung Boden senken, zurück – dann das andere Bein.',
                'tip' => 'Oberkörper aufrecht, das vordere Knie bleibt über dem Fuß.'],
            ['key' => 'knieheben', 'name' => 'Knie heben', 'category' => self::CARDIO, 'seconds' => 40, 'anim' => 'highknees',
                'how' => 'Auf der Stelle laufen und die Knie abwechselnd Richtung Hüfte ziehen, Arme schwingen mit.',
                'tip' => 'Tempo selbst wählen – am Ende darfst du außer Atem sein.'],
            ['key' => 'wadenheben', 'name' => 'Wadenheben', 'category' => self::STRENGTH, 'seconds' => 30, 'anim' => 'calfraise',
                'how' => 'Auf die Zehenspitzen hochdrücken, kurz halten, langsam wieder absenken.',
                'tip' => 'Zum Ausgleich an einer Stuhllehne festhalten.'],
            ['key' => 'schattenboxen', 'name' => 'Schattenboxen', 'category' => self::CARDIO, 'seconds' => 40, 'anim' => 'boxing',
                'how' => 'Leicht in den Knien federn und abwechselnd mit links und rechts in die Luft boxen.',
                'tip' => 'Aus der Hüfte drehen, nicht nur aus dem Arm.'],
            ['key' => 'unterarmstuetz', 'name' => 'Unterarmstütz', 'category' => self::STRENGTH, 'seconds' => 30, 'anim' => 'plank',
                'how' => 'Unterarme und Zehen am Boden, Körper bildet eine gerade Linie von Kopf bis Ferse.',
                'tip' => 'Bauch fest, Po nicht in die Höhe. Wenn es zu schwer ist: Knie ablegen.'],
            ['key' => 'wandsitz', 'name' => 'Wandsitz', 'category' => self::STRENGTH, 'seconds' => 30, 'anim' => 'wallsit',
                'how' => 'Mit dem Rücken an der Wand hinunterrutschen, bis die Knie im rechten Winkel sind – und halten.',
                'tip' => 'Die Oberschenkel brennen? Genau richtig.'],
            ['key' => 'augen', 'name' => 'Augen entspannen', 'category' => self::CALM, 'seconds' => 20, 'anim' => 'eyes',
                'how' => 'Weg vom Bildschirm: 20 Sekunden lang auf etwas schauen, das mindestens 6 Meter entfernt ist.',
                'tip' => 'Am besten aus dem Fenster. Zwischendurch ein paar Mal bewusst blinzeln.'],
            ['key' => 'atmen', 'name' => 'Ruhig atmen', 'category' => self::CALM, 'seconds' => 45, 'anim' => 'breathe',
                'how' => '4 Sekunden einatmen, 4 Sekunden halten, 6 Sekunden ausatmen. Dem Kreis auf dem Bildschirm folgen.',
                'tip' => 'Bringt den Puls runter und den Kopf frei für den nächsten Block.'],
        ]);
    }

    /**
     * Aufwärmen am Morgen: sanfte Mobilisation.
     *
     * @return Collection<int, Exercise>
     */
    public function warmup(CarbonInterface $date): Collection
    {
        return $this->pick($date, 'warmup', [self::MOBILITY => 2, self::STRETCH => 1]);
    }

    /**
     * Bewegungspause: Ausdauer, Kraft und ein bisschen Dehnen.
     *
     * @return Collection<int, Exercise>
     */
    public function movementBreak(CarbonInterface $date, int $index): Collection
    {
        return $this->pick($date, 'break'.$index, [self::CARDIO => 2, self::STRENGTH => 2, self::STRETCH => 1]);
    }

    /**
     * Mikropause mitten in der Doppelstunde: Augen, kurz bewegen.
     *
     * @return Collection<int, Exercise>
     */
    public function microBreak(): Collection
    {
        return $this->all()->whereIn('key', ['augen', 'schultern'])->values();
    }

    /**
     * Abschluss des Schultags: Dehnen und runterkommen.
     *
     * @return Collection<int, Exercise>
     */
    public function cooldown(CarbonInterface $date): Collection
    {
        return $this->pick($date, 'cooldown', [self::STRETCH => 2, self::MOBILITY => 1])
            ->push($this->all()->firstWhere('key', 'atmen'));
    }

    /**
     * Wählt pro Kategorie deterministisch (abhängig vom Datum) Übungen aus, damit
     * jeder Tag anders aussieht, ein Reload aber denselben Plan zeigt.
     *
     * @param  array<string, int>  $quota
     * @return Collection<int, Exercise>
     */
    private function pick(CarbonInterface $date, string $salt, array $quota): Collection
    {
        $seed = $date->format('Ymd').$salt;

        return collect($quota)
            ->flatMap(fn (int $count, string $category) => $this->all()
                ->where('category', $category)
                ->sortBy(fn (array $exercise) => crc32($seed.$exercise['key']))
                ->take($count))
            ->values();
    }
}
