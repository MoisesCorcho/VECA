<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Arr;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        $organizationsMaira = [

            // Organization 1
            [
                'name'      => 'CENTRO CARDIOINFANTIL  IPS SAS',
                'nit'       => '900090247',
                'address'   => 'CALLE 22 N° 16 - 30',
                'cellphone' => null,
                'phone'     => '7897151',
                'city'      => 'MONTERIA'
            ],
            // Organization 2
            [
                'name'      => 'INSTITUTO DEL RIÑON DE CORDOBA',
                'nit'       => '900238708',
                'address'   => 'CLLE 28 No 15-16',
                'cellphone' => null,
                'phone'     => '7831655',
                'city'      => 'MONTERIA'
            ],
            // Organization 3
            [
                'name'      => 'FUNDACION OPORTUNIDAD Y VIDA',
                'nit'       => '900184499',
                'address'   => 'CR 17 16 A 04 URBINA',
                'cellphone' => null,
                'phone'     => '7830867',
                'city'      => 'MONTERIA'
            ],
            // Organization 4
            [
                'name'      => 'DIAC LTDA Y/O SALIM MIGUEL HADDAD GARCIA',
                'nit'       => '900012819',
                'address'   => 'CL 30 6 49',
                'cellphone' => null,
                'phone'     => '7920221',
                'city'      => 'MONTERIA'
            ],
            // Organization 5
            [
                'name'      => 'MACRO SUMINISTROS DEL SINU S.A.S',
                'nit'       => '901358325',
                'address'   => 'CALLE 27 # 02-05',
                'cellphone' => '3116916816',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 6
            [
                'name'      => 'MEDISINU IPS S.A.S',
                'nit'       => '900931343',
                'address'   => 'CRA 8 # 25-25 BARRIO CENTRO',
                'cellphone' => null,
                'phone'     => '7890772',
                'city'      => 'MONTERIA'
            ],
            // Organization 7
            [
                'name'      => 'CLINICA MATERNO INFANTIL CASA DEL NIÑO LTDA',
                'nit'       => '812004935',
                'address'   => 'CALLE 39  NO. 6-15',
                'cellphone' => null,
                'phone'     => '7811529',
                'city'      => 'MONTERIA'
            ],
            // Organization 8
            [
                'name'      => 'CLINICA ZAYMA S.A.S.',
                'nit'       => '800074112',
                'address'   => 'CLL 28 7 11',
                'cellphone' => null,
                'phone'     => '7848984',
                'city'      => 'MONTERIA'
            ],
            // Organization 9
            [
                'name'      => 'CLINICA MONTERIA S.A',
                'nit'       => '891001122',
                'address'   => 'CRA 4 # 60 - 35',
                'cellphone' => null,
                'phone'     => '7816606',
                'city'      => 'MONTERIA'
            ],
            // Organization 10
            [
                'name'      => 'UROCLINICA DE CORDOBA S.A.S',
                'nit'       => '900193988',
                'address'   => 'CALLE 26 Nº 11 - 19',
                'cellphone' => null,
                'phone'     => '7826002',
                'city'      => 'MONTERIA'
            ],
            // Organization 11
            [
                'name'      => 'CENTRAL DE URGENCIAS DE TRAUMA S.A.S',
                'nit'       => '901165560',
                'address'   => 'CRA 6 # 30-62 B/ CENTRO',
                'cellphone' => '3164544729',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 12
            [
                'name'      => 'CMP PHARMA',
                'nit'       => '901161356',
                'address'   => '',
                'cellphone' => '',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 13
            [
                'name'      => 'E.S.E HOSPITAL UNIVERSITARIO DE CARTAGENA',
                'nit'       => '901164581',
                'address'   => '',
                'cellphone' => '',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 14
            [
                'name'      => 'CLINICA DE REFERENCIA',
                'nit'       => '901164367',
                'address'   => '',
                'cellphone' => '',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 15
            [
                'name'      => 'MEDICINA INTEGRAL S.A.',
                'nit'       => '800250634',
                'address'   => 'CLL 44 14 232 PORTAL DE ALMERIA',
                'cellphone' => null,
                'phone'     => '7910919',
                'city'      => 'MONTERIA'
            ],
            // Organization 16
            [
                'name'      => 'CLINICA CARDIOVASCULAR DEL CARIBE S.A.S',
                'nit'       => '800215019',
                'address'   => 'CRA 9  25 27',
                'cellphone' => null,
                'phone'     => '7825121',
                'city'      => 'MONTERIA'
            ],

        ];

        $organizationsVeronica = [

            // Organization 1
            [
                'name'      => 'SOLUCIONES DIAGNOSTICAS DEL RIO S.A.S',
                'nit'       => '812000357',
                'address'   => 'CALLE 27 # 8-46 B/ CHUCHURUBI',
                'cellphone' => '3184151909',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 2
            [
                'name'      => 'MULTISUMINISTROS Y ASESORIAS S.A.S.',
                'nit'       => '900638321',
                'address'   => 'CALLE 29 N° 20 - 148   BARRIO PASATIEMPO',
                'cellphone' => '3043352586',
                'phone'     => '7951982',
                'city'      => 'MONTERIA'
            ],
            // Organization 3
            [
                'name'      => 'KIDS CENTER UNIDAD PEDIATRICA S.A.S',
                'nit'       => '900884885',
                'address'   => 'CL 62 B 7 A  71  LA CASTELLANA',
                'cellphone' => '3205404055',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 4
            [
                'name'      => 'FUNDACION LA MANO DE DIOS',
                'nit'       => '900004312',
                'address'   => 'BARRIO NARIÑO CRA 8 No 39 36 MOCARÍ',
                'cellphone' => null,
                'phone'     => '7918764',
                'city'      => 'MONTERIA'
            ],
            // Organization 5
            [
                'name'      => 'ESPECIALISTAS ASOCIADOS S.A',
                'nit'       => '812005130',
                'address'   => 'CLL 27 13 38',
                'cellphone' => null,
                'phone'     => '7919999',
                'city'      => 'MONTERIA'
            ],
            // Organization 6
            [
                'name'      => 'NORELA VAZQUEZ MONTOYA',
                'nit'       => '25786075',
                'address'   => 'CALLE 58 No 7-07',
                'cellphone' => '3007043297',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 7
            [
                'name'      => 'VISALUD S.A.S',
                'nit'       => '802007426',
                'address'   => 'CL 101 13 600    AGUAS NEGRAS',
                'cellphone' => '3017502812',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 8
            [
                'name'      => 'SUMIDROGAS S.A.S',
                'nit'       => '900409942',
                'address'   => 'DIG 14 # 31-12 ETP 4  B/ EDMUNDO LOPEZ',
                'cellphone' => '3135079861',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 9
            [
                'name'      => 'LABORATORIO CLINICO DUNALAB I.P.S S.A.S',
                'nit'       => '900517512',
                'address'   => 'CRA 14 # 17-24',
                'cellphone' => '3104020433',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 10
            [
                'name'      => 'MARIA PATRICIA SILVA ALEAN',
                'nit'       => '34961424',
                'address'   => 'CRA 6 # 65-24 B/ RECREO  EDF PLACES MALL',
                'cellphone' => '3003214485',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 11
            [
                'name'      => 'CENTRO AVANZADO DE ATENCION EN TRATAMIENTOS DE HERIDAS S.A.S',
                'nit'       => '901073066',
                'address'   => 'CRA 14 # 37-07     CENTRO',
                'cellphone' => '3508460720',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 12
            [
                'name'      => 'INVERSIONES DISTRIAGRO S.A.S',
                'nit'       => '900877126',
                'address'   => 'CR 1 B 40 26',
                'cellphone' => null,
                'phone'     => '7817267',
                'city'      => 'MONTERIA'
            ],
            // Organization 13
            [
                'name'      => 'ENTRE PERROS Y GATOS PETSHOP Y CONSULTA VERTERINARIA Y/O GAB',
                'nit'       => '1067884086',
                'address'   => 'CRA 14 # 32-36 LOC 2  B/ EL EDEN',
                'cellphone' => '3103698015',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 14
            [
                'name'      => 'CENTRAL DE COOPERATIVAS DE SERVICIOS INTEGRALES DE CORDOBA Los olivos',
                'nit'       => '812000010',
                'address'   => 'CR 14 # 34-09',
                'cellphone' => null,
                'phone'     => '7820077',
                'city'      => 'MONTERIA'
            ],
            // Organization 15
            [
                'name'      => 'CLINICA VETERINARIA MOMO',
                'nit'       => '34978945',
                'address'   => 'CRA 12 N°29-37',
                'cellphone' => '3215412380',
                'phone'     => '7814184',
                'city'      => 'MONTERIA'
            ],
            // Organization 16
            [
                'name'      => 'CENTRO VETERINARIO ALEAN LORA',
                'nit'       => '700062808',
                'address'   => 'CRA 10 # 33 - 25',
                'cellphone' => null,
                'phone'     => '7950069',
                'city'      => 'MONTERIA'
            ],
            // Organization 17
            [
                'name'      => 'MONTERRICO VETERIANARIA Y SPA Y/O JUAN SALLEG TABOADA',
                'nit'       => '80715203',
                'address'   => 'CL 40 10 103',
                'cellphone' => '3107076571',
                'phone'     => '7920145',
                'city'      => 'MONTERIA'
            ],
            // Organization 18
            [
                'name'      => 'SCANER S.A',
                'nit'       => '800184093',
                'address'   => 'CALLE 35 # 14-06',
                'cellphone' => '3012321316',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 19
            [
                'name'      => 'COMERCIALIZADORA BETT- MEDICAL Y/O JORGE LUIS BETTIN ROJAS',
                'nit'       => '15727267',
                'address'   => 'CR 20 27 91 BRR PASATIEMPO',
                'cellphone' => '3041325495',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 20
            [
                'name'      => 'CENTRO OFTALMOLOGICO DEL SINU S.A.S',
                'nit'       => '900868736',
                'address'   => 'CALLE 58 # 7-06 B/ LA CASTELLANA',
                'cellphone' => '3004342503',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],


        ];

        $organizationsHector = [

            // Organization 1
            [
                'name'      => 'E.S.E. VIDA SINU',
                'nit'       => '812005726',
                'address'   => 'CLL 22 B 4 W 33 BRR EL AMPARO (MARGEN IZQUIERDA)',
                'cellphone' => null,
                'phone'     => '7918065',
                'city'      => 'MONTERIA'
            ],
            // Organization 2
            [
                'name'      => 'E.S.E. CAMU SAN PELAYO',
                'nit'       => '812001550',
                'address'   => 'CRA 9 6 35   SAN PELAYO',
                'cellphone' => null,
                'phone'     => '7740152',
                'city'      => 'SAN PELAYO'
            ],
            // Organization 3
            [
                'name'      => 'LABORATORIO CLINICO ANIMAL ELVELAS',
                'nit'       => '111111111',
                'address'   => '',
                'cellphone' => null,
                'phone'     => null,
                'city'      => ''
            ],
            // Organization 4
            [
                'name'      => 'SERVICIO NACIONAL DE APRENDIZAJE - SENA',
                'nit'       => '222222222',
                'address'   => '',
                'cellphone' => null,
                'phone'     => null,
                'city'      => ''
            ],
            // Organization 5
            [
                'name'      => 'DISTRISERVICIOS Y SUMINISTROS DEL BAJO SINU S.A.S',
                'nit'       => '901387977',
                'address'   => 'B/ KENNEDY CALLE 15 CR 21 # 21-33',
                'cellphone' => '323336343',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 6
            [
                'name'      => 'E.S.E. CAMU SANTA TERESITA',
                'nit'       => '812001423',
                'address'   => 'CRA 1 10 08',
                'cellphone' => null,
                'phone'     => '7731763',
                'city'      => 'LORICA'
            ],
            // Organization 7
            [
                'name'      => 'SOLUCIONES MEDICAS DEL SINU S.A.S',
                'nit'       => '900927782',
                'address'   => 'CALLE 26 # 17B-19 B/ SAN PEDRO LORICA',
                'cellphone' => '3147397705',
                'phone'     => null,
                'city'      => 'MONTERIA'
            ],
            // Organization 8
            [
                'name'      => 'E.S.E CAMU IRIS LOPEZ DURAN',
                'nit'       => '812002993',
                'address'   => 'CARRETERA TRONCAL VIA A COVEÑAS    SAN ANTERO',
                'cellphone' => null,
                'phone'     => '7730171',
                'city'      => 'MONTERIA'
            ],
            // Organization 9
            [
                'name'      => 'E.S.E CAMU IRIS LOPEZ DURAN',
                'nit'       => '812002994',
                'address'   => 'CARRETERA TRONCAL VIA A COVEÑAS    SAN ANTERO',
                'cellphone' => null,
                'phone'     => '7730171 - 7637377 - 8110334',
                'city'      => 'MONTERIA'
            ],
            // Organization 10
            [
                'name'      => 'RADIOLOGOS ASOCIADOS DEL BAJO SINU S.A.S.',
                'nit'       => '333333333',
                'address'   => '',
                'cellphone' => null,
                'phone'     => null,
                'city'      => ''
            ],
            // Organization 11
            [
                'name'      => 'E.S.E. CAMU DEL PRADO',
                'nit'       => '812002836',
                'address'   => 'CLL 27 CRA 9 ESQUINA  B/ EL PRADO',
                'cellphone' => null,
                'phone'     => '7642841',
                'city'      => 'CERETE'
            ],
        ];

        $seller1 = User::where('dni', '1005478123')->first();

        foreach ($organizationsMaira as $organizationM) {
            $organization = Organization::create([
                'name'      => $organizationM['name'],
                'nit'       => $organizationM['nit'],
                'cellphone' => fake()->numerify('##########'),
                'phone' => $organizationM['phone'],
                'user_id'      => $seller1->id,
            ]);

            $organization->addresses()->create([
                'street' => $organizationM['address'],
                'city' => $organizationM['city'],
                'state' => '',
                'country' => '',
                'zip_code' => '',
            ]);
        }

        $seller2 = User::where('dni', '1005472347')->first();

        foreach ($organizationsVeronica as $organizationV) {
            $organization = Organization::create([
                'name'      => $organizationV['name'],
                'nit'       => $organizationV['nit'],
                'cellphone' => fake()->numerify('##########'),
                'phone' => $organizationV['phone'],
                'user_id'      => $seller2->id,
            ]);

            $organization->addresses()->create([
                'street' => $organizationV['address'],
                'city' => $organizationV['city'],
                'state' => '',
                'country' => '',
                'zip_code' => '',
            ]);
        }

        $seller3 = User::where('dni', '1005479536')->first();

        foreach ($organizationsHector as $organizationH) {
            $organization = Organization::create([
                'name'      => $organizationH['name'],
                'nit'       => $organizationH['nit'],
                'cellphone' => fake()->numerify('##########'),
                'phone' => $organizationH['phone'],
                'user_id'      => $seller3->id,
            ]);

            $organization->addresses()->create([
                'street' => $organizationH['address'],
                'city' => $organizationH['city'],
                'state' => '',
                'country' => '',
                'zip_code' => '',
            ]);
        }

        $organizations = [
            [
                'name'      => 'Droguerias la botica',
                'nit'       => '1004731778',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3165893612',
                'email'     => 'drogueriabotica@gmail.com',
                'city'      => 'Montería'
            ],
            [
                'name'      => 'Droguerias la rebaja',
                'nit'       => '1004731745',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3155893667',
                'email'     => 'drogueriarebaja@gmail.com',
                'city'      => 'Montería'
            ],
            [
                'name'      => 'Drogueria la Economia',
                'nit'       => '1004731734',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3165893698',
                'email'     => 'drogueriaeconomia@gmail.com',
                'city'      => 'Montería'
            ],
        ];

        foreach ($organizations as $organization) {

            $newOrganization = Organization::create([
                'name'      => $organization['name'],
                'nit'       => $organization['nit'],
                'cellphone' => $organization['cellphone'],
                'email'     => $organization['email'],
            ]);

            $newOrganization->user()->associate($seller1);

            $newOrganization->addresses()->create([
                'street' => $organization['address'],
                'city' => $organization['city'],
                'state' => '',
                'country' => '',
                'zip_code' => '',
            ]);
        }
    }
}
