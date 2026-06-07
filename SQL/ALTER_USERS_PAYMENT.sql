DROP VIEW IF EXISTS createUser;
DROP VIEW IF EXISTS getUserInformations;

ALTER TABLE USERS
ADD COLUMN IF NOT EXISTS cardNumberEncrypted TEXT,
ADD COLUMN IF NOT EXISTS cardExpirationEncrypted TEXT;

ALTER TABLE USERS
ALTER COLUMN phoneNumber TYPE VARCHAR(20);

CREATE VIEW createUser AS
SELECT id_user, email, password, firstName, lastName,
       streetAddress, zipCode, city, phoneNumber,
       cardNumberEncrypted, cardExpirationEncrypted, role
FROM USERS;

CREATE VIEW getUserInformations AS
SELECT firstName, lastName, email, password, streetAddress, zipCode, city, phoneNumber,
       cardNumberEncrypted, cardExpirationEncrypted, role
FROM USERS;

GRANT SELECT, INSERT ON createUser TO serie_user, serie_admin;
GRANT UPDATE (firstName, lastName, streetAddress, zipCode, city, phoneNumber,
              cardNumberEncrypted, cardExpirationEncrypted)
ON createUser TO serie_user, serie_admin;
GRANT SELECT ON getUserInformations TO serie_user, serie_admin;
