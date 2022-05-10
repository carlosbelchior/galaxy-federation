<h2 style="text-align:center"><strong>Galaxy Federation</strong></h2>

<p><strong><u><em>Minimum system requirements:</em></u></strong></p>
<p>NGINX or APACHE (Remember to configure your virtualhost)</p>
<p>PHP version 8.1 or higher</p>
<p>MySQL 8.0.29 or higher</p>

<p>I recommend using Docker and the laradock library</p>

<br/>

<p>After install use <code>composer install</code> and create the .env in project</p>
<p>Create your database and set in .env, after run command <code>php artisan migrate --seed</code> for create your database and populate yourdatabase.</p>

<br/>
<br/>

<p><em><span style="font-size:16px"><u><span style="background-color:#FFFF00">Routers API:</span></u></span></em></p>


<p><strong><u><em>Add pilot:</em></u></strong></p>
<p>URL: /api/add/pilot<br />
Method: POST</p>
<p>Data: pilot_certification, name, age, credits, location_planet</p>


<p><strong><u><em>Add ship:</em></u></strong></p>
<p>URL: /api/add/ship<br />
Method: POST</p>
<p>Data: fuel_capacity, fuel_level, weight_capacity, location_planet</p>


<p><strong><u><em>Add contract:</em></u></strong></p>
<p>URL: /api/add/contract<br />
Method: POST</p>
<p>Data:<br />
pilot_certification,<br />
ship (Identification code),<br />
payload (json with the products and the transported weight), <br />
origin_planet, destination_planet, value</p>
<p><strong><u><em>Accept contract:</em></u></strong></p>
<p>URL: /api/contracts/accept/id_contract<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>Finish contract:</em></u></strong></p>
<p>URL: /api/contracts/finish/id_contract<br />
Method: GET</p>
<p>At the end of the contract, all costs and credits are automatically debited.</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>List open contract:</em></u></strong></p>
<p>URL: /api/contracts/all<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>New travel:</em></u></strong></p>
<p>URL: /api/travels/new<br />
Method: POST</p>
<p>Data: pilot_certification, ship (Identification code), origin_planet, destination_planet</p>
<p>All costs are automatically debited.</p>


<p><strong><u><em>Buy fuel:</em></u></strong></p>
<p>URL: /api/fuel/buy<br />
Method: POST</p>
<p>Data: pilot_certification, ship (Identification code), refill (number of refills you want)</p>
<p>All costs are automatically debited.</p>


<p><strong><u><em>Report </em></u><em><u>transactions:</u></em></strong></p>
<p>URL: /api/reports/transactions<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>Report </em></u><em><u>pilots:</u></em></strong></p>
<p>URL: /api/reports/pilots<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>Report </em></u><em><u>ships:</u></em></strong></p>
<p>URL: /api/reports/ships<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>Report </em></u><em><u>travels:</u></em></strong></p>
<p>URL: /api/reports/travels<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>Report </em></u><em><u>routers:</u></em></strong></p>
<p>URL: /api/reports/routers<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>Report </em></u><em><u>contracts:</u></em></strong></p>
<p>URL: /api/reports/contracts<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>Report </em></u><em><u>finish contracts by pilot:</u></em></strong></p>
<p>URL: /api/reports/contracts-pilot/{pilot_certification}<br />
Method: GET</p>
<p>Data: pilot_certification (use in url after /contracts-pilot/</p>
<p>REMOVE<b>{ }</b> in URL before use.</p>


<p><strong><u><em>Report percentage of resource type transported by each pilot:</u></em></strong></p>
<p>URL: /api/reports/resource-pilot<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>


<p><strong><u><em>Report total weight in tons of each resource sent and received by each planet.</u></em></strong></p>
<p>URL: /api/reports/resource-planet<br />
Method: GET</p>
<p><u>No additional information is needed</u></p>

<br/>
</br/>

<p>To perform the tests populate the database, you can use all the seeds available in the project or enter the data manually. After that use the command <code>php artisan test</code</p>

<p><strong>REMEMBER THAT YOUR ACTION ARE MONITORED BY THE INTERGALACTIC AGENCY, BE CAREFUL.</strong></p>

<p><strong>MAY THE FORCE BE WITH YOU!</strong></p>
