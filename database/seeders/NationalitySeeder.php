<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Nationality;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationals = [

            [
                'name' => 'Afghan'
            ],
            [
                'name' => 'Albanian'
            ],
            [
                'name' => 'Aland Islander'
            ],
            [
                'name' => 'Algerian'
            ],
            [
                'name' => 'American Samoan'
            ],
            [
                'name' => 'Andorran'
            ],
            [
                'name' => 'Angolan'
            ],
            [
                'name' => 'Anguillan'
            ],
            [
                'name' => 'Antarctican'
            ],
            [
                'name' => 'Antiguan'
            ],
            [
                'name' => 'Argentinian'
            ],
            [
                'name' => 'Armenian'
            ],
            [
                'name' => 'Aruban'
            ],
            [
                'name' => 'Australian'
            ],
            [
                'name' => 'Austrian'
            ],
            [
                'name' => 'Azerbaijani'
            ],
            [
                'name' => 'Bahamian'
            ],
            [
                'name' => 'Bahraini'
            ],
            [
                'name' => 'Bangladeshi'
            ],
            [
                'name' => 'Barbadian'
            ],
            [
                'name' => 'Belarusian'
            ],
            [
                'name' => 'Belgian'
            ],
            [
                'name' => 'Belizean'
            ],
            [
                'name' => 'Beninese'
            ],
            [
                'name' => 'Saint Barthelmian'
            ],
            [
                'name' => 'Bermudan'
            ],
            [
                'name' => 'Bhutanese'
            ],
            [
                'name' => 'Bolivian'
            ],
            [
                'name' => 'Bosnian / Herzegovinian'
            ],
            [
                'name' => 'Botswanan'
            ],
            [
                'name' => 'Bouvetian'
            ],
            [
                'name' => 'Brazilian'
            ],
            [
                'name' => 'British Indian Ocean Territory'
            ],
            [
                'name' => 'Bruneian'
            ],
            [
                'name' => 'Bulgarian'
            ],
            [
                'name' => 'Burkinabe'
            ],
            [
                'name' => 'Burundian'
            ],
            [
                'name' => 'Cambodian'
            ],
            [
                'name' => 'Cameroonian'
            ],
            [
                'name' => 'Canadian'
            ],
            [
                'name' => 'Cape Verdean'
            ],
            [
                'name' => 'Caymanian'
            ],
            [
                'name' => 'Central African'
            ],
            [
                'name' => 'Chadian'
            ],
            [
                'name' => 'Chilean'
            ],
            [
                'name' => 'Chinese'
            ],
            [
                'name' => 'Christmas Islander'
            ],
            [
                'name' => 'Cocos Islander'
            ],
            [
                'name' => 'Colombian'
            ],
            [
                'name' => 'Comorian'
            ],
            [
                'name' => 'Congolese'
            ],
            [
                'name' => 'Cook Islander'
            ],
            [
                'name' => 'Costa Rican'
            ],
            [
                'name' => 'Croatian'
            ],
            [
                'name' => 'Cuban'
            ],
            [
                'name' => 'Cypriot'
            ],
            [
                'name' => 'Curacian'
            ],
            [
                'name' => 'Czech'
            ],
            [
                'name' => 'Danish'
            ],
            [
                'name' => 'Djiboutian'
            ],
            [
                'name' => 'Dominican'
            ],
            [
                'name' => 'Ecuadorian'
            ],
            [
                'name' => 'Egyptian'
            ],
            [
                'name' => 'Salvadoran'
            ],
            [
                'name' => 'Equatorial Guinean'
            ],
            [
                'name' => 'Eritrean'
            ],
            [
                'name' => 'Estonian'
            ],
            [
                'name' => 'Ethiopian'
            ],
            [
                'name' => 'Falkland Islander'
            ],
            [
                'name' => 'Faroese'
            ],
            [
                'name' => 'Fijian'
            ],
            [
                'name' => 'Finnish'
            ],
            [
                'name' => 'French'
            ],
            [
                'name' => 'French Guianese'
            ],
            [
                'name' => 'French Polynesian'
            ],
            [
                'name' => 'Gabonese',
            ],
            [
                'name' => 'Gambian',
            ],
            [
                'name' => 'Georgian',
            ],
            [
                'name' => 'German',
            ],
            [
                'name' => 'Ghanaian',
            ],
            [
                'name' => 'Gibraltar',
            ],
            [
                'name' => 'Guernsian',
            ],
            [
                'name' => 'Greek',
            ],
            [
                'name' => 'Greenlandic',
            ],
            [
                'name' => 'Grenadian',
            ],
            [
                'name' => 'Guadeloupe',
            ],
            [
                'name' => 'Guamanian',
            ],
            [
                'name' => 'Guatemalan',
            ],
            [
                'name' => 'Guinean',
            ],
            [
                'name' => 'Guinea-Bissauan',
            ],
            [
                'name' => 'Guyanese',
            ],
            [
                'name' => 'Haitian',
            ],
            [
                'name' => 'Heard and McDonald Islanders',
            ],
            [
                'name' => 'Honduran',
            ],
            [
                'name' => 'Hongkongese',
            ],
            [
                'name' => 'Hungarian',
            ],
            [
                'name' => 'Icelandic',
            ],
            [
                'name' => 'Indian',
            ],
            [
                'name' => 'Manx',
            ],
            [
                'name' => 'Indonesian',
            ],
            [
                'name' => 'Iranian',
            ],
            [
                'name' => 'Iraqi',
            ],
            [
                'name' => 'Irish',
            ],
            [
                'name' => 'Italian',
            ],
            [
                'name' => 'Ivory Coastian',
            ],
            [
                'name' => 'Jersian',
            ],
            [
                'name' => 'Jamaican',
            ],
            [
                'name' => 'Japanese',
            ],
            [
                'name' => 'Jordanian',
            ],
            [
                'name' => 'Kazakh',
            ],
            [
                'name' => 'Kenyan',
            ],
            [
                'name' => 'I-Kiribati',
            ],
            [
                'name' => 'North Korean',
            ],
            [
                'name' => 'South Korean',
            ],
            [
                'name' => 'Kosovar',
            ],
            [
                'name' => 'Kuwaiti',
            ],
            [
                'name' => 'Kyrgyzstani',
            ],
            [
                'name' => 'Laotian',
            ],
            [
                'name' => 'Latvian',
            ],
            [
                'name' => 'Lebanese',
            ],
            [
                'name' => 'Basotho',
            ],
            [
                'name' => 'Liberian',
            ],
            [
                'name' => 'Libyan',
            ],
            [
                'name' => 'Liechtenstein',
            ],
            [
                'name' => 'Lithuanian',
            ],
            [
                'name' => 'Luxembourger',
            ],
            [
                'name' => 'Sri Lankian',
            ],
            [
                'name' => 'Macanese',
            ],
            [
                'name' => 'Macedonian',
            ],
            [
                'name' => 'Malagasy',
            ],
            [
                'name' => 'Malawian',
            ],
            [
                'name' => 'Malaysian',
            ],
            [
                'name' => 'Maldivian',
            ],
            [
                'name' => 'Malian',
            ],
            [
                'name' => 'Maltese',
            ],
            [
                'name' => 'Marshallese',
            ],
            [
                'name' => 'Martiniquais',
            ],
            [
                'name' => 'Mauritanian',
            ],
            [
                'name' => 'Mauritian',
            ],
            [
                'name' => 'Mahoran',
            ],
            [
                'name' => 'Mexican',
            ],
            [
                'name' => 'Micronesian',
            ],
            [
                'name' => 'Moldovan',
            ],
            [
                'name' => 'Monacan',
            ],
            [
                'name' => 'Mongolian',
            ],
            [
                'name' => 'Montenegrin',
            ],
            [
                'name' => 'Montserratian',
            ],
            [
                'name' => 'Moroccan',
            ],
            [
                'name' => 'Mozambican',
            ],
            [
                'name' => 'Myanmarian',
            ],
            [
                'name' => 'Namibian',
            ],
            [
                'name' => 'Nauruan',
            ],
            [
                'name' => 'Nepalese',
            ],
            [
                'name' => 'Dutch',
            ],
            [
                'name' => 'Dutch Antilier',
            ],
            [
                'name' => 'New Caledonian',
            ],
            [
                'name' => 'New Zealander',
            ],
            [
                'name' => 'Nicaraguan',
            ],
            [
                'name' => 'Nigerien',
            ],
            [
                'name' => 'Nigerian',
            ],
            [
                'name' => 'Niuean',
            ],
            [
                'name' => 'Norfolk Islander',
            ],
            [
                'name' => 'Northern Marianan',
            ],
            [
                'name' => 'Norwegian',
            ],
            [
                'name' => 'Omani',
            ],
            [
                'name' => 'Pakistani',
            ],
            [
                'name' => 'Palauan',
            ],

            [
                'name' => 'Sao Tomean',
            ],
            [
                'name' => 'Saudi Arabian',
            ],
            [
                'name' => 'Senegalese',
            ],
            [
                'name' => 'Serbian',
            ],
            [
                'name' => 'Seychellois',
            ],
            [
                'name' => 'Sierra Leonean',
            ],
            [
                'name' => 'Singaporean',
            ],
            [
                'name' => 'Slovak',
            ],
            [
                'name' => 'Slovenian',
            ],
            [
                'name' => 'Solomon Islander',
            ],
            [
                'name' => 'Somali',
            ],
            [
                'name' => 'South African',
            ],
            [
                'name' => 'South Georgia and the South Sandwich Islands',
            ],
            [
                'name' => 'South Sudanese',
            ],
            [
                'name' => 'Spanish',
            ],
            [
                'name' => 'St. Helenian',
            ],
            [
                'name' => 'Sudanese',
            ],
            [
                'name' => 'Surinamese',
            ],
            [
                'name' => 'Svalbardian/Jan Mayenian',
            ],
            [
                'name' => 'Swazi',
            ],
            [
                'name' => 'Swedish',
            ],
            [
                'name' => 'Swiss',
            ],
            [
                'name' => 'Syrian',
            ],
            [
                'name' => 'Taiwanese',
            ],
            [
                'name' => 'Tajikistani',
            ],
            [
                'name' => 'Tanzanian',
            ],
            [
                'name' => 'Thai',
            ],
            [
                'name' => 'Timor-Lestian',
            ],
            [
                'name' => 'Togolese',
            ],
            [
                'name' => 'Tokelaian',
            ],
            [
                'name' => 'Tongan',
            ],
            [
                'name' => 'Trinidadian/Tobagonian',
            ],
            [
                'name' => 'Tunisian',
            ],
            [
                'name' => 'Turkish',
            ],
            [
                'name' => 'Turkmen',
            ],
            [
                'name' => 'Turks and Caicos Islander',
            ],
            [
                'name' => 'Tuvaluan',
            ],
            [
                'name' => 'Ugandan',
            ],
            [
                'name' => 'Ukrainian',
            ],
            [
                'name' => 'Emirati',
            ],
            [
                'name' => 'British',
            ],
            [
                'name' => 'American',
            ],
            [
                'name' => 'US Minor Outlying Islander',
            ],
            [
                'name' => 'Uruguayan',
            ],
            [
                'name' => 'Uzbek',
            ],
            [
                'name' => 'Vanuatuan',
            ],
            [
                'name' => 'Venezuelan',
            ],
            [
                'name' => 'Vietnamese',
            ],
            [
                'name' => 'American Virgin Islander',
            ],
            [
                'name' => 'Vatican',
            ],
            [
                'name' => 'Wallisian/Futunan',
            ],
            [
                'name' => 'Sahrawian',
            ],
            [
                'name' => 'Yemeni',
            ],
            [
                'name' => 'Zambian',
            ],
            [
                'name' => 'Zimbabwean',
            ]
        ];

        foreach ($nationals as $national) {
            Nationality::create($national);
        }
    }
}
