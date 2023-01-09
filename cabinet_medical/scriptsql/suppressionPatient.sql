-- AIDES -----------------------------------------
-- Toutes les données du patient test (clé primaire = numeroCarteVitale)
-- 		SELECT patients.*, visites.*, ordonnances.*, prescriptions.* 
-- 		FROM patients 
-- 		JOIN visites ON patients.numeroCarteVitale = visites.id_patient  
-- 		JOIN ordonnances ON visites.id_visite = ordonnances.id_visite
-- 		JOIN prescriptions ON ordonnances.id_ordo = prescriptions.id_ordonnance
-- 		WHERE numeroCarteVitale = '203118100403710'
-- ------------------------------------------------

--PRESCRIPTIONS
-- Suppression des prescriptions liées à ce patient
DELETE FROM prescriptions WHERE id_ordonnance IN(
	SELECT id_ordo
	FROM ordonnances
	WHERE id_visite IN (
		SELECT id_visite
		FROM visites
		WHERE id_patient IN (
			SELECT numeroCarteVitale
			FROM patients
			WHERE numeroCarteVitale = '203118100403710'
		)
	)
)

--ORDONNANCES
-- Suppression des ordonnances liées à ce patient
DELETE FROM ordonnances WHERE id_visite IN(
	SELECT id_visite
	FROM visites
	WHERE id_patient IN (
		SELECT numeroCarteVitale
		FROM patients
		WHERE numeroCarteVitale = '203118100403710'
	)
)

--VISITES
-- Suppression des visites liées à ce patient
DELETE FROM visites WHERE id_patient IN (
	SELECT numeroCarteVitale
	FROM patients
	WHERE numeroCarteVitale = '203118100403710'
)

--PATIENT
-- Suppression du patient
DELETE FROM patients WHERE numeroCarteVitale = '203118100403710'

