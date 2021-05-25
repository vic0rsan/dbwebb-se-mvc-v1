New Yatzy object

IF SESSION[Key] NOT exists THEN CREATE start value INT OR ARRAY ELSE set EQUALS SESSION[Key]

IF POST[Key] SET SESSION[Key] EQUALS POST[Key]

button "Kasta"
	FUNCTION rollYatzy THEN FUNCTION setLastRoll

	FUNCTION getRounds add +1 rolls AND SET TRIES to 3 - 1*rolls

	IF TRIES EQUALS -1 THEN getYayzySum THEN SET "slots" TO empty ARRAY

	THEN SET "tries" TO 3 THEN SET "rounds"+1*rounds

	IF rounds reachs 7 THEN END game AND check IF "sum" GREATER THAN OR EQUALS TO 63
	THEN SET "sum" + 35 AND print score
