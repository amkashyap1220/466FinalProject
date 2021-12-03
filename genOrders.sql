/**
* Greg Gancarz
* sql script for creating 5 orders from 5 customers
**/

/** One of the five orders will not be default "processing", but processed. **/
/** Order total is $60 so we say they order one pair of 'WORK BOOTS' **/
INSERT INTO `ORDER`
  (STATUS, CARD_NUMBER, CARDHOLDER, CVV, BILLING_ZIP, ZIP, STREET_ADDRESS, CITY, STATE, TOTAL, NOTES)
  VALUES(
    'Processed',
    '123456',
    'Bob Ross',
    '123',
    '60180',
    '60180',
    '104 Elm St',
    'Aurora',
    'IL',
    '60',
    'WORK BOOTS x1'
);

/** Another of the five orders will not be default "processing", but 'shipped'. **/
/** Order total is $29 so we say they order one pair of 'BOLT CUTTER' **/
INSERT INTO `ORDER`
  (STATUS, CARD_NUMBER, CARDHOLDER, CVV, BILLING_ZIP, ZIP, STREET_ADDRESS, CITY, STATE, TOTAL, NOTES)
  VALUES(
    'Shipped',
    '121212',
    'Robert Twelve',
    '121',
    '60121',
    '60121',
    '3029 N Mulch St',
    'Carlisle',
    'NY',
    '29',
    'BOLT CUTTER x1'
);

/** Another of the five orders will not be default "processing", but 'delivered'. **/
/** Order total is $24 so we say they order one 'CROW BAR' **/
INSERT INTO `ORDER`
  (STATUS, CARD_NUMBER, CARDHOLDER, CVV, BILLING_ZIP, ZIP, STREET_ADDRESS, CITY, STATE, TOTAL, NOTES)
  VALUES(
    'Delivered',
    '505050',
    'Will Fitty',
    '050',
    '60505',
    '60505',
    '18 Hampton Ave',
    'Hamburg',
    'TN',
    '24',
    'CROW BAR'
);

/** Order total is $8 so we say they order one pair of 'SAFETY GOGGLES' **/
INSERT INTO `ORDER`
  (CARD_NUMBER, CARDHOLDER, CVV, BILLING_ZIP, ZIP, STREET_ADDRESS, CITY, STATE, TOTAL, NOTES)
  VALUES(
    '100100',
    'Marcus Cien',
    '100',
    '60100',
    '50923',
    '55 W 23rd St',
    'Burrville',
    'NY',
    '29',
    'SAFETY GOGGLES x1'
);

/** Order total is $35 so we say they order one can of 'PAINT CAN (BLACK)' **/
INSERT INTO `ORDER`
  (CARD_NUMBER, CARDHOLDER, CVV, BILLING_ZIP, ZIP, STREET_ADDRESS, CITY, STATE, TOTAL, NOTES)
  VALUES(
    '323303',
    'Tommy Trio',
    '303',
    '60331',
    '60331',
    '32 W Third St',
    'Peyton',
    'WY',
    '35',
    'PAINT CAN (BLACK) x1'
);
