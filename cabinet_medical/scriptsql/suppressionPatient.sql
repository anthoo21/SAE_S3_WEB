--Patients liés à visites liées à ordonnances liées à prescriptions => en fonction de l'id patient

-- Toutes les données du patient test (clé primaire = numeroCarteVitale)
SELECT patients.*, visites.*, ordonnances.*, prescriptions.* 
FROM patients 
JOIN visites ON patients.numeroCarteVitale = visites.id_patient  
JOIN ordonnances ON visites.id_visite = ordonnances.id_visite
JOIN prescriptions ON ordonnances.id_ordo = prescriptions.id_ordonnance
WHERE numeroCarteVitale = '111111111111111'

-- Suppression des prescriptions liées à ce patient
DELETE FROM prescriptions WHERE prescriptions.id_prescriptions IN(
	SELECT prescriptions.* 
	FROM prescriptions
	JOIN ordonnances ON ordonnances.id_ordo = prescriptions.id_ordonnance
	JOIN visites ON visites.id_visite = ordonnances.id_visite
	JOIN patients ON patients.numeroCarteVitale = visites.id_patient
	WHERE numeroCarteVitale = '111111111111111'
)

-- NON 
DELETE * 
FROM prescriptions 
JOIN visites ON patients.numeroCarteVitale = visites.id_patient  
JOIN ordonnances ON visites.id_visite = ordonnances.id_visite
JOIN prescriptions ON ordonnances.id_ordo = prescriptions.id_ordonnance
WHERE numeroCarteVitale = '111111111111111'


-- Suppression des ordonnances liées à ce patient
DELETE FROM ordonnances WHERE (
	SELECT ordonnances.*
	FROM patients ON patients.numeroCarteVitale = visites.id_patient  
	JOIN ordonnances ON visites.id_visite = ordonnances.id_visite
	WHERE numeroCarteVitale = '111111111111111'
)

-- Suppression des visites liées à ce patient
DELETE FROM visites WHERE (
	SELECT visites.*
	FROM patients 
	JOIN visites ON patients.numeroCarteVitale = visites.id_patient  
	WHERE numeroCarteVitale = '111111111111111'
)

-- Suppression du patient
DELETE FROM patients WHERE numeroCarteVitale = '111111111111111'

