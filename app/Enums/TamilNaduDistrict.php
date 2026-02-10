<?php

namespace App\Enums;

enum TamilNaduDistrict: string
{
    case Ariyalur = 'Ariyalur';
    case Chengalpattu = 'Chengalpattu';
    case Chennai = 'Chennai';
    case Coimbatore = 'Coimbatore';
    case Cuddalore = 'Cuddalore';
    case Dharmapuri = 'Dharmapuri';
    case Dindigul = 'Dindigul';
    case Erode = 'Erode';
    case Kallakurichi = 'Kallakurichi';
    case Kancheepuram = 'Kancheepuram';
    case Karur = 'Karur';
    case Krishnagiri = 'Krishnagiri';
    case Madurai = 'Madurai';
    case Mayiladuthurai = 'Mayiladuthurai';
    case Nagapattinam = 'Nagapattinam';
    case Namakkal = 'Namakkal';
    case Nilgiris = 'Nilgiris';
    case Perambalur = 'Perambalur';
    case Pudukkottai = 'Pudukkottai';
    case Ramanathapuram = 'Ramanathapuram';
    case Ranipet = 'Ranipet';
    case Salem = 'Salem';
    case Sivagangai = 'Sivagangai';
    case Tenkasi = 'Tenkasi';
    case Thanjavur = 'Thanjavur';
    case Theni = 'Theni';
    case Thoothukudi = 'Thoothukudi';
    case Tiruchirappalli = 'Tiruchirappalli';
    case Tirunelveli = 'Tirunelveli';
    case Tirupathur = 'Tirupathur';
    case Tiruppur = 'Tiruppur';
    case Tiruvallur = 'Tiruvallur';
    case Tiruvannamalai = 'Tiruvannamalai';
    case Tiruvarur = 'Tiruvarur';
    case Vellore = 'Vellore';
    case Viluppuram = 'Viluppuram';
    case Virudhunagar = 'Virudhunagar';

    public function label(): string
    {
        return $this->value;
    }
}
