<?php

declare(strict_types=1);

namespace WebDevelovers\CodiceFiscale;

use WebDevelovers\CodiceFiscale\Exception\ISTATDataException;
use WebDevelovers\CodiceFiscale\Model\ISTATCity;

use function count;
use function fclose;
use function fgetcsv;
use function file_exists;
use function fopen;
use function mb_convert_encoding;
use function preg_replace;

class ISTATUtils
{
    /** @throws ISTATDataException */
    public static function findCityByField(string $fieldName, string $value, string $csvFilePath = __DIR__ . '/data/elenco_comuni_2026.csv'): ISTATCity|null
    {
        if (! file_exists($csvFilePath)) {
            throw new ISTATDataException('ISTAT data file not found at: ' . $csvFilePath);
        }

        $handle = fopen($csvFilePath, 'r');
        if ($handle === false) {
            throw new ISTATDataException('Cannot open CSV file.');
        }

        if (fgetcsv($handle, separator: ';', escape: '\\') === false) {
            fclose($handle);

            throw new ISTATDataException('Unable to parse ISTAT data headers.');
        }

        $searchValue = self::cleanString($value);

        while (($row = fgetcsv($handle, separator: ';', escape: '\\')) !== false) {
            if (count($row) !== 27) {
                continue;
            }

            $data = self::mapIstatDataToArray($row);

            if (isset($data[$fieldName]) && self::cleanString((string) $data[$fieldName]) === $searchValue) {
                fclose($handle);

                return ISTATCity::fromISTATDataArray($data);
            }
        }

        fclose($handle);

        return null;
    }

    /**
     * @param array<int, mixed> $istatData
     *
     * @return array<string, mixed> $istatData
     */
    private static function mapIstatDataToArray(array $istatData): array
    {
        return [
            'codiceRegione' => $istatData[0],
            'codiceUnitaTerritoriale' => $istatData[1],
            'codiceProvinciaStorico' => $istatData[2],
            'progressivoComune' => $istatData[3],
            'codiceComuneAlfanumerico' => $istatData[4],
            'denominazioneItalianaStraniera' => $istatData[5],
            'denominazioneItaliano' => $istatData[6],
            'denominazioneAltraLingua' => $istatData[7],
            'codiceRipartizioneGeografica' => $istatData[8],
            'ripartizioneGeografica' => $istatData[9],
            'denominazioneRegione' => $istatData[10],
            'denominazioneUnitaTerritoriale' => $istatData[11],
            'tipologiaUnitaTerritoriale' => $istatData[12],
            'flagComuneCapoluogo' => $istatData[13],
            'siglaAutomobilistica' => $istatData[14],
            'codiceComuneNumerico' => $istatData[15],
            'codiceComuneNumerico110Province' => $istatData[17],
            'codiceComuneNumerico107Province' => $istatData[18],
            'codiceComuneNumerico103Province' => $istatData[19],
            'codiceCatastaleComune' => $istatData[20],
            'codiceNUTS12021' => $istatData[21],
            'codiceNUTS22021' => $istatData[22],
            'codiceNUTS32021' => $istatData[23],
            'codiceNUTS12024' => $istatData[24],
            'codiceNUTS22024' => $istatData[25],
            'codiceNUTS32024' => $istatData[26],
        ];
    }

    /** @throws ISTATDataException */
    public static function findCityByName(string $cityName): ISTATCity|null
    {
        return self::findCityByField('denominazioneItaliano', $cityName);
    }

    /** @return ISTATCity[] */
    public static function getCities(string $csvFilePath = __DIR__ . '/data/istat_2024.csv'): array
    {
        $cities = [];
        $handle = fopen($csvFilePath, 'r');

        if ($handle !== false) {
            fgetcsv($handle, separator: ';', escape: '\\');

            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                $cities[] = ISTATCity::fromISTATDataArray($data);
            }

            fclose($handle);
        }

        return $cities;
    }

    /** cleanup string converting to UTF-8 and removing non valid characters */
    private static function cleanString(string $string): string
    {
        $utf8String = mb_convert_encoding($string, 'UTF-8', 'auto');
        $newString = preg_replace('/[^\x20-\x7E]/', '', $utf8String);
        if ($newString === null) {
            throw new ISTATDataException('String could not be encoded: ' . $string);
        }

        return $newString;
    }
}
