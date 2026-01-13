<?php

declare(strict_types=1);

namespace WebDevelovers\CodiceFiscale\Model;

use CodiceFiscale\Subject;
use DateTimeInterface;
use WebDevelovers\CodiceFiscale\Exception\ISTATDataException;
use WebDevelovers\CodiceFiscale\ISTATUtils;

use function strtoupper;

readonly class InverseData
{
    private function __construct(
        public DateTimeInterface $birthDate,
        public string $gender,
        public string $belfioreCode,
        public ISTATCity|null $istatData = null,
    ) {
    }

    public static function fromSubject(Subject $subject): self
    {
        $belfiore = strtoupper($subject->getBelfioreCode());
        $istatCity = null;

        try {
            $istatCity = ISTATUtils::findCityByField('codiceCatastaleComune', $belfiore);
        } catch (ISTATDataException) {
        }

        return new self(
            $subject->getBirthDate(),
            strtoupper($subject->getGender()),
            $subject->getBelfioreCode(),
            $istatCity,
        );
    }
}