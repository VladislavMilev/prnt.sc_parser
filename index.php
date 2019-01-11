<?php 

/*
	При запуске скрипта необходимо создать папку "save_dir" рядом с index.php
*/
	
set_time_limit(1024); //Максимальное время выполнения скрипта

function GeraHash($qtd){

$RandChar = 'abcdefghijklmopqrstuvxwyz0123456789';
$QuantidadeRandChar = strlen($RandChar);
$QuantidadeRandChar--;

$Hash=NULL;
    for($x = 1 ; $x <= $qtd ; $x++){
        $Posicao = rand(0,$QuantidadeRandChar);
        $Hash .= substr($RandChar,$Posicao,1);
    }

return $Hash;
}

$imgNumber = 500; // указать сколько будет добавленно ссылок в массив

$srcLink = array();
$srcSrting = array();

for ($i = 0 ; $i < $imgNumber ; $i++) { 

	$gera = GeraHash(6);
	$setLink = "https://prnt.sc/" . $gera; 
	
	$srcLink[i] = $setLink;	

	foreach ($srcLink as $key => $value) {

		$url= $value;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		$html = curl_exec($ch);
		curl_close($ch);

		$doc = new DOMDocument();
		@$doc->loadHTML($html);

		$tags = $doc->getElementsByTagName('img');

		$srcLinkWithImage = array();

		foreach ($tags as $tag) {
			array_push($srcLinkWithImage, $tags[0]->getAttribute('src'));
			$srcSrting = $srcLinkWithImage[0];
		}

		if (!isset($srcSrting) || $srcSrting == "//st.prntscr.com/2018/10/13/2048/img/0_173a7b_211be8ff.png") {
			echo "IMAGE NOT FOUND". "</br>";
		}else{
			copy("$srcSrting" , "save_dir/" . $gera . ".png"); 	// Сохранение изображений в папку save_dir
			// echo $setLink . " - " . $srcSrting. "</br>"; 	// Вывод найденых ссылок в брайзер в формате "ссылка на https://prnt.sc/" + "ссылка на IMG"
			// echo "<img src= $srcSrting>" . "<br>";			// Вывод изображений на страницу брайзера
		}
	}
}
