<?php
$lang['version']                    = "Pool Software Versie";
$lang['pool_name']                  = "Naam van je pool";
$lang['time_offset']                = "Tijdscorrectie t.o.v. CET (Central European Time) voor de server, in seconden.";
$lang['predictions_open']           = "Als dit `1` is, kunnen gebruikers uitslagen voorspellen totdat de wedstijd begint.
                                       Als je dit op `0` zet, kunnen gebruikers voorspellingen invullen totdat het toernooi (wedstrijd #1) begint.";
$lang['predictions_open_offset']    = "Het aantal seconden dat een wedstrijd 'op slot' gaat voordat de wedstrijd echt begint.";
$lang['public_predictions']         = "Als je dit op 0 zet, kunnen deelnemers elkaars voorspellingen niet zien. Toegestane waarde is 0 of 1.";
$lang['public_social_links']        = "Als je dit op 0 zet blijven de links naar sociale netwerken voor andere deelnemers verborgen. Toegestane waarde is 0 of 1.";
$lang['sign_up_email_admin']		= "Als je dit op 1 zet, krijgt de beheerder een e-mail als er een nieuwe gebruiker is aangemeld. Toegestane waarde is 0 of 1.";
$lang['verify_users']				= "Als je dit op 1 zet, moeten nieuwe gebruikers eerst worden geverifi&euml;erd door de beheerder. Toegestane waarde is 0 of 1.";
$lang['email_from_address']			= "Het e-mail adres dat als afzender wordt gebruikt voor alle emails.";
$lang['play_for_money']			= "Als je dit op 1 zet, moeten deelnemers een inleg betalen. Toegestane waarde is 0 of 1.";
$lang['payment_per_user']			= "Inleg per deelnemer.";
$lang['currency']					= "Valuta voor de inleg.";
$lang['payout_schedule']			= "Uitbetaling in procenten, door komma's gescheiden. Zet je dit op '50,30,20', dan krijgt de eerste plaats 50%, de tweede 30% en de derde 20%. Het totaal hoeft geen 100% te zijn, als de organisatie een gedeelte zelf houdt. Je mag zoveel waarden geven als je wilt, '30,20,15,10,5' kan bijvoorbeeld ook.";
$lang['enable_shoutbox']			= "Shoutbox aan of uit, mogelijke waarden 0 (uit) of 1 (aan)";

$lang['pred_points_goals']			= "Aantal punten voor thuis- of uitdoelpunten goed voorspeld.";
$lang['pred_points_result']			= "Aantal punten voor winst - gelijk - verlies goed voorspeld.";
$lang['pred_points_qf_team']		= "Aantal punten voor thuis of uit spelend team in de kwartfinales goed voorspeld.";
$lang['pred_points_sf_team']		= "Aantal punten voor thuis of uit spelend team in de halve finales goed voorspeld.";
$lang['pred_points_f_team']		= "Aantal punten voor thuis of uit spelend team in de finale goed voorspeld.";
$lang['pred_points_bonus']			= "Maximaal aantal punten voor het totaal aantal doelpunten goed voorspeld. Voor elk doelpunt dan men naast het totaal aantal doelpunten zit, wordt er &eacute;&eacute;n punt minder toegekend.";
$lang['pred_points_champion']		= "Aantal punten voor het correct voorspellen van de kampioen bij de extra vragen.";

$lang['ssl_enabled']				= "SSL verbinding toestaan (niet mee rommelen tenzij je weet wat je doet)";
$lang['sign_in_recaptcha_enabled']	= "Als je dit op '1' zet moet er een re-captcha worden ingevuld bij het inloggen.";
$lang['sign_in_recaptcha_offset']	= "Niet mee rommelen, tenzij je verstand hebt van re-captcha.";
$lang['sign_up_recaptcha_enabled']	= "Als je dit op '1' zet moet er een re-captcha worden ingevuld bij het aanmelden.";
$lang['sign_up_auto_sign_in']		= "Als je dit op '1' zet, zijn mensne na de aanmeld procedure meteen ingelogd. Dit werkt natuurlijk alleen als ze niet eerst heoven te worden geverifi&euml;erd.";
$lang['sign_out_view_enabled']		= "Als je dit op '1' zet, worden mensen na het uitloggen naar de 'je bent uitgelogd' pagina gestuurd. Staat het op '0', gaan ze meteen door naar de home pagina.";
$lang['password_reset_expiration']  = "Aantal seconden dat de wachtwoord reset link geldig is. Standaard is dit 1800 seconden, oftewel 30 minuten. Daarna moet dus een nieuwe link worden aangevraagd.";
$lang['password_reset_secret']		= "Een code van 64 karakters om wachtwoord-reset links mee te versleutelen. De veiligste oplossing is om niet de defgault waarde te gebruiken. Genereer er zelf eentje op <a href='https://www.grc.com/passwords.htm'>GRC's Ultra High Security Password Generator</a>.";
$lang['recaptcha_public_key']		= "'Public Key' voor re-captcha. De default waarde zou moeten werken, maar je kunt ook je eigen set sleutels aanvragen op <a href='https://www.google.com/recaptcha/admin/create'>de re-captcha website</a>.";
$lang['recaptcha_private_key']		= "'Private Key' voor re-captcha. De default waarde zou moeten werken, maar je kunt ook je eigen set sleutels aanvragen op <a href='https://www.google.com/recaptcha/admin/create'>de re-captcha website</a>.";
$lang['recaptcha_theme']			= "Kleurstelling van de recaptcha's. Waardes: 'red' | 'white' | 'blackglass' | 'clean' | 'custom'";

$lang['openid_file_store_path']		= "Folder op de server waar OpenID bestanden worden opgeslagen. Alleen belangrijk a;s je OpenID wilt gebruiken als log-in mogelijkheid (dit werkt niet in de huideige versie van de pool, en misschien wel nooit).";
$lang['openid_google_discovery_endpoint']	= "Wordt niet gebruikt, misschien in de toekomst.";
$lang['openid_yahoo_discovery_endpoint']	= "Wordt niet gebruikt, misschien in de toekomst.";
$lang['third_party_auth_providers']			= "Sociale netwerken waar men mee in kan loggen. Mogelijkheden zijn 'twitter', 'facebook' of 'facebook,twitter' (voor allebei). Wil je geen sociale netwerken gebruiken, laat het dan leeg.";
$lang['openid_what_is_url']					= "Wordt niet gebruikt.";
$lang['twitter_consumer_key']				= "'Consumer Key', unieke waarde voor jouw pool. Als je Twitter wilt gebruiken voor aanmelden en inloggen, moet je je pool hier als Twitter App aanmelden: <a href='http://dev.twitter.com/apps'>Twitter Apps</a>."; 
$lang['twitter_consumer_secret']				= "'Consumer Secret', unieke waarde voor jouw pool. Als je Twitter wilt gebruiken voor aanmelden en inloggen, moet je je pool hier als Twitter App aanmelden: <a href='http://dev.twitter.com/apps'>Twitter Apps</a>.";

$lang['facebook_app_id']			= "Als je Facebook wilt gebruiken voor aanmelden en inloggen, moet je je app hier aanmelden: <a href='http://www.facebook.com/developers/createapp.php'>Facebook Apps</a>.";

$lang['facebook_secret']			= "Als je Facebook wilt gebruiken voor aanmelden en inloggen, moet je je app hier aanmelden: <a href='http://www.facebook.com/developers/createapp.php'>Facebook Apps</a>.";

$lang['category_0']                 = "Algemene Instellingen";
$lang['category_1']                 = "Punten Instellingen";
$lang['category_2']                 = "Account Instellingen";
$lang['category_3']                 = "Social Media";


/* End of file poolconfig_lang.php */
/* Location: ./application/language/en/poolconfig_lang.php */
