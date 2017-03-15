SELECT address
FROM user_prefs, properties
WHERE properties.city=user_prefs.city
      AND properties.cost>=user_prefs.min_cost
      AND (properties.cost<=user_prefs.max_cost OR user_prefs.max_cost='5000+')
      AND (properties.num_bedrooms=user_prefs.num_bedrooms OR user_prefs.num_bedrooms='Any')
      AND (properties.num_bathrooms=user_prefs.num_bathrooms OR user_prefs.num_bathrooms='Any')
      AND properties.sq_ft>=user_prefs.min_sq_ft
      AND (properties.sq_ft<=user_prefs.max_sq_ft OR user_prefs.max_sq_ft='5000+')
      AND (properties.has_balcony=user_prefs.has_balcony OR user_prefs.has_balcony='Any')
      AND (properties.is_furnished=user_prefs.is_furnished OR user_prefs.is_furnished='Any')
      AND (properties.allows_pets=user_prefs.allows_pets OR user_prefs.allows_pets='Any')
      AND (properties.allows_smoking=user_prefs.allows_smoking OR user_prefs.allows_smoking='Any');