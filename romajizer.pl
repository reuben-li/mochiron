use Lingua::JA::Kana;
use Encode;

$!="no file";
open FILE, "kana.txt" or die $!;

while ($line =<FILE>){
    $romaji = kana2romaji(decode_utf8 $line);
    print $romaji;
}

