# Italian Codice Fiscale Utility (with ISTAT Data)

This library is a PHP utility for calculating, validating, and reversing the Italian Tax ID (*Codice Fiscale*). It acts as a **Facade and Wrapping library** for the excellent [davidepastore/codice-fiscale](https://github.com/davidepastore/codice-fiscale).

## Key Features

- **Calculations & Validation**: Easily calculate tax IDs for people and validate formats or data consistency.
- **Enhanced Inverse Calculation**: Unlike standard libraries, reversing a Tax ID here doesn't just give you raw codes. It automatically links the results to **official ISTAT geographic data**.
- **Real Geographic Data**: Includes updated ISTAT datasets (municipalities, provinces, regions, and NUTS codes) to provide full context (e.g., city names, car license plates) from a simple Belfiore code.
- **Exception Wrapping**: All internal errors and logic failures from the core library are wrapped into custom, domain-specific exceptions for better error handling in your applications.

## Acknowledgements

This project would not be possible without the work of **Davide Pastore**. This library wraps his core logic to provide a more "ready-to-use" experience for developers who need ISTAT data integration out of the box.

Special thanks to:
- [Davide Pastore](https://github.com/davidepastore) for the [codice-fiscale](https://github.com/davidepastore/codice-fiscale) PHP library.

## Installation

```bash
composer require webdevelovers/codice-fiscale
```