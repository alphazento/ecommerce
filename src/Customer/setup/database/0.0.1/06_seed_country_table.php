<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedCountryTable extends Seeder
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->run();
    }

    public function run() {
        $rows = [
            ['Afghanistan','AF','AFG', 1, 1],
            ['Albania','AL','ALB', 1, 1],
            ['Algeria','DZ','DZA', 1, 1],
            ['American Samoa','AS','ASM', 1, 1],
            ['Andorra','AD','AND', 1, 1],
            ['Angola','AO','AGO', 1, 1],
            ['Anguilla','AI','AIA', 1, 1],
            ['Antarctica','AQ','ATA', 1, 1],
            ['Antigua and Barbuda','AG','ATG', 1, 1],
            ['Argentina','AR','ARG', 1, 1],
            ['Armenia','AM','ARM', 1, 1],
            ['Aruba','AW','ABW', 1, 1],
            ['Australia','AU','AUS', 1, 1],
            ['Austria','AT','AUT', 1, 1],
            ['Azerbaijan','AZ','AZE', 1, 1],
            ['Bahamas','BS','BHS', 1, 1],
            ['Bahrain','BH','BHR', 1, 1],
            ['Bangladesh','BD','BGD', 1, 1],
            ['Barbados','BB','BRB', 1, 1],
            ['Belarus','BY','BLR', 1, 1],
            ['Belgium','BE','BEL', 1, 1],
            ['Belize','BZ','BLZ', 1, 1],
            ['Benin','BJ','BEN', 1, 1],
            ['Bermuda','BM','BMU', 1, 1],
            ['Bhutan','BT','BTN', 1, 1],
            ['Bolivia (Plurinational State of)','BO','BOL', 1, 1],
            ['Bonaire, Sint Eustatius and Saba','BQ','BES', 1, 1],
            ['Bosnia and Herzegovina','BA','BIH', 1, 1],
            ['Botswana','BW','BWA', 1, 1],
            ['Bouvet Island','BV','BVT', 1, 1],
            ['Brazil','BR','BRA', 1, 1],
            ['British Indian Ocean Territory','IO','IOT', 1, 1],
            ['Brunei Darussalam','BN','BRN', 1, 1],
            ['Bulgaria','BG','BGR', 1, 1],
            ['Burkina Faso','BF','BFA', 1, 1],
            ['Burundi','BI','BDI', 1, 1],
            ['Cabo Verde','CV','CPV', 1, 1],
            ['Cambodia','KH','KHM', 1, 1],
            ['Cameroon','CM','CMR', 1, 1],
            ['Canada','CA','CAN', 1, 1],
            ['Cayman Islands','KY','CYM', 1, 1],
            ['Central African Republic','CF','CAF', 1, 1],
            ['Chad','TD','TCD', 1, 1],
            ['Chile','CL','CHL', 1, 1],
            ['China','CN','CHN', 1, 1],
            ['Christmas Island','CX','CXR', 1, 1],
            ['Cocos (Keeling) Islands','CC','CCK', 1, 1],
            ['Colombia','CO','COL', 1, 1],
            ['Comoros','KM','COM', 1, 1],
            ['Congo (the Democratic Republic of the)','CD','COD', 1, 1],
            ['Congo','CG','COG', 1, 1],
            ['Cook Islands','CK','COK', 1, 1],
            ['Costa Rica','CR','CRI', 1, 1],
            ['Croatia','HR','HRV', 1, 1],
            ['Cuba','CU','CUB', 1, 1],
            ['Curaçao','CW','CUW', 1, 1],
            ['Cyprus','CY','CYP', 1, 1],
            ['Czechia','CZ','CZE', 1, 1],
            ['Côte d\'Ivoire','CI','CIV', 1, 1],
            ['Denmark','DK','DNK', 1, 1],
            ['Djibouti','DJ','DJI', 1, 1],
            ['Dominica','DM','DMA', 1, 1],
            ['Dominican Republic','DO','DOM', 1, 1],
            ['Ecuador','EC','ECU', 1, 1],
            ['Egypt','EG','EGY', 1, 1],
            ['El Salvador','SV','SLV', 1, 1],
            ['Equatorial Guinea','GQ','GNQ', 1, 1],
            ['Eritrea','ER','ERI', 1, 1],
            ['Estonia','EE','EST', 1, 1],
            ['Eswatini','SZ','SWZ', 1, 1],
            ['Ethiopia','ET','ETH', 1, 1],
            ['Falkland Islands [Malvinas]','FK','FLK', 1, 1],
            ['Faroe Islands','FO','FRO', 1, 1],
            ['Fiji','FJ','FJI', 1, 1],
            ['Finland','FI','FIN', 1, 1],
            ['France','FR','FRA', 1, 1],
            ['French Guiana','GF','GUF', 1, 1],
            ['French Polynesia','PF','PYF', 1, 1],
            ['French Southern Territories','TF','ATF', 1, 1],
            ['Gabon','GA','GAB', 1, 1],
            ['Gambia','GM','GMB', 1, 1],
            ['Georgia','GE','GEO', 1, 1],
            ['Germany','DE','DEU', 1, 1],
            ['Ghana','GH','GHA', 1, 1],
            ['Gibraltar','GI','GIB', 1, 1],
            ['Greece','GR','GRC', 1, 1],
            ['Greenland','GL','GRL', 1, 1],
            ['Grenada','GD','GRD', 1, 1],
            ['Guadeloupe','GP','GLP', 1, 1],
            ['Guam','GU','GUM', 1, 1],
            ['Guatemala','GT','GTM', 1, 1],
            ['Guernsey','GG','GGY', 1, 1],
            ['Guinea','GN','GIN', 1, 1],
            ['Guinea-Bissau','GW','GNB', 1, 1],
            ['Guyana','GY','GUY', 1, 1],
            ['Haiti','HT','HTI', 1, 1],
            ['Heard Island and McDonald Islands','HM','HMD', 1, 1],
            ['Holy See','VA','VAT', 1, 1],
            ['Honduras','HN','HND', 1, 1],
            ['Hong Kong','HK','HKG', 1, 1],
            ['Hungary','HU','HUN', 1, 1],
            ['Iceland','IS','ISL', 1, 1],
            ['India','IN','IND', 1, 1],
            ['Indonesia','ID','IDN', 1, 1],
            ['Iran (Islamic Republic of)','IR','IRN', 1, 1],
            ['Iraq','IQ','IRQ', 1, 1],
            ['Ireland','IE','IRL', 1, 1],
            ['Isle of Man','IM','IMN', 1, 1],
            ['Israel','IL','ISR', 1, 1],
            ['Italy','IT','ITA', 1, 1],
            ['Jamaica','JM','JAM', 1, 1],
            ['Japan','JP','JPN', 1, 1],
            ['Jersey','JE','JEY', 1, 1],
            ['Jordan','JO','JOR', 1, 1],
            ['Kazakhstan','KZ','KAZ', 1, 1],
            ['Kenya','KE','KEN', 1, 1],
            ['Kiribati','KI','KIR', 1, 1],
            ['Korea (the Democratic People\'s Republic of)','KP','PRK', 1, 1],
            ['Korea (the Republic of)','KR','KOR', 1, 1],
            ['Kuwait','KW','KWT', 1, 1],
            ['Kyrgyzstan','KG','KGZ', 1, 1],
            ['Lao People\'s Democratic Republic','LA','LAO', 1, 1],
            ['Latvia','LV','LVA', 1, 1],
            ['Lebanon','LB','LBN', 1, 1],
            ['Lesotho','LS','LSO', 1, 1],
            ['Liberia','LR','LBR', 1, 1],
            ['Libya','LY','LBY', 1, 1],
            ['Liechtenstein','LI','LIE', 1, 1],
            ['Lithuania','LT','LTU', 1, 1],
            ['Luxembourg','LU','LUX', 1, 1],
            ['Macao','MO','MAC', 1, 1],
            ['Madagascar','MG','MDG', 1, 1],
            ['Malawi','MW','MWI', 1, 1],
            ['Malaysia','MY','MYS', 1, 1],
            ['Maldives','MV','MDV', 1, 1],
            ['Mali','ML','MLI', 1, 1],
            ['Malta','MT','MLT', 1, 1],
            ['Marshall Islands','MH','MHL', 1, 1],
            ['Martinique','MQ','MTQ', 1, 1],
            ['Mauritania','MR','MRT', 1, 1],
            ['Mauritius','MU','MUS', 1, 1],
            ['Mayotte','YT','MYT', 1, 1],
            ['Mexico','MX','MEX', 1, 1],
            ['Micronesia (Federated States of)','FM','FSM', 1, 1],
            ['Moldova (the Republic of)','MD','MDA', 1, 1],
            ['Monaco','MC','MCO', 1, 1],
            ['Mongolia','MN','MNG', 1, 1],
            ['Montenegro','ME','MNE', 1, 1],
            ['Montserrat','MS','MSR', 1, 1],
            ['Morocco','MA','MAR', 1, 1],
            ['Mozambique','MZ','MOZ', 1, 1],
            ['Myanmar','MM','MMR', 1, 1],
            ['Namibia','NA','NAM', 1, 1],
            ['Nauru','NR','NRU', 1, 1],
            ['Nepal','NP','NPL', 1, 1],
            ['Netherlands','NL','NLD', 1, 1],
            ['New Caledonia','NC','NCL', 1, 1],
            ['New Zealand','NZ','NZL', 1, 1],
            ['Nicaragua','NI','NIC', 1, 1],
            ['Niger','NE','NER', 1, 1],
            ['Nigeria','NG','NGA', 1, 1],
            ['Niue','NU','NIU', 1, 1],
            ['Norfolk Island','NF','NFK', 1, 1],
            ['Northern Mariana Islands','MP','MNP', 1, 1],
            ['Norway','NO','NOR', 1, 1],
            ['Oman','OM','OMN', 1, 1],
            ['Pakistan','PK','PAK', 1, 1],
            ['Palau','PW','PLW', 1, 1],
            ['Palestine, State of','PS','PSE', 1, 1],
            ['Panama','PA','PAN', 1, 1],
            ['Papua New Guinea','PG','PNG', 1, 1],
            ['Paraguay','PY','PRY', 1, 1],
            ['Peru','PE','PER', 1, 1],
            ['Philippines','PH','PHL', 1, 1],
            ['Pitcairn','PN','PCN', 1, 1],
            ['Poland','PL','POL', 1, 1],
            ['Portugal','PT','PRT', 1, 1],
            ['Puerto Rico','PR','PRI', 1, 1],
            ['Qatar','QA','QAT', 1, 1],
            ['Republic of North Macedonia','MK','MKD', 1, 1],
            ['Romania','RO','ROU', 1, 1],
            ['Russian Federation','RU','RUS', 1, 1],
            ['Rwanda','RW','RWA', 1, 1],
            ['Réunion','RE','REU', 1, 1],
            ['Saint Barthélemy','BL','BLM', 1, 1],
            ['Saint Helena, Ascension and Tristan da Cunha','SH','SHN', 1, 1],
            ['Saint Kitts and Nevis','KN','KNA', 1, 1],
            ['Saint Lucia','LC','LCA', 1, 1],
            ['Saint Martin (French part)','MF','MAF', 1, 1],
            ['Saint Pierre and Miquelon','PM','SPM', 1, 1],
            ['Saint Vincent and the Grenadines','VC','VCT', 1, 1],
            ['Samoa','WS','WSM', 1, 1],
            ['San Marino','SM','SMR', 1, 1],
            ['Sao Tome and Principe','ST','STP', 1, 1],
            ['Saudi Arabia','SA','SAU', 1, 1],
            ['Senegal','SN','SEN', 1, 1],
            ['Serbia','RS','SRB', 1, 1],
            ['Seychelles','SC','SYC', 1, 1],
            ['Sierra Leone','SL','SLE', 1, 1],
            ['Singapore','SG','SGP', 1, 1],
            ['Sint Maarten (Dutch part)','SX','SXM', 1, 1],
            ['Slovakia','SK','SVK', 1, 1],
            ['Slovenia','SI','SVN', 1, 1],
            ['Solomon Islands','SB','SLB', 1, 1],
            ['Somalia','SO','SOM', 1, 1],
            ['South Africa','ZA','ZAF', 1, 1],
            ['South Georgia and the South Sandwich Islands','GS','SGS', 1, 1],
            ['South Sudan','SS','SSD', 1, 1],
            ['Spain','ES','ESP', 1, 1],
            ['Sri Lanka','LK','LKA', 1, 1],
            ['Sudan','SD','SDN', 1, 1],
            ['Suriname','SR','SUR', 1, 1],
            ['Svalbard and Jan Mayen','SJ','SJM', 1, 1],
            ['Sweden','SE','SWE', 1, 1],
            ['Switzerland','CH','CHE', 1, 1],
            ['Syrian Arab Republic','SY','SYR', 1, 1],
            ['Taiwan (Province of China)','TW','TWN', 1, 1],
            ['Tajikistan','TJ','TJK', 1, 1],
            ['Tanzania, United Republic of','TZ','TZA', 1, 1],
            ['Thailand','TH','THA', 1, 1],
            ['Timor-Leste','TL','TLS', 1, 1],
            ['Togo','TG','TGO', 1, 1],
            ['Tokelau','TK','TKL', 1, 1],
            ['Tonga','TO','TON', 1, 1],
            ['Trinidad and Tobago','TT','TTO', 1, 1],
            ['Tunisia','TN','TUN', 1, 1],
            ['Turkey','TR','TUR', 1, 1],
            ['Turkmenistan','TM','TKM', 1, 1],
            ['Turks and Caicos Islands','TC','TCA', 1, 1],
            ['Tuvalu','TV','TUV', 1, 1],
            ['Uganda','UG','UGA', 1, 1],
            ['Ukraine','UA','UKR', 1, 1],
            ['United Arab Emirates','AE','ARE', 1, 1],
            ['United Kingdom of Great Britain and Northern Ireland','GB','GBR', 1, 1],
            ['United States Minor Outlying Islands','UM','UMI', 1, 1],
            ['United States of America','US','USA', 1, 1],
            ['Uruguay','UY','URY', 1, 1],
            ['Uzbekistan','UZ','UZB', 1, 1],
            ['Vanuatu','VU','VUT', 1, 1],
            ['Venezuela (Bolivarian Republic of)','VE','VEN', 1, 1],
            ['Viet Nam','VN','VNM', 1, 1],
            ['Virgin Islands (British)','VG','VGB', 1, 1],
            ['Virgin Islands (U.S.)','VI','VIR', 1, 1],
            ['Wallis and Futuna','WF','WLF', 1, 1],
            ['Western Sahara','EH','ESH', 1, 1],
            ['Yemen','YE','YEM', 1, 1],
            ['Zambia','ZM','ZMB', 1, 1],
            ['Zimbabwe','ZW','ZWE', 1, 1],
            ['Åland Islands','AX','ALA', 1, 1]];

        foreach($rows as $row) {
            $data = [
                'name' => $row[0],
                'alpha2_code' => $row[1],
                'alpha3_code' => $row[2],
                'frontstore_active' => $row[3],
                'backend_active' => $row[4],
            ];
            DB::table('countries')->insert($data);
        }
    }
}