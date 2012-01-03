<?php
$lang['created_table']                  =   "Tabel aangemaakt";
$lang['create_admin_account']           =   "Maak beheerder aan";
$lang['create_first_account']           =   "Maak de eerste gebruiker aan. Dit is het beheerdersaccount.";
$lang['username']                       =   "Gebruikersnaam";
$lang['first_name']                     =   "Voornaam";
$lang['last_name']                      =   "Achternaam";
$lang['email']                          =   "Email Adres";
$lang['password']                       =   "Wachtwoord";
$lang['installation_script_running']    =   "Installatie van %s";
$lang['start']                          =   "Installatie checks";
$lang['step1']                          =   "Stap 1: Tabellen aanmaken";
$lang['step2']                          =   "Stap 2: Configuratie check";
$lang['start_installation']             =   "Begin installatie";
$lang['version']                        =   "Versie";
$lang['installation_not_possible']      =   "De server is niet geschikt voor installatie";
$lang['user_created']                   =   "Gebruiker %s aangemaakt!";
$lang['config_change']                  =   "Je kunt deze instellingen aanpassen in <span class='code'>/application/config/pool.php</span>.
                                             Als je aanpassingen maakt, kun je daarna deze pagina verversen om te zien of het werkt.";
$lang['time_offset_check']              =   "Je tijd offset staat nu op <span class='boldtext'>%s seconden</span>. Als de weergegeven tijd onderin niet klopt, pas dit dan aan in <span class='code'>/application/config/pool.php</span>.";
$lang['timezone_check']                 =   "Je server staat ingesteld op tijdzone <span class='boldtext'><em>'%s'</em></span>.";
$lang['try_this_offset']                =   "Als dat klopt, zou je time_offset op <span class='boldtext'>%s seconden</span> moeten staan.";
$lang['predictions_open']               =   "Als dit `1` of `TRUE` is, kunnen gebruikers uitslagen voorspellen totdat de wedstijd begint.
                                             Als je dit op `0` of `FALSE` zet, kunnen gebruikers voorspellingen invullen totdat het toernooi (wedstrijd #1) begint.
                                             Je kan de instelling veranderen in <span class='code'>/application/config/pool.php</span>.";
$lang['sign_up_email_admin']            =   "De beheerder krijgt een e-mail als er een nieuwe gebruiker wordt aangemeld.
                                             Je kan de instelling veranderen in <span class='code'>/application/config/pool.php</span>.";
$lang['verify_users']                   =   "De beheerder moet alle nieuwe gebruikers verifieren.
                                             Je kan de instelling veranderen in <span class='code'>/application/config/pool.php</span>.";
$lang['email_from_address']             =   "Dit is het e-mail adres dat gebruikt wordt als de verzender van wachtwoord reset en verificatie emails e.d.";                                             
$lang['pred_points_goals']              =   "Het aantal punten dat men kan verdienen als thuis- of uitdoelpunten goed zijn voorspeld.";
$lang['pred_points_result']             =   "Het aantal punten dat men kan verdienen als winst/gelijk/verlies goed is voorspeld.";
$lang['pred_points_qf_team']            =   "Het aantal punten dat men kan verdienen als uit- of thuisploeg in de kwart finales goed is voorspeld.";
$lang['pred_points_sf_team']            =   "Het aantal punten dat men kan verdienen als uit- of thuisploeg in de halve finales goed is voorspeld.";
$lang['pred_points_f_team']             =   "Het aantal punten dat men kan verdienen als uit- of thuisploeg in de finale goed is voorspeld.";
$lang['pred_points_bonus']              =   "Het aantal bonuspunten dat men <em>maximaal</em> kan verdienen als het toaal aantal doelpunten goed is voorspeld.
                                             Zit men er 1 doelpunten naast, wordt er 1 bonus punt minder gegeven, bij 2 doelpunten verschil 2 minder, enz.";
$lang['pred_points_champion']           =   "Het aantal punten dat men kan verdienen als de Europees Kampioen goed is voorspeld.";
$lang['account_settings']               =   "<p class='info'>In hetzelfde bestand vind je ook heel veel `account settings`,
                                             die te maken hebben met de manier waarop gebruikers zich inschrijven en aanmelden.
                                             Hier moet je bijvoorbeeld je Twitter sleutels en Facebook sleutels opgeven als je de gebruiker de mogelijkheid
                                             wilt geven om via die netwekren in te schrijven en aan te melden. Instructies spreken voor zich, of staan
                                             in het configuratie bestand beschreven.<br/>
                                             Wil je geen sociale netwerken, verander dan<br/>
                                             <span class='code'>\$config['third_party_auth_providers'] = array('facebook', 'twitter', 'google');</span><br/>
                                             in<br/>
                                             <span class='code'>\$config['third_party_auth_providers'] = array();</span></p>
                                             ";
$lang['done_take_me_home']              =   "Klaar, ik wil beginnen!";


/* End of file install_lang.php */
/* Location: ./application/language/nl/install_lang.php */
