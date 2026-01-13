<?php

declare(strict_types=1);

namespace WebDevelovers\CodiceFiscale\Model;

use CodiceFiscale\Subject;
use DateTime;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;

use function in_array;
use function strlen;

readonly class TaxIDData
{
    private const array ALLOWED_TAX_ID_GENDERS = ['M', 'F'];

    public function __construct(
        public string $firstName,
        public string $lastName,
        public DateTimeInterface $birthDate,
        public string $gender,
        public string $belfioreCode,
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        $now = new DateTime();
        if ($this->birthDate > $now) {
            throw new InvalidArgumentException('Birthdate in the future: ' . $this->birthDate->format('d-m-Y'));
        }

        if (! in_array($this->gender, self::ALLOWED_TAX_ID_GENDERS)) {
            throw new InvalidArgumentException('Unsupported gender value: ' . $this->gender . '. Use M or F.');
        }

        if (strlen($this->belfioreCode) !== 4) {
            throw new InvalidArgumentException('Belfiore code must be exactly 4 characters: ' . $this->belfioreCode);
        }
    }

    /** @throws Exception */
    public function toSubject(): Subject
    {
        return new Subject([
            'name' => $this->firstName,
            'surname' => $this->lastName,
            'birthDate' => $this->birthDate->format('Y-m-d'),
            'gender' => $this->gender,
            'belfioreCode' => $this->belfioreCode,
        ]);
    }
}
