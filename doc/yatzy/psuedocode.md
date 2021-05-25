new Yazty

IF button "Kasta" IS ACTIVATED
    SET SESSION[key] TO INT OR ARRAY IF SESSION[key] NOT EXISTS THEN SET SESSION[key] TO SELF

    IF POST[slots] EXISTS SET EQUALS TO SESSION[key]

    NEXT CALL TO METHOD rollYazty
    THEN setLastRoll IF POST[slots] NOT EMPTY AND keep objects values-property
    THEN LOAD values TO SESSION[values]

    add 1 TO SESSION[rolls] AND sub -1 TO SESSION[tries]
    IF SESSION[tries] EQUALS -1 THEN SET SESSION[tries] TO 3 AND add 1 TO SESSION[rounds]
    AND set POST[slots] TO EMPTY ARRAY
    THEN GET SESSION[sum] FOR current round

    IF SESSION[rounds] GREATER THAN 6 THEN END Game AND CHECK IF sum GREATER THAN OR EQUALS TO
    IF TRUE THAN add 35 TO sum
    THEN print "Game Over" and show sum
