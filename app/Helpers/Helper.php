<?php

namespace App\Helpers;

class Helper
{
      public static function namaBulan($bulan)
      {
        switch ($bulan) {
          case '1':
            return 'Januari';
            break;
          case '2':
            return 'Februari';
            break;
          case '3':
            return 'Maret';
            break;
          case '4':
            return 'April';
            break;
          case '5':
            return 'Mei';
            break;
          case '6':
            return 'Juni';
            break;
          case '7':
            return 'Juli';
            break;
          case '8':
            return 'agustus';
            break;
          case '9':
            return 'september';
            break;
          case '10':
            return 'Oktober';
            break;
          case '11':
            return 'November';
            break;
          case '12':
            return 'Desember';
            break;
          default:
            return $bulan;
            break;
        }
      }
}
