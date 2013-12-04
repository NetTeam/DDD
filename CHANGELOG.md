## CHANGELOG ##

#### v1.1.6 (2012-12-04) ####
- Add autoflush parameter to doctrine based repository implementation.

#### v1.1.5 (2013-10-07) ####
- Dodanie obiektów clock

#### v1.1.4 (2013-08-27) ####
- Dodanie listenera Mockery do phpunit.xml.dist
- Refaktoryzacja istniejących Value Objects, dodanie Money, Percent i MoneyRange.
- Dodanie statycznych faktory w `Money`, `MoneyRange` i `Enum`
- Dodanie możliwości pominięcia walidacji w konstruktorze `Range`
- Zmiana sposobu walidowania `Range`

#### v1.1.3 (2013-07-04) ####
- Dodanie metody zwracającej posortowany alfabetycznie choice list w `EnumUtil`

#### v1.1.2 (2013-06-26) ####
- Dodanie domyślnej wartości w konstuktorze `Enum`

#### v1.1.1 (2013-06-12) ####
- Nowy value object `Money`
- Nowy value object `KeyValue`
- `DateRange` może przyjmować `null`

#### v1.1.0 (2013-03-21) ####
- [BC BREAK] Usunięcie ORMRepository.
- Generyczne repozytorium dla Doctrine. Pozwala na tworzenie repozytorium dla dowolnych klas obsługiwanych przez menedżera obiektów Doctrine (ORM, MongoDb).
- Implementacja metody `__toString()` w `Enum`. Dla wartości `StatusEnum::SOME_STATUS_CONST` zwraca `statusEnum.someStatusConst`.
- Utworzenie z `EnumUtil` pozwalającego na pobranie dostępnych wartości w Enumie.
- `Enum::__toString()` dla wartości `__NULL` zwraca pusty string

#### v1.0.0 (2013-02-19) ####
- Pierwsza wersja stabilna

