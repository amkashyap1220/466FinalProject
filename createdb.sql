/**
 * Alexander Kashyap
 * CSCI 466
 * 11/29/21
**/

use z1926618;

CREATE TABLE ORDER(
    ORDER_NUMBER INT AUTO_INCREMENT,
    STATUS VARCHAR(70),
    CARD_NUMBER INT,
    CARDHOLDER VARCHAR(70),
    CVV
    BILLING_ZIP
    ZIP
    STREET_ADDRESS
    CITY
    STATE
    TOTAL
    NOTES

    PRIMARY KEY (ORDER_NUMBER)
);

CREATE TABLE ITEMS_ORDERED(
    
);

CREATE TABLE PRODUCTS(
   
);

CREATE TABLE CART(
 
);