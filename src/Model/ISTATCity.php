<?php

declare(strict_types=1);

namespace WebDevelovers\CodiceFiscale\Model;

use InvalidArgumentException;

use function count;

readonly class ISTATCity
{
    private function __construct(
        public string $codiceRegione,
        public string $codiceUnitaTerritoriale,
        public string $codiceProvinciaStorico,
        public string $progressivoComune,
        public string $codiceComuneAlfanumerico,
        public string $denominazioneItalianaStraniera,
        public string $denominazioneItaliano,
        public string $denominazioneAltraLingua,
        public int $codiceRipartizioneGeografica,
        public string $ripartizioneGeografica,
        public string $denominazioneRegione,
        public string $denominazioneUnitaTerritoriale,
        public int $tipologiaUnitaTerritoriale,
        public bool $flagComuneCapoluogo,
        public string $siglaAutomobilistica,
        public int $codiceComuneNumerico,
        public int $codiceComuneNumerico110Province,
        public int $codiceComuneNumerico107Province,
        public int $codiceComuneNumerico103Province,
        public string $codiceCatastaleComune,
        public string $codiceNUTS12021,
        public string $codiceNUTS22021,
        public string $codiceNUTS32021,
        public string $codiceNUTS12024,
        public string $codiceNUTS22024,
        public string $codiceNUTS32024,
    ) {
    }

    /** @param array<string, int|string|null> $data */
    public static function fromISTATDataArray(array $data): self
    {
        if (count($data) < 20) {
            throw new InvalidArgumentException('Dati ISTAT incompleti o non mappati correttamente per creare la città.');
        }

        return new self(
            codiceRegione: (string) ($data['codiceRegione'] ?? ''),
            codiceUnitaTerritoriale: (string) ($data['codiceUnitaTerritoriale'] ?? ''),
            codiceProvinciaStorico: (string) ($data['codiceProvinciaStorico'] ?? ''),
            progressivoComune: (string) ($data['progressivoComune'] ?? ''),
            codiceComuneAlfanumerico: (string) ($data['codiceComuneAlfanumerico'] ?? ''),
            denominazioneItalianaStraniera: (string) ($data['denominazioneItalianaStraniera'] ?? ''),
            denominazioneItaliano: (string) ($data['denominazioneItaliano'] ?? ''),
            denominazioneAltraLingua: (string) ($data['denominazioneAltraLingua'] ?? ''),
            codiceRipartizioneGeografica: (int) ($data['codiceRipartizioneGeografica'] ?? 0),
            ripartizioneGeografica: (string) ($data['ripartizioneGeografica'] ?? ''),
            denominazioneRegione: (string) ($data['denominazioneRegione'] ?? ''),
            denominazioneUnitaTerritoriale: (string) ($data['denominazioneUnitaTerritoriale'] ?? ''),
            tipologiaUnitaTerritoriale: (int) ($data['tipologiaUnitaTerritoriale'] ?? 0),
            flagComuneCapoluogo: (bool) ($data['flagComuneCapoluogo'] ?? false),
            siglaAutomobilistica: (string) ($data['siglaAutomobilistica'] ?? ''),
            codiceComuneNumerico: (int) ($data['codiceComuneNumerico'] ?? 0),
            codiceComuneNumerico110Province: (int) ($data['codiceComuneNumerico110Province'] ?? 0),
            codiceComuneNumerico107Province: (int) ($data['codiceComuneNumerico107Province'] ?? 0),
            codiceComuneNumerico103Province: (int) ($data['codiceComuneNumerico103Province'] ?? 0),
            codiceCatastaleComune: (string) ($data['codiceCatastaleComune'] ?? ''),
            codiceNUTS12021: (string) ($data['codiceNUTS12021'] ?? ''),
            codiceNUTS22021: (string) ($data['codiceNUTS22021'] ?? ''),
            codiceNUTS32021: (string) ($data['codiceNUTS32021'] ?? ''),
            codiceNUTS12024: (string) ($data['codiceNUTS12024'] ?? ''),
            codiceNUTS22024: (string) ($data['codiceNUTS22024'] ?? ''),
            codiceNUTS32024: (string) ($data['codiceNUTS32024'] ?? ''),
        );
    }
}
